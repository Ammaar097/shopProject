<?php
include_once("Connection.php");

class Notification
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAddCategory()
    {
        try {
            $sql = "SELECT P.*,C.* FROM category_tb C,product_tb P WHERE P.category_id = C.category_id AND P.product_rm_unit <= P.notification_amt ORDER BY P.product_name ASC";
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

    public function search($keyword, $id = null)
    {
        try {
            $like = "%$keyword%";
            if (is_null($id)) {
                $sql = "SELECT C.*,P.* FROM category_tb C,product_tb P WHERE C.category_id = P.category_id AND P.product_rm_unit <= P.notification_amt AND P.product_name LIKE ? ORDER BY P.product_name ASC";
            } else {
                $sql = "SELECT C.*,P.* FROM category_tb C,product_tb P WHERE C.category_id = ? AND P.product_rm_unit <= P.notification_amt AND P.product_name LIKE ? ORDER BY P.product_name ASC";
            }
            $stmt = $this->conn->prepare($sql);
            if (is_null($id)) {
                $stmt->bindParam(1, $like, PDO::PARAM_STR);
            } else {
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->bindParam(2, $like, PDO::PARAM_STR);
            }
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

    public function fetchByCategoryId($id)
    {
        try {
            $sql = "SELECT C.*,P.* FROM category_tb C,product_tb P WHERE C.category_id = P.category_id AND P.product_rm_unit <= P.notification_amt AND C.category_id = ? ORDER BY P.product_name ASC";
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
            echo strval($e);
        }
    }

    function updateStatus($status, $id)
    {
        try {
            $sql = "UPDATE product_tb SET sales_status = ? WHERE product_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $status, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
