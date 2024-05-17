<?php
class EntityWishList
{
    public $custommer_id;
    public $product_id;

    public function __construct(
        $custommer_id,
        $product_id,
    ) {
        $this->custommer_id = $custommer_id;
        $this->product_id = $product_id;
    }

    public function getCustommerID()
    {
        return $this->custommer_id;
    }

    public function setCustommerID($custommer_id)
    {
        $this->custommer_id = $custommer_id;
    }

    public function getProductID()
    {
        return $this->product_id;
    }

    public function setProductID($product_id)
    {
        $this->product_id = $product_id;
    }
}
?>