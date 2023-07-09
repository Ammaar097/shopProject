<?php
include_once("Connection.php");

class CostPrice
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        $sql = "SELECT CP.*,P.product_name,P.brand,C.category_name FROM costprice_tb CP,product_tb P,category_tb C WHERE CP.product_id = P.product_id = C.category_id  ORDER BY CP.order_dt DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }

    public function fetchById($id)
    {
        try {
            $sql = "SELECT * FROM costprice_tb WHERE product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch (PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchBetween($id, $start, $end)
    {
        try {
            $sql = "SELECT C.*,P.product_name,P.product_id FROM costprice_tb C,product_tb P WHERE P.product_id = C.product_id AND C.product_id = ? AND C.costprice_dt BETWEEN ? AND ? ORDER BY C.costprice_dt DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->bindParam(2, $start, PDO::PARAM_STR);
            $stmt->bindParam(3, $end, PDO::PARAM_STR);
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

    public function insert($data)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "INSERT INTO costprice_tb (order_id, product_id, cost_price) 
            VALUES (?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['order_id'], PDO::PARAM_INT);//รหัสใบสั่งซื้อ
            $stmt->bindParam(2, $data['product_id'], PDO::PARAM_INT);//รหัสรายการสินค้า
            $stmt->bindParam(3, $data['cost_price'], PDO::PARAM_STR);//ราคาทุน
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
