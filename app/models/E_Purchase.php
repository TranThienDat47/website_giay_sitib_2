<?php
class EntityPurchase
{
    public $id;
    public $supplier_id;
    public $purcharse_date;
    public $total_amount;
    public $qty;

    public function __construct($id, $supplier_id, $purcharse_date, $total_amount, $qty)
    {
        $this->id = $id;
        $this->supplier_id = $supplier_id;
        $this->purcharse_date = $purcharse_date;
        $this->total_amount = $total_amount;
        $this->qty = $qty;
    }

    public function getPurchaseID()
    {
        return $this->id;
    }

    public function setPurchaseID($id)
    {
        $this->id = $id;
    }

    public function getSupplierID()
    {
        return $this->supplier_id;
    }

    public function setSupplierID($supplier_id)
    {
        $this->supplier_id = $supplier_id;
    }

    public function getPurchaseDate()
    {
        return $this->purcharse_date;
    }

    public function setPurchaseDate($purcharse_date)
    {
        $this->purcharse_date = $purcharse_date;
    }

    public function getTotalAmount()
    {
        return $this->total_amount;
    }

    public function setTotalAmount($total_amount)
    {
        $this->total_amount = $total_amount;
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