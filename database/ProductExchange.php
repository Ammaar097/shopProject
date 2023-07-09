<?php
include_once("Connection.php");
if (!isset($_SESSION)) {
    session_start();
};
if (!isset($_SESSION['day_change'])) {
    $_SESSION['day_change'] = 7;
}
if (isset($_POST['day_change'])) {
    $_SESSION['day_change'] = $_POST['day_change'];
}

class ProductExchange
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try {
            $sql = "SELECT E.*,P.product_name FROM product_exchange_tb E,product_tb P WHERE E.product_id = P.product_id ORDER BY E.exchange_date DESC  ";
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
            echo strval($e);
        }
    }

    public function fetchById($id)
    {
        try {
            $sql = "SELECT E.*,P.product_name FROM product_exchange_tb E,product_tb P WHERE E.product_id = P.product_id AND E.product_exchange_id = ?";
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

    public function fetchBetween($start, $end)
    {
        try {
            $sql = "SELECT PE.*,P.* FROM product_exchange_tb PE,product_tb P WHERE PE.product_id = P.product_id  AND PE.exchange_date BETWEEN ? AND ? ORDER BY PE.exchange_date DESC ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $start, PDO::PARAM_STR);
            $stmt->bindParam(2, $end, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            if (!$result) {
                return [];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchExchange2Id($id)
    {
        try {
            $sql = "SELECT E.*,P.product_name FROM product_exchange_tb E,product_tb P WHERE E.product_id = P.product_id AND E.product_exchange_id = ?";
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

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM product_exchange_tb WHERE product_exchange_id = ?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    //เปลี่ยนชนิดข้อมูล INT หรือ STR
    public function insert($data)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "INSERT INTO product_exchange_tb
                (product_id, 
                 damage_proof, 
                 note, 
                 exchange_amount, 
                 exchange_status ";
            if ($data['exchange_status'] == '1') {
                $day_change = !isset($_SESSION['day_change']) ? 7 : $_SESSION['day_change'];
                $sql .= ' ,exchange_period,exchange_name,exchange_tel) VALUES (?,?,?,?,?, DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL ? DAY),?,?)';
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $data['product_id'], PDO::PARAM_INT);
                $stmt->bindParam(2, $data['damage_proof'], PDO::PARAM_STR);
                $stmt->bindParam(3, $data['note'], PDO::PARAM_STR);
                $stmt->bindParam(4, $data['exchange_amount'], PDO::PARAM_INT);
                $stmt->bindParam(5, $data['exchange_status'], PDO::PARAM_INT);
                $stmt->bindParam(6, $day_change, PDO::PARAM_STR);
                $stmt->bindParam(7, $data['exchange_name'], PDO::PARAM_STR);
                $stmt->bindParam(8, $data['exchange_tel'], PDO::PARAM_STR);
                $stmt->execute();
            } else {
                $sql .= ") VALUES (?,?,?,?,?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $data['product_id'], PDO::PARAM_INT);
                $stmt->bindParam(2, $data['damage_proof'], PDO::PARAM_STR);
                $stmt->bindParam(3, $data['note'], PDO::PARAM_STR);
                $stmt->bindParam(4, $data['exchange_amount'], PDO::PARAM_INT);
                $stmt->bindParam(5, $data['exchange_status'], PDO::PARAM_INT);
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
            $sql = "UPDATE product_exchange_tb
            SET damage_proof = ?, note = ?, exchange_amount = ?, exchange_status = ?, exchange_name = ?, exchange_tel = ?
            WHERE product_exchange_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['damage_proof'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['note'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['exchange_amount'], PDO::PARAM_INT);
            $stmt->bindParam(4, $data['exchange_status'], PDO::PARAM_INT);
            $stmt->bindParam(5, $data['exchange_name'], PDO::PARAM_STR);
            $stmt->bindParam(6, $data['exchange_tel'], PDO::PARAM_STR);
            $stmt->bindParam(7, $data['product_exchange_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function updateimage($filename, $img, $product_exchange_id)
    {
        try {
            $colname = ['damage_proof'];
            if (in_array($filename, $colname)) {
                $sql = "UPDATE product_exchange_tb SET $filename = ? WHERE product_exchange_id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $img, PDO::PARAM_STR);
                $stmt->bindParam(2, $product_exchange_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function status($product_exchange_id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "UPDATE product_exchange_tb SET exchange_status = 0 WHERE product_exchange_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $product_exchange_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
