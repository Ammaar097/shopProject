<?php
include_once("Connection.php");
include_once("UserAccount.php");

class Employee
{
    private $conn;

    function __construct()
    {
        try {
            $this->conn = Connection();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchAll()
    {
        try {
            $sql = "SELECT * FROM employee_tb";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function fetchWithOutUserId()
    {
        try {
            $employees = $this->fetchAll();
            $users = (new UserAccount())->fetchAll();
            $data = [];
            foreach ($employees as $employee) {
                $found = 0;
                foreach ($users as $user) {
                    if ($employee['employee_id'] == $user['employee_id']) {
                        $found++;
                    }
                }
                if ($found <= 0) {
                    $data[] = $employee;
                }
            }
            return $data;
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function fetchLabers()
    {
        try {
            $user = (new UserAccount())->fetchLabers();
            $labers = [];
            foreach ($user as $row) {
                $data = $this->fetchById($row['employee_id']);
                $labers[] = $data;
            }
            return $labers;
        } catch (Exception $e) {
            return [];
        }
    }

    public function searchByName($keyword)
    {
        try {
            $like = "%" . $keyword . "%";
            $sql = "SELECT * FROM employee_tb WHERE employee_firstname LIKE ? OR employee_lastname LIKE ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $like, PDO::PARAM_STR);
            $stmt->bindParam(2, $like, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function search($keyword, $id = null)
    {
        try {
            $like = "%" . $keyword . "%";
            $sql = "SELECT * FROM user_account_tb LEFT JOIN employee_tb ON user_account_tb.employee_id = user_account_tb.employee_id
        WHERE employee_firstname LIKE ? OR employee_lastname LIKE ?";
            if (!is_null($id)) {
                $sql .= " AND user_account_tb.account_user_type=?";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $like, PDO::PARAM_STR);
            if (!is_null($id)) {
                $stmt->bindParam(2, $id, PDO::PARAM_INT);
            }
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function updateStatus($status, $id)
    {
        try {
            $sql = "UPDATE employee_tb SET employee_status = ? WHERE employee_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $status, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function emailCheck($email)
    {
        try {
            $sql = "SELECT * FROM employee_tb WHERE employee_email=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function fetchHaveUser()
    {
    }

    public function fetchById($id)
    {
        try {
            $sql = "SELECT * FROM employee_tb WHERE employee_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function fetchLast()
    {
        try {
            $sql = "SELECT * FROM employee_tb ORDER BY employee_id DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM employee_tb WHERE employee_id=?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function insert($data)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "INSERT INTO employee_tb (employee_model, employee_startwork_dt, employee_prefix, employee_firstname, employee_lastname, employee_address, employee_birthday, employee_card_id, employee_telephone, employee_email, employee_card_id_copy, employee_address_copy) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['employee_model'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['employee_startwork_dt'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['employee_prefix'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['employee_firstname'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['employee_lastname'], PDO::PARAM_STR);
            $stmt->bindParam(6, $data['employee_address'], PDO::PARAM_STR);
            $stmt->bindParam(7, $data['employee_birthday'], PDO::PARAM_STR);
            $stmt->bindParam(8, $data['employee_card_id'], PDO::PARAM_STR);
            $stmt->bindParam(9, $data['employee_telephone'], PDO::PARAM_STR);
            $stmt->bindParam(10, $data['employee_email'], PDO::PARAM_STR);
            $stmt->bindParam(11, $data['employee_card_id_copy'], PDO::PARAM_STR);
            $stmt->bindParam(12, $data['employee_address_copy'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function updateimage($filename, $img, $employee_id)
    {
        try {
            $colname = ['employee_card_id_copy', 'employee_address_copy'];
            if (in_array($filename, $colname)) {
                $sql = "UPDATE employee_tb SET $filename = ? WHERE employee_id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $img, PDO::PARAM_STR);
                $stmt->bindParam(2, $employee_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }


    public function update($data)
    {
        try {
            $sql = "UPDATE employee_tb
        SET employee_firstname = ?, employee_lastname = ?, employee_address = ?, employee_telephone = ?, employee_email = ?
        WHERE employee_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['employee_firstname'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['employee_lastname'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['employee_address'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['employee_telephone'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['employee_email'], PDO::PARAM_STR);
            $stmt->bindParam(6, $data['employee_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
