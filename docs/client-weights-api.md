# API de Pesos dos Clientes (Client Weights)

Esta documentação descreve os endpoints CRUD para gerenciar os registros de peso dos clientes.

## URL Base
```
/routes/index.php?route=client-weights
```

## Endpoints Disponíveis

### 1. Criar Registro de Peso
**Método:** `POST`
**URL:** `/routes/index.php?route=client-weights`

**Body (JSON):**
```json
{
    "action": "add",
    "client_id": 1,
    "height": 175.5,
    "weight": 70.2,
    "bmi": 22.8,
    "classification": "Peso normal"
}
```

**Campos obrigatórios:**
- `client_id` (int): ID do cliente/paciente
- `height` (float): Altura em centímetros
- `weight` (float): Peso em quilogramas

**Campos opcionais:**
- `bmi` (float): IMC (será calculado automaticamente se não fornecido)
- `classification` (string): Classificação do IMC (será determinada automaticamente se não fornecida)

**Resposta de sucesso:**
```json
{
    "status": "success",
    "message": "Registro de peso cadastrado com sucesso!"
}
```

### 2. Listar Todos os Registros
**Método:** `GET`
**URL:** `/routes/index.php?route=client-weights`

**Resposta:**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "client_id": 1,
            "height": 175.50,
            "weight": 70.20,
            "bmi": 22.80,
            "classification": "Peso normal",
            "created_at": "2024-01-15 10:30:00",
            "client_name": "João Silva"
        }
    ]
}
```

### 3. Buscar por ID
**Método:** `GET`
**URL:** `/routes/index.php?route=client-weights&id=1`

**Resposta:**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "client_id": 1,
        "height": 175.50,
        "weight": 70.20,
        "bmi": 22.80,
        "classification": "Peso normal",
        "created_at": "2024-01-15 10:30:00",
        "client_name": "João Silva"
    }
}
```

### 4. Buscar por Cliente
**Método:** `GET`
**URL:** `/routes/index.php?route=client-weights&client_id=1`

**Método alternativo:** `POST`
**Body (JSON):**
```json
{
    "action": "search_by_client",
    "client_id": 1
}
```

### 5. Buscar por Período
**Método:** `GET`
**URL:** `/routes/index.php?route=client-weights&start_date=2024-01-01&end_date=2024-01-31&client_id=1`

**Método alternativo:** `POST`
**Body (JSON):**
```json
{
    "action": "search_by_date_range",
    "start_date": "2024-01-01",
    "end_date": "2024-01-31",
    "client_id": 1
}
```

### 6. Atualizar Registro
**Método:** `PUT`
**URL:** `/routes/index.php?route=client-weights`

**Body (JSON):**
```json
{
    "id": 1,
    "client_id": 1,
    "height": 176.0,
    "weight": 72.5,
    "bmi": 23.4,
    "classification": "Peso normal"
}
```

**Resposta de sucesso:**
```json
{
    "status": "success",
    "message": "Registro de peso atualizado com sucesso!"
}
```

### 7. Excluir Registro
**Método:** `DELETE`
**URL:** `/routes/index.php?route=client-weights&id=1`

**Resposta de sucesso:**
```json
{
    "status": "success",
    "message": "Registro de peso removido com sucesso!"
}
```

## Classificações de IMC

O sistema calcula automaticamente a classificação do IMC baseada nos seguintes valores:

- **Abaixo do peso:** IMC < 18.5
- **Peso normal:** 18.5 ≤ IMC < 25
- **Sobrepeso:** 25 ≤ IMC < 30
- **Obesidade grau I:** 30 ≤ IMC < 35
- **Obesidade grau II:** 35 ≤ IMC < 40
- **Obesidade grau III:** IMC ≥ 40

## Códigos de Erro

- `400`: Dados inválidos ou ausentes
- `404`: Registro não encontrado
- `500`: Erro interno do servidor

## Exemplos de Uso

### Criar um novo registro com cURL:
```bash
curl -X POST "http://localhost/clinica-system/routes/index.php?route=client-weights" \
  -H "Content-Type: application/json" \
  -d '{
    "action": "add",
    "client_id": 1,
    "height": 175.5,
    "weight": 70.2
  }'
```

### Buscar registros de um cliente:
```bash
curl "http://localhost/clinica-system/routes/index.php?route=client-weights&client_id=1"
```

### Atualizar um registro:
```bash
curl -X PUT "http://localhost/clinica-system/routes/index.php?route=client-weights" \
  -H "Content-Type: application/json" \
  -d '{
    "id": 1,
    "client_id": 1,
    "height": 176.0,
    "weight": 72.5
  }'
```

### Excluir um registro:
```bash
curl -X DELETE "http://localhost/clinica-system/routes/index.php?route=client-weights&id=1"
```
