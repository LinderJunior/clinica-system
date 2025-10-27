-- Script para criar as tabelas de Proforma Invoices
-- Execute este script no seu banco de dados MySQL

-- Criar tabela proforma_invoices
CREATE TABLE IF NOT EXISTS proforma_invoices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_number VARCHAR(50) UNIQUE NOT NULL,
  client_name VARCHAR(255) NOT NULL,
  issue_date DATE DEFAULT (CURRENT_DATE),
  due_date DATE,
  currency VARCHAR(10) DEFAULT 'MZN',
  subtotal DECIMAL(12,2) DEFAULT 0,
  tax DECIMAL(12,2) DEFAULT 0,
  total DECIMAL(12,2) DEFAULT 0,
  status ENUM('PENDING', 'APPROVED', 'CANCELLED') DEFAULT 'PENDING',
  notes TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  INDEX idx_invoice_number (invoice_number),
  INDEX idx_client_name (client_name),
  INDEX idx_status (status),
  INDEX idx_issue_date (issue_date),
  INDEX idx_created_at (created_at)
);

-- Criar tabela proforma_items
CREATE TABLE IF NOT EXISTS proforma_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  proforma_id INT NOT NULL,
  description VARCHAR(255) NOT NULL,
  quantity INT DEFAULT 1,
  unit_price DECIMAL(12,2) NOT NULL,
  total_price DECIMAL(12,2) GENERATED ALWAYS AS (quantity * unit_price) STORED,
  
  FOREIGN KEY (proforma_id) REFERENCES proforma_invoices(id) ON DELETE CASCADE,
  INDEX idx_proforma_id (proforma_id),
  INDEX idx_description (description)
);

-- Inserir dados de exemplo (opcional)
INSERT INTO proforma_invoices (invoice_number, client_name, issue_date, due_date, currency, subtotal, tax, total, status, notes) VALUES
('PF-000001', 'Empresa ABC Lda', '2024-10-26', '2024-11-25', 'MZN', 10000.00, 1700.00, 11700.00, 'PENDING', 'Primeira proforma de exemplo'),
('PF-000002', 'Consultoria XYZ', '2024-10-25', '2024-11-24', 'USD', 500.00, 85.00, 585.00, 'APPROVED', 'Serviços de consultoria'),
('PF-000003', 'Fornecedor 123', '2024-10-24', '2024-11-23', 'MZN', 7500.00, 1275.00, 8775.00, 'CANCELLED', 'Proforma cancelada pelo cliente');

-- Inserir itens de exemplo
INSERT INTO proforma_items (proforma_id, description, quantity, unit_price) VALUES
(1, 'Desenvolvimento de Sistema Web', 1, 8000.00),
(1, 'Treinamento de Usuários', 2, 1000.00),
(2, 'Consultoria em TI - 10 horas', 10, 50.00),
(3, 'Equipamento de Rede', 5, 1500.00);

-- Verificar se as tabelas foram criadas corretamente
SELECT 'Tabelas criadas com sucesso!' as status;

-- Mostrar estrutura das tabelas
DESCRIBE proforma_invoices;
DESCRIBE proforma_items;

-- Mostrar dados de exemplo
SELECT 
    pi.id,
    pi.invoice_number,
    pi.client_name,
    pi.issue_date,
    pi.total,
    pi.status,
    COUNT(pit.id) as total_items
FROM proforma_invoices pi
LEFT JOIN proforma_items pit ON pi.id = pit.proforma_id
GROUP BY pi.id
ORDER BY pi.created_at DESC;
