<?php


class EntityProduct
{
    public $product_id;
    public $name;
    public $description;
    public $price;
    public $stock;
    public $news;
    public $category_id;
    public $product_status;
    public $created_at;
    public $updated_at;
    public $productDetails;

    public $catgory;
    public $parent_catgory;

    public function __construct($product_id, $name, $description, $price, $stock, $news, $category_id, $product_status, $created_at)
    {
        $this->product_id = $product_id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->news = $news;
        $this->category_id = $category_id;
        $this->product_status = $product_status;
        $this->created_at = $created_at;
    }

    public function getProductID()
    {
        return $this->product_id;
    }

    public function setProductID($product_id)
    {
        $this->product_id = $product_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function getNews()
    {
        return $this->news;
    }

    public function setNews($news)
    {
        $this->news = $news;
    }

    public function getCategoryID()
    {
        return $this->category_id;
    }

    public function setCategoryID($category_id)
    {
        $this->category_id = $category_id;
    }

    public function getProductStatus()
    {
        return $this->product_status;
    }

    public function setProductStatus($product_status)
    {
        $this->product_status = $product_status;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

}

?>