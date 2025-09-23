# Documentação do Sistema de Preços para Receitas Médicas

Este documento descreve como o sistema gerencia os preços dos medicamentos nas receitas médicas.

## Estrutura de Dados

### Tabela `recipe_medication`

A tabela `recipe_medication` foi atualizada para incluir informações de preço:

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | int(11) | Identificador único do relacionamento (AUTO_INCREMENT) |
| recipe_id | int(11) | ID da receita médica |
| medication_id | int(11) | ID do medicamento prescrito |
| qty | int(11) | Quantidade do medicamento |
| dosage | varchar(50) | Dosagem e instruções de uso |
| unit_price | decimal(10,2) | Preço unitário do medicamento |
| total_price | decimal(10,2) | Preço total (quantidade × preço unitário) |

## Funcionalidades Implementadas

### 1. Cálculo Automático de Preços

Quando uma receita médica é criada ou atualizada, o sistema:

1. Obtém o preço de venda (`salePrice`) de cada medicamento do banco de dados
2. Calcula o preço total para cada medicamento multiplicando o preço unitário pela quantidade
3. Armazena tanto o preço unitário quanto o preço total na tabela `recipe_medication`
4. Calcula o preço total da receita somando os preços totais de todos os medicamentos

### 2. Exibição de Preços nas Consultas

Todas as consultas de receitas médicas agora incluem:

1. O preço unitário de cada medicamento
2. O preço total de cada medicamento (quantidade × preço unitário)
3. O preço total da receita (soma dos preços totais de todos os medicamentos)

## Endpoints Atualizados

### 1. Buscar receita médica por ID

**Resposta:**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "date": "2023-09-20",
    "consult_id": 1,
    "consult_date": "2023-09-20",
    "consult_time": "09:00:00",
    "patient_name": "João Silva",
    "doctor_name": "Dr. Carlos Mendes",
    "medications": [
      {
        "id": 1,
        "recipe_id": 1,
        "medication_id": 1,
        "qty": 2,
        "dosage": "1 comprimido a cada 8 horas",
        "unit_price": 5.50,
        "total_price": 11.00,
        "medication_name": "Paracetamol",
        "medication_type": "Analgésico"
      },
      {
        "id": 2,
        "recipe_id": 1,
        "medication_id": 2,
        "qty": 1,
        "dosage": "1 comprimido ao dia",
        "unit_price": 8.75,
        "total_price": 8.75,
        "medication_name": "Ibuprofeno",
        "medication_type": "Anti-inflamatório"
      }
    ],
    "total_price": 19.75
  }
}
```

### 2. Listar todas as receitas médicas

**Resposta:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "date": "2023-09-20",
      "consult_id": 1,
      "consult_date": "2023-09-20",
      "consult_time": "09:00:00",
      "patient_name": "João Silva",
      "doctor_name": "Dr. Carlos Mendes",
      "medications_count": 2,
      "medications": [
        {
          "id": 1,
          "recipe_id": 1,
          "medication_id": 1,
          "qty": 2,
          "dosage": "1 comprimido a cada 8 horas",
          "unit_price": 5.50,
          "total_price": 11.00,
          "medication_name": "Paracetamol",
          "medication_type": "Analgésico"
        },
        {
          "id": 2,
          "recipe_id": 1,
          "medication_id": 2,
          "qty": 1,
          "dosage": "1 comprimido ao dia",
          "unit_price": 8.75,
          "total_price": 8.75,
          "medication_name": "Ibuprofeno",
          "medication_type": "Anti-inflamatório"
        }
      ],
      "total_price": 19.75
    },
    // ... mais receitas médicas
  ]
}
```

### 3. Buscar receitas médicas por consulta, paciente, médico, medicação ou data

Todas estas consultas agora retornam informações de preço no mesmo formato que as consultas acima.

## Exemplo de Uso

### Exibir uma receita médica com preços

```javascript
fetch('routes/index.php?route=recipes&id=1')
  .then(response => response.json())
  .then(data => {
    if (data.status === "success") {
      const recipe = data.data;
      
      // Exibir informações da receita
      console.log(`Receita #${recipe.id} - Data: ${recipe.date}`);
      console.log(`Paciente: ${recipe.patient_name}`);
      console.log(`Médico: ${recipe.doctor_name}`);
      
      // Exibir medicamentos e preços
      console.log("\nMedicamentos:");
      recipe.medications.forEach(med => {
        console.log(`- ${med.medication_name} (${med.medication_type})`);
        console.log(`  Quantidade: ${med.qty}`);
        console.log(`  Dosagem: ${med.dosage}`);
        console.log(`  Preço unitário: R$ ${med.unit_price.toFixed(2)}`);
        console.log(`  Preço total: R$ ${med.total_price.toFixed(2)}`);
      });
      
      // Exibir preço total da receita
      console.log(`\nPreço Total da Receita: R$ ${recipe.total_price.toFixed(2)}`);
    }
  })
  .catch(error => console.error('Erro:', error));
```

## Observações Importantes

1. O preço unitário é obtido diretamente da tabela `medication` (campo `salePrice`) no momento da criação ou atualização da receita.
2. Se o preço de um medicamento for alterado na tabela `medication`, isso não afetará as receitas já existentes.
3. O preço total da receita é calculado dinamicamente ao buscar a receita, somando os preços totais de todos os medicamentos.
4. Ao criar ou atualizar uma receita, certifique-se de que o campo `salePrice` esteja corretamente preenchido na tabela `medication`.
