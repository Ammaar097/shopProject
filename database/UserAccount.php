<?php
include_once("Connection.php");

class UserAccount
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try {
            $sql = "SELECT * FROM user_account_tb";
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

    public function fetchLabers()
    {
        try {
            $sql = 'SELECT * FROM user_account_tb WHERE account_user_type ="L"';
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

    public function fetchAddEmployee()
    {
        try {
            $sql = "SELECT U.*,E.* FROM user_account_tb U,employee_tb E WHERE U.employee_id = E.employee_id";
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

    public function updateStatus($status, $id)
    {
        try {
            $sql = "UPDATE user_account_tb SET account_user_status = ? WHERE employee_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $status, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchById($id)
    {
        try {
            $sql = "SELECT * FROM user_account_tb WHERE unique_id = ?";
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

    public function fetchByIdWithoutAdmin($id)
    {
        try {
            $sql = "SELECT * FROM user_account_tb WHERE employee_id = ? ";
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

    public function deleteByEmployeeId($id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "DELETE FROM user_account_tb WHERE employee_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function delete($id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "DELETE FROM user_account_tb WHERE unique_id=?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchByEmail($email)
    {
        try {
            $sql = "SELECT * FROM user_account_tb WHERE account_username = ?";
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


    public function search($keyword, $type = null)  // sql ผิดอยู่
    {
      try{
          $userData = $this->fetchAddEmployee();
          $data = [];
          foreach ($userData as $user) {
              if (strpos($user['employee_firstname'], $keyword) !== false
                  || strpos($user['employee_lastname'], $keyword) !== false) {
                  if (is_null($type)) {
                      $data[] = $user;
                  } else {
                      if (strpos($user['account_user_type'], $type) !== false) {
                          $data[] = $user;
                      }
                  }
              }
          }
          return $data;
      }catch (Exception $e) {
          http_response_code(500);
          return [];
      }
    }

    public function findByType($type)
    {
        try{
            $userData = $this->fetchAddEmployee();
            $data = [];
            foreach ($userData as $user) {
                if ($user['account_user_type'] == $type) {
                    $data[] = $user;
                }
            }
            return $data;
        }catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function insert($data)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "INSERT INTO user_account_tb (account_username, account_password, account_user_status, employee_id ,account_user_type) 
        VALUES (?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['account_username'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['account_password'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['account_user_status'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['employee_id'], PDO::PARAM_INT);
            $stmt->bindParam(5, $data['account_user_type'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function update($data)
    {

        if ($data['account_password'] == "") {
            try {
                $sql = "SET FOREIGN_KEY_CHECKS=0";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $sql = "UPDATE user_account_tb SET account_username = ?, account_user_type= ? WHERE employee_id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $data['account_username'], PDO::PARAM_STR);
                $stmt->bindParam(2, $data['account_user_type'], PDO::PARAM_STR);
                $stmt->bindParam(3, $data['employee_id'], PDO::PARAM_INT);
                $stmt->execute();
                $sql = "UPDATE employee_tb SET employee_email = ? WHERE employee_id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $data['account_username'], PDO::PARAM_STR);
                $stmt->bindParam(2, $data['employee_id'], PDO::PARAM_INT);
                $stmt->execute();
            } catch (Exception $e) {
                http_response_code(500);
                echo strval($e);
            }
        }
        else {
            try {
                $sql = "SET FOREIGN_KEY_CHECKS=0";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $sql = "UPDATE user_account_tb
            SET account_username = ?, account_password = ?,  account_user_type= ?
            WHERE employee_id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $data['account_username'], PDO::PARAM_STR);
                $password_hash = password_hash($data['account_password'], PASSWORD_BCRYPT);
                $stmt->bindParam(2, $password_hash, PDO::PARAM_STR);
                $stmt->bindParam(3, $data['account_user_type'], PDO::PARAM_STR);
                $stmt->bindParam(4, $data['employee_id'], PDO::PARAM_INT);
                $stmt->execute();
                $sql = "UPDATE employee_tb SET employee_email = ? WHERE employee_id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $data['account_username'], PDO::PARAM_STR);
                $stmt->bindParam(2, $data['employee_id'], PDO::PARAM_INT);
                $stmt->execute();
            } catch (Exception $e) {
                http_response_code(500);
                echo strval($e);
            }
        }

    }
}
