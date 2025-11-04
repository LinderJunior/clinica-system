<?php
/**
 * Modelo para a tabela employee
 */
class Employee {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

  public function createEmployee(string $name, string $bi, string $phoneNumber, string $doctor, array $positionIds): bool {
    try {
        $this->pdo->beginTransaction();

        // Inserir o funcionário
        $stmt = $this->pdo->prepare("
            INSERT INTO employee (name, bi, phoneNumber, doctor)
            VALUES (?, ?, ?, ?)
        ");
        $result = $stmt->execute([$name, $bi, $phoneNumber, $doctor]); // <-- corrigido

        if (!$result) {
            $this->pdo->rollBack();
            return false;
        }

        $employeeId = $this->pdo->lastInsertId();

        // Associar o funcionário às posições/cargos
        foreach ($positionIds as $positionId) {
            $stmt = $this->pdo->prepare("
                INSERT INTO employee_position (employee_id, position_id)
                VALUES (?, ?)
            ");
            $result = $stmt->execute([$employeeId, $positionId]);

            if (!$result) {
                $this->pdo->rollBack();
                return false;
            }
        }

        $this->pdo->commit();
        return true;

    } catch (PDOException $e) {
        $this->pdo->rollBack();
        error_log("Erro ao criar funcionário: " . $e->getMessage());
        return false;
    }
}


    /**
     * Retorna todos os funcionários com suas posições/cargos
     */
    public function getAllEmployees(): array {
        try {
            $stmt = $this->pdo->query("
                SELECT e.*, GROUP_CONCAT(p.id) as position_ids, GROUP_CONCAT(p.type) as position_types
                FROM employee e
                LEFT JOIN employee_position ep ON e.id = ep.employee_id
                LEFT JOIN position p ON ep.position_id = p.id
                GROUP BY e.id
                ORDER BY e.name ASC
            ");
            
            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Formatar os dados para incluir as posições como arrays
            foreach ($employees as &$employee) {
                if (isset($employee['position_ids']) && $employee['position_ids']) {
                    $employee['positions'] = array_map(function($id, $type) {
                        return ['id' => $id, 'type' => $type];
                    }, 
                    explode(',', $employee['position_ids']),
                    explode(',', $employee['position_types']));
                } else {
                    $employee['positions'] = [];
                }
                
                // Remover campos auxiliares
                unset($employee['position_ids']);
                unset($employee['position_types']);
            }
            
            return $employees;
        } catch (PDOException $e) {
            error_log("Erro ao listar funcionários: " . $e->getMessage());
            return [];
        }
    }


    public function getAllDoctors(): array {
    try {
        $stmt = $this->pdo->prepare("
            SELECT e.*, GROUP_CONCAT(p.id) as position_ids, GROUP_CONCAT(p.type) as position_types
            FROM employee e
            LEFT JOIN employee_position ep ON e.id = ep.employee_id
            LEFT JOIN position p ON ep.position_id = p.id
            WHERE e.doctor = ?
            GROUP BY e.id
            ORDER BY e.name ASC
        ");
        $stmt->execute(['1']); // apenas médicos

        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Formatar os dados para incluir as posições como arrays
        foreach ($employees as &$employee) {
            if (isset($employee['position_ids']) && $employee['position_ids']) {
                $employee['positions'] = array_map(function($id, $type) {
                    return ['id' => $id, 'type' => $type];
                }, 
                explode(',', $employee['position_ids']),
                explode(',', $employee['position_types']));
            } else {
                $employee['positions'] = [];
            }

            // Remover campos auxiliares
            unset($employee['position_ids']);
            unset($employee['position_types']);
        }

        return $employees;
    } catch (PDOException $e) {
        error_log("Erro ao listar médicos: " . $e->getMessage());
        return [];
    }
}





    /**
     * Busca um funcionário pelo ID com suas posições/cargos
     */
    public function findById(int $id): ?array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT e.*, GROUP_CONCAT(p.id) as position_ids, GROUP_CONCAT(p.type) as position_types
                FROM employee e
                LEFT JOIN employee_position ep ON e.id = ep.employee_id
                LEFT JOIN position p ON ep.position_id = p.id
                WHERE e.id = ?
                GROUP BY e.id
            ");
            
            $stmt->execute([$id]);
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($employee) {
                // Formatar as posições como array
                if (isset($employee['position_ids']) && $employee['position_ids']) {
                    $employee['positions'] = array_map(function($id, $type) {
                        return ['id' => $id, 'type' => $type];
                    }, 
                    explode(',', $employee['position_ids']),
                    explode(',', $employee['position_types']));
                } else {
                    $employee['positions'] = [];
                }
                
                // Remover campos auxiliares
                unset($employee['position_ids']);
                unset($employee['position_types']);
            }
            
            return $employee ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar funcionário: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Atualiza os dados de um funcionário e suas posições/cargos
     */
    public function updateEmployee(int $id, string $name, string $bi, string $phoneNumber, array $positionIds): bool {
        try {
            // Iniciar transação
            $this->pdo->beginTransaction();
            
            // Atualizar o funcionário
            $stmt = $this->pdo->prepare("
                UPDATE employee 
                SET name = ?, bi = ?, phoneNumber = ?
                WHERE id = ?
            ");
            
            $result = $stmt->execute([$name, $bi, $phoneNumber, $id]);
            
            if (!$result) {
                $this->pdo->rollBack();
                return false;
            }
            
            // Remover todas as associações existentes
            $stmt = $this->pdo->prepare("DELETE FROM employee_position WHERE employee_id = ?");
            $result = $stmt->execute([$id]);
            
            if (!$result) {
                $this->pdo->rollBack();
                return false;
            }
            
            // Adicionar as novas associações
            foreach ($positionIds as $positionId) {
                $stmt = $this->pdo->prepare("
                    INSERT INTO employee_position (employee_id, position_id)
                    VALUES (?, ?)
                ");
                
                $result = $stmt->execute([$id, $positionId]);
                
                if (!$result) {
                    $this->pdo->rollBack();
                    return false;
                }
            }
            
            // Confirmar transação
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            // Reverter em caso de erro
            $this->pdo->rollBack();
            error_log("Erro ao atualizar funcionário: " . $e->getMessage());
            return false;
        }
    }



    public function updateEmployeeBasic(int $id, string $name, string $bi, string $phoneNumber): bool {
    try {
        $stmt = $this->pdo->prepare("
            UPDATE employee 
            SET name = ?, bi = ?, phoneNumber = ?
            WHERE id = ?
        ");
        return $stmt->execute([$name, $bi, $phoneNumber, $id]);
    } catch (PDOException $e) {
        error_log("Erro ao atualizar dados do funcionário: " . $e->getMessage());
        return false;
    }
}








public function updateEmployeePositions(int $id, array $positionIds): bool {
    try {
        $this->pdo->beginTransaction();

        // Remover associações antigas
        $stmt = $this->pdo->prepare("DELETE FROM employee_position WHERE employee_id = ?");
        $stmt->execute([$id]);

        // Inserir novas posições
        $stmt = $this->pdo->prepare("INSERT INTO employee_position (employee_id, position_id) VALUES (?, ?)");
        foreach ($positionIds as $positionId) {
            $stmt->execute([$id, $positionId]);
        }

        $this->pdo->commit();
        return true;
    } catch (PDOException $e) {
        $this->pdo->rollBack();
        error_log("Erro ao atualizar posições do funcionário: " . $e->getMessage());
        return false;
    }
}





    /**
     * Remove um funcionário e suas associações com posições/cargos
     */
    public function deleteEmployee(int $id): bool {
        try {
            // Iniciar transação
            $this->pdo->beginTransaction();
            
            // Remover as associações com posições/cargos
            $stmt = $this->pdo->prepare("DELETE FROM employee_position WHERE employee_id = ?");
            $result = $stmt->execute([$id]);
            
            if (!$result) {
                $this->pdo->rollBack();
                return false;
            }
            
            // Remover o funcionário
            $stmt = $this->pdo->prepare("DELETE FROM employee WHERE id = ?");
            $result = $stmt->execute([$id]);
            
            if (!$result) {
                $this->pdo->rollBack();
                return false;
            }
            
            // Confirmar transação
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            // Reverter em caso de erro
            $this->pdo->rollBack();
            error_log("Erro ao excluir funcionário: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca funcionários por nome (pesquisa parcial)
     */
    public function searchByName(string $name): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT e.*, GROUP_CONCAT(p.id) as position_ids, GROUP_CONCAT(p.type) as position_types
                FROM employee e
                LEFT JOIN employee_position ep ON e.id = ep.employee_id
                LEFT JOIN position p ON ep.position_id = p.id
                WHERE e.name LIKE ?
                GROUP BY e.id
                ORDER BY e.name ASC
            ");
            
            $stmt->execute(['%' . $name . '%']);
            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Formatar os dados para incluir as posições como arrays
            foreach ($employees as &$employee) {
                if (isset($employee['position_ids']) && $employee['position_ids']) {
                    $employee['positions'] = array_map(function($id, $type) {
                        return ['id' => $id, 'type' => $type];
                    }, 
                    explode(',', $employee['position_ids']),
                    explode(',', $employee['position_types']));
                } else {
                    $employee['positions'] = [];
                }
                
                // Remover campos auxiliares
                unset($employee['position_ids']);
                unset($employee['position_types']);
            }
            
            return $employees;
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar funcionários: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtém todas as posições/cargos disponíveis
     */
    public function getAllPositions(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM position ORDER BY type ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar posições/cargos: " . $e->getMessage());
            return [];
        }
    }
}
?>