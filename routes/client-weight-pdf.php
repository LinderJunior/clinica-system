<?php
// Configuração de erro
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/ClientWeightService.php';
require_once __DIR__ . '/../fpdf/fpdf.php';

// Verificar se o client_id foi fornecido
if (!isset($_GET['client_id']) || !is_numeric($_GET['client_id'])) {
    die('ID do cliente é obrigatório');
}

$clientId = intval($_GET['client_id']);
$period = $_GET['period'] ?? 'all';

// Instância do controlador
$clientWeightController = new ClientWeightController($pdo);

// Buscar dados do cliente
$clientData = null;
$stmt = $pdo->prepare("SELECT * FROM patient WHERE id = ?");
$stmt->execute([$clientId]);
$clientData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$clientData) {
    die('Cliente não encontrado');
}

// Buscar registros de peso
$weightRecords = [];
if ($period === 'all') {
    $response = $clientWeightController->getClientWeightsByClientId($clientId);
} else {
    $endDate = date('Y-m-d');
    $startDate = date('Y-m-d', strtotime("-{$period} days"));
    $response = $clientWeightController->getClientWeightsByDateRange($startDate, $endDate, $clientId);
}

if ($response['status'] === 'success') {
    $weightRecords = $response['data'];
}

// Ordenar registros por data
usort($weightRecords, function($a, $b) {
    return strtotime($a['created_at']) - strtotime($b['created_at']);
});

// Função auxiliar para converter UTF-8 para ISO-8859-1
function convertText($text) {
    return mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
}

// Criar PDF
class ClientWeightPDF extends FPDF
{
    private $clientName;
    
    public function setClientName($name) {
        $this->clientName = $name;
    }
    
    // Cabeçalho
    function Header()
    {
        // Logo ou título
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,convertText('RELATÓRIO DE PROGRESSO - FITNESS MODE'),0,1,'C');
        $this->SetFont('Arial','B',12);
        $this->Cell(0,8,convertText('Cliente: ' . $this->clientName),0,1,'C');
        $this->Ln(5);
        
        // Data do relatório
        $this->SetFont('Arial','',10);
        $this->Cell(0,6,convertText('Relatório gerado em: ' . date('d/m/Y H:i:s')),0,1,'R');
        $this->Ln(5);
    }
    
    // Rodapé
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,convertText('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Instanciar PDF
$pdf = new ClientWeightPDF();
$pdf->setClientName($clientData['name']);
$pdf->AliasNbPages();
$pdf->AddPage();

// Informações do Cliente
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,convertText('INFORMAÇÕES DO CLIENTE'),0,1,'L');
$pdf->SetFont('Arial','',10);

$pdf->Cell(50,6,convertText('Nome:'),0,0,'L');
$pdf->Cell(0,6,convertText($clientData['name']),0,1,'L');

$pdf->Cell(50,6,convertText('Data de Nascimento:'),0,0,'L');
$pdf->Cell(0,6,date('d/m/Y', strtotime($clientData['dateBirth'])),0,1,'L');

$pdf->Cell(50,6,convertText('Telefone:'),0,0,'L');
$pdf->Cell(0,6,convertText($clientData['phoneNumber']),0,1,'L');

$pdf->Cell(50,6,convertText('Total de Registros:'),0,0,'L');
$pdf->Cell(0,6,count($weightRecords),0,1,'L');

if (count($weightRecords) > 0) {
    $firstRecord = $weightRecords[0];
    $lastRecord = $weightRecords[count($weightRecords) - 1];
    
    $pdf->Cell(50,6,convertText('Primeiro Registro:'),0,0,'L');
    $pdf->Cell(0,6,date('d/m/Y', strtotime($firstRecord['created_at'])),0,1,'L');
    
    $pdf->Cell(50,6,convertText('Último Registro:'),0,0,'L');
    $pdf->Cell(0,6,date('d/m/Y', strtotime($lastRecord['created_at'])),0,1,'L');
}

$pdf->Ln(10);

// Estatísticas
if (count($weightRecords) > 0) {
    $weights = array_map(function($r) { return floatval($r['weight']); }, $weightRecords);
    $bmis = array_map(function($r) { return floatval($r['bmi']); }, $weightRecords);
    
    $currentWeight = $weights[count($weights) - 1];
    $currentBMI = $bmis[count($bmis) - 1];
    $minWeight = min($weights);
    $maxWeight = max($weights);
    $weightVariation = $currentWeight - $weights[0];
    
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,8,convertText('ESTATÍSTICAS'),0,1,'L');
    $pdf->SetFont('Arial','',10);
    
    $pdf->Cell(50,6,convertText('Peso Atual:'),0,0,'L');
    $pdf->Cell(0,6,number_format($currentWeight, 1) . ' kg',0,1,'L');
    
    $pdf->Cell(50,6,convertText('IMC Atual:'),0,0,'L');
    $pdf->Cell(0,6,number_format($currentBMI, 1),0,1,'L');
    
    $pdf->Cell(50,6,convertText('Peso Mínimo:'),0,0,'L');
    $pdf->Cell(0,6,number_format($minWeight, 1) . ' kg',0,1,'L');
    
    $pdf->Cell(50,6,convertText('Peso Máximo:'),0,0,'L');
    $pdf->Cell(0,6,number_format($maxWeight, 1) . ' kg',0,1,'L');
    
    $pdf->Cell(50,6,convertText('Variação Total:'),0,0,'L');
    $variationText = ($weightVariation >= 0 ? '+' : '') . number_format($weightVariation, 1) . ' kg';
    $pdf->Cell(0,6,convertText($variationText),0,1,'L');
    
    $pdf->Ln(10);
}

// Tabela de Registros
if (count($weightRecords) > 0) {
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,8,convertText('HISTÓRICO DE REGISTROS'),0,1,'L');
    
    // Cabeçalho da tabela
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(25,8,'Data',1,0,'C');
    $pdf->Cell(20,8,'Altura (m)',1,0,'C');
    $pdf->Cell(20,8,'Peso (kg)',1,0,'C');
    $pdf->Cell(15,8,'IMC',1,0,'C');
    $pdf->Cell(35,8,convertText('Classificação'),1,0,'C');
    $pdf->Cell(25,8,convertText('Variação'),1,1,'C');
    
    // Dados da tabela
    $pdf->SetFont('Arial','',8);
    foreach ($weightRecords as $index => $record) {
        // Verificar se precisa de nova página
        if ($pdf->GetY() > 250) {
            $pdf->AddPage();
            // Repetir cabeçalho
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(25,8,'Data',1,0,'C');
            $pdf->Cell(20,8,'Altura (m)',1,0,'C');
            $pdf->Cell(20,8,'Peso (kg)',1,0,'C');
            $pdf->Cell(15,8,'IMC',1,0,'C');
            $pdf->Cell(35,8,'Classificação',1,0,'C');
            $pdf->Cell(25,8,'Variação',1,1,'C');
            $pdf->SetFont('Arial','',8);
        }
        
        $date = date('d/m/Y', strtotime($record['created_at']));
        $height = number_format(floatval($record['height']), 2);
        $weight = number_format(floatval($record['weight']), 1);
        $bmi = number_format(floatval($record['bmi']), 1);
        $classification = convertText($record['classification']);
        
        // Calcular variação
        $variation = '';
        if ($index > 0) {
            $prevWeight = floatval($weightRecords[$index - 1]['weight']);
            $currentWeight = floatval($record['weight']);
            $diff = $currentWeight - $prevWeight;
            $variation = ($diff >= 0 ? '+' : '') . number_format($diff, 1);
        } else {
            $variation = '-';
        }
        
        $pdf->Cell(25,6,$date,1,0,'C');
        $pdf->Cell(20,6,$height,1,0,'C');
        $pdf->Cell(20,6,$weight,1,0,'C');
        $pdf->Cell(15,6,$bmi,1,0,'C');
        $pdf->Cell(35,6,$classification,1,0,'C');
        $pdf->Cell(25,6,$variation,1,1,'C');
    }
} else {
    $pdf->SetFont('Arial','I',12);
    $pdf->Cell(0,10,convertText('Nenhum registro encontrado para este cliente.'),0,1,'C');
}

// Adicionar informações sobre classificação do IMC
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,convertText('CLASSIFICAÇÃO DO IMC'),0,1,'L');
$pdf->SetFont('Arial','',9);

$classifications = [
    'Abaixo do peso: IMC < 18.5',
    'Peso normal: 18.5 ≤ IMC < 25',
    'Sobrepeso: 25 ≤ IMC < 30',
    'Obesidade grau I: 30 ≤ IMC < 35',
    'Obesidade grau II: 35 ≤ IMC < 40',
    'Obesidade grau III: IMC ≥ 40'
];

foreach ($classifications as $class) {
    $pdf->Cell(0,5,convertText('• ' . $class),0,1,'L');
}

// Gerar nome do arquivo
$fileName = 'Progresso_' . str_replace(' ', '_', $clientData['name']) . '_' . date('Y-m-d') . '.pdf';

// Output do PDF - 'I' para visualizar inline no navegador
$pdf->Output('I', $fileName);
?>
