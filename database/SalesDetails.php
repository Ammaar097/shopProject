<?php
include_once("Connection.php");

class SalesDetails
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try{
            $sql = "SELECT * FROM sales_details_tb";
            $stmt = $this->conn->prepare($sql);
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

    public function fetchById($id)
    {
        try {
            $sql = "SELECT * FROM sales_details_tb WHERE unique_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch( PDO::FETCH_ASSOC);
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

    public function fetchBySalesId($id)
    {
        try {
            $sql = "SELECT C.*,SAD.*,P.* FROM contract_tb C,sales_details_tb SAD,product_tb P WHERE SAD.product_id = P.product_id AND SAD.sales_list_id = C.sales_list_id AND C.sales_list_id  = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();
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
            $sql = "DELETE FROM sales_details_tb WHERE unique_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function  deleteBySalesId($salesId){ //ลบรายละเอียดการขายจากรหัสการขาย
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "DELETE FROM sales_details_tb WHERE sales_list_id=?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $salesId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function insert($data)
    {
        try{
            $sql = "INSERT INTO sales_details_tb (sales_list_id ,product_id ,sales_amt, sales_pr)
        VALUES (?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['sales_list_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['product_id'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['sales_amt'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['sales_pr'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function update($data)
    {
        try{
            $sql = "UPDATE sales_details_tb
        SET sales_list_id = ?, product_id = ?, sales_amt = ?, sales_pr = ?
        WHERE unique_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['sales_list_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['product_id'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['sales_amt'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['sales_pr'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['unique_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
