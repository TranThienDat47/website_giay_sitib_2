<?php

class EntityProductDetail
{
    public $product_detail_id;
    public $product_id;
    public $img1;
    public $img2;
    public $img3;
    public $img4;
    public $img5;
    public $img6;
    public $size;
    public $color;
    public $qty;

    public function __construct($product_detail_id, $product_id, $img1, $img2, $img3, $img4, $img5, $img6, $size, $color, $qty)
    {
        $this->product_detail_id = $product_detail_id;
        $this->product_id = $product_id;
        $this->img1 = $img1;
        $this->img2 = $img2;
        $this->img3 = $img3;
        $this->img4 = $img4;
        $this->img5 = $img5;
        $this->img6 = $img6;
        $this->size = $size;
        $this->color = $color;
        $this->qty = $qty;
    }

    public function getProductDetailID()
    {
        return $this->product_detail_id;
    }

    public function setProductDetailID($product_detail_id)
    {
        $this->product_detail_id = $product_detail_id;
    }

    public function getProductID()
    {
        return $this->product_id;
    }

    public function setProductID($product_id)
    {
        $this->product_id = $product_id;
    }

    public function getImg1()
    {
        return $this->img1;
    }

    public function setImg1($img1)
    {
        $this->img1 = $img1;
    }

    public function getImg2()
    {
        return $this->img2;
    }

    public function setImg2($img2)
    {
        $this->img2 = $img2;
    }

    public function getImg3()
    {
        return $this->img3;
    }

    public function setImg3($img3)
    {
        $this->img3 = $img3;
    }

    public function getImg4()
    {
        return $this->img4;
    }

    public function setImg4($img4)
    {
        $this->img4 = $img4;
    }

    public function getImg5()
    {
        return $this->img5;
    }

    public function setImg5($img5)
    {
        $this->img5 = $img5;
    }

    public function getImg6()
    {
        return $this->img6;
    }

    public function setImg6($img6)
    {
        $this->img6 = $img6;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getQty()
    {
        return $this->qty;
    }

    public function setQty($qty)
    {
        $this->qty = $qty;
    }
}

?>