<?php
include_once("Connection.php");
class Order
{
    private $conn;
    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try {
            $sql = "SELECT * FROM order_tb";
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
            return [];
        }
    }

    public function fetchAllOrder($id)
    {
        try {
            $sql = "SELECT O.*,OD.*, S.sell_name,S.sell_id FROM order_tb O,order_details_tb OD,sell_tb S WHERE O.order_id = OD.order_id AND O.order_id AND O.sell_id = S.sell_id AND O.order_id = ?";
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

    public function fetchAllOrder2($id)
    {
        try {
            $sql = "SELECT O.*,S.sell_name,S.sell_id FROM order_tb O,sell_tb S WHERE O.sell_id = S.sell_id AND O.order_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch();
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

    public function fetchAllSell()
    {
        try {
            $sql = "SELECT O.*,S.* FROM order_tb O,sell_tb S WHERE O.sell_id = S.sell_id order by O.datebill desc ";
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
            return [];
        }
    }

    public function search($keyword, $date = null)
    {
        try {
            $like = "%$keyword%";
            if (is_null($date)) {
                $sql = "SELECT O.*,S.* FROM order_tb O,sell_tb S WHERE O.sell_id = S.sell_id AND S.sell_name LIKE ?";
            } else {
                $sql = "SELECT O.*,S.* FROM order_tb O,sell_tb S WHERE O.sell_id = S.sell_id AND S.sell_name LIKE ? AND payment_dt = ?";
            }
            $stmt = $this->conn->prepare($sql);
            if (is_null($date)) {
                $stmt->bindParam(1, $like, PDO::PARAM_STR);
            } else {
                $stmt->bindParam(2, $date, PDO::PARAM_STR);
            }
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
    public function fetchByDate($date)
    {
        try {
            $sql = "SELECT O.*,S.* FROM order_tb O,sell_tb S WHERE O.sell_id = S.sell_id AND payment_dt = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $date, PDO::PARAM_STR);
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

    public function fetchAllSell2()
    {
        try {
            $sql = "SELECT O.*,S.* FROM order_tb O,sell_tb S WHERE O.sell_id = S.sell_id AND O.order_status = 0 order by O.datebill desc ";
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
            return [];
        }
    }

    public function search2($keyword, $date = null)
    {
        try {
            $like = "%$keyword%";
            if (is_null($date)) {
                $sql = "SELECT O.*,S.* FROM order_tb O,sell_tb S WHERE O.sell_id = S.sell_id AND O.order_status = 0 AND S.sell_name LIKE ?";
            } else {
                $sql = "SELECT O.*,S.* FROM order_tb O,sell_tb S WHERE O.sell_id = S.sell_id AND O.order_status = 0 AND S.sell_name LIKE ? AND payment_dt = ?";
            }
            $stmt = $this->conn->prepare($sql);
            if (is_null($date)) {
                $stmt->bindParam(1, $like, PDO::PARAM_STR);
            } else {
                $stmt->bindParam(2, $date, PDO::PARAM_STR);
            }
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
    public function fetchByDate2($date)
    {
        try {
            $sql = "SELECT O.*,S.* FROM order_tb O,sell_tb S WHERE O.sell_id = S.sell_id AND O.order_status = 0 AND payment_dt = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $date, PDO::PARAM_STR);
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
            $sql = "SELECT * FROM order_tb WHERE order_id =?";
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

    public function getLastId()
    {
        try {
            $data = $this->fetchLast();
            return $data['order_id'];
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function fetchLast() //Order
    {
        try {
            $sql = "SELECT * FROM order_tb ORDER BY order_id DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM order_tb WHERE order_id=?;";
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
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "INSERT INTO order_tb (datebill, datereceive, sell_id, payment_sl, payment_dt, note, bank_slip, /*receipt, invoice*/ all_price_odr,all_amount_odr) 
        VALUES (TIMESTAMP(?, CURRENT_TIME()),TIMESTAMP(?, CURRENT_TIME()),?,?,TIMESTAMP(?, CURRENT_TIME()),?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['datebill'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['datereceive'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['sell_id'], PDO::PARAM_INT);
            $stmt->bindParam(4, $data['payment_sl'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['payment_dt'], PDO::PARAM_STR);
            $stmt->bindParam(6, $data['note'], PDO::PARAM_STR);
            $stmt->bindParam(7, $data['bank_slip'], PDO::PARAM_STR);
            $stmt->bindParam(8, $data['all_price_odr']);
            $stmt->bindParam(9, $data['all_amount_odr'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    function updateStatus($status, $id)
    {
        try {
            $sql = "UPDATE order_tb SET order_status = ? WHERE order_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $status, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function updateimageB($filename, $img, $order_id)
    {
        try {
            $colname = ['bank_slip'];
            if (in_array($filename, $colname)) {
                $sql = "UPDATE order_tb SET $filename = ? WHERE order_id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $img, PDO::PARAM_STR);
                $stmt->bindParam(2, $order_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function updateimageR($filename, $img, $order_id)
    {
        try {
            $colname = ['receipt'];
            if (in_array($filename, $colname)) {
                $sql = "UPDATE order_tb SET $filename = ? WHERE order_id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $img, PDO::PARAM_STR);
                $stmt->bindParam(2, $order_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function updateimageI($filename, $img, $order_id)
    {
        try {
            $colname = ['invoice'];
            if (in_array($filename, $colname)) {
                $sql = "UPDATE order_tb SET $filename = ? WHERE order_id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $img, PDO::PARAM_STR);
                $stmt->bindParam(2, $order_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function updateconfirm($data)
    {
        try {
            $sql = "UPDATE order_tb
            SET all_price_odr = ?, order_status = ?
            WHERE order_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['all_price_odr']);
            $stmt->bindParam(2, $data['order_status'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['order_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function update($data)
    {
        try {
            $sql = "UPDATE order_tb
            SET datereceive = ?,payment_sl = ?,payment_dt = ?,note = ?, all_price_odr = ? , all_amount_odr = ?
            WHERE order_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['datereceive'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['payment_sl'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['payment_dt'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['note'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['all_price_odr']);
            $stmt->bindParam(6, $data['all_amount_odr'], PDO::PARAM_INT);
            $stmt->bindParam(7, $data['order_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
