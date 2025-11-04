<?php
/**
 * Modelo para a tabela consult
 */
class Consult {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cria uma nova consulta
     */
    public function createConsult(
        string $date, 
        string $time, 
        string $type, 
        int $status, 
        int $patient_id, 
        int $doctor_id
    ): int {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO consult (date, time, type, status, patient_id, doctor_id)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([$date, $time, $type, $status, $patient_id, $doctor_id]);
            return (int)$this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erro ao criar consulta: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Retorna todas as consultas com informações do paciente e médico
     */
    public function getAllConsults(): array {
        try {
            $stmt = $this->pdo->query("
                SELECT c.*, 
                       p.name as patient_name, 
                       e.name as doctor_name,
                       (SELECT COUNT(*) FROM diagnosis d WHERE d.consult_id = c.id) as diagnosis_count
                FROM consult c
                LEFT JOIN patient p ON c.patient_id = p.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                ORDER BY c.date DESC, c.time DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar consultas: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca uma consulta pelo ID com informações do paciente e médico
     */
    public function findById(int $id): ?array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT c.*, 
                       p.name as patient_name, 
                       e.name as doctor_name
                FROM consult c
                LEFT JOIN patient p ON c.patient_id = p.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                WHERE c.id = ?
            ");
            $stmt->execute([$id]);
            $consult = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($consult) {
                // Buscar diagnósticos relacionados
                $diagnosisStmt = $this->pdo->prepare("
                    SELECT d.*, e.name as doctor_name
                    FROM diagnosis d
                    LEFT JOIN employee e ON d.doctor_id = e.id
                    WHERE d.consult_id = ?
                ");
                $diagnosisStmt->execute([$id]);
                $consult['diagnoses'] = $diagnosisStmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            return $consult ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar consulta: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Atualiza os dados de uma consulta
     */
    public function updateConsult(
        int $id,
        string $date, 
        string $time, 
        string $type, 
        int $status, 
        int $patient_id, 
        int $doctor_id
    ): bool {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE consult 
                SET date = ?, time = ?, type = ?, status = ?, patient_id = ?, doctor_id = ?
                WHERE id = ?
            ");
            
            return $stmt->execute([$date, $time, $type, $status, $patient_id, $doctor_id, $id]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar consulta: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove uma consulta e seus diagnósticos relacionados
     */
    public function deleteConsult(int $id): bool {
        try {
            // Iniciar transação
            $this->pdo->beginTransaction();
            
            // Remover diagnósticos relacionados
            $diagnosisStmt = $this->pdo->prepare("DELETE FROM diagnosis WHERE consult_id = ?");
            $diagnosisStmt->execute([$id]);
            
            // Remover a consulta
            $consultStmt = $this->pdo->prepare("DELETE FROM consult WHERE id = ?");
            $result = $consultStmt->execute([$id]);
            
            // Confirmar transação
            $this->pdo->commit();
            return $result;
        } catch (PDOException $e) {
            // Reverter em caso de erro
            $this->pdo->rollBack();
            error_log("Erro ao excluir consulta: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca consultas por data
     */
    public function searchByDate(string $date): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT c.*, 
                       p.name as patient_name, 
                       e.name as doctor_name,
                       (SELECT COUNT(*) FROM diagnosis d WHERE d.consult_id = c.id) as diagnosis_count
                FROM consult c
                LEFT JOIN patient p ON c.patient_id = p.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                WHERE c.date = ?
                ORDER BY c.time ASC
            ");
            $stmt->execute([$date]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar consultas por data: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca consultas por paciente
     */
    public function searchByPatient(int $patient_id): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT c.*, 
                       p.name as patient_name, 
                       e.name as doctor_name,
                       (SELECT COUNT(*) FROM diagnosis d WHERE d.consult_id = c.id) as diagnosis_count
                FROM consult c
                LEFT JOIN patient p ON c.patient_id = p.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                WHERE c.patient_id = ?
                ORDER BY c.date DESC, c.time DESC
            ");
            $stmt->execute([$patient_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar consultas por paciente: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca consultas por médico
     */
    public function searchByDoctor(int $doctor_id): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT c.*, 
                       p.name as patient_name, 
                       e.name as doctor_name,
                       (SELECT COUNT(*) FROM diagnosis d WHERE d.consult_id = c.id) as diagnosis_count
                FROM consult c
                LEFT JOIN patient p ON c.patient_id = p.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                WHERE c.doctor_id = ?
                ORDER BY c.date DESC, c.time DESC
            ");
            $stmt->execute([$doctor_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar consultas por médico: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca consultas por status
     */
    public function searchByStatus(int $status): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT c.*, 
                       p.name as patient_name, 
                       e.name as doctor_name,
                       (SELECT COUNT(*) FROM diagnosis d WHERE d.consult_id = c.id) as diagnosis_count
                FROM consult c
                LEFT JOIN patient p ON c.patient_id = p.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                WHERE c.status = ?
                ORDER BY c.date DESC, c.time DESC
            ");
            $stmt->execute([$status]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar consultas por status: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtém todos os pacientes para seleção
     */
    public function getAllPatients(): array {
        try {
            $stmt = $this->pdo->query("SELECT id, name FROM patient ORDER BY name ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar pacientes: " . $e->getMessage());
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





        /**
     * Retorna o resumo e as consultas de um médico para o dashboard
     */
    public function getDoctorDashboardData(int $doctor_id): array {
        try {
            // Totais gerais
            $stmtTotal = $this->pdo->prepare("SELECT COUNT(*) FROM consult WHERE doctor_id = ?");
            $stmtTotal->execute([$doctor_id]);
            $total = (int)$stmtTotal->fetchColumn();

            $stmtCompleted = $this->pdo->prepare("SELECT COUNT(*) FROM consult WHERE doctor_id = ? AND status = 1");
            $stmtCompleted->execute([$doctor_id]);
            $completed = (int)$stmtCompleted->fetchColumn();

            $stmtPending = $this->pdo->prepare("SELECT COUNT(*) FROM consult WHERE doctor_id = ? AND status = 0");
            $stmtPending->execute([$doctor_id]);
            $pending = (int)$stmtPending->fetchColumn();

            $stmtCanceled = $this->pdo->prepare("SELECT COUNT(*) FROM consult WHERE doctor_id = ? AND status = 2");
            $stmtCanceled->execute([$doctor_id]);
            $canceled = (int)$stmtCanceled->fetchColumn();

            // Totais do mês e semana atuais
            $stmtMonth = $this->pdo->prepare("
                SELECT COUNT(*) FROM consult 
                WHERE doctor_id = ? AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())
            ");
            $stmtMonth->execute([$doctor_id]);
            $monthTotal = (int)$stmtMonth->fetchColumn();

            $stmtWeek = $this->pdo->prepare("
                SELECT COUNT(*) FROM consult 
                WHERE doctor_id = ? AND YEARWEEK(date, 1) = YEARWEEK(CURRENT_DATE(), 1)
            ");
            $stmtWeek->execute([$doctor_id]);
            $weekTotal = (int)$stmtWeek->fetchColumn();

            // Faturamento (considerando apenas consultas concluídas)
            $stmtFaturamento = $this->pdo->prepare("
                SELECT SUM(CASE WHEN type LIKE '%VIP%' THEN 5000 
                                WHEN type LIKE '%Normal%' THEN 3500 
                                ELSE 3000 END)
                FROM consult 
                WHERE doctor_id = ? AND status = 1
            ");
            $stmtFaturamento->execute([$doctor_id]);
            $faturamento = (float)($stmtFaturamento->fetchColumn() ?? 0);

            // Salário (exemplo: 70% do faturamento)
            $salary = round($faturamento * 0.7, 2);

            // Lista de consultas recentes
            $stmtConsults = $this->pdo->prepare("
                SELECT c.id, c.date, c.time, c.type, c.status, p.name AS patient_name
                FROM consult c
                LEFT JOIN patient p ON c.patient_id = p.id
                WHERE c.doctor_id = ?
                ORDER BY c.date DESC, c.time DESC
                LIMIT 50
            ");
            $stmtConsults->execute([$doctor_id]);
            $consults = $stmtConsults->fetchAll(PDO::FETCH_ASSOC);

            return [
                "total_consults" => $total,
                "completed" => $completed,
                "pending" => $pending,
                "canceled" => $canceled,
                "month_total" => $monthTotal,
                "week_total" => $weekTotal,
                "faturamento" => $faturamento,
                "salary" => $salary,
                "consults" => $consults
            ];

        } catch (PDOException $e) {
            error_log("Erro ao carregar dashboard do médico: " . $e->getMessage());
            return [];
        }
    }

































}
?>