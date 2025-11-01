<?php
require_once __DIR__ . '/../../config/database.php';

class ConsultService {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getConsultById(int $id): ?array {
        $stmt = $this->pdo->prepare("
            SELECT id, date, time, type, status, patient_id, doctor_id
            FROM consult
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        $consult = $stmt->fetch(PDO::FETCH_ASSOC);
        return $consult ?: null;
    }

    public function getPatientByConsultId(int $consultId): ?array {
        $stmt = $this->pdo->prepare("
            SELECT p.id, p.name, p.dateBirth, p.bi, p.province, p.city, p.neighborhood, p.phoneNumber
            FROM patient p
            JOIN consult c ON c.patient_id = p.id
            WHERE c.id = ?
        ");
        $stmt->execute([$consultId]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);
        return $patient ?: null;
    }

    public function getDoctorByConsultId(int $consultId): ?array {
        $stmt = $this->pdo->prepare("
            SELECT e.id, e.name, e.bi, e.phoneNumber
            FROM employee e
            JOIN consult c ON c.doctor_id = e.id
            WHERE c.id = ? AND e.doctor = 1
        ");
        $stmt->execute([$consultId]);
        $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
        return $doctor ?: ['name' => 'Não atribuído', 'bi' => '-', 'phoneNumber' => '-'];
    }

    public function getDiagnosticByConsultId(int $consultId): ?array {
        $stmt = $this->pdo->prepare("
            SELECT id, details, consult_id, doctor_id
            FROM diagnosis
            WHERE consult_id = ?
            LIMIT 1
        ");
        $stmt->execute([$consultId]);
        $diagnostic = $stmt->fetch(PDO::FETCH_ASSOC);
        return $diagnostic ?: null;
    }
}
?>