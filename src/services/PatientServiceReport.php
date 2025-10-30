<?php
require_once __DIR__ . '/../../config/database.php';

class PatientService {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Busca paciente por ID
     */
    public function getPatientById(int $id): ?array {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.id,
                p.name,
                p.dateBirth,
                p.bi,
                p.province,
                p.city,
                p.neighborhood,
                p.phoneNumber
            FROM patient p
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);
        return $patient ?: null;
    }

    /**
     * Retorna lista de consultas do paciente (se quiser exibir no PDF)
     */
    public function getConsultationsByPatientId(int $patientId): array {
        $stmt = $this->pdo->prepare("
            SELECT 
                c.id,
                c.date,
                c.time,
                c.type,
                c.status
            FROM consult c
            WHERE c.patient_id = ?
            ORDER BY c.date DESC
        ");
        $stmt->execute([$patientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>