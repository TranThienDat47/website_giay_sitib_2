<?php
include_once "../config/database.php";

include_once "../models/E_Product.php";
include_once "../models/E_ProductDetail.php";

class ProductModel
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

    public function getProductAndProductDetailCustommer($category)
    {

        try {
            $sql = "SELECT products.*, productdetails.*, categories.title as cur_category, parent_category.title AS parent_category_name
            FROM products
            LEFT JOIN productdetails ON products.product_id = productdetails.product_id
            LEFT JOIN categories ON products.category_id = categories.category_id
            LEFT JOIN categories AS parent_category ON categories.PARENT_CATEGORY_ID = parent_category.category_id
            WHERE (categories.title = '$category' OR parent_category.title = '$category') AND products.product_status = 'Hoạt động' and productdetails.qty > 0;";

            $result = $this->db->fetchAll($sql);

            // Convert the result set into an array of Product objects
            $products = [];
            foreach ($result as $row) {
                $product = new EntityProduct(
                    $row['PRODUCT_ID'],
                    $row['NAME'],
                    $row['DESCRIPTION'],
                    $row['PRICE'],
                    $row['STOCK'],
                    $row['NEWS'],
                    $row['CATEGORY_ID'],
                    $row['PRODUCT_STATUS'],
                    $row['CREATED_AT']
                );
                $productDetail = new EntityProductDetail(
                    $row['PRODUCTDETAIL_ID'],
                    $row['PRODUCT_ID'],
                    $row['IMG1'],
                    $row['IMG2'],
                    $row['IMG3'],
                    $row['IMG4'],
                    $row['IMG5'],
                    $row['IGM6'],
                    $row['SIZE'],
                    $row['COLOR'],
                    $row['QTY']
                );
                $product->productDetails = $productDetail;

                $product->catgory = $row['parent_category_name'];
                $product->parent_catgory = $row['cur_category'];

                $products[] = $product;
            }



            return $products;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getProductAndProductDetailCustommerWithCategoryID($category_id)
    {

        try {
            $sql = "SELECT products.*, productdetails.*, categories.title as cur_category, parent_category.title AS parent_category_name
            FROM products
            LEFT JOIN productdetails ON products.product_id = productdetails.product_id
            LEFT JOIN categories ON products.category_id = categories.category_id
            LEFT JOIN categories AS parent_category ON categories.PARENT_CATEGORY_ID = parent_category.category_id
            WHERE (categories.CATEGORY_ID  = '$category_id' OR parent_category.CATEGORY_ID = '$category_id') AND products.product_status = 'Hoạt động' and productdetails.qty > 0;";

            $result = $this->db->fetchAll($sql);

            // Convert the result set into an array of Product objects
            $products = [];
            foreach ($result as $row) {
                $product = new EntityProduct(
                    $row['PRODUCT_ID'],
                    $row['NAME'],
                    $row['DESCRIPTION'],
                    $row['PRICE'],
                    $row['STOCK'],
                    $row['NEWS'],
                    $row['CATEGORY_ID'],
                    $row['PRODUCT_STATUS'],
                    $row['CREATED_AT']
                );
                $productDetail = new EntityProductDetail(
                    $row['PRODUCTDETAIL_ID'],
                    $row['PRODUCT_ID'],
                    $row['IMG1'],
                    $row['IMG2'],
                    $row['IMG3'],
                    $row['IMG4'],
                    $row['IMG5'],
                    $row['IGM6'],
                    $row['SIZE'],
                    $row['COLOR'],
                    $row['QTY']
                );
                $product->productDetails = $productDetail;

                $product->catgory = $row['parent_category_name'];
                $product->parent_catgory = $row['cur_category'];

                $products[] = $product;
            }



            return $products;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getProductAndProductDetail()
    {

        try {
            $sql = "SELECT products.*, productdetails.*, categories.title as cur_category, parent_category.title AS parent_category_name
            FROM products
            LEFT JOIN productdetails ON products.product_id = productdetails.product_id
            LEFT JOIN categories ON products.category_id = categories.category_id
            LEFT JOIN categories AS parent_category ON categories.PARENT_CATEGORY_ID = parent_category.category_id
            WHERE (products.product_status = 'Hoạt động' or products.product_status = 'Tạm dừng' or products.product_status = 'Hết hàng') and productdetails.qty >= 0";

            $result = $this->db->fetchAll($sql);

            // Convert the result set into an array of Product objects
            $products = [];
            foreach ($result as $row) {
                $product = new EntityProduct(
                    $row['PRODUCT_ID'],
                    $row['NAME'],
                    $row['DESCRIPTION'],
                    $row['PRICE'],
                    $row['STOCK'],
                    $row['NEWS'],
                    $row['CATEGORY_ID'],
                    $row['PRODUCT_STATUS'],
                    $row['CREATED_AT']
                );
                $productDetail = new EntityProductDetail(
                    $row['PRODUCTDETAIL_ID'],
                    $row['PRODUCT_ID'],
                    $row['IMG1'],
                    $row['IMG2'],
                    $row['IMG3'],
                    $row['IMG4'],
                    $row['IMG5'],
                    $row['IGM6'],
                    $row['SIZE'],
                    $row['COLOR'],
                    $row['QTY']
                );
                $product->productDetails = $productDetail;

                $product->catgory = $row['parent_category_name'];
                $product->parent_catgory = $row['cur_category'];

                $products[] = $product;
            }



            return $products;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getProductAndProductDetailCustommerAll()
    {

        try {
            $sql = "SELECT products.*, productdetails.*, categories.title as cur_category, parent_category.title AS parent_category_name
            FROM products
            LEFT JOIN productdetails ON products.product_id = productdetails.product_id
            LEFT JOIN categories ON products.category_id = categories.category_id
            LEFT JOIN categories AS parent_category ON categories.PARENT_CATEGORY_ID = parent_category.category_id
            WHERE products.product_status = 'Hoạt động' and productdetails.qty > 0;";

            $result = $this->db->fetchAll($sql);

            // Convert the result set into an array of Product objects
            $products = [];
            foreach ($result as $row) {
                $product = new EntityProduct(
                    $row['PRODUCT_ID'],
                    $row['NAME'],
                    $row['DESCRIPTION'],
                    $row['PRICE'],
                    $row['STOCK'],
                    $row['NEWS'],
                    $row['CATEGORY_ID'],
                    $row['PRODUCT_STATUS'],
                    $row['CREATED_AT']
                );
                $productDetail = new EntityProductDetail(
                    $row['PRODUCTDETAIL_ID'],
                    $row['PRODUCT_ID'],
                    $row['IMG1'],
                    $row['IMG2'],
                    $row['IMG3'],
                    $row['IMG4'],
                    $row['IMG5'],
                    $row['IGM6'],
                    $row['SIZE'],
                    $row['COLOR'],
                    $row['QTY']
                );
                $product->productDetails = $productDetail;

                $product->catgory = $row['parent_category_name'];
                $product->parent_catgory = $row['cur_category'];

                $products[] = $product;
            }



            return $products;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function getProductAndProductDetailCustommerWithProductID($productID)
    {

        try {
            $sql = "SELECT products.*, productdetails.*, categories.title as cur_category, parent_category.title AS parent_category_name
            FROM products
            LEFT JOIN productdetails ON products.product_id = productdetails.product_id
            LEFT JOIN categories ON products.category_id = categories.category_id
            LEFT JOIN categories AS parent_category ON categories.PARENT_CATEGORY_ID = parent_category.category_id
            WHERE products.product_id = $productID and products.product_status = 'Hoạt động' and productdetails.qty > 0;";

            $result = $this->db->fetchAll($sql);

            // Convert the result set into an array of Product objects
            $products = [];
            foreach ($result as $row) {
                $product = new EntityProduct(
                    $row['PRODUCT_ID'],
                    $row['NAME'],
                    $row['DESCRIPTION'],
                    $row['PRICE'],
                    $row['STOCK'],
                    $row['NEWS'],
                    $row['CATEGORY_ID'],
                    $row['PRODUCT_STATUS'],
                    $row['CREATED_AT']
                );
                $productDetail = new EntityProductDetail(
                    $row['PRODUCTDETAIL_ID'],
                    $row['PRODUCT_ID'],
                    $row['IMG1'],
                    $row['IMG2'],
                    $row['IMG3'],
                    $row['IMG4'],
                    $row['IMG5'],
                    $row['IGM6'],
                    $row['SIZE'],
                    $row['COLOR'],
                    $row['QTY']
                );
                $product->productDetails = $productDetail;

                $product->catgory = $row['parent_category_name'];
                $product->parent_catgory = $row['cur_category'];

                $products[] = $product;
            }



            return $products;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function getQtyOfProudctWhenAddCart($product_id, $size, $color)
    {
        try {
            $sql = "SELECT productdetails.qty as qty, productdetails.PRODUCTDETAIL_ID as detail_id
            FROM products
            JOIN productdetails ON products.PRODUCT_ID = productdetails.product_id
            WHERE (products.product_status = 'Hoạt động') and products.PRODUCT_ID = $product_id and products.PRODUCT_ID = productdetails.product_id and color = '$color' and size = '$size' and QTY >= 0;";

            $quantity = $this->db->fetchOne($sql);

            if ($quantity) {
                $result[] = $quantity['qty'];
                $result[] = $quantity['detail_id'];

                return $result;
            }

            return [0, 0];
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // public function getOneProductAndProductDetail($product_id)
    // {
    //     try {
    //         $sql = "SELECT * FROM products LEFT JOIN productDetail 
    //         ON products.product_id = productDetail.product_id
    //         WHERE products.product_id = $product_id";

    //         $result = $this->db->fetchOne($sql);

    //         if ($result) {
    //             // Convert the result set into a Product object
    //             $product = new EntityProduct(
    //                 $result['PRODUCT_ID'],
    //                 $result['NAME'],
    //                 $result['DESCRIPTION'],
    //                 $result['PRICE'],
    //                 $result['STOCK'],
    //                 $result['NEWS'],
    //                 $result['CATEGORY_ID'],
    //                 $result['PRODUCT_STATUS'],
    //                 $result['CREATED_AT'],
    //             );

    //             $productDetail = new EntityProductDetail(
    //                 $result['PRODUCTDETAIL_ID'],
    //                 $result['PRODUCT_ID'],
    //                 $result['IMG1'],
    //                 $result['IMG2'],
    //                 $result['IMG3'],
    //                 $result['IMG4'],
    //                 $result['IMG5'],
    //                 $result['IGM6'],
    //                 $result['SIZE'],
    //                 $result['COLOR'],
    //                 $result['QTY']
    //             );
    //             $product->productDetails = $productDetail;


    //             return $product;
    //         }
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

    public function getOneProductDetail($product_detail_id)
    {
        try {
            $sql = "SELECT * FROM  productdetails WHERE productdetail_id = ? and qty >= 0";
            $params = [$product_detail_id];

            $result = $this->db->fetchOne($sql, $params);
            // Convert the result set into a Product object

            $productDetail = null;

            if ($result) {
                $productDetail = new EntityProductDetail(
                    $result['PRODUCTDETAIL_ID'],
                    $result['PRODUCT_ID'],
                    $result['IMG1'],
                    $result['IMG2'],
                    $result['IMG3'],
                    $result['IMG4'],
                    $result['IMG5'],
                    $result['IGM6'],
                    $result['SIZE'],
                    $result['COLOR'],
                    $result['QTY']
                );
            }


            return $productDetail;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addProduct($product)
    {
        try {
            $table = "products";

            $data = [
                'name' => $product->name,
                'description' => nl2br($product->description),
                'price' => $product->price,
                'category_id' => $product->category_id
            ];

            $resul = $this->db->insert($table, $data);

            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addProductDetail($productDetail)
    {
        try {
            $table = "productdetails";

            $data = [
                'PRODUCT_ID' => $productDetail->product_id,
                'IMG1' => $productDetail->img1,
                'img2' => $productDetail->img2,
                'IMG3' => $productDetail->img3,
                'IMG4' => $productDetail->img4,
                'IMG5' => $productDetail->img5,
                'IGM6' => $productDetail->img6,
                'SIZE' => $productDetail->size,
                'color' => $productDetail->color,
            ];

            $resul = $this->db->insertResultRow($table, $data);

            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function updateProduct($product)
    {
        try {
            $table = "products";

            $data = [
                'name' => $product->name,
                'description' => nl2br($product->description),
                'price' => $product->price,
                'category_id' => $product->category_id
            ];

            $where = "PRODUCT_ID = " . $product->product_id;



            $result = $this->db->update($table, $data, $where);

            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // public function updateProductPrice($product_id, $price)
    // {
    //     try {
    //         $table = "products";

    //         $data = [
    //             'price' => $price,
    //         ];

    //         $where = "product_id = " . $product_id;

    //         $result = $this->db->update($table, $data, $where);


    //         return $result;
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

    public function updateProductDetail($productDetail)
    {
        try {
            $table = "productdetails";

            $data = [
                'IMG1' => $productDetail->img1,
                'img2' => $productDetail->img2,
                'IMG3' => $productDetail->img3,
                'IMG4' => $productDetail->img4,
                'IMG5' => $productDetail->img5,
                'IGM6' => $productDetail->img6,
            ];

            $where = 'PRODUCTDETAIL_ID =' . $productDetail->product_detail_id;

            $result = $this->db->update($table, $data, $where);

            return $result > 0;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // public function increaseProductDetailQuantity($productDetailId, $qty)
    // {

    //     try {
    //         $curQty = (int) $this->getOneProductDetail($productDetailId)->getQty();

    //         if ($curQty && $curQty >= 0) {

    //             $table = "productdetail";

    //             $data = [
    //                 'qty' => $curQty + $qty
    //             ];

    //             $where = 'product_detail_id =' . $productDetailId;

    //             $result = $this->db->update($table, $data, $where);


    //             return $result;
    //         }

    //         return false;

    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

    public function decreaseProductQuantity($productDetailId, $qty)
    {

        try {
            $curQty = (int) $this->getOneProductDetail($productDetailId)->getQty();

            if ($curQty && $curQty - $qty >= 0) {

                $table = "productdetails";

                $data = [
                    'qty' => (int) $curQty - (int) $qty
                ];

                $where = "productdetail_id = $productDetailId";

                $result = $this->db->update($table, $data, $where);


                return $result;
            }

            return false;

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function checkProductQuantity($productDetailId, $qty)
    {

        try {
            $curQty = (int) $this->getOneProductDetail($productDetailId)->getQty();

            if ($curQty && $curQty - $qty >= 0) {
                return true;
            }

            return false;

        } catch (\Throwable $th) {
            //throw $th;
        }
    }




    public function deleteProductDetail($product_detail_id)
    {
        try {
            $table = "productdetails";
            $where = 'product_detail_id =' . $product_detail_id;

            $result = $this->db->delete($table, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

?>