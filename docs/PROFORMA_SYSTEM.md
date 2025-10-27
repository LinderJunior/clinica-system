# Sistema de Proforma Invoices

Este documento descreve o sistema completo de gestão de proforma invoices implementado no sistema da clínica.

## 📋 Funcionalidades

### Gestão de Proformas
- ✅ Criar novas proformas com numeração automática
- ✅ Editar proformas existentes
- ✅ Visualizar detalhes completos das proformas
- ✅ Alterar status (Pendente, Aprovado, Cancelado)
- ✅ Excluir proformas
- ✅ Buscar por cliente ou status
- ✅ Listagem com filtros avançados

### Gestão de Itens
- ✅ Adicionar itens às proformas
- ✅ Editar itens existentes
- ✅ Remover itens
- ✅ Cálculo automático de totais
- ✅ Suporte a múltiplas moedas (MZN, USD, EUR)
- ✅ Cálculo automático de IVA (17%)

## 🗂️ Estrutura de Arquivos

```
clinica-system/
├── src/services/
│   ├── ProformaInvoice.php      # Modelo para proforma invoices
│   ├── ProformaItem.php         # Modelo para itens das proformas
│   └── ProformaService.php      # Controlador principal
├── routes/
│   └── proformaRoutes.php       # Endpoints da API
├── pages/proformas/
│   ├── proforma-list.php        # Página de listagem
│   └── proforma-register.php    # Página de cadastro/edição
├── sql/
│   └── proforma_tables.sql      # Script de criação das tabelas
└── docs/
    └── PROFORMA_SYSTEM.md       # Esta documentação
```

## 🗄️ Estrutura do Banco de Dados

### Tabela: proforma_invoices
```sql
CREATE TABLE proforma_invoices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_number VARCHAR(50) UNIQUE NOT NULL,
  client_name VARCHAR(255) NOT NULL,
  issue_date DATE DEFAULT CURRENT_DATE,
  due_date DATE,
  currency VARCHAR(10) DEFAULT 'MZN',
  subtotal DECIMAL(12,2) DEFAULT 0,
  tax DECIMAL(12,2) DEFAULT 0,
  total DECIMAL(12,2) DEFAULT 0,
  status ENUM('PENDING', 'APPROVED', 'CANCELLED') DEFAULT 'PENDING',
  notes TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Tabela: proforma_items
```sql
CREATE TABLE proforma_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  proforma_id INT NOT NULL,
  description VARCHAR(255) NOT NULL,
  quantity INT DEFAULT 1,
  unit_price DECIMAL(12,2) NOT NULL,
  total_price DECIMAL(12,2) GENERATED ALWAYS AS (quantity * unit_price) STORED,
  FOREIGN KEY (proforma_id) REFERENCES proforma_invoices(id) ON DELETE CASCADE
);
```

## 🚀 Instalação

### 1. Criar as Tabelas
Execute o script SQL no seu banco de dados:
```bash
mysql -u root -p clinica_system < sql/proforma_tables.sql
```

### 2. Verificar Configuração
Certifique-se de que o arquivo `config/database.php` está configurado corretamente.

### 3. Acessar o Sistema
- **Listagem:** `pages/proformas/proforma-list.php`
- **Cadastro:** `pages/proformas/proforma-register.php`

## 📡 API Endpoints

### GET Requests
```
GET /routes/proformaRoutes.php                    # Listar todas as proformas
GET /routes/proformaRoutes.php?id=1              # Buscar proforma por ID
GET /routes/proformaRoutes.php?search=cliente    # Buscar por nome do cliente
GET /routes/proformaRoutes.php?status=PENDING    # Buscar por status
GET /routes/proformaRoutes.php?action=next_invoice_number  # Próximo número
```

### POST Requests
```json
// Criar nova proforma
POST /routes/proformaRoutes.php
{
  "action": "add",
  "client_name": "Nome do Cliente",
  "issue_date": "2024-10-26",
  "due_date": "2024-11-25",
  "currency": "MZN",
  "status": "PENDING",
  "notes": "Observações",
  "items": [
    {
      "description": "Descrição do item",
      "quantity": 2,
      "unit_price": 1000.00
    }
  ]
}

// Buscar por cliente
POST /routes/proformaRoutes.php
{
  "action": "search",
  "client_name": "Nome do Cliente"
}

// Adicionar item a proforma existente
POST /routes/proformaRoutes.php
{
  "action": "add_item",
  "proforma_id": 1,
  "description": "Novo item",
  "quantity": 1,
  "unit_price": 500.00
}
```

### PUT Requests
```json
// Atualizar proforma completa
PUT /routes/proformaRoutes.php
{
  "action": "update",
  "id": 1,
  "invoice_number": "PF-000001",
  "client_name": "Nome Atualizado",
  "issue_date": "2024-10-26",
  "due_date": "2024-11-25",
  "currency": "MZN",
  "status": "APPROVED",
  "notes": "Observações atualizadas",
  "items": [...]
}

// Atualizar apenas status
PUT /routes/proformaRoutes.php
{
  "action": "update_status",
  "id": 1,
  "status": "APPROVED"
}

// Atualizar item
PUT /routes/proformaRoutes.php
{
  "action": "update_item",
  "item_id": 1,
  "description": "Descrição atualizada",
  "quantity": 3,
  "unit_price": 1200.00
}
```

### DELETE Requests
```json
// Excluir proforma
DELETE /routes/proformaRoutes.php
{
  "action": "delete",
  "id": 1
}

// Excluir item
DELETE /routes/proformaRoutes.php
{
  "action": "delete_item",
  "item_id": 1
}
```

## 💡 Características Técnicas

### Numeração Automática
- Formato: `PF-XXXXXX` (ex: PF-000001)
- Incremento automático baseado no maior número existente
- Único por proforma

### Cálculos Automáticos
- **Subtotal:** Soma de todos os itens (quantidade × preço unitário)
- **IVA:** 17% sobre o subtotal
- **Total:** Subtotal + IVA

### Validações
- Nome do cliente obrigatório
- Data de emissão obrigatória
- Pelo menos um item obrigatório
- Valores numéricos positivos
- Número de proforma único

### Recursos de Interface
- DataTables para listagem responsiva
- Modais para visualização e edição
- Filtros por status e cliente
- Alertas de confirmação para exclusões
- Formatação automática de moedas
- Interface responsiva

## 🔧 Personalização

### Alterar Taxa de IVA
No arquivo `ProformaItem.php`, linha 87:
```php
$tax = $subtotal * 0.17; // Altere 0.17 para a taxa desejada
```

### Adicionar Novas Moedas
No arquivo `proforma-register.php`, adicione opções no select:
```html
<option value="BRL">BRL - Real</option>
```

### Modificar Formato de Numeração
No arquivo `ProformaInvoice.php`, método `generateNextInvoiceNumber()`:
```php
return 'INV-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
```

## 🐛 Troubleshooting

### Erro: "Tabela não encontrada"
Execute o script SQL de criação das tabelas.

### Erro: "Número de proforma já existe"
Verifique se há duplicatas na tabela ou se a numeração automática está funcionando.

### Problemas de Permissão
Verifique se o usuário do banco tem permissões para CREATE, INSERT, UPDATE, DELETE.

### Interface não carrega
Verifique se os arquivos CSS e JS estão sendo carregados corretamente.

## 📞 Suporte

Para dúvidas ou problemas:
1. Verifique os logs de erro do PHP
2. Verifique os logs do MySQL
3. Teste os endpoints da API diretamente
4. Verifique a configuração do banco de dados

---

**Desenvolvido para o Sistema da Clínica**  
*Versão 1.0 - Outubro 2024*
