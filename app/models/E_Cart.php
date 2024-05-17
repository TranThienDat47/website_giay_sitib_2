<?php
class EntityCart
{
    public $id;
    public $custommer_id;
    public $total_cart;
    public $cart_status;

    // Constructor
    public function __construct($id, $custommer_id, $total_cart, $cart_status)
    {
        $this->id = $id;
        $this->custommer_id = $custommer_id;
        $this->total_cart = $total_cart;
        $this->cart_status = $cart_status;
    }

    // Getter and Setter methods
    public function getCartId()
    {
        return $this->id;
    }

    public function setCartId($id)
    {
        $this->id = $id;
    }

    public function getCustommerID()
    {
        return $this->custommer_id;
    }

    public function setCustommerID($custommer_id)
    {
        $this->custommer_id = $custommer_id;
    }

    public function getTotalCart()
    {
        return $this->total_cart;
    }

    public function setTotalCart($total_cart)
    {
        $this->total_cart = $total_cart;
    }

    public function getCartStatus()
    {
        return $this->cart_status;
    }

    public function setCartStatus($cart_status)
    {
        $this->cart_status = $cart_status;
    }

}
?>