<?php
/**
 * Modelo para a tabela diagnosis
 */
class Diagnosis {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cria um novo diagnóstico
     */
    public function createDiagnosis(
        string $details, 
        string $file, 
        int $consult_id, 
        int $doctor_id
    ): int {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO diagnosis (details, file, consult_id, doctor_id)
                VALUES (?, ?, ?, ?)
            ");
            
            $stmt->execute([$details, $file, $consult_id, $doctor_id]);
            return (int)$this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erro ao criar diagnóstico: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Retorna todos os diagnósticos com informações da consulta e médico
     */
    public function getAllDiagnoses(): array {
        try {
            $stmt = $this->pdo->query("
                SELECT d.*, 
                       e.name as doctor_name,
                       c.date as consult_date,
                       c.time as consult_time,
                       p.name as patient_name
                FROM diagnosis d
                LEFT JOIN employee e ON d.doctor_id = e.id
                LEFT JOIN consult c ON d.consult_id = c.id
                LEFT JOIN patient p ON c.patient_id = p.id
                ORDER BY c.date DESC, c.time DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar diagnósticos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca um diagnóstico pelo ID com informações da consulta e médico
     */
    public function findById(int $id): ?array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT d.*, 
                       e.name as doctor_name,
                       c.date as consult_date,
                       c.time as consult_time,
                       c.type as consult_type,
                       p.name as patient_name
                FROM diagnosis d
                LEFT JOIN employee e ON d.doctor_id = e.id
                LEFT JOIN consult c ON d.consult_id = c.id
                LEFT JOIN patient p ON c.patient_id = p.id
                WHERE d.id = ?
            ");
            $stmt->execute([$id]);
            $diagnosis = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $diagnosis ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar diagnóstico: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Atualiza os dados de um diagnóstico
     */
    public function updateDiagnosis(
        int $id,
        string $details, 
        string $file, 
        int $consult_id, 
        int $doctor_id
    ): bool {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE diagnosis 
                SET details = ?, file = ?, consult_id = ?, doctor_id = ?
                WHERE id = ?
            ");
            
            return $stmt->execute([$details, $file, $consult_id, $doctor_id, $id]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar diagnóstico: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove um diagnóstico
     */
    public function deleteDiagnosis(int $id): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM diagnosis WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erro ao excluir diagnóstico: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca diagnósticos por consulta
     */
    public function findByConsult(int $consult_id): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT d.*, e.name as doctor_name
                FROM diagnosis d
                LEFT JOIN employee e ON d.doctor_id = e.id
                WHERE d.consult_id = ?
                ORDER BY d.id ASC
            ");
            $stmt->execute([$consult_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar diagnósticos por consulta: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca diagnósticos por médico
     */
    public function findByDoctor(int $doctor_id): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT d.*, 
                       c.date as consult_date,
                       c.time as consult_time,
                       p.name as patient_name
                FROM diagnosis d
                LEFT JOIN consult c ON d.consult_id = c.id
                LEFT JOIN patient p ON c.patient_id = p.id
                WHERE d.doctor_id = ?
                ORDER BY c.date DESC, c.time DESC
            ");
            $stmt->execute([$doctor_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar diagnósticos por médico: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca diagnósticos por paciente
     */
    public function findByPatient(int $patient_id): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT d.*, 
                       e.name as doctor_name,
                       c.date as consult_date,
                       c.time as consult_time
                FROM diagnosis d
                LEFT JOIN employee e ON d.doctor_id = e.id
                LEFT JOIN consult c ON d.consult_id = c.id
                WHERE c.patient_id = ?
                ORDER BY c.date DESC, c.time DESC
            ");
            $stmt->execute([$patient_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar diagnósticos por paciente: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtém todas as consultas para seleção
     */
    public function getAllConsults(): array {
        try {
            $stmt = $this->pdo->query("
                SELECT c.id, c.date, c.time, p.name as patient_name
                FROM consult c
                LEFT JOIN patient p ON c.patient_id = p.id
                ORDER BY c.date DESC, c.time DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar consultas: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtém todos os médicos para seleção
     */
    public function getAllDoctors(): array {
        try {
            $stmt = $this->pdo->query("
                SELECT e.id, e.name 
                FROM employee e
                JOIN employee_position ep ON e.id = ep.employee_id
                JOIN position p ON ep.position_id = p.id
                WHERE p.type LIKE '%Médico%' OR p.type LIKE '%Doctor%' OR p.type LIKE '%Doutor%'
                GROUP BY e.id
                ORDER BY e.name ASC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar médicos: " . $e->getMessage());
            return [];
        }
    }
}
?>
