<?php
require_once __DIR__ . '/../../fpdf/fpdf.php';
require_once __DIR__ . '/ProformaService.php';

// Função auxiliar para converter UTF-8 para ISO-8859-1
function convertText($text) {
    return mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
}

class ProformaPDF extends FPDF {
    private $proformaData;
    
    public function __construct($proformaData) {
        parent::__construct();
        $this->proformaData = $proformaData;
    }
    
    // Cabeçalho
    function Header() {
        // Espaço inicial para o cabeçalho
        $this->Ln(15);
    }
    
    // Rodapé
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, convertText('Página ') . $this->PageNo(), 0, 0, 'C');
    }
    
    // Informações de faturação
    function BillingInfo() {
        $logoPath = __DIR__ . '/../../assets/png/logo1.png';
        $y_start = 30;
        $this->SetY($y_start);
        
        // Título FACTURA no lado direito
        $this->SetXY(150, 20);
        $this->SetFont('Arial', 'B', 24);
        $this->Cell(50, 15, convertText('FACTURA'), 0, 1, 'C');
        
        // Resetar posição
        $this->SetY($y_start);
         // Logo embaixo do Bill From
        if (file_exists($logoPath)) {
            $this->Image($logoPath, 15, $this->GetY() + 5, 40, 25);
        }
        
        $this->Ln(35); // Espaço extra para o logo
        
        // Bill From
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(60, 6, convertText('Bill From'), 0, 0);
        
        
        // Bill To
        $this->SetX(80);
        $this->Cell(60, 6, convertText('Bill To'), 0, 0);
        
        // Invoice Info
        $this->SetX(150);
        $this->Cell(50, 6, convertText('Invoice No. ') . convertText($this->proformaData['invoice_number']), 0, 1);
        
        $this->Ln(2);
        
        // Informações da empresa (Bill From)
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 5, convertText('Name: Clínica System'), 0, 0);
        $this->SetX(80);
        $this->Cell(60, 5, convertText('Name: ') . convertText($this->proformaData['client_name']), 0, 0);
        $this->SetX(150);
        $this->Cell(50, 5, convertText('Invoice Date: ') . $this->formatDate($this->proformaData['issue_date']), 0, 1);
        
        $this->Cell(60, 5, convertText('Company Name: Clínica System Lda'), 0, 0);
        $this->SetX(80);
        $this->Cell(60, 5, convertText('Company Name: ') . convertText($this->proformaData['client_name']), 0, 0);
        $this->SetX(150);
        $this->Cell(50, 5, convertText('Due Date: ') . $this->formatDate($this->proformaData['due_date']), 0, 1);
        
        $this->Cell(60, 5, convertText('Street Address: Rua Principal, 123'), 0, 0);
    
    

        $this->Cell(60, 5, '', 0, 1);
        
        $this->Cell(60, 5, convertText('Phone: +258 84 123 4567'), 0, 0);
        $this->Ln(15);
       
        
       
    }
    
    // Tabela de itens
    function ItemsTable() {
        // Cabeçalho da tabela
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(169, 169, 169); // Cinza
        $this->SetTextColor(255, 255, 255); // Branco
        
        $this->Cell(80, 8, convertText('Description'), 1, 0, 'C', true);
        $this->Cell(30, 8, convertText('Quantity'), 1, 0, 'C', true);
        $this->Cell(40, 8, convertText('Price (') . convertText($this->proformaData['currency']) . convertText(')'), 1, 0, 'C', true);
        $this->Cell(40, 8, convertText('Total (') . convertText($this->proformaData['currency']) . convertText(')'), 1, 1, 'C', true);
        
        // Resetar cor do texto
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 9);
        
        // Itens
        if (isset($this->proformaData['items']) && is_array($this->proformaData['items'])) {
            foreach ($this->proformaData['items'] as $item) {
                $this->Cell(80, 8, convertText($this->truncateText($item['description'], 35)), 1, 0);
                $this->Cell(30, 8, convertText($item['quantity']), 1, 0, 'C');
                $this->Cell(40, 8, convertText(number_format($item['unit_price'], 2)), 1, 0, 'R');
                $this->Cell(40, 8, convertText(number_format($item['total_price'], 2)), 1, 1, 'R');
            }
        }
        
        $this->Ln(5);
    }
    
    // Totais
    function Totals() {
        $this->SetFont('Arial', 'B', 10);
        
        // Posicionar no lado direito
        $x_start = 140;
        
        // Subtotal
        $this->SetX($x_start);
        $this->Cell(25, 8, convertText('Subtotal'), 1, 0, 'R');
        $this->Cell(35, 8, convertText(number_format($this->proformaData['subtotal'], 2) . ' ' . $this->proformaData['currency']), 1, 1, 'R');
        
        // IVA
        $this->SetX($x_start);
        $this->Cell(25, 8, convertText('Sales Tax'), 1, 0, 'R');
        $this->Cell(35, 8, convertText(number_format($this->proformaData['tax'], 2) . ' ' . $this->proformaData['currency']), 1, 1, 'R');
        
        // Other (vazio)
        $this->SetX($x_start);
        $this->Cell(25, 8, convertText('Other'), 1, 0, 'R');
        $this->Cell(35, 8, convertText(''), 1, 1, 'R');
        
        // Total
        $this->SetFont('Arial', 'B', 12);
        $this->SetX($x_start);
        $this->Cell(25, 10, convertText('Total'), 1, 0, 'R');
        $this->Cell(35, 10, convertText(number_format($this->proformaData['total'], 2) . ' ' . $this->proformaData['currency']), 1, 1, 'R');
    }
    
    // Observações
    function Notes() {
        if (!empty($this->proformaData['notes'])) {
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 6, convertText('Observações:'), 0, 1);
            $this->SetFont('Arial', '', 9);
            $this->MultiCell(0, 5, convertText($this->proformaData['notes']), 0, 'L');
        }
    }
    
    // Função para truncar texto
    function truncateText($text, $maxLength) {
        $convertedText = convertText($text);
        if (strlen($convertedText) > $maxLength) {
            return substr($convertedText, 0, $maxLength - 3) . '...';
        }
        return $convertedText;
    }
    
    // Formatar data
    function formatDate($date) {
        if (empty($date)) return convertText('');
        return convertText(date('d/m/Y', strtotime($date)));
    }
    
    // Gerar PDF completo
    function generatePDF() {
        $this->AddPage();
        $this->BillingInfo();
        $this->ItemsTable();
        $this->Totals();
        $this->Notes();
    }
}

// Função para gerar PDF de uma proforma
function generateProformaPDF($proformaId, $output = 'I') {
    global $pdo;
    
    try {
        $proformaController = new ProformaController($pdo);
        $response = $proformaController->getProformaInvoiceById($proformaId);
        
        if ($response['status'] !== 'success') {
            throw new Exception('Proforma não encontrada');
        }
        
        $proformaData = $response['data'];
        
        // Criar PDF
        $pdf = new ProformaPDF($proformaData);
        $pdf->generatePDF();
        
        // Definir nome do arquivo
        $filename = 'Proforma_' . $proformaData['invoice_number'] . '.pdf';
        
        // Output do PDF
        switch ($output) {
            case 'D': // Download
                $pdf->Output($filename, 'D');
                break;
            case 'F': // Salvar arquivo
                $pdf->Output(__DIR__ . '/../../temp/' . $filename, 'F');
                return $filename;
                break;
            case 'S': // String
                return $pdf->Output('', 'S');
                break;
            default: // 'I' - Inline (browser)
                $pdf->Output($filename, 'I');
                break;
        }
        
    } catch (Exception $e) {
        error_log('Erro ao gerar PDF: ' . $e->getMessage());
        throw $e;
    }
}

?>
