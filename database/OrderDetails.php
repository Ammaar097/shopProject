<?php
include_once("Connection.php");

class OrderDetails
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try{$sql = "SELECT O.*,P.*,S.* FROM order_tb O,product_tb P,stock_tb S WHERE O.order_id = P.product_id = S.order_id ORDER BY S.exp_date DESC";
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

    public function fetchAllDate($date)
    {
       try{
           $sql = "SELECT O.*,OD.*,P.*,S.* FROM order_tb O,order_details_tb OD,product_tb P,stock_tb S WHERE O.order_id = OD.unique_id = P.product_id = S.stock_id AND S.exp_date = ? ORDER BY S.exp_date DESC ";
           $stmt = $this->conn->prepare($sql);
           $stmt->bindParam(1, $date, PDO::PARAM_STR);
           $stmt->execute();
           $result = $stmt->fetchAll();
           $dup = [];
           $res = [];
           foreach ($result as $r) {
               if (!in_array($r['product_id'], $dup)) {
                   $r['count'] = 1;
                   $res[] = $r;
                   $dup[] = $r['product_id'];
               } else {
                   $i = array_search($r['product_id'], $dup);
                   $res[$i]['count']++;
                   $res[$i]['all_amount'] += $r['all_amount'];
               }
           }
           $result = $res;
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

    public function fetchAllCondition($date, $id, $keyword)
    {
        try{
            $sql = "SELECT O.*,OD.*,P.*,S.* FROM order_tb O,order_details_tb OD,product_tb P,stock_tb S WHERE O.order_id = OD.unique_id = P.product_id = S.stock_id  AND P.category_id = ?
                AND S.exp_date = ? AND P.product_name LIKE ? ORDER BY S.exp_date DESC   ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->bindParam(2, $date, PDO::PARAM_STR);
            $like = "%" . $keyword . "%";
            $stmt->bindParam(3, $like, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['product_id'], $dup)) {
                    $r['count'] = 1;
                    $res[] = $r;
                    $dup[] = $r['product_id'];
                } else {
                    $i = array_search($r['product_id'], $dup);
                    $res[$i]['count']++;
                    $res[$i]['all_amount'] += $r['all_amount'];
                }
            }
            $result = $res;
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

    public function searchsales($keyword, $id = null)
    {
        try{
            $like = "%$keyword%";
            if (is_null($id)) {
                $sql = "SELECT O.*,OD.*,P.*,S.* FROM order_tb O,order_details_tb OD,product_tb P,stock_tb S WHERE O.order_id = OD.unique_id = P.product_id = S.stock_id  AND product_name LIKE ?";

            } else {
                $sql = "SELECT O.*,OD.*,P.*,S.* FROM order_tb O,order_details_tb OD,product_tb P,stock_tb S WHERE O.order_id = OD.unique_id = P.product_id = S.stock_id AND  P.category_id = ?  AND product_name LIKE ? ";
            }
            $sql .= ' ORDER BY S.exp_date DESC';
            $stmt = $this->conn->prepare($sql);
            if (is_null($id)) {
                $stmt->bindParam(1, $like, PDO::PARAM_STR);
            } else {
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->bindParam(2, $like, PDO::PARAM_STR);
            }
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['product_id'], $dup)) {
                    $r['count'] = 1;
                    $res[] = $r;
                    $dup[] = $r['product_id'];
                } else {
                    $i = array_search($r['product_id'], $dup);
                    $res[$i]['count']++;
                    $res[$i]['all_amount'] += $r['all_amount'];
                }
            }
            $result = $res;
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

    public function fetchAllDateAndKeyword($date, $keyword)
    {
        try{
            $sql = "SELECT O.*,OD.*,P.*,S.* FROM order_tb O,order_details_tb OD,product_tb P,stock_tb S WHERE O.order_id = OD.unique_id = P.product_id = S.stock_id  
                AND S.exp_date = ? AND P.product_name LIKE ? ORDER BY S.exp_date DESC ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $date, PDO::PARAM_STR);
            $like = "%" . $keyword . "%";
            $stmt->bindParam(2, $like, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['product_id'], $dup)) {
                    $r['count'] = 1;
                    $res[] = $r;
                    $dup[] = $r['product_id'];
                } else {
                    $i = array_search($r['product_id'], $dup);
                    $res[$i]['count']++;
                    $res[$i]['all_amount'] += $r['all_amount'];
                }
            }
            $result = $res;
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

    public function fetchAllDateAndId($date, $id)
    {
        try{
            $sql = "SELECT O.*,OD.*,P.*,S.* FROM order_tb O,order_details_tb OD,product_tb P,stock_tb S WHERE O.order_id = OD.unique_id = P.product_id = S.stock_id AND  P.category_id = ?
                AND S.exp_date = ? ORDER BY S.exp_date DESC ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->bindParam(2, $date, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['product_id'], $dup)) {
                    $r['count'] = 1;
                    $res[] = $r;
                    $dup[] = $r['product_id'];
                } else {
                    $i = array_search($r['product_id'], $dup);
                    $res[$i]['count']++;
                    $res[$i]['all_amount'] += $r['all_amount'];
                }
            }
            $result = $res;
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
            $sql = "SELECT O.*,OD.*,P.*,S.* FROM order_tb O,order_details_tb OD,product_tb P,stock_tb S WHERE O.order_id = OD.unique_id = P.product_id = S.stock_id AND P.category_id = ? ORDER BY S.exp_date DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['product_id'], $dup)) {
                    $r['count'] = 1;
                    $res[] = $r;
                    $dup[] = $r['product_id'];
                } else {
                    $i = array_search($r['product_id'], $dup);
                    $res[$i]['count']++;
                    $res[$i]['all_amount'] += $r['all_amount'];
                }
            }
            $result = $res;
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

    public function fetchByODId($id)
    {
        try {
            $sql = "SELECT O.*,P.* FROM order_details_tb O, product_tb P WHERE P.product_id = O.product_id AND O.order_id = ?";
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
            $sql = "DELETE FROM order_details_tb WHERE unique_id=?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
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
            $sql = "INSERT INTO order_details_tb (order_id, product_id, order_pr, order_amt) VALUES (?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['order_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['product_id'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['order_pr']);
            $stmt->bindParam(4, $data['order_amt'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function update($data)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "UPDATE order_details_tb
        SET  order_id = ?, product_id = ?, order_pr = ?, order_amt = ?
        WHERE unique_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['order_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['product_id'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['order_pr']);
            $stmt->bindParam(4, $data['order_amt'], PDO::PARAM_INT);
            $stmt->bindParam(5, $data['unique_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
