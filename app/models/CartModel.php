<?php
include_once "../config/database.php";

include_once "../models/E_Cart.php";
include_once "../models/E_CustommerPayment.php";

class CartModel
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

    // public function getAllCart()
    // {
    //     try {
    //         $sql = "SELECT * FROM carts";

    //         $result = $this->db->fetchAll($sql);

    //         $carts = [];
    //         foreach ($result as $row) {
    //             $carts[] = new EntityCart(
    //                 $row['ID'],
    //                 $row['CUSTOMER_ID'],
    //                 $row['TOTAL_CART'],
    //                 $row['CART_STATUS'],
    //             );
    //         }

    //         return $carts;
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

    // public function getOneCart($cart_id)
    // {
    //     try {
    //         $sql = "SELECT * FROM carts WHERE id = ?";

    //         $params = [$cart_id];

    //         $result = $this->db->fetchOne($sql, $params);

    //         // Convert the result set into a Product object
    //         $carts = new EntityCart(
    //             $result['ID'],
    //             $result['CUSTOMER_ID'],
    //             $result['TOTAL_CART'],
    //             $result['CART_STATUS']
    //         );



    //         return $carts;
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }



    public function getOneCartCurrentOfUser($custommer_id)
    {
        try {

            $sql = "SELECT * FROM carts WHERE customer_id = ? and cart_status = ?";
            $cart_status = "Chờ mua hàng";
            $params = [$custommer_id, $cart_status];

            $result = $this->db->fetchOne($sql, $params);
            // Convert the result set into a Product object
            $carts = null;
            if ($result) {
                $carts = new EntityCart(
                    $result['ID'],
                    $result['CUSTOMER_ID'],
                    $result['TOTAL_CART'],
                    $result['CART_STATUS']
                );
            }

            return $carts;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addCart($custommer_id)
    {
        try {
            $table = "carts";

            $data = [
                'customer_id' => $custommer_id,
            ];

            $resul = $this->db->insertResultRow($table, $data);

            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function updateCartStatus($cart_id, $cart_status)
    {
        try {
            $table = "carts";

            $data = [
                'cart_status' => $cart_status,
            ];

            $where = "id = " . $cart_id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // public function updateCartTotal($cart_id, $total_cart)
    // {
    //     try {
    //         $table = "carts";

    //         $data = [
    //             'total_cart' => $total_cart,
    //         ];

    //         $where = "id = " . $cart_id;

    //         $result = $this->db->update($table, $data, $where);


    //         return $result;
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

    public function getTotalCart($cartID)
    {
        try {
            $sql = "SELECT SUM(p.price * cd.quantity) AS total_price
            FROM products p
            JOIN cartdetails cd ON p.product_id = cd.product_id
            WHERE cd.cart_id = $cartID;";

            $total = $this->db->fetchOne($sql);

            if ($total) {
                $result = $total['total_price'];

                return $result;
            }

            return false;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function paymentCart($payment_method_id, $address_id, $cart_id)
    {
        try {
            $table = "customerpayments";

            $data = [
                'PAYMENT_METHOD_ID' => $payment_method_id,
                'CART_ID' => $cart_id,
                'ADDRESS_ID' => $address_id
            ];

            $resul = $this->db->insertResultRow($table, $data);
            return $resul;
        } catch (\Throwable $th) {
            //throw $th;

            return false;
        }
    }
}

?>