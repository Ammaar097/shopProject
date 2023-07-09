<?php
include_once("Connection.php");

class Contract
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try {
            $sql = "SELECT * FROM contract_tb WHERE contract_code order by date_contract desc";
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

    public function upload($data)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "UPDATE contract_tb SET contract_attachment = ? WHERE contract_code = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['contract_attachment'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['contract_code'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchById($id)
    {
        try {
            $sql = "SELECT C.*,D.* FROM contract_tb C, debt_payment_details_tb D WHERE C.contract_code = D.contract_code AND C.contract_code = ?";
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

    public function fetchByemployee($id)
    {
        try {
            $sql = "SELECT C.*,E.* FROM contract_tb C, employee_tb E WHERE C.employee_id = E.employee_id AND C.contract_code = ?";
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
            if (count($data) <= 0) {
                return 1;
            }
            return $data['contract_code'];
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    public function fetchLast() //Contract
    {
        try {
            $sql = "SELECT * FROM contract_tb ORDER BY contract_code DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
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

    public function fetchByPayId($id)
    {
        try {
            $sql = "SELECT C.*,D.* FROM contract_tb C, debt_payment_details_tb D WHERE C.contract_code = D.contract_code AND C.contract_code = ?";
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

    public function fetchByPDFId($id)
    {
        try {
            $sql = "SELECT C.*,E.* FROM contract_tb C , employee_tb E WHERE C.contract_code = ? AND E.employee_id = C.employee_id ";
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

    public function searchByName($keyword)
    {
        try {
            $like = "%" . $keyword . "%";
            $sql = "SELECT * FROM contract_tb WHERE customer_firstname LIKE ? OR customer_lastname LIKE ? order by date_contract desc";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $like, PDO::PARAM_STR);
            $stmt->bindParam(2, $like, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            http_response_code(500);
            return [];
        }
    }

    //ส่วนการค้นหาลูกค้า
    public function searchBycopyID($keyword)
    {
        try {
            $like = "$keyword";
            $sql = "SELECT * FROM contract_tb WHERE customer_img like ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $like, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function promisestatus()
    {
        try {
            $sql = "SELECT C.*,D.* FROM contract_tb C ,debt_payment_details_tb D WHERE C.contract_code = D.contract_code AND C.customer_img = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $like, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $outstanding = 0;
            foreach ($result as $rows) {
                $outstanding = $rows['$outstanding'];
            }
            $promise = 0;
            foreach ($result as $rows) {
                $promise = $rows['$promise_status'];
            }
            $object = new stdClass();
            $object->ot = $outstanding;
            $object->ps = $promise;
            $object->result = $result;
            return $object;
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }


    public function delete($id)
    {
        try {
            $sql = "DELETE FROM contract_tb WHERE contract_code=?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function insert($data)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $date_contract = $_GET['date_contract'];
            $interest_month = !isset($_SESSION['interest_month']) ? 4 : $_SESSION['interest_month'];
            $interest = !isset($_SESSION['interest']) ? 15 : $_SESSION['interest'];
            $sql = "INSERT INTO contract_tb (date_contract, employee_id, customer_prefix, contract_details, customer_firstname, customer_lastname, customer_img ,date_send, price_send, product_detail, date_due,baht,stang,stangt,sales_list_id,outstanding) 
            VALUES (TIMESTAMP(?, CURRENT_TIME()),?,?,?,?,?,?,TIMESTAMP (?, CURRENT_TIME()),TIMESTAMP (?, CURRENT_TIME()),?,DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL ? MONTH ),?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['date_contract'], PDO::PARAM_STR); //วันที่ทำสัญญา
            $stmt->bindParam(2, $data['employee_id'], PDO::PARAM_INT); //รหัสข้อมูลพนักงาน
            $stmt->bindParam(3, $data['customer_prefix'], PDO::PARAM_STR); //คำนำหน้า
            $stmt->bindParam(4, $data['contract_details'], PDO::PARAM_STR); //ข้อตกลงของสัญญา
            $stmt->bindParam(5, $data['customer_firstname'], PDO::PARAM_STR); //ชื่อลูกค้า
            $stmt->bindParam(6, $data['customer_lastname'], PDO::PARAM_STR); //นามสกุลลูกค้า
            $stmt->bindParam(7, $data['customer_img'], PDO::PARAM_STR); //รหัสบัตรประชาชนลูกค้า
            $stmt->bindParam(8, $data['date_send'], PDO::PARAM_STR); //วันที่ส่งมอบ
            $stmt->bindParam(9, $data['price_send'], PDO::PARAM_STR); //ราคาที่ตกลง
            $stmt->bindParam(10, $data['product_detail'], PDO::PARAM_STR); //รายละเอียดสินค้าที่ซื้อ
            $stmt->bindParam(11, $interest_month, PDO::PARAM_STR); //วันที่ครบชำระ
            $stmt->bindParam(12, $data['baht'], PDO::PARAM_INT); //บาท
            $stmt->bindParam(13, $data['stang'], PDO::PARAM_INT); //สตางค์
            $stmt->bindParam(14, $data['stangt'], PDO::PARAM_STR); //สตางค์ไทย
            $stmt->bindParam(15, $data['sales_list_id'], PDO::PARAM_INT);
            $stmt->bindParam(16, $data['baht'], PDO::PARAM_INT);
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
            $sql = "UPDATE contract_tb
            SET employee_id = ?,customer_prefix = ?,contract_details = ?,customer_firstname = ?,customer_lastname = ?,customer_img = ? ,product_detail = ?
            WHERE contract_code = ? ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['employee_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['customer_prefix'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['contract_details'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['customer_firstname'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['customer_lastname'], PDO::PARAM_STR);
            $stmt->bindParam(6, $data['customer_img'], PDO::PARAM_STR);
            $stmt->bindParam(7, $data['product_detail'], PDO::PARAM_STR);
            $stmt->bindParam(8, $data['contract_code'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function push($q, $id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "UPDATE contract_tb SET sales_list_id = ? WHERE contract_code = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $q, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function updateremain($q, $id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "UPDATE contract_tb SET outstanding = ? WHERE contract_code = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $q, PDO::PARAM_STR);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function getTimeOut(){
        try{
            $sql = "SELECT * FROM contract_tb WHERE date_due < CURRENT_TIMESTAMP AND promise_status = 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function updatestatus($q,$id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "UPDATE contract_tb SET promise_status = ? WHERE contract_code = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $q, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
