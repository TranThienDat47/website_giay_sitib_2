<?php
include_once "../models/CartModel.php";
include_once "../models/CartDetailModel.php";
include_once "../models/ProductModel.php";

include_once "../../libs/session.php";


class CartController
{
    public function getCartOfUser($custommer_id)
    {
        $cartModel = new CartModel();
        $cartDetailModel = new CartDetailModel();
        $cur_cart = $cartModel->getOneCartCurrentOfUser($custommer_id);
        $result = array();

        if ($cur_cart) {
            $list_detail = $cartDetailModel->getAllProductOfCartDetail($cur_cart->getCartId());
            foreach ($list_detail as $temp) {
                $result[] = [
                    $temp->getProductID(), $temp->name, $temp->getColor(), $temp->getSize(), $temp->img,
                    $temp->getQuantity(), $temp->price, $temp->getCartDetailId()
                ];
            }
        }

        return $result;
    }

    public function paymentCart($address_id, $payment_method_id)
    {
        $cartModel = new CartModel();
        $cur_cart = $cartModel->getOneCartCurrentOfUser(Session::get("customer_id"));

        if ($cur_cart) {
            $list_cart_detail = $this->getCartOfUser(Session::get("customer_id"));

            foreach ($list_cart_detail as $temp) {
                if ($this->checkProductQuantity($temp[0], $temp[3], $temp[2], $temp[5]) === false) {
                } else {
                    return false;
                }
            }

            $check_payment = $cartModel->paymentCart($payment_method_id, $address_id, $cur_cart->getCartId());
            if ($check_payment) {

                foreach ($list_cart_detail as $temp) {
                    if ($this->decreaseProductQuantity($temp[0], $temp[3], $temp[2], $temp[5])) {
                    } else {
                        return false;
                    }
                }

                $cartModel->updateCartStatus($cur_cart->getCartId(), "Chờ xác nhận");
                $cartModel->addCart(Session::get("customer_id"));

                return true;
            }
        }

        return false;
    }

    public function checkProductQuantity($product_id, $size, $color, $quantity)
    {
        $productModel = new ProductModel();
        $qty_isvalid = $productModel->getQtyOfProudctWhenAddCart($product_id, $size, $color);
        if ($qty_isvalid[0] - $quantity >= 0) {

            return false;
        }

        return $qty_isvalid[0];
    }

    public function decreaseProductQuantity($product_id, $size, $color, $quantity)
    {
        $productModel = new ProductModel();
        $qty_isvalid = $productModel->getQtyOfProudctWhenAddCart($product_id, $size, $color);
        if ($qty_isvalid[0] - $quantity >= 0) {

            if ($productModel->decreaseProductQuantity($qty_isvalid[1], $quantity))
                return true;
        }

        return false;
    }

    public function addProductToCart($cartDetail)
    {
        $productModel = new ProductModel();
        $cartModel = new CartModel();
        $cartDetailModel = new CartDetailModel();
        $cur_cart = $cartModel->getOneCartCurrentOfUser(Session::get("customer_id"));
        $qty_isvalid = $productModel->getQtyOfProudctWhenAddCart($cartDetail->product_id, $cartDetail->size, $cartDetail->color);
        if ($cur_cart && $qty_isvalid[0] - $cartDetail->quantity >= 0) {

            $check_duplicate = $cartDetailModel->getOneCartDetailWidtCartIDProductIDColorSize($cur_cart->getCartId(), $cartDetail->product_id, $cartDetail->color, $cartDetail->size);

            if ($check_duplicate && $check_duplicate[0] != -1 && $check_duplicate[1] != -1) {

                if ((int) $qty_isvalid[0] - ((int) $cartDetail->quantity + (int) $check_duplicate[1]) >= 0) {
                    $check_update_qty = $cartDetailModel->updateCartDetailQuantity($check_duplicate[0], (int) $cartDetail->quantity + (int) $check_duplicate[1]);
                    if ($check_update_qty) {

                        return true;
                    }
                }

            } else {

                if ((int) $qty_isvalid[0] - ((int) $cartDetail->quantity + (int) $check_duplicate[1]) >= 0) {
                    $cartDetail->cart_id = $cur_cart->getCartId();

                    if ($cartDetailModel->addCartDetail($cartDetail)) {
                        // $productModel->decreaseProductQuantity($qty_isvalid[1], $cartDetail->quantity);
                        return true;
                    }
                }
            }

        }

        return false;
    }

    public function minusProductOfCart($cart_detail_id)
    {
        $cartDetailModel = new CartDetailModel();

        if ($cartDetailModel->getCartDetailQuantity($cart_detail_id) == 1) {

            return $cartDetailModel->deleteCartDetail($cart_detail_id);
        } else if ($cartDetailModel->getCartDetailQuantity($cart_detail_id) > 1) {
            if ($cartDetailModel->minusCartDetailQuantity($cart_detail_id)) {
                return true;
            }
        }


        return false;
    }

    public function deleteProductOfCart($cart_detail_id)
    {
        $cartDetailModel = new CartDetailModel();

        if ($cartDetailModel->deleteCartDetail($cart_detail_id)) {
            return true;
        }

        return false;
    }

    public function totalCart()
    {
        $cartModel = new CartModel();
        $cur_cart = $cartModel->getOneCartCurrentOfUser(Session::get("customer_id"));
        if ($cur_cart) {
            $total_cart = 0;
            $check = $cartModel->getTotalCart($cur_cart->getCartId());
            if ($check) {

                $total_cart = $check;
            }

            return $total_cart;
        }

        return 0;
    }
}
// $productModel->decreaseProductQuantity($qty_isvalid[1], $cartDetail->quantity);

?>