<?php
require_once __DIR__ . '/../../config/database.php';

class DoctorService {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Busca médico (funcionário com doctor = 1) por ID
    public function getDoctorById(int $id): ?array {
        $stmt = $this->pdo->prepare("
            SELECT 
                e.id,
                e.name,
                e.bi,
                e.phoneNumber,
                GROUP_CONCAT(p.type SEPARATOR ', ') AS posicao
            FROM employee e
            LEFT JOIN employee_position ep ON e.id = ep.employee_id
            LEFT JOIN position p ON p.id = ep.position_id
            WHERE e.id = ? AND e.doctor = 1
            GROUP BY e.id
        ");
        $stmt->execute([$id]);
        $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
        return $doctor ?: null;
    }

    // Consultas associadas ao médico
    public function getConsultationsByDoctorId(int $doctorId): array {
        $stmt = $this->pdo->prepare("
            SELECT 
                c.id,
                c.date,
                c.time,
                c.type,
                c.status,
                p.name AS patient_name
            FROM consult c
            JOIN patient p ON p.id = c.patient_id
            WHERE c.doctor_id = ?
            ORDER BY c.date DESC
        ");
        $stmt->execute([$doctorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>