<?php
include_once "../models/ProductModel.php";

class ProductController
{
    public function getProductAndProductDetailCustommerWithCategoryID($category_id)
    {

        $productModel = new ProductModel();
        $list_product = $productModel->getProductAndProductDetailCustommerWithCategoryID($category_id);

        $result = array();

        foreach ($list_product as $temp) {
            $result[] = [
                $temp->getProductID(), $temp->getName(), $temp->getDescription(), $temp->getPrice(), $temp->getStock(),
                $temp->getNews(), $temp->productDetails->getImg1(), $temp->productDetails->getImg2(),
                $temp->productDetails->getImg3(), $temp->productDetails->getImg4(), $temp->productDetails->getImg5(),
                $temp->productDetails->getImg6(), $temp->productDetails->getSize(), $temp->productDetails->getColor(),
                $temp->productDetails->getQty(), $temp->catgory, $temp->parent_catgory
            ];
        }

        return $result;
    }

    public function getProductAndProductDetailCustommer($category)
    {

        $productModel = new ProductModel();
        $list_product = $productModel->getProductAndProductDetailCustommer($category);

        $result = array();

        foreach ($list_product as $temp) {
            $result[] = [
                $temp->getProductID(), $temp->getName(), $temp->getDescription(), $temp->getPrice(), $temp->getStock(),
                $temp->getNews(), $temp->productDetails->getImg1(), $temp->productDetails->getImg2(),
                $temp->productDetails->getImg3(), $temp->productDetails->getImg4(), $temp->productDetails->getImg5(),
                $temp->productDetails->getImg6(), $temp->productDetails->getSize(), $temp->productDetails->getColor(),
                $temp->productDetails->getQty(), $temp->catgory, $temp->parent_catgory
            ];
        }

        return $result;
    }

    public function getAllProductAndProductDetailWithProductID($productID)
    {

        $productModel = new ProductModel();
        $list_product = $productModel->getProductAndProductDetailCustommerWithProductID($productID);

        $result = array();

        foreach ($list_product as $temp) {
            $result[] = [
                $temp->getProductID(), $temp->getName(), $temp->getDescription(), $temp->getPrice(), $temp->getStock(),
                $temp->getNews(), $temp->productDetails->getImg1(), $temp->productDetails->getImg2(),
                $temp->productDetails->getImg3(), $temp->productDetails->getImg4(), $temp->productDetails->getImg5(),
                $temp->productDetails->getImg6(), $temp->productDetails->getSize(), $temp->productDetails->getColor(),
                $temp->productDetails->getQty(), $temp->catgory, $temp->parent_catgory
            ];
        }

        return $result;
    }

    public function getAllProductAndProductDetailCustommer()
    {
        $productModel = new ProductModel();
        $list_product = $productModel->getProductAndProductDetailCustommerAll();

        $result = array();

        foreach ($list_product as $temp) {
            $result[] = [
                $temp->getProductID(), $temp->getName(),
                strip_tags($temp->getDescription()), $temp->getPrice(), $temp->getStock(),
                $temp->getNews(), $temp->productDetails->getImg1(), $temp->productDetails->getImg2(),
                $temp->productDetails->getImg3(), $temp->productDetails->getImg4(), $temp->productDetails->getImg5(),
                $temp->productDetails->getImg6(), $temp->productDetails->getSize(), $temp->productDetails->getColor(),
                $temp->productDetails->getQty(), $temp->catgory, $temp->parent_catgory
            ];
        }

        return $result;
    }

    public function getAllProductAndProductDetail()
    {
        $productModel = new ProductModel();
        $list_product = $productModel->getProductAndProductDetail();

        $result = array();

        foreach ($list_product as $temp) {
            $result[] = [
                $temp->getProductID(), $temp->getName(),
                strip_tags($temp->getDescription()), $temp->getPrice(), $temp->getStock(),
                $temp->getNews(), $temp->productDetails->getImg1(), $temp->productDetails->getImg2(),
                $temp->productDetails->getImg3(), $temp->productDetails->getImg4(), $temp->productDetails->getImg5(),
                $temp->productDetails->getImg6(), $temp->productDetails->getSize(), $temp->productDetails->getColor(),
                $temp->productDetails->getQty(), $temp->catgory, $temp->parent_catgory, $temp->productDetails->getProductDetailID(), $temp->getProductStatus()
            ];
        }

        return $result;
    }

    public function addProduct($entityProduct)
    {
        $productModel = new ProductModel();
        $result = $productModel->addProduct($entityProduct);

        return $result;
    }

    public function addProductDetail($entityProductDetail)
    {
        $productModel = new ProductModel();

        $result = $productModel->addProductDetail($entityProductDetail);

        return $result;
    }

    public function updateProduct($entityProduct)
    {
        $productModel = new ProductModel();

        $result = $productModel->updateProduct($entityProduct);

        return $result;
    }

    public function updateProductDetail($entityProductDetail)
    {
        $productModel = new ProductModel();

        $result = $productModel->updateProductDetail($entityProductDetail);

        return $result;
    }
}

?>