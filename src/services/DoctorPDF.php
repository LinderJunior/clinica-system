<?php
require_once __DIR__ . '/../../fpdf/fpdf.php';
require_once __DIR__ . '/DoctorServiceReport.php';

// Função auxiliar para converter UTF-8 → ISO-8859-1
function convertText($text) {
    return mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
}

class DoctorPDF extends FPDF {
    private array $doctor;
    private array $consultations;

    public function __construct(array $doctor, array $consultations) {
        parent::__construct();
        $this->doctor = $doctor;
        $this->consultations = $consultations;
    }

    // Cabeçalho
    function Header() {
        $logoPath = __DIR__ . '/../../assets/png/logo1.png';
        if (file_exists($logoPath)) {
            $this->Image($logoPath, 15, 10, 30);
        }

        $this->SetFont('Arial', 'B', 20);
        $this->SetXY(0, 15);
        $this->Cell($this->w - 20, 10, convertText('Relatório do Médico'), 0, 0, 'C');

        $this->SetLineWidth(0.5);
        $this->Line(10, 45, $this->w - 10, 45);

        $this->Ln(30);
    }

    // Rodapé
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 5, convertText('Página ') . $this->PageNo(), 0, 1, 'C');
        $this->Cell(0, 5, convertText('Impresso em: ' . date('d/m/Y H:i:s')), 0, 0, 'C');
    }

    // Dados do médico
    function DoctorInfo() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, convertText('Dados do Médico'), 0, 1);
        $this->SetFont('Arial', '', 10);

        $fields = [
            'Nome' => $this->doctor['name'],
            'Número de BI' => $this->doctor['bi'],
            'Telefone' => $this->doctor['phoneNumber']
        ];

        foreach ($fields as $label => $value) {
            $this->Cell(50, 8, convertText($label . ':'), 0, 0);
            $this->Cell(0, 8, convertText($value), 0, 1);
        }

        $this->Ln(10);
    }

    // Histórico de consultas do médico
    function ConsultationsTable() {
        $y = $this->GetY();
        $this->SetLineWidth(0.3);
        $this->Line(10, $y, $this->w - 10, $y);
        $this->Ln(2);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, convertText('Consultas Realizadas'), 0, 1);
        $this->SetFont('Arial', 'B', 10);

        $this->SetFillColor(169, 169, 169);
        $this->SetTextColor(255);

        $headers = ['ID', 'Paciente', 'Data', 'Hora', 'Tipo', 'Estado'];
        $widths = [15, 50, 30, 25, 50, 20];
        foreach ($headers as $i => $header) {
            $this->Cell($widths[$i], 8, convertText($header), 1, 0, 'C', true);
        }
        $this->Ln();

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);

        $countPendentes = 0;
        $countConcluidas = 0;
        $countCanceladas = 0;

        if (!empty($this->consultations)) {
            foreach ($this->consultations as $row) {
                // 🔁 Mapeia o estado numérico para texto
                $estadoTexto = match ($row['status']) {
                    '0', 0 => 'Pendente',
                    '1', 1 => 'Concluída',
                    '2', 2 => 'Cancelada',
                    default => 'Desconhecido',
                };

                // Contadores
                if ($estadoTexto === 'Pendente') $countPendentes++;
                elseif ($estadoTexto === 'Concluída') $countConcluidas++;
                elseif ($estadoTexto === 'Cancelada') $countCanceladas++;

                $this->Cell(15, 8, $row['id'], 1);
                $this->Cell(50, 8, convertText($row['patient_name']), 1);
                $this->Cell(30, 8, date('d/m/Y', strtotime($row['date'])), 1);
                $this->Cell(25, 8, $row['time'], 1);
                $this->Cell(50, 8, convertText($row['type']), 1);
                $this->Cell(20, 8, convertText($estadoTexto), 1);
                $this->Ln();
            }

            // 🔽 Resumo final
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(0, 8, convertText('Resumo das Consultas:'), 0, 1);

            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 8, convertText("Concluídas: $countConcluidas | Pendentes: $countPendentes | Canceladas: $countCanceladas"), 0, 1);
        } else {
            $this->Cell(array_sum($widths), 8, convertText('Sem consultas registradas.'), 1, 1, 'C');
        }

        $this->Ln(5);
    }

    // Gera o PDF completo
    function generatePDF() {
        $this->AddPage();
        $this->DoctorInfo();
        $this->ConsultationsTable();
    }
}

// Função auxiliar para gerar o PDF do médico
function generateDoctorPDF($doctorId, $output = 'I') {
    global $pdo;
    $service = new DoctorService($pdo);

    $doctor = $service->getDoctorById($doctorId);
    if (!$doctor) throw new Exception('Médico não encontrado.');

    $consultations = $service->getConsultationsByDoctorId($doctorId);
    $pdf = new DoctorPDF($doctor, $consultations);
    $pdf->generatePDF();

    $filename = 'Medico_' . preg_replace('/[^A-Za-z0-9]/', '_', $doctor['name']) . '.pdf';
    $pdf->Output($filename, $output);
}
?>