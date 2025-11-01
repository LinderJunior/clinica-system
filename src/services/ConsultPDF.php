<?php
require_once __DIR__ . '/../../fpdf/fpdf.php';
require_once __DIR__ . '/ConsultServiceReport.php';

function convertText($text) {
    return mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
}

class ConsultPDF extends FPDF {
    private array $consult;
    private array $patient;
    private array $doctor;
    private ?array $diagnostic;

    // Informações da clínica
    private string $clinicName = 'Clínica Saúde e Vida';
    private string $clinicAddress = 'Avenida da Saúde, 123, Cidade X';

    public function __construct(array $consult, array $patient, array $doctor, ?array $diagnostic) {
        parent::__construct();
        $this->consult = $consult;
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->diagnostic = $diagnostic;
    }

    function Header() {
        // Logo
        $logoPath = __DIR__ . '/../../assets/png/logo1.png';
        if (file_exists($logoPath)) {
            $this->Image($logoPath, 15, 10, 30);
        }

        // Nome da clínica
        $this->SetFont('Arial', 'B', 16);
        $this->SetXY(50, 15);
        $this->Cell(0, 10, convertText($this->clinicName), 0, 1, 'C');

        // Linha de separação
        $this->SetLineWidth(0.5);
        $this->Line(10, 35, $this->w - 10, 35);
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-25);
        $this->SetFont('Arial', 'I', 8);

        // Linha superior do rodapé
        $this->SetLineWidth(0.3);
        $this->Line(10, $this->GetY(), $this->w - 10, $this->GetY());

        // Endereço e data/hora da impressão
        $this->SetY(-20);
        $this->Cell(0, 5, convertText($this->clinicAddress), 0, 1, 'L');
        $this->Cell(0, 5, 'Impresso em: ' . date('d/m/Y H:i:s'), 0, 1, 'L');

        // Número da página
        $this->SetY(-15);
        $this->Cell(0, 10, convertText('Página ') . $this->PageNo(), 0, 0, 'C');
    }

    private function drawBox($title, array $leftCol, array $rightCol) {
        $lineHeight = 8;
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, convertText($title), 0, 1);
        $this->SetFont('Arial', '', 10);

        $maxRows = max(count($leftCol), count($rightCol));
        $leftKeys = array_keys($leftCol);
        $rightKeys = array_keys($rightCol);

        // Box de fundo
        $yStart = $this->GetY();
        $this->SetFillColor(240, 240, 240); // cor leve de fundo
        $this->Rect(10, $yStart - 2, $this->w - 20, ($maxRows * $lineHeight) + 4, 'F');

        // Conteúdo
        for ($i = 0; $i < $maxRows; $i++) {
            $lKey = $leftKeys[$i] ?? '';
            $lValue = $leftCol[$lKey] ?? '';
            $rKey = $rightKeys[$i] ?? '';
            $rValue = $rightCol[$rKey] ?? '';

            // Nomes dos campos em negrito suave (cinza escuro)
            $this->SetTextColor(50, 50, 50); 
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(40, $lineHeight, convertText($lKey . ':'), 0, 0);
            $this->SetTextColor(0,0,0);
            $this->SetFont('Arial', '', 10);
            $this->Cell(50, $lineHeight, convertText($lValue), 0, 0);

            $this->SetTextColor(50, 50, 50);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(40, $lineHeight, convertText($rKey . ':'), 0, 0);
            $this->SetTextColor(0,0,0);
            $this->SetFont('Arial', '', 10);
            $this->Cell(50, $lineHeight, convertText($rValue), 0, 1);
        }

        $this->Ln(5);
    }

    function ConsultInfo() {
        $statusText = match($this->consult['status']) {
            0 => 'Pendente',
            1 => 'Concluída',
            2 => 'Cancelada',
            default => 'Desconhecido'
        };

        $leftCol = [
            'ID' => $this->consult['id'],
            'Data' => date('d/m/Y', strtotime($this->consult['date'])),
            'Hora' => $this->consult['time'],
            'Tipo' => $this->consult['type']
        ];

        $rightCol = ['Estado' => $statusText];

        $this->drawBox('Dados da Consulta', $leftCol, $rightCol);
    }

    function PatientInfo() {
        $leftCol = [
            'Nome' => $this->patient['name'],
            'Data Nasc.' => date('d/m/Y', strtotime($this->patient['dateBirth'])),
            'BI' => $this->patient['bi']
        ];
        $rightCol = [
            'Província' => $this->patient['province'],
            'Cidade' => $this->patient['city'],
            'Bairro' => $this->patient['neighborhood'],
            'Telefone' => $this->patient['phoneNumber']
        ];

        $this->drawBox('Dados do Paciente', $leftCol, $rightCol);
    }

    function DoctorInfo() {
        $leftCol = ['Nome' => $this->doctor['name'], 'BI' => $this->doctor['bi']];
        $rightCol = ['Telefone' => $this->doctor['phoneNumber']];

        $this->drawBox('Dados do Médico', $leftCol, $rightCol);
    }

    function DiagnosticInfo() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, convertText('Diagnóstico'), 0, 1);
        $this->SetFont('Arial', '', 10);

        if ($this->diagnostic && !empty($this->diagnostic['details'])) {
            $this->MultiCell(0, 8, convertText($this->diagnostic['details']), 0, 1);
        } else {
            $this->Cell(0, 8, convertText('Nenhum diagnóstico registrado.'), 0, 1);
        }
        $this->Ln(5);
    }

    function generatePDF() {
        $this->AddPage();
        $this->ConsultInfo();
        $this->PatientInfo();
        $this->DoctorInfo();
        $this->DiagnosticInfo();
    }
}

// Função para gerar PDF da consulta
function generateConsultPDF($consultId, $output = 'I') {
    global $pdo;
    $service = new ConsultService($pdo);

    $consult = $service->getConsultById($consultId);
    if (!$consult) throw new Exception('Consulta não encontrada.');

    $patient = $service->getPatientByConsultId($consultId);
    $doctor = $service->getDoctorByConsultId($consultId);
    $diagnostic = $service->getDiagnosticByConsultId($consultId);

    $pdf = new ConsultPDF($consult, $patient, $doctor, $diagnostic);
    $pdf->generatePDF();

    $filename = 'Consulta_' . $consult['id'] . '.pdf';
    $pdf->Output($filename, $output);
}
?>