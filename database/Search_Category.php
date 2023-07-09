<?php
include_once("Connection.php");

class Search_Category
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try {
            $sql = "SELECT SC.*,C.category_name FROM search_category_tb SC,category_tb C WHERE SC.category_id = C.category_id ";
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

    public function insert($data)
    {
        try {
            $sql = "INSERT INTO search_category_tb(category_id) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['category_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function reset()
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0; TRUNCATE TABLE search_category_tb;";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
