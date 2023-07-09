<?php
include_once("Connection.php");
include_once("Product.php");

class Stock
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try{
            $sql = "SELECT S.*,P.*,O.* FROM stock_tb S,product_tb P, order_tb O WHERE S.product_id =  P.product_id AND S.order_id = O.order_id ORDER BY S.exp_date DESC";
            $stmt = $this -> conn -> prepare($sql);
            $stmt->execute();
            $result = $stmt ->fetchAll();
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

    public function fetchAllDate($date)
    {
        try{
            $sql = "SELECT S.*,P.*,O.* FROM stock_tb S,product_tb P, order_tb O WHERE S.product_id =  P.product_id AND S.order_id = O.order_id AND S.exp_date LIKE ? ORDER BY S.exp_date DESC";
            $stmt = $this->conn->prepare($sql);
            $like = "%$date%";
            $stmt->bindParam(1, $like, PDO::PARAM_STR);
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

    public function fetchAllCondition($date,$id,$keyword)
    {
        try{
            $sql = "SELECT S.*,P.*,O.* FROM stock_tb S,product_tb P, order_tb O WHERE S.product_id =  P.product_id AND S.order_id = O.order_id AND P.category_id = ?
                AND S.exp_date LIKE ? AND P.product_name LIKE ? ORDER BY S.exp_date DESC   ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $like = "%$date%";
            $stmt->bindParam(2, $like, PDO::PARAM_STR);
            $like2 = "%$keyword%";
            $stmt->bindParam(3, $like2, PDO::PARAM_STR);
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

    public function searchsales($keyword, $id = null)
    {
        try{
            $like = "%$keyword%";
            if (is_null($id)) {
                $sql = "SELECT S.*,P.*,O.* FROM stock_tb S,product_tb P, order_tb O WHERE S.product_id =  P.product_id AND S.order_id = O.order_id AND P.product_name LIKE ?";

            } else {
                $sql = "SELECT S.*,P.*,O.* FROM stock_tb S,product_tb P, order_tb O WHERE S.product_id =  P.product_id AND S.order_id = O.order_id AND P.category_id = ?  AND P.product_name LIKE ? ";
            }
            $sql .= ' ORDER BY S.exp_date DESC' ;
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
            return [];
        }
    }

    public function fetchAllDateAndKeyword($date,$keyword)
    {
        try{
            $sql = "SELECT S.*,P.*,O.* FROM stock_tb S,product_tb P, order_tb O WHERE S.product_id =  P.product_id AND S.order_id = O.order_id  
                AND S.exp_date LIKE ? AND P.product_name LIKE ? ORDER BY S.exp_date DESC ";
            $stmt = $this->conn->prepare($sql);
            $like = "%$date%";
            $stmt->bindParam(1, $like, PDO::PARAM_STR);
            $like2 = "%$keyword%";
            $stmt->bindParam(2, $like2, PDO::PARAM_STR);
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

    public function fetchAllDateAndId($date,$id)
    {
        try{
            $sql = "SELECT S.*,P.*,O.* FROM stock_tb S,product_tb P, order_tb O WHERE S.product_id =  P.product_id AND S.order_id = O.order_id AND P.category_id = ? AND S.exp_date LIKE ? ORDER BY S.exp_date DESC ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $like = "%$date%";
            $stmt->bindParam(2, $like, PDO::PARAM_STR);
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

    public function fetchById($id)
    {
        try{
            $sql = "SELECT S.*,P.*,O.* FROM stock_tb S,product_tb P, order_tb O WHERE S.product_id =  P.product_id AND S.order_id = O.order_id AND P.category_id = ? ORDER BY S.exp_date DESC";
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

   /* public function fetchByProductId($id)
    {
        $servername = "localhost";
        $username = "elnvento_AgrStore";
        $password = "grSt0re6502";
        $database = "elnvento_AgrStore";
        $conn = mysqli_connect($servername, $username, $password, $database);
        $id = mysqli_real_escape_string($conn,$id);
        $sql = "SELECT * FROM stock_tb WHERE product_id = $id";
        $q = mysqli_query($conn,$sql);
        $result = [];
        if($q){
            while ($r=mysqli_fetch_assoc($q)){
                $result[] = $r;
            }
        }
        return $result;
   }*/

        /*เซิร์ฟ หลัก*/
        /*$servername = "localhost";
        $username = "elnvento_AgrStore";
        $password = "grSt0re6502";
        $database = "elnvento_AgrStore";*/

        /*เซิร์ฟ รอง*/
        /*$servername = "localhost";
        $username = "root";
        $password = "shopproject";
        $database = "shop_pj";*/

        /*เซิร์ฟ  ทดสอบ*/
        /*$servername = "localhost";
        $username = "root";
        $password = "";
        $database = "shop_pj";*/

    public function fetchByProductId($id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "SELECT * FROM stock_tb WHERE product_id = ?";
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
            echo strval($e);
        }
    }


    public function cut($q,$id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "UPDATE stock_tb SET amount_exp = amount_exp - ? WHERE stock_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $q, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function delete($id)
    {
        try{
            $sql = "DELETE FROM stock_tb WHERE stock_id=?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function insert($data)
    {
        try{
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "INSERT INTO stock_tb (order_id, product_id, exp_date, amount_exp) 
        VALUES (?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['order_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['product_id'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['exp_date'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['amount_exp'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function update($data)
    {
        try{
            $sql = "UPDATE stock_tb
        SET order_id = ?, product_id = ?, exp_date = ?, amount_exp = ?
        WHERE stock_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['order_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['product_id'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['exp_date'], PDO::PARAM_INT);
            $stmt->bindParam(4, $data['amount_exp'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['stock_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }
}
