<?php
include_once("Connection.php");
class Search
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try{
            $sql = "SELECT * FROM search_tb ";
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

    public function insert($data)
    {
        try{
            $sql = "INSERT INTO search_tb (keyword) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['keyword'], PDO::PARAM_STR);
            $stmt->execute();
        }catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function reset()
    {
        try{
            $sql = "SET FOREIGN_KEY_CHECKS=0; TRUNCATE TABLE search_tb;";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        }catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
