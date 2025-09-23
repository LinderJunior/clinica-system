# Documentação do Serviço de Receitas Médicas

Este documento descreve como utilizar o serviço de receitas médicas (Recipe Service) implementado no sistema clínico.

## Estrutura da Tabela

A tabela `recipe` possui os seguintes campos:

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | int(11) | Identificador único da receita médica (AUTO_INCREMENT) |
| qty | int(11) | Quantidade do medicamento |
| dosage | varchar(50) | Dosagem e instruções de uso |
| date | date | Data da receita |
| consult_id | int(11) | ID da consulta associada |
| medication_id | int(11) | ID do medicamento prescrito |

## Relacionamentos

- Uma consulta (`consult`) pode ter várias receitas médicas (`recipe`)
- Cada receita médica está associada a um medicamento (`medication`)
- Quando uma consulta é excluída, todas as receitas médicas associadas também são excluídas (ON DELETE CASCADE)
- Quando um medicamento é excluído, todas as receitas médicas associadas também são excluídas (ON DELETE CASCADE)

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
      "qty": 2,
      "dosage": "1 comprimido a cada 8 horas",
      "date": "2023-09-20",
      "consult_id": 1,
      "medication_id": 1,
      "consult_date": "2023-09-20",
      "consult_time": "09:00:00",
      "patient_name": "João Silva",
      "doctor_name": "Dr. Carlos Mendes",
      "medication_name": "Paracetamol",
      "medication_type": "Analgésico"
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
    "qty": 2,
    "dosage": "1 comprimido a cada 8 horas",
    "date": "2023-09-20",
    "consult_id": 1,
    "medication_id": 1,
    "consult_date": "2023-09-20",
    "consult_time": "09:00:00",
    "patient_name": "João Silva",
    "doctor_name": "Dr. Carlos Mendes",
    "medication_name": "Paracetamol",
    "medication_type": "Analgésico"
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
      "qty": 2,
      "dosage": "1 comprimido a cada 8 horas",
      "date": "2023-09-20",
      "consult_id": 1,
      "medication_id": 1,
      "medication_name": "Paracetamol",
      "medication_type": "Analgésico"
    },
    {
      "id": 2,
      "qty": 1,
      "dosage": "1 comprimido ao dia",
      "date": "2023-09-20",
      "consult_id": 1,
      "medication_id": 2,
      "medication_name": "Ibuprofeno",
      "medication_type": "Anti-inflamatório"
    }
  ]
}
```

### 4. Buscar receitas médicas por medicação

**Requisição:**
```
GET routes/index.php?route=recipes&medication_id=1
```

### 5. Buscar receitas médicas por paciente

**Requisição:**
```
GET routes/index.php?route=recipes&patient_id=1
```

### 6. Buscar receitas médicas por médico

**Requisição:**
```
GET routes/index.php?route=recipes&doctor_id=2
```

### 7. Buscar receitas médicas por data

**Requisição:**
```
GET routes/index.php?route=recipes&date=2023-09-20
```

### 8. Listar todas as consultas para seleção

**Requisição:**
```
GET routes/index.php?route=recipes&consults=true
```

### 9. Listar todas as medicações para seleção

**Requisição:**
```
GET routes/index.php?route=recipes&medications=true
```

### 10. Adicionar nova receita médica

**Requisição:**
```
POST routes/index.php?route=recipes
```

**Corpo da requisição:**
```json
{
  "action": "add",
  "qty": 2,
  "dosage": "1 comprimido a cada 8 horas",
  "date": "2023-09-23",
  "consult_id": 1,
  "medication_id": 1
}
```

**Resposta:**
```json
{
  "status": "success",
  "message": "Receita médica cadastrada com sucesso!",
  "recipe_id": 4
}
```

### 11. Atualizar receita médica existente

**Requisição:**
```
POST routes/index.php?route=recipes
```

**Corpo da requisição:**
```json
{
  "action": "update",
  "id": 1,
  "qty": 3,
  "dosage": "1 comprimido a cada 6 horas",
  "date": "2023-09-20",
  "consult_id": 1,
  "medication_id": 1
}
```

**Resposta:**
```json
{
  "status": "success",
  "message": "Receita médica atualizada com sucesso!"
}
```

### 12. Excluir receita médica

**Requisição:**
```
POST routes/index.php?route=recipes
```

**Corpo da requisição:**
```json
{
  "action": "delete",
  "id": 1
}
```

**Resposta:**
```json
{
  "status": "success",
  "message": "Receita médica removida com sucesso!"
}
```

## Exemplos de Uso

### Exemplo com JavaScript (Fetch API)

```javascript
// Exemplo de listagem de receitas médicas por consulta
fetch('routes/index.php?route=recipes&consult_id=1')
  .then(response => response.json())
  .then(data => {
    if (data.status === "success") {
      console.log(data.data); // Lista de receitas médicas
    }
  })
  .catch(error => console.error('Erro:', error));

// Exemplo de criação de receita médica
const recipeData = {
  action: "add",
  qty: 2,
  dosage: "1 comprimido a cada 8 horas",
  date: "2023-09-23",
  consult_id: 1,
  medication_id: 1
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
```

## Configuração Inicial

Para criar a tabela `recipe` no banco de dados, acesse:

```
http://seu-servidor/clinica-system/setup_recipe_table.php
```

Este script criará a tabela e inserirá alguns dados de exemplo para teste.

## Observações Importantes

1. Certifique-se de que as tabelas `consult` e `medication` já existam antes de criar a tabela `recipe`.
2. A tabela `recipe` possui chaves estrangeiras que referenciam as tabelas `consult` e `medication`.
3. Ao excluir uma consulta ou um medicamento, todas as receitas médicas associadas também serão excluídas automaticamente (ON DELETE CASCADE).
4. O campo `dosage` deve conter instruções claras sobre como o paciente deve tomar o medicamento.
5. O campo `qty` representa a quantidade do medicamento prescrito (ex: número de comprimidos, frascos, etc.).
6. A data da receita (`date`) pode ser diferente da data da consulta, mas geralmente são iguais.
