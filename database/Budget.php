<?php
include_once("Connection.php");

class Budget
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchBetweenSales($firstdate = null, $lastdate = null)
    {
        try {
            if (is_null($firstdate)) {
                $firstdate = date('Y-m-d');
            }
            if (is_null($lastdate)) {
                $lastdate = date('Y-m-d');
            }
            $sql = "SELECT SA.*,SA.payment_sl as payment_sl_sales FROM sales_tb SA WHERE SA.sales_list_id AND SA.payment_dt BETWEEN ? AND ? OR SA.payment_dt BETWEEN ? AND ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $firstdate, PDO::PARAM_STR);
            $stmt->bindParam(2, $lastdate, PDO::PARAM_STR);
            $stmt->bindParam(3, $firstdate, PDO::PARAM_STR);
            $stmt->bindParam(4, $lastdate, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $Allprice2 = 0;
            foreach ($result as $rowss) {
                $Allprice2 += $rowss['all_price'];
            }
            $credit2 = 0;
            foreach ($result as $rows) {
                if ($rows['payment_sl_sales'] == 'ผ่อนชำระ') {
                    $credit2 += $rows['all_price'];
                }
            }
            $cash2 = 0;
            foreach ($result as $rowsss) {
                if ($rowsss['payment_sl_sales'] != 'ผ่อนชำระ') {
                    $cash2 += $rowsss['all_price'];
                }
            }
            $object = new stdClass();
            $object->BG2 = $Allprice2;
            $object->credit2 = $credit2;
            $object->cash2 = $cash2;
            $object->result = $result;
            return $object;
            /*if (!$result) {
                return [];
            } else {
                if (!$result) {
                    return [];
                } else {
                    return $result;
                }
            }*/
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchBetweenSales2()
    {
        try {
            $sql = "SELECT SA.*,SA.payment_sl as payment_sl_sales FROM sales_tb SA WHERE SA.sales_list_id AND SA.payment_dt ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $Allprice2 = 0;
            foreach ($result as $rowss) {
                $Allprice2 += $rowss['all_price'];
            }
            $credit2 = 0;
            foreach ($result as $rows) {
                if ($rows['payment_sl_sales'] == 'ผ่อนชำระ') {
                    $credit2 += $rows['all_price'];
                }
            }
            $cash2 = 0;
            foreach ($result as $rowss) {
                if ($rowss['payment_sl_sales'] != 'ผ่อนชำระ') {
                    $cash2 += $rowss['all_price'];
                }
            }
            $object = new stdClass();
            $object->BG2 = $Allprice2;
            $object->credit2 = $credit2;
            $object->cash2 = $cash2;
            $object->result = $result;
            return $object;
            /*if (!$result) {
                return [];
            } else {
                if (!$result) {
                    return [];
                } else {
                    return $result;
                }
            }*/
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchBetweenDebt($firstdate = null, $lastdate = null)
    {
        try {
            if (is_null($firstdate)) {
                $firstdate = date('Y-m-d');
            }
            if (is_null($lastdate)) {
                $lastdate = date('Y-m-d');
            }
            $sql = "SELECT * FROM debt_payment_details_tb DB WHERE DB.unique_id AND DB.repayment_date BETWEEN ? AND ? OR DB.repayment_date BETWEEN ? AND ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $firstdate, PDO::PARAM_STR);
            $stmt->bindParam(2, $lastdate, PDO::PARAM_STR);
            $stmt->bindParam(3, $firstdate, PDO::PARAM_STR);
            $stmt->bindParam(4, $lastdate, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $Debt = 0;
            foreach ($result as $rows) {
                $Debt += $rows['payment_amount'];
            }
            $object = new stdClass();
            $object->DB = $Debt;
            $object->result = $result;
            return $object;
            /*if (!$result) {
                return [];
            } else {
                if (!$result) {
                    return [];
                } else {
                    return $result;
                }
            }*/
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchBetweenDebt2()
    {
        try {
            $sql = "SELECT * FROM debt_payment_details_tb DB WHERE DB.unique_id AND DB.repayment_date";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $Debt = 0;
            foreach ($result as $rows) {
                $Debt += $rows['payment_amount'];
            }
            $object = new stdClass();
            $object->DB = $Debt;
            $object->result = $result;
            return $object;
            /*if (!$result) {
                return [];
            } else {
                if (!$result) {
                    return [];
                } else {
                    return $result;
                }
            }*/
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchBetweenOrder($firstdate = null, $lastdate = null)
    {
        try {
            if (is_null($firstdate)) {
                $firstdate = date('Y-m-d');
            }
            if (is_null($lastdate)) {
                $lastdate = date('Y-m-d');
            }
            $sql = "SELECT O.*,O.payment_sl as payment_sl_order FROM order_tb O WHERE O.payment_dt BETWEEN ? AND ? OR O.payment_dt BETWEEN ? AND ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $firstdate, PDO::PARAM_STR);
            $stmt->bindParam(2, $lastdate, PDO::PARAM_STR);
            $stmt->bindParam(3, $firstdate, PDO::PARAM_STR);
            $stmt->bindParam(4, $lastdate, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $Allprice3 = 0;
            foreach ($result as $rowsss) {
                $Allprice3 += $rowsss['all_price_odr'];
            }
            $credit = 0;
            foreach ($result as $rowsss) {
                if ($rowsss['payment_sl_order'] == 'เครดิต' && $rowsss['order_status'] == 1) {
                    $credit += $rowsss['all_price_odr'];
                }
            }
            $cash = 0;
            foreach ($result as $rowsss) {
                if ($rowsss['payment_sl_order'] == 'เงินสด' && $rowsss['order_status'] == 1) {
                    $cash += $rowsss['all_price_odr'];
                }
            }
            $complete = 0;
            foreach ($result as $rowsss) {
                if ($rowsss['order_status'] == 0) {
                    $complete += $rowsss['all_price_odr'];
                }
            }
            $object = new stdClass();
            $object->BG3 = $Allprice3;
            $object->credit = $credit;
            $object->cash = $cash;
            $object->complete = $complete;
            $object->result = $result;
            return $object;
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchBetweenOrder2()
    {
        try {
            $sql = "SELECT O.*,O.payment_sl as payment_sl_order FROM order_tb O WHERE O.payment_dt";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $Allprice3 = 0;
            foreach ($result as $rowsss) {
                $Allprice3 += $rowsss['all_price_odr'];
            }
            $credit = 0;
            foreach ($result as $rowsss) {
                if ($rowsss['payment_sl_order'] == 'เครดิต' && $rowsss['order_status'] == 1) {
                    $credit += $rowsss['all_price_odr'];
                }
            }
            $cash = 0;
            foreach ($result as $rowsss) {
                if ($rowsss['payment_sl_order'] == 'เงินสด' && $rowsss['order_status'] == 1) {
                    $cash += $rowsss['all_price_odr'];
                }
            }
            $complete = 0;
            foreach ($result as $rowsss) {
                if ($rowsss['order_status'] == 0) {
                    $complete += $rowsss['all_price_odr'];
                }
            }
            $object = new stdClass();
            $object->BG3 = $Allprice3;
            $object->credit = $credit;
            $object->cash = $cash;
            $object->complete = $complete;
            $object->result = $result;
            return $object;
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }


    function fetchBetweenProduct()
    {
        try {
            $sql = "SELECT * FROM product_tb WHERE product_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $Allprice1 = 0;
            foreach ($result as $rows) {
                $Allprice1 += $rows['price'] * $rows['product_rm_unit'];
            }
            $object = new stdClass();
            $object->BG1 = $Allprice1;
            $object->result = $result;
            return $object;
            /*if (!$result) {
                return [];
            } else {
                if (!$result) {
                    return [];
                } else {
                    return $result;
                }
            }*/
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
