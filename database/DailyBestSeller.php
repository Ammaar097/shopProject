<?php
include_once("Connection.php");

class DailyBestSeller
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
      try{
          $sql = "SELECT SAD.*,P.* FROM sales_details_tb SAD,product_tb P WHERE SAD.product_id = P.product_id ORDER BY SAD.sales_amt DESC";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll();
          $dup = [];
          $res = [];
          foreach ($result as $r) {
              if (!in_array($r['product_id'], $dup)) {
                  $r['count']=1;
                  $res[] = $r;
                  $dup[] = $r['product_id'];
              }else{
                  $i = array_search($r['product_id'], $dup);
                  $res[$i]['count']++;
                  $res[$i]['sales_amt'] += $r['sales_amt'];
              }
          }
          $result = $res;
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

    public function fetchAllDate($date)
    {
        try{
            $like = "%$date%";
            $sql = "SELECT SAD.*,P.* FROM sales_details_tb SAD,product_tb P WHERE SAD.product_id = P.product_id AND SAD.sales_dt like ? ORDER BY SAD.sales_amt DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $like, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['product_id'], $dup)) {
                    $r['count']=1;
                    $res[] = $r;
                    $dup[] = $r['product_id'];
                }else{
                    $i = array_search($r['product_id'], $dup);
                    $res[$i]['count']++;
                    $res[$i]['sales_amt'] += $r['sales_amt'];
                }
            }
            $result = $res;
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

    public function fetchAllCondition($date,$id,$keyword)
    {
       try{
           $sql = "SELECT SAD.*,P.* FROM sales_details_tb SAD,product_tb P WHERE SAD.product_id = P.product_id AND P.category_id = ?
                AND SAD.sales_dt LIKE ? AND P.product_name LIKE ? ORDER BY SAD.sales_amt DESC";
           $stmt = $this->conn->prepare($sql);
           $stmt->bindParam(1, $id, PDO::PARAM_INT);
           $like2 = "%$date%";
           $stmt->bindParam(2, $like2, PDO::PARAM_STR);
           $like1 = "%" . $keyword . "%";
           $stmt->bindParam(3, $like1, PDO::PARAM_STR);
           $stmt->execute();
           $result = $stmt->fetchAll();
           $dup = [];
           $res = [];
           foreach ($result as $r) {
               if (!in_array($r['product_id'], $dup)) {
                   $r['count']=1;
                   $res[] = $r;
                   $dup[] = $r['product_id'];
               }else{
                   $i = array_search($r['product_id'], $dup);
                   $res[$i]['count']++;
                   $res[$i]['sales_amt'] += $r['sales_amt'];
               }
           }
           $result = $res;
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

    public function searchsales($keyword, $id = null)
    {
        try{
            $like = "%$keyword%";
            if (is_null($id)) {
                $sql = "SELECT SAD.*,P.* FROM sales_details_tb SAD,product_tb P WHERE SAD.product_id = P.product_id AND P.product_name LIKE ?";

            } else {
                $sql = "SELECT SAD.*,P.* FROM sales_details_tb SAD,product_tb P WHERE SAD.product_id = P.product_id AND P.category_id = ? AND P.product_name LIKE ? ";
            }
            $sql .= ' ORDER BY SAD.sales_dt DESC' ;
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
                    $r['count']=1;
                    $res[] = $r;
                    $dup[] = $r['product_id'];
                }else{
                    $i = array_search($r['product_id'], $dup);
                    $res[$i]['count']++;
                    $res[$i]['sales_amt'] += $r['sales_amt'];
                }
            }
            $result = $res;
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

    public function fetchAllDateAndKeyword($date,$keyword)
    {
      try{
          $sql = "SELECT SAD.*,P.* FROM sales_details_tb SAD,product_tb P WHERE SAD.product_id = P.product_id  
                AND SAD.sales_dt LIKE ? AND P.product_name LIKE ? ORDER BY SAD.sales_amt DESC ";
          $stmt = $this->conn->prepare($sql);
          $like2 = "%$date%";
          $stmt->bindParam(1, $like2, PDO::PARAM_STR);
          $like1 = "%" . $keyword . "%";
          $stmt->bindParam(2, $like1, PDO::PARAM_STR);
          $stmt->execute();
          $result = $stmt->fetchAll();
          $dup = [];
          $res = [];
          foreach ($result as $r) {
              if (!in_array($r['product_id'], $dup)) {
                  $r['count']=1;
                  $res[] = $r;
                  $dup[] = $r['product_id'];
              }else{
                  $i = array_search($r['product_id'], $dup);
                  $res[$i]['count']++;
                  $res[$i]['sales_amt'] += $r['sales_amt'];
              }
          }
          $result = $res;
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

    public function fetchAllDateAndId($date,$id)
    {
        try{
            $sql = "SELECT SAD.*,P.* FROM sales_details_tb SAD,product_tb P WHERE SAD.product_id = P.product_id AND P.category_id = ?
                AND SAD.sales_dt LIKE ? ORDER BY SAD.sales_amt DESC ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $like = "%$date%";
            $stmt->bindParam(2, $like, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['product_id'], $dup)) {
                    $r['count']=1;
                    $res[] = $r;
                    $dup[] = $r['product_id'];
                }else{
                    $i = array_search($r['product_id'], $dup);
                    $res[$i]['count']++;
                    $res[$i]['sales_amt'] += $r['sales_amt'];
                }
            }
            $result = $res;
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
       try{
           $sql = "SELECT SAD.*,P.* FROM sales_details_tb SAD,product_tb P WHERE SAD.product_id = P.product_id AND P.category_id = ? ORDER BY SAD.sales_amt DESC";
           $stmt = $this->conn->prepare($sql);
           $stmt->bindParam(1, $id, PDO::PARAM_INT);
           $stmt->execute();
           $result = $stmt->fetchAll();
           $dup = [];
           $res = [];
           foreach ($result as $r) {
               if (!in_array($r['product_id'], $dup)) {
                   $r['count']=1;
                   $res[] = $r;
                   $dup[] = $r['product_id'];
               }else{
                   $i = array_search($r['product_id'], $dup);
                   $res[$i]['count']++;
                   $res[$i]['sales_amt'] += $r['sales_amt'];
               }
           }
           $result = $res;
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

    public function fetchBySalesListId($id)
    {
        try{
            $sql = "SELECT SAD.*,P.* FROM sales_details_tb SAD,product_tb P WHERE SAD.product_id = P.product_id AND SAD.sales_list_id  = ?";
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
}
