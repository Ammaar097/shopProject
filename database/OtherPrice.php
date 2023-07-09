<?php
include_once("Connection.php");

class OtherPrice
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try{
            $sql = "SELECT * FROM otherprice_tb";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            if (!$result) {
                return [];
            } else {
                return $result;
            }
        }catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }

    }

    public function fetchById($id)
    {
        try {
            $sql = "SELECT * FROM otherprice_tb WHERE unique_id =?";
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
            return [];
        }
    }

    public function delete($id)
    {
        try{
            $sql = "DELETE FROM otherprice_tb  WHERE unique_id = ?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        }catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchByOPId($id)
    {
        try {
            $sql = "SELECT * FROM otherprice_tb WHERE order_id = ?";
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
            return [];
        }
    }

    public function insert($data)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "INSERT INTO otherprice_tb (order_id, listother, priceother) VALUES (?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['order_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['listother'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['priceother'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function update($data)
    {
        try{
            $sql = "UPDATE otherprice_tb
        SET order_id = ?, listother = ?, priceother = ?
        WHERE unique_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['order_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['listother'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['priceother'], PDO::PARAM_INT);
            $stmt->bindParam(4, $data['unique_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
