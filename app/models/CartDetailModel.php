<?php
include_once "../config/database.php";

include_once "../models/E_CartDetail.php";

class CartDetailModel
{
    public $db;

    public function __construct()
    {
        try {
            $this->db = new Database();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function getAllCartDetailOfCart($cart_id)
    {
        try {

            $sql = "SELECT * FROM cartdetails WHERE cart_id = ?";

            $params = [$cart_id];

            $result = $this->db->fetchOne($sql, $params);
            $cartdetails = array();
            foreach ($result as $row) {
                $cartdetails[] = new EntityCartDetail(
                    $row['CART_DETAIL_ID'],
                    $row['CART_ID'],
                    $row['PRODUCT_ID'],
                    $row['QUANTITY'],
                    $row['COLOR'],
                    $row['SIZE']
                );
            }



            return $cartdetails;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getAllProductOfCartDetail($cart_id)
    {
        try {


            $sql = "SELECT p.PRODUCT_ID as productID, p.NAME as name, pd.COLOR as color, pd.SIZE as size, pd.IMG1 as img, cd.QUANTITY as qty, p.PRICE as price, CART_DETAIL_ID as detail_id
            FROM products p
            JOIN productdetails pd ON p.PRODUCT_ID = pd.PRODUCT_ID
            JOIN cartdetails cd ON p.PRODUCT_ID = cd.PRODUCT_ID AND cd.COLOR = pd.COLOR AND cd.SIZE = pd.SIZE
            WHERE cd.CART_ID = $cart_id;";


            $result = $this->db->fetchAll($sql);

            $cartdetails = [];
            $i = 0;
            foreach ($result as $row) {
                $cartdetails[] = new EntityCartDetail(
                    $row['detail_id'],
                    $cart_id,
                    $row['productID'],
                    $row['qty'],
                    $row['color'],
                    $row['size']
                );
                $cartdetails[$i]->price = $row['price'];
                $cartdetails[$i]->name = $row['name'];
                $cartdetails[$i]->img = $row['img'];
                $i++;
            }



            return $cartdetails;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getOneCartDetail($cart_detail_id)
    {
        try {

            $sql = "SELECT * FROM cartdetails WHERE cart_detail_id = ?";

            $params = [$cart_detail_id];

            $result = $this->db->fetchOne($sql, $params);

            if ($result) {
                // Convert the result set into a Product object
                $cartDetails = new EntityCartDetail(
                    $result['CART_DETAIL_ID'],
                    $result['CART_ID'],
                    $result['PRODUCT_ID'],
                    $result['QUANTITY'],
                    $result['COLOR'],
                    $result['SIZE']
                );



                return $cartDetails;
            }

            return [];

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getOneCartDetailWidtCartIDProductIDColorSize($cartID, $productID, $color, $size)
    {
        try {

            $sql = "SELECT * FROM cartdetails WHERE cart_id = ? and product_id = ? and color = ? and size = ?";

            $params = [$cartID, $productID, $color, $size];

            $result = $this->db->fetchOne($sql, $params);

            // Convert the result set into a Product object
            if ($result) {
                return [$result['CART_DETAIL_ID'], $result['QUANTITY']];

            }


            return [-1, -1];

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addCartDetail($cart_detail)
    {
        try {
            $table = "cartdetails";

            $data = [
                'cart_id' => $cart_detail->cart_id,
                'product_id' => $cart_detail->product_id,
                'quantity' => $cart_detail->quantity,
                'color' => $cart_detail->color,
                'size' => $cart_detail->size,
            ];

            $resul = $this->db->insertResultRow($table, $data);


            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function updateCartDetail($cart_detail)
    {
        try {
            $table = "cartdetails";

            $data = [
                'product_id' => $cart_detail->product_id,
                'color' => $cart_detail->color,
                'size' => $cart_detail->size,
                'quantity' => $cart_detail->quantity,
            ];

            $where = "cart_detail_id = " . $cart_detail->cart_detail_id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function updateCartDetailQuantity($cart_detail_id, $qty)
    {
        try {
            $table = "cartdetails";

            $data = [
                'quantity' => $qty,
            ];

            $where = "CART_DETAIL_ID = " . $cart_detail_id;

            $result = $this->db->update($table, $data, $where);


            return $result != 0;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function minusCartDetailQuantity($cart_detail_id)
    {
        try {
            $this->db->connect();
            $sql = "UPDATE cartdetails SET quantity = quantity - 1 WHERE cart_detail_id = $cart_detail_id";

            // thực hiện câu lệnh SQL
            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->affected_rows > 0;

            // lấy số hàng bị ảnh hưởng bởi câu lệnh và trả về kết quả
            return $result;

        } catch (\Throwable $th) {
            // nếu có lỗi xảy ra, in ra thông báo lỗi và ném ra ngoại lệ
            throw new \Exception("Error while updating cart detail quantity: " . $th->getMessage());
        }
    }

    public function getCartDetailQuantity($cart_detail_id)
    {
        try {
            $this->db->connect();
            $sql = "SELECT quantity FROM cartdetails WHERE cart_detail_id = $cart_detail_id";

            // thực hiện câu lệnh SQL
            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute();

            // lấy kết quả truy vấn
            $result = $stmt->get_result();
            $quantity = $result->fetch_assoc()['quantity'];

            if ($quantity) {

                // trả về số lượng sản phẩm
                return $quantity;
            }

            return -1;

        } catch (\Throwable $th) {
            // nếu có lỗi xảy ra, in ra thông báo lỗi và ném ra ngoại lệ
            throw new \Exception("Error while getting cart detail quantity: " . $th->getMessage());
        }
    }

    public function deleteCartDetail($cart_detail_id)
    {
        try {
            $table = "cartdetails";
            $where = 'cart_detail_id = ' . $cart_detail_id;

            // echo json_decode($cart_detail_id);

            $result = $this->db->delete($table, $where);

            return $result > 0;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


}

?>