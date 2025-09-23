# Endpoints para Verificação de Estoque de Medicamentos

Este documento descreve os endpoints disponíveis para verificar o estoque de medicamentos antes de criar ou atualizar receitas médicas.

## Verificação de Estoque

### 1. Verificar estoque de uma medicação específica (GET)

**Requisição:**
```
GET routes/index.php?route=recipes&medication_id=1&check_stock=true
```

**Resposta:**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "Paracetamol",
    "type": "Analgésico",
    "qty": 50
  }
}
```

### 2. Verificar estoque de uma medicação específica (POST)

**Requisição:**
```
POST routes/index.php?route=recipes
```

**Corpo da requisição:**
```json
{
  "action": "checkStock",
  "medication_id": 1
}
```

**Resposta:**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "Paracetamol",
    "type": "Analgésico",
    "qty": 50
  }
}
```

### 3. Listar todas as medicações com seus estoques

**Requisição:**
```
GET routes/index.php?route=recipes&medications=true
```

**Resposta:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Paracetamol",
      "type": "Analgésico",
      "qty": 50
    },
    {
      "id": 2,
      "name": "Ibuprofeno",
      "type": "Anti-inflamatório",
      "qty": 30
    },
    // ... mais medicações
  ]
}
```

## Tratamento de Erros de Estoque

Ao criar ou atualizar uma receita médica, o sistema verifica automaticamente se há estoque suficiente para todas as medicações solicitadas. Se não houver estoque suficiente, o sistema retornará um erro.

### Exemplo de erro de estoque insuficiente

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
      "qty": 100,
      "dosage": "1 comprimido a cada 8 horas"
    }
  ]
}
```

**Resposta (quando o estoque é insuficiente):**
```json
{
  "status": "error",
  "message": "Estoque insuficiente para a medicação ID 1. Disponível: 50, Solicitado: 100"
}
```

## Fluxo Recomendado para Criação de Receitas

1. Listar todas as medicações disponíveis com seus estoques:
   ```
   GET routes/index.php?route=recipes&medications=true
   ```

2. Verificar o estoque específico de uma medicação antes de adicioná-la à receita:
   ```
   GET routes/index.php?route=recipes&medication_id=1&check_stock=true
   ```

3. Criar a receita com as medicações e quantidades desejadas:
   ```
   POST routes/index.php?route=recipes
   ```
   Com o corpo:
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
       }
     ]
   }
   ```

4. Tratar possíveis erros de estoque insuficiente e informar ao usuário.

## Observações Importantes

1. O sistema verifica automaticamente o estoque antes de criar ou atualizar uma receita.
2. Se não houver estoque suficiente, a operação será cancelada e nenhuma alteração será feita no banco de dados.
3. Ao excluir uma receita, as quantidades dos medicamentos são automaticamente devolvidas ao estoque.
4. Ao atualizar uma receita, o sistema primeiro devolve as quantidades originais ao estoque e depois subtrai as novas quantidades.
5. É recomendável sempre verificar o estoque disponível antes de tentar criar ou atualizar uma receita.
