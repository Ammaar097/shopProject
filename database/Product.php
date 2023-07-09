<?php
include_once("Connection.php");
include_once('Category.php');

class Product
{
    private $conn;

    function __construct()
    {
        $this->conn = Connection();
    }

    public function fetchAll()
    {
        try {
            $sql = "SELECT * FROM product_tb";
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

    public function fetchById($id)
    {
        try {
            $sql = "SELECT * FROM product_tb WHERE product_id=?";
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
            echo strval($e);
        }
    }

    public function fetchcate($id)
    {
        try {
            $sql = "SELECT P.*,C.* FROM product_tb P,category_tb C WHERE P.category_id = C.category_id AND P.product_id=?";
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
            echo strval($e);
        }
    }

    public function fetchsell($id)
    {
        try {
            $sql = "SELECT P.*,S.* FROM product_tb P,sell_tb S WHERE P.sell_id = S.sell_id AND P.product_id=?";
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
            echo strval($e);
        }
    }

    public function fetchByCategoryName($id)
    {
        try {
            $sql = "SELECT P.*,C.category_name FROM product_tb P, category_tb C WHERE P.category_id = C.category_id AND P.product_id = ?";
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
            echo strval($e);
        }
    }

    public function fetchBypriceId($id)
    {
        try {
            $sql = "SELECT * FROM product_tb WHERE price = ?";
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

    public function fetchExchange1Id($id)
    {
        try {
            $sql = "SELECT * FROM product_tb WHERE product_id=?";
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
            echo strval($e);
        }
    }

    //แจ้งเตือนสินค้าใกล้หมด
    public function fetchLost()
    {

        try {
            $sql = "SELECT * FROM product_tb WHERE product_rm_unit <= notification_amt";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            /*$sql = "SELECT * FROM product_tb WHERE product_rm_unit <= notification_amt AND sales_status = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            */
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

    public function getCountprice($id)
    {
        try {
            $products = new Product();
            $products = $products->fetchBypriceId($id);
            $counts = 0;

            return $counts;
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function fetchAddCategory()
    {
        try {
            $sql = "SELECT P.*,C.* FROM category_tb C,product_tb P WHERE P.category_id = C.category_id ORDER BY P.product_name ASC";
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

    public function fetchByName($keyword)
    {
        try {
            $like = "%$keyword%";
            $sql = "SELECT P.*,C.* FROM category_tb C,product_tb P WHERE P.category_id = C.category_id AND P.product_name LIKE ? ORDER BY P.product_name ASC";
            $stmt = $this->conn->prepare($sql);
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
            echo strval($e);
        }
    }

    public function search($keyword, $id = null)
    {
        try {
            $like = "%$keyword%";
            if (is_null($id)) {
                $sql = "SELECT C.*,P.* FROM category_tb C,product_tb P WHERE C.category_id = P.category_id AND P.product_name LIKE ? ORDER BY P.product_name ASC";
            } else {
                $sql = "SELECT C.*,P.* FROM category_tb C,product_tb P WHERE C.category_id = ? AND P.product_name LIKE ? ORDER BY P.product_name ASC";
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
            $sql = "SELECT C.*,P.* FROM category_tb C,product_tb P WHERE C.category_id = P.category_id AND C.category_id = ? ORDER BY P.product_name ASC";
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

    public function autoComplete($keyword)
    {
        try {
            $like = $keyword . "%";
            $sql = "SELECT * FROM product_tb WHERE product_name LIKE ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $like, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $json = [];

            foreach ($result as $row) {
                $object = new stdClass();
                $object->label = $row['product_name'];
                $object->value = $row['product_id'];
                $json[] = $object;
            }
            return json_encode($json);
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    //สต็อกสินค้า

    public function getStockQuantity($id)
    {
        try {
            $sql = "SELECT product_rm_unit FROM product_tb WHERE product_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
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



    public function cutStock($q, $id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "UPDATE product_tb SET product_rm_unit = product_rm_unit - ? WHERE product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $q, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function addStock($id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $q = $this->getStockQuantity($id);
            $sql = "UPDATE product_tb SET product_dlt_unit = product_dlt_unit + ? WHERE product_id=?";
            $stmt->bindParam(1, $id, PDO::PARAM_INT); //Boolean ใช้ INT
            $stmt->bindParam(2, $q['product_rm_unit'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    //การแทรก

    public function insert($data)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "INSERT INTO product_tb (product_name, category_id, brand, model, sell_id, product_detail, product_img, product_detail_img, product_dlt_unit, product_unit, price, notification_amt, sales_status, set_n_amt, date_n_amt, notification_amt2, product_rm_unit, vat, set_exchange) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['product_name'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['category_id'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['brand'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['model'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['sell_id'], PDO::PARAM_INT);
            $stmt->bindParam(6, $data['product_detail'], PDO::PARAM_STR);
            $stmt->bindParam(7, $data['product_img1'], PDO::PARAM_STR);
            $stmt->bindParam(8, $data['product_img2'], PDO::PARAM_STR);
            $stmt->bindParam(9, $data['product_dlt_unit'], PDO::PARAM_INT);
            $stmt->bindParam(10, $data['product_unit'], PDO::PARAM_STR);
            $stmt->bindParam(11, $data['price']);
            $stmt->bindParam(12, $data['notification_amt'], PDO::PARAM_INT);
            $stmt->bindParam(13, $data['sales_status'], PDO::PARAM_INT);
            $stmt->bindParam(14, $data['set_n_amt'], PDO::PARAM_INT);
            $stmt->bindParam(15, $data['date_n_amt'], PDO::PARAM_STR);
            $stmt->bindParam(16, $data['notification_amt2'], PDO::PARAM_INT); //Boolean ใช้ INT
            $stmt->bindParam(17, $data['product_dlt_unit'], PDO::PARAM_INT);
            $stmt->bindParam(18, $data['vat'], PDO::PARAM_INT);
            $stmt->bindParam(19, $data['set_exchange'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    //การอัพเดต

    public function updateimage($filename, $img, $product_id)
    {
        try {
            $colname = ['product_img', 'product_detail_img'];
            if (in_array($filename, $colname))
                $sql = "UPDATE product_tb SET $filename = ? WHERE product_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $img, PDO::PARAM_STR);
            $stmt->bindParam(2, $product_id, PDO::PARAM_INT);
            $stmt->execute();
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

    public function update($data)
    {
        try {
            $sql = "UPDATE product_tb
        SET product_detail = ?, product_dlt_unit = ?, price = ?, notification_amt = ?, set_n_amt = ?, date_n_amt = ?, notification_amt2 = ? , vat = ?, set_exchange = ? , product_rm_unit = ?
        WHERE product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $data['product_detail'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['product_dlt_unit'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['price'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['notification_amt'], PDO::PARAM_INT);
            $stmt->bindParam(5, $data['set_n_amt'], PDO::PARAM_INT);
            $stmt->bindParam(6, $data['date_n_amt'], PDO::PARAM_STR);
            $stmt->bindParam(7, $data['notification_amt2'], PDO::PARAM_INT);
            $stmt->bindParam(8, $data['vat'], PDO::PARAM_INT);
            $stmt->bindParam(9, $data['set_exchange'], PDO::PARAM_INT);
            $stmt->bindParam(10, $data['product_dlt_unit'], PDO::PARAM_INT);
            $stmt->bindParam(11, $data['product_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function countCategoryId($id, $on)
    {
        try {
            $sql = "SELECT * FROM product_tb LEFT JOIN category_tb ON product_tb.category_id = category_tb.category_id ";
            if ($on) {
                $sql .= " AND product_tb.sales_status=1";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->rowCount();
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

    public function fetchVat($id)
    {
        try {
            $sql = "SELECT vat FROM product_tb WHERE product_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result["vat"];
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }

    public function deleteByCategoryId($id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "DELETE FROM product_tb WHERE category_id=?";
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

    public function delete($id)
    {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = "DELETE FROM product_tb WHERE product_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            http_response_code(500);
            echo strval($e);
        }
    }
}
