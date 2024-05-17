<?php
class EntityCartDetail
{
    public $cart_detail_id;
    public $cart_id;
    public $product_id;
    public $quantity;
    public $color;
    public $size;
    public $name;
    public $price;
    public $img;

    // Constructor
    public function __construct($cart_detail_id, $cart_id, $product_id, $quantity, $color, $size)
    {
        $this->cart_detail_id = $cart_detail_id;
        $this->cart_id = $cart_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
        $this->color = $color;
        $this->size = $size;
    }

    // Getter and Setter methods
    public function getCartId()
    {
        return $this->cart_id;
    }

    public function setCartId($cart_id)
    {
        $this->cart_id = $cart_id;
    }

    public function getCartDetailId()
    {
        return $this->cart_detail_id;
    }

    public function setCartDetailId($cart_detail_id)
    {
        $this->cart_detail_id = $cart_detail_id;
    }

    public function getProductID()
    {
        return $this->product_id;
    }

    public function setProductID($product_id)
    {
        $this->product_id = $product_id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }
}

?>