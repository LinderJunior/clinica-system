# API de Movimentos de Estoque

Esta documentação descreve os endpoints disponíveis para gerenciar movimentos de estoque de medicamentos.

## Base URL
```
http://localhost/clinica-system/routes/index.php?route=stock-movements
```

## Endpoints Disponíveis

### 1. Criar Movimento de Estoque
**POST** `&action=create`

Cria um novo movimento de estoque (entrada ou saída).

**Parâmetros (POST):**
- `medication_id` (int, obrigatório): ID do medicamento
- `quantity` (int, obrigatório): Quantidade (positiva para entrada, negativa para saída)

**Exemplo de requisição:**
```bash
curl -X POST "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=create" \
  -d "medication_id=1&quantity=50"
```

**Resposta de sucesso:**
```json
{
  "status": "success",
  "message": "Movimento de estoque criado com sucesso",
  "data": {
    "id": "1"
  }
}
```

### 2. Listar Todos os Movimentos
**GET** `&action=list`

Retorna todos os movimentos de estoque com informações dos medicamentos.

**Exemplo de requisição:**
```bash
curl "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=list"
```

**Resposta de sucesso:**
```json
{
  "status": "success",
  "data": [
    {
      "id": "1",
      "medication_id": "1",
      "quantity": "50",
      "movement_date": "2025-10-17 11:06:00",
      "medication_name": "Paracetamol",
      "medication_description": "Analgésico e antipirético"
    }
  ]
}
```

### 3. Buscar Movimento por ID
**GET** `&action=get&id={id}`

Retorna um movimento específico pelo ID.

**Parâmetros (GET):**
- `id` (int, obrigatório): ID do movimento

**Exemplo de requisição:**
```bash
curl "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=get&id=1"
```

### 4. Buscar Movimentos por Medicamento
**GET** `&action=list&medication_id={id}`

Retorna todos os movimentos de um medicamento específico.

**Parâmetros (GET):**
- `medication_id` (int, obrigatório): ID do medicamento

**Exemplo de requisição:**
```bash
curl "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=list&medication_id=1"
```

### 5. Buscar Movimentos por Período
**GET** `&action=list&start_date={date}&end_date={date}`

Retorna movimentos dentro de um período específico.

**Parâmetros (GET):**
- `start_date` (string, obrigatório): Data inicial (formato: YYYY-MM-DD)
- `end_date` (string, obrigatório): Data final (formato: YYYY-MM-DD)

**Exemplo de requisição:**
```bash
curl "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=list&start_date=2025-10-01&end_date=2025-10-31"
```

### 6. Atualizar Movimento
**POST** `&action=update`

Atualiza um movimento de estoque existente.

**Parâmetros (POST):**
- `id` (int, obrigatório): ID do movimento
- `medication_id` (int, obrigatório): ID do medicamento
- `quantity` (int, obrigatório): Nova quantidade

**Exemplo de requisição:**
```bash
curl -X POST "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=update" \
  -d "id=1&medication_id=1&quantity=75"
```

**Resposta de sucesso:**
```json
{
  "status": "success",
  "message": "Movimento atualizado com sucesso"
}
```

### 7. Deletar Movimento
**POST** `&action=delete`

Remove um movimento de estoque.

**Parâmetros (POST):**
- `id` (int, obrigatório): ID do movimento

**Exemplo de requisição:**
```bash
curl -X POST "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=delete" \
  -d "id=1"
```

**Resposta de sucesso:**
```json
{
  "status": "success",
  "message": "Movimento deletado com sucesso"
}
```

### 8. Consultar Estoque Atual
**GET** `&action=stock&medication_id={id}`

Retorna o estoque atual de um medicamento (soma de todos os movimentos).

**Parâmetros (GET):**
- `medication_id` (int, obrigatório): ID do medicamento

**Exemplo de requisição:**
```bash
curl "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=stock&medication_id=1"
```

**Resposta de sucesso:**
```json
{
  "status": "success",
  "data": {
    "medication_id": 1,
    "current_stock": 50
  }
}
```

### 9. Relatório de Estoque
**GET** `&action=report`

Retorna um relatório completo do estoque de todos os medicamentos.

**Exemplo de requisição:**
```bash
curl "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=report"
```

**Resposta de sucesso:**
```json
{
  "status": "success",
  "data": [
    {
      "medication_id": "1",
      "medication_name": "Paracetamol",
      "medication_description": "Analgésico e antipirético",
      "current_stock": "50",
      "total_movements": "1",
      "last_movement_date": "2025-10-17 11:06:00"
    }
  ]
}
```

## Códigos de Resposta HTTP

- **200 OK**: Requisição bem-sucedida
- **400 Bad Request**: Erro na requisição (dados inválidos)
- **500 Internal Server Error**: Erro interno do servidor

## Tratamento de Erros

Todas as respostas de erro seguem o formato:

```json
{
  "status": "error",
  "message": "Descrição do erro"
}
```

## Exemplos de Uso Prático

### Registrar Entrada de Medicamento
```bash
# Entrada de 100 unidades de Paracetamol
curl -X POST "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=create" \
  -d "medication_id=1&quantity=100"
```

### Registrar Saída de Medicamento
```bash
# Saída de 25 unidades (quantidade negativa)
curl -X POST "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=create" \
  -d "medication_id=1&quantity=-25"
```

### Verificar Estoque Atual
```bash
curl "http://localhost/clinica-system/routes/index.php?route=stock-movements&action=stock&medication_id=1"
```

## Observações Importantes

1. **Quantidades Negativas**: Use quantidades negativas para registrar saídas de estoque
2. **Data Automática**: A data do movimento é registrada automaticamente como NOW()
3. **Cálculo de Estoque**: O estoque atual é calculado somando todos os movimentos (positivos e negativos)
4. **Validações**: Todos os campos obrigatórios são validados antes da inserção
5. **Relacionamento**: Os movimentos são relacionados com a tabela `medication` via `medication_id`
