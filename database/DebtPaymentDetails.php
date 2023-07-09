<?php
include_once("Connection.php");

class DebtPaymentDetails
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try{
            $sql = "SELECT D.*,C.* FROM debt_payment_details_tb D, contract_tb C WHERE D.contract_code = C.contract_code";
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

    public function fetchById($id)
    {
        try{
            $sql = "SELECT * FROM debt_payment_details_tb WHERE contract_code = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function fetchByPayId($id)
    {
        try{
            $sql = "SELECT D.*,C.* FROM debt_payment_details_tb D, contract_tb C WHERE  D.unique_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function delete($id)
    {
        try{
            $sql = "DELETE FROM debt_payment_details_tb WHERE unique_id=?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        }catch (Exception $e) {
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
            $sql = "INSERT INTO debt_payment_details_tb (contract_code, repayment_date, payment, payment_amount,deduct_principal,less_interest,outstanding,slip_img) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['contract_code'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['repayment_date'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['payment'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['payment_amount']);
            $stmt->bindParam(5, $data['deduct_principal']);
            $stmt->bindParam(6, $data['less_interest']);
            $stmt->bindParam(7, $data['outstanding'] );
            $stmt->bindParam(8, $data['slip_img'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function insertinit($data)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "INSERT INTO debt_payment_details_tb (contract_code, outstanding) VALUES (?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['contract_code'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['outstanding'], PDO::PARAM_STR);
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
            $sql = "UPDATE debt_payment_details_tb
        SET contract_code = ?, repayment_date = ?, payment = ?, payment_amount = ?,deduct_principal = ?,less_interest = ?,outstanding = ?,slip_img = ?
        WHERE unique_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['contract_code'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['repayment_date'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['payment'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['payment_amount'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['deduct_principal'], PDO::PARAM_STR);
            $stmt->bindParam(6, $data['less_interest'], PDO::PARAM_STR);
            $stmt->bindParam(7, $data['outstanding'], PDO::PARAM_STR);
            $stmt->bindParam(8, $data['slip_img'], PDO::PARAM_STR);
            $stmt->bindParam(9, $data['unique_id'], PDO::PARAM_INT);
            $stmt->execute();
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
            $sql = "UPDATE debt_payment_details_tb SET slip_img = ? WHERE unique_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['slip_img'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['unique_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
