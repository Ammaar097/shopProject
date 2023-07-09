<?php
include_once("Connection.php");
class Bank
{
    private $conn;
    function __construct()
    {
        $this->conn = Connection();
    }
    public function fetchAll()
    {
        try {
            $sql = "SELECT * FROM bank_tb";
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

    public function fetchById($id)
    {
        try {
            $sql = "SELECT * FROM bank_tb WHERE bank_id=?";
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

    public function fetchBySellId($id)
    {
        try {
            $sql = "SELECT * FROM bank_tb WHERE sell_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
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

    public function delete($id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "DELETE FROM bank_tb WHERE bank_id=?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function  deleteBySellId($SellId)
    { //ลบธนาคารจากรหัสพนักงาน
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "DELETE FROM bank_tb WHERE sell_id=?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $SellId, PDO::PARAM_INT);
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
            $sql = "INSERT INTO bank_tb (sell_id, bank_name, bank_number, bank_account) 
        VALUES (?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['sell_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['bank_name'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['bank_number'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['bank_account'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function update($data)
    {
        try {
            $sql = "UPDATE bank_tb
        SET sell_id = ?, bank_name = ?, bank_number = ?, bank_account = ?
        WHERE bank_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['sell_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['bank_name'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['bank_number'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['bank_account'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['bank_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
