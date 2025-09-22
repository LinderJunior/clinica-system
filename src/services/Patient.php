<?php
/**
 * Modelo para a tabela patient
 */
class Patient {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cria um novo paciente
     */
    public function createPatient(string $name, string $dateBirth, string $bi, string $province, 
                                string $city, string $neighborhood, string $phoneNumber, int $iswhatsapp): bool {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO patient (name, dateBirth, bi, province, city, neighborhood, phoneNumber, iswhatsapp)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            return $stmt->execute([
                $name, $dateBirth, $bi, $province, $city, $neighborhood, $phoneNumber, $iswhatsapp
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao criar paciente: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retorna todos os pacientes
     */
    public function getAllPatients(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM patient ORDER BY name ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar pacientes: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca um paciente pelo ID
     */
    public function findById(int $id): ?array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM patient WHERE id = ?");
            $stmt->execute([$id]);
            $patient = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $patient ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar paciente: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Atualiza os dados de um paciente
     */
    public function updatePatient(int $id, string $name, string $dateBirth, string $bi, string $province, 
                                string $city, string $neighborhood, string $phoneNumber, int $iswhatsapp): bool {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE patient 
                SET name = ?, dateBirth = ?, bi = ?, province = ?, city = ?, 
                    neighborhood = ?, phoneNumber = ?, iswhatsapp = ?
                WHERE id = ?
            ");
            
            return $stmt->execute([
                $name, $dateBirth, $bi, $province, $city, $neighborhood, $phoneNumber, $iswhatsapp, $id
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar paciente: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove um paciente
     */
    public function deletePatient(int $id): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM patient WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erro ao excluir paciente: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca pacientes por nome (pesquisa parcial)
     */
    public function searchByName(string $name): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM patient WHERE name LIKE ? ORDER BY name ASC");
            $stmt->execute(['%' . $name . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar pacientes: " . $e->getMessage());
            return [];
        }
    }
}
?>
