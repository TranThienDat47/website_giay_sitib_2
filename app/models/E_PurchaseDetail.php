<?php
class EntityPurchaseDetail
{
    public $purchase_detail_id;
    public $purchase_id;
    public $product_id;
    public $quantity;

    public function __construct($purchase_detail_id, $purchase_id, $product_id, $quantity)
    {
        $this->purchase_detail_id = $purchase_detail_id;
        $this->purchase_id = $purchase_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public function getPurchcaseDetailID()
    {
        return $this->purchase_detail_id;
    }

    public function setPurchcaseDetailID($purchase_detail_id)
    {
        $this->purchase_detail_id = $purchase_detail_id;
    }

    public function getPurchaseID()
    {
        return $this->purchase_id;
    }

    public function setPurchaseID($purchase_id)
    {
        $this->purchase_id = $purchase_id;
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
}
?>