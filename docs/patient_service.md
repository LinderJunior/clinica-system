# Documentação do Serviço de Pacientes

Este documento descreve como utilizar o serviço de pacientes (Patient Service) implementado no sistema clínico.

## Estrutura da Tabela

A tabela `patient` possui os seguintes campos:

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | int(11) | Identificador único do paciente (AUTO_INCREMENT) |
| name | varchar(50) | Nome completo do paciente |
| dateBirth | date | Data de nascimento |
| bi | varchar(50) | Bilhete de Identidade |
| province | varchar(50) | Província |
| city | varchar(50) | Cidade |
| neighborhood | varchar(50) | Bairro |
| phoneNumber | varchar(9) | Número de telefone (9 dígitos) |
| iswhatsapp | tinyint(1) | Indica se o número tem WhatsApp (1=Sim, 0=Não) |

## Endpoints da API

### 1. Listar todos os pacientes

**Requisição:**
```
GET routes/index.php?route=patients
```

**Resposta:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "João Silva",
      "dateBirth": "1985-05-15",
      "bi": "001234567LA042",
      "province": "Luanda",
      "city": "Luanda",
      "neighborhood": "Maianga",
      "phoneNumber": "923456789",
      "iswhatsapp": 1
    },
    // ... mais pacientes
  ]
}
```

### 2. Buscar paciente por ID

**Requisição:**
```
GET routes/index.php?route=patients&id=1
```

**Resposta:**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "João Silva",
    "dateBirth": "1985-05-15",
    "bi": "001234567LA042",
    "province": "Luanda",
    "city": "Luanda",
    "neighborhood": "Maianga",
    "phoneNumber": "923456789",
    "iswhatsapp": 1
  }
}
```

### 3. Pesquisar pacientes por nome

**Requisição:**
```
GET routes/index.php?route=patients&search=João
```

**Resposta:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "João Silva",
      "dateBirth": "1985-05-15",
      "bi": "001234567LA042",
      "province": "Luanda",
      "city": "Luanda",
      "neighborhood": "Maianga",
      "phoneNumber": "923456789",
      "iswhatsapp": 1
    },
    // ... mais pacientes com "João" no nome
  ]
}
```

### 4. Adicionar novo paciente

**Requisição:**
```
POST routes/index.php?route=patients
```

**Corpo da requisição:**
```json
{
  "action": "add",
  "name": "Ana Oliveira",
  "dateBirth": "1992-08-25",
  "bi": "004567890LA075",
  "province": "Luanda",
  "city": "Luanda",
  "neighborhood": "Viana",
  "phoneNumber": "934567890",
  "iswhatsapp": 1
}
```

**Resposta:**
```json
{
  "status": "success",
  "message": "Paciente cadastrado com sucesso!"
}
```

### 5. Atualizar paciente existente

**Requisição:**
```
POST routes/index.php?route=patients
```

**Corpo da requisição:**
```json
{
  "action": "update",
  "id": 1,
  "name": "João Silva Atualizado",
  "dateBirth": "1985-05-15",
  "bi": "001234567LA042",
  "province": "Luanda",
  "city": "Luanda",
  "neighborhood": "Maianga",
  "phoneNumber": "923456789",
  "iswhatsapp": 0
}
```

**Resposta:**
```json
{
  "status": "success",
  "message": "Paciente atualizado com sucesso!"
}
```

### 6. Excluir paciente

**Requisição:**
```
POST routes/index.php?route=patients
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
  "message": "Paciente removido com sucesso!"
}
```

## Páginas do Sistema

O serviço de pacientes inclui as seguintes páginas:

1. **patientList.php** - Lista todos os pacientes com opções para adicionar, editar e excluir
2. **patientCreate.php** - Formulário para adicionar um novo paciente
3. **patientUpdate.php** - Formulário para editar um paciente existente

## Configuração Inicial

Para criar a tabela `patient` no banco de dados, acesse:

```
http://seu-servidor/clinica-system/setup_patient_table.php
```

Este script criará a tabela e inserirá alguns dados de exemplo para teste.

## Validações

- O número de telefone deve ter exatamente 9 dígitos numéricos
- Todos os campos marcados como obrigatórios devem ser preenchidos
- A data de nascimento deve ser uma data válida
