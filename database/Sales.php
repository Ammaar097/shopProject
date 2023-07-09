<?php
include_once("Connection.php");

class Sales
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try {
            $sql = "SELECT SA.*,SAD.*,P.* FROM sales_tb SA,sales_details_tb SAD,product_tb P WHERE SA.sales_list_id = SAD.sales_list_id = P.product_id ORDER BY SAD.sales_list_id DESC ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['sales_list_id'], $dup)) {
                    $r['count'] = 1;
                    $res[] = $r;
                    $dup[] = $r['sales_list_id'];
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

    public function fetchAllContract()
    {
        try {
            $sql = "SELECT * FROM sales_tb SA WHERE SA.sales_list_id ORDER BY SA.payment_dt DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['sales_list_id'], $dup)) {
                    $r['count'] = 1;
                    $res[] = $r;
                    $dup[] = $r['sales_list_id'];
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

    public function fetchAllContract2()
    {
        try {
            $sql = "SELECT SA.*,C.outstanding FROM sales_tb SA,contract_tb C WHERE SA.sales_list_id = C.sales_list_id ORDER BY SA.payment_dt DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['sales_list_id'], $dup)) {
                    $r['count'] = 1;
                    $res[] = $r;
                    $dup[] = $r['sales_list_id'];
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
        try {
            $sql = "SELECT SA.*,SAD.*,P.* FROM sales_tb SA,sales_details_tb SAD,product_tb P WHERE SA.sales_list_id = SAD.sales_list_id = P.product_id ORDER BY SAD.sales_list_id DESC";
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


    public function fetchBetween($start, $end)
    {
        try {
            $sql = "SELECT * FROM sales_tb SA WHERE SA.payment_dt BETWEEN ? AND ? ORDER BY SA.payment_dt DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $start, PDO::PARAM_STR);
            $stmt->bindParam(2, $end, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['sales_list_id'], $dup)) {
                    $r['count'] = 1;
                    $res[] = $r;
                    $dup[] = $r['sales_list_id'];
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

    public function fetchBetween2($start, $end)
    {
        try {
            $sql = "SELECT SA.*,C.outstanding FROM sales_tb SA,contract_tb C WHERE SA.sales_list_id = C.sales_list_id AND SA.payment_dt BETWEEN ? AND ? ORDER BY SA.payment_dt DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $start, PDO::PARAM_STR);
            $stmt->bindParam(2, $end, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $dup = [];
            $res = [];
            foreach ($result as $r) {
                if (!in_array($r['sales_list_id'], $dup)) {
                    $r['count'] = 1;
                    $res[] = $r;
                    $dup[] = $r['sales_list_id'];
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

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM sales_tb WHERE sales_list_id=?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }


    public function getLastId()
    {
        try {
            $data = $this->fetchLast();
            if (count($data) <= 0) {
                return 1;
            }
            return $data['sales_list_id'];
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchBySalesListId($id)
    {
        try{
            $sql = "SELECT * FROM sales_tb WHERE sales_list_id  = ?";
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
            echo strval($e);
        }
    }

    public function fetchLast() //Sales
    {
        try {
            $sql = "SELECT * FROM sales_tb ORDER BY sales_list_id DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result == false) {
                return [];
            } else {
                if (!$result) {
                    return [];
                } else {
                    return $result;
                }
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function fetchByPDFId($id)
    {
        try {
            $sql = "SELECT C.*,E.* FROM contract_tb C , employee_tb E WHERE C.sales_list_id = ? AND E.employee_id = C.employee_id ";
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

    public function fetchBysaletocontractId($id)
    {
        try {
            $sql = "SELECT C.*,SAD.* FROM contract_tb C,sales_details_tb SAD WHERE SAD.sales_list_id = C.sales_list_id AND C.contract_code = ?";
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

    public function fetchBankSlipId($id)
    {
        try {
            $sql = "SELECT * FROM sales_tb WHERE sales_list_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
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

    public function updateimage($filename, $img, $sales_list_id)
    {
        try {
            $colname = ['import_files'];
            if (in_array($filename, $colname)) {
                $sql = "UPDATE sales_tb SET $filename = ? WHERE sales_list_id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $img, PDO::PARAM_STR);
                $stmt->bindParam(2, $sales_list_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function insert($data)
    {
        try {
            $sql = "INSERT INTO sales_tb (payment_sl ,all_price ,all_quantity, employee_id ,import_files, note)
        VALUES (?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['payment_sl'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['all_price'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['all_quantity'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['employee_id'], PDO::PARAM_INT);
            //$stmt->bindParam(5, $data['discount'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['import_files'], PDO::PARAM_STR);
            $stmt->bindParam(6, $data['note'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function update($data)
    {
        try {
            $sql = "UPDATE sales_tb SET note = ? WHERE sales_list_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['note'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['sales_list_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
