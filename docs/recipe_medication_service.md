# Documentação do Serviço de Receitas Médicas com Múltiplas Medicações

Este documento descreve como utilizar o serviço de receitas médicas (Recipe Service) implementado no sistema clínico, com suporte para múltiplas medicações por receita.

## Estrutura das Tabelas

### Tabela `recipe`

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | int(11) | Identificador único da receita médica (AUTO_INCREMENT) |
| date | date | Data da receita |
| consult_id | int(11) | ID da consulta associada |

### Tabela `recipe_medication`

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | int(11) | Identificador único do relacionamento (AUTO_INCREMENT) |
| recipe_id | int(11) | ID da receita médica |
| medication_id | int(11) | ID do medicamento prescrito |
| qty | int(11) | Quantidade do medicamento |
| dosage | varchar(50) | Dosagem e instruções de uso |

## Relacionamentos

- Uma consulta (`consult`) pode ter várias receitas médicas (`recipe`)
- Uma receita médica (`recipe`) pode ter várias medicações (`medication`) através da tabela de relacionamento `recipe_medication`
- Quando uma consulta é excluída, todas as receitas médicas associadas também são excluídas (ON DELETE CASCADE)
- Quando uma receita médica é excluída, todos os seus relacionamentos com medicações também são excluídos (ON DELETE CASCADE)
- Quando um medicamento é excluído, todos os seus relacionamentos com receitas médicas também são excluídos (ON DELETE CASCADE)

## Endpoints da API

### 1. Listar todas as receitas médicas

**Requisição:**
```
GET routes/index.php?route=recipes
```

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
      "medications_count": 2
    },
    // ... mais receitas médicas
  ]
}
```

### 2. Buscar receita médica por ID

**Requisição:**
```
GET routes/index.php?route=recipes&id=1
```

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
        "medication_name": "Paracetamol",
        "medication_type": "Analgésico"
      },
      {
        "id": 2,
        "recipe_id": 1,
        "medication_id": 2,
        "qty": 1,
        "dosage": "1 comprimido ao dia",
        "medication_name": "Ibuprofeno",
        "medication_type": "Anti-inflamatório"
      }
    ]
  }
}
```

### 3. Buscar receitas médicas por consulta

**Requisição:**
```
GET routes/index.php?route=recipes&consult_id=1
```

**Resposta:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "date": "2023-09-20",
      "consult_id": 1,
      "medications_count": 2,
      "medications": [
        {
          "id": 1,
          "recipe_id": 1,
          "medication_id": 1,
          "qty": 2,
          "dosage": "1 comprimido a cada 8 horas",
          "medication_name": "Paracetamol",
          "medication_type": "Analgésico"
        },
        {
          "id": 2,
          "recipe_id": 1,
          "medication_id": 2,
          "qty": 1,
          "dosage": "1 comprimido ao dia",
          "medication_name": "Ibuprofeno",
          "medication_type": "Anti-inflamatório"
        }
      ]
    }
  ]
}
```

### 4. Adicionar nova receita médica com múltiplas medicações

**Requisição:**
```
POST routes/index.php?route=recipes
```

**Corpo da requisição:**
```json
{
  "action": "add",
  "date": "2023-09-23",
  "consult_id": 1,
  "medications": [
    {
      "medication_id": 1,
      "qty": 2,
      "dosage": "1 comprimido a cada 8 horas"
    },
    {
      "medication_id": 2,
      "qty": 1,
      "dosage": "1 comprimido ao dia"
    },
    {
      "medication_id": 3,
      "qty": 3,
      "dosage": "1 comprimido a cada 12 horas"
    }
  ]
}
```

**Resposta:**
```json
{
  "status": "success",
  "message": "Receita médica cadastrada com sucesso!",
  "recipe_id": 3
}
```

### 5. Atualizar receita médica existente

**Requisição:**
```
POST routes/index.php?route=recipes
```

**Corpo da requisição:**
```json
{
  "action": "update",
  "id": 1,
  "date": "2023-09-20",
  "consult_id": 1,
  "medications": [
    {
      "medication_id": 1,
      "qty": 3,
      "dosage": "1 comprimido a cada 6 horas"
    },
    {
      "medication_id": 2,
      "qty": 1,
      "dosage": "1 comprimido ao dia"
    },
    {
      "medication_id": 4,
      "qty": 1,
      "dosage": "1 comprimido antes de dormir"
    }
  ]
}
```

**Resposta:**
```json
{
  "status": "success",
  "message": "Receita médica atualizada com sucesso!"
}
```

## Exemplos de Uso

### Exemplo com JavaScript (Fetch API)

```javascript
// Exemplo de criação de receita médica com múltiplas medicações
const recipeData = {
  action: "add",
  date: "2023-09-23",
  consult_id: 1,
  medications: [
    {
      medication_id: 1,
      qty: 2,
      dosage: "1 comprimido a cada 8 horas"
    },
    {
      medication_id: 2,
      qty: 1,
      dosage: "1 comprimido ao dia"
    }
  ]
};

fetch('routes/index.php?route=recipes', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(recipeData)
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Erro:', error));

// Exemplo de busca de receita médica por ID
fetch('routes/index.php?route=recipes&id=1')
  .then(response => response.json())
  .then(data => {
    if (data.status === "success") {
      console.log(data.data); // Dados da receita médica com suas medicações
      
      // Acessar as medicações
      const medications = data.data.medications;
      medications.forEach(med => {
        console.log(`Medicação: ${med.medication_name}, Quantidade: ${med.qty}, Dosagem: ${med.dosage}`);
      });
    }
  })
  .catch(error => console.error('Erro:', error));
```

## Configuração Inicial

Para criar as tabelas `recipe` e `recipe_medication` no banco de dados, acesse:

```
http://seu-servidor/clinica-system/setup_recipe_table.php
```

Este script criará as tabelas e inserirá alguns dados de exemplo para teste.

## Observações Importantes

1. Certifique-se de que as tabelas `consult` e `medication` já existam antes de criar as tabelas `recipe` e `recipe_medication`.
2. As tabelas `recipe` e `recipe_medication` possuem chaves estrangeiras que referenciam as tabelas `consult` e `medication`.
3. Ao excluir uma consulta ou um medicamento, todas as receitas médicas e relacionamentos associados também serão excluídos automaticamente (ON DELETE CASCADE).
4. O campo `dosage` deve conter instruções claras sobre como o paciente deve tomar o medicamento.
5. O campo `qty` representa a quantidade do medicamento prescrito (ex: número de comprimidos, frascos, etc.).
6. Uma receita médica pode conter várias medicações, cada uma com sua própria quantidade e dosagem.
