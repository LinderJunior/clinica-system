<?php
require_once __DIR__ . '/../../fpdf/fpdf.php';
require_once __DIR__ . '/PatientServiceReport.php';

// Função auxiliar para converter UTF-8 → ISO-8859-1
function convertText($text) {
    return mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
}

class PatientPDF extends FPDF {
    private array $patient;
    private array $consultations;

    public function __construct(array $patient, array $consultations) {
        parent::__construct();
        $this->patient = $patient;
        $this->consultations = $consultations;
    }

    // Cabeçalho
    function Header() {
        $logoPath = __DIR__ . '/../../assets/png/logo1.png';
        if (file_exists($logoPath)) {
            $this->Image($logoPath, 15, 10, 30); // logo à esquerda
        }

        // Título do relatório à direita
        $this->SetFont('Arial', 'B', 20);
        $this->SetXY(0, 15);
        $this->Cell($this->w - 20, 10, convertText('Relatório do Paciente'), 0, 0, 'C');

        // Linha horizontal mais baixa (Y = 45)
    $this->SetLineWidth(0.5);
    $this->Line(10, 45, $this->w - 10, 45);

    $this->Ln(30); // Espaço entre linha e conteúdo
    }

    // Rodapé
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, convertText('Página ') . $this->PageNo(), 0, 0, 'C');
    }

    // Informações do paciente
    function PatientInfo() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, convertText('Dados do Paciente'), 0, 1);
        $this->SetFont('Arial', '', 10);

        $fields = [
            'Nome' => $this->patient['name'],
            'Data de Nascimento' => date('d/m/Y', strtotime($this->patient['dateBirth'])),
            'BI' => $this->patient['bi'],
            'Província' => $this->patient['province'],
            'Cidade' => $this->patient['city'],
            'Bairro' => $this->patient['neighborhood'],
            'Telefone' => $this->patient['phoneNumber']
        ];

        foreach ($fields as $label => $value) {
            $this->Cell(50, 8, convertText($label . ':'), 0, 0);
            $this->Cell(0, 8, convertText($value), 0, 1);
        }

        $this->Ln(10);
    }

// Histórico de consultas
function ConsultationsTable() {
    // Linha horizontal acima do título
    $y = $this->GetY(); // pega a posição Y atual
    $this->SetLineWidth(0.3);
    $this->Line(10, $y, $this->w - 10, $y); // linha de margem a margem
    $this->Ln(2); // pequeno espaço antes do título

    $this->SetFont('Arial', 'B', 12);
    $this->Cell(0, 8, convertText('Histórico de Consultas'), 0, 1);
    $this->SetFont('Arial', 'B', 10);

    // Cabeçalho
    $this->SetFillColor(169, 169, 169); // cinza padronizado
    $this->SetTextColor(255); // branco
    $headers = ['ID', 'Data', 'Hora', 'Tipo', 'Estado'];
    $widths = [20, 40, 40, 60, 20];
    foreach ($headers as $i => $header) {
        $this->Cell($widths[$i], 8, convertText($header), 1, 0, 'C', true);
    }
    $this->Ln();

    // Conteúdo
    $this->SetFont('Arial', '', 10);
    $this->SetTextColor(0);
    if (!empty($this->consultations)) {
        foreach ($this->consultations as $row) {
            $this->Cell(20, 8, $row['id'], 1);
            $this->Cell(40, 8, date('d/m/Y', strtotime($row['date'])), 1);
            $this->Cell(40, 8, $row['time'], 1);
            $this->Cell(60, 8, convertText($row['type']), 1);
            $this->Cell(20, 8, convertText($row['status']), 1);
            $this->Ln();
        }
    } else {
        $this->Cell(array_sum($widths), 8, convertText('Sem consultas registradas.'), 1, 1, 'C');
    }

    $this->Ln(5);
}


    // Gerar PDF completo
    function generatePDF() {
        $this->AddPage();
        $this->PatientInfo();
        $this->ConsultationsTable();
    }
}

// Função auxiliar para gerar PDF do paciente
function generatePatientPDF($patientId, $output = 'I') {
    global $pdo;
    $service = new PatientService($pdo);

    $patient = $service->getPatientById($patientId);
    if (!$patient) throw new Exception('Paciente não encontrado.');

    $consultations = $service->getConsultationsByPatientId($patientId);
    $pdf = new PatientPDF($patient, $consultations);
    $pdf->generatePDF();

    $filename = 'Paciente_' . preg_replace('/[^A-Za-z0-9]/', '_', $patient['name']) . '.pdf';
    $pdf->Output($filename, $output);
}
?>