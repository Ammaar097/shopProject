<?php
include_once("Connection.php");
include_once("Product.php");

class Category
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try{
            $sql = "SELECT * FROM category_tb";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll( PDO::FETCH_ASSOC);
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
        try{
            $sql = "SELECT * FROM category_tb WHERE category_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch( PDO::FETCH_ASSOC);
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


    public function getCount($id, $on)
    {
        try{
            $products = new Product();
            $products = $products->fetchByCategoryId($id);
            $counts = 0;
            if ($on) {
                foreach ($products as $product) {
                    if (intval($product['sales_status']) === 0) {
                        $counts++;
                    }
                }
            } else {
                foreach ($products as $product) {
                    $counts++;
                }
            }
            return $counts;
        }catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function delete($id)
    {
        try{
            $sql = "DELETE FROM category_tb WHERE category_id=?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        }catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function insert($data)
    {
       try{
           $sql = "SET FOREIGN_KEY_CHECKS=0";
           $stmt = $this->conn->prepare($sql);
           $stmt->execute();
           $sql = "INSERT INTO category_tb (category_name) VALUES (?)";
           $stmt = $this->conn->prepare($sql);
           $stmt->bindParam(1, $data['category_name'], PDO::PARAM_STR);
           $stmt->execute();
       }catch (Exception $e) {
           http_response_code(500);
           echo strval($e);
       }
    }

    public function update($data)
    {
        try{
            $sql = "UPDATE category_tb
        SET category_name = ?
        WHERE category_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['category_name'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['category_id'], PDO::PARAM_INT);
            $stmt->execute();
        }catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
