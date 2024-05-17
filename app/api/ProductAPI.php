<?php
include_once "../models/E_Product.php";
include_once "../models/E_ProductDetail.php";
include_once "../models/ProductModel.php";
include_once "../controllers/ProductController.php";

$productController = new ProductController();

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_data = json_decode(file_get_contents('php://input'), true);

    if (!empty($input_data) && isset($input_data['action']) && isset($input_data['category'])) {
        $action = $input_data['action'];
        $category = $input_data['category'];

        $result = array();

        if ($action == 'home_nam') {
            $category = trim($category);
            $list_product = $productController->getProductAndProductDetailCustommer($category);
            $result[] = $list_product;
        }

        if ($action == 'home_nu') {
            $category = trim($category);
            $list_product = $productController->getProductAndProductDetailCustommer($category);
            $result[] = $list_product;
        }

        echo json_encode($result);
        exit();
    }

    if (!empty($input_data) && isset($input_data['action']) && isset($input_data['productID'])) {
        $action = $input_data['action'];
        $productID = $input_data['productID'];

        $result = array();

        if ($action == 'one_product') {
            $list_product = $productController->getAllProductAndProductDetailWithProductID($productID);
            $result[] = $list_product;
            echo json_encode($result);
            exit();
        }

        echo json_encode($result);
        exit();
    }

    if (!empty($input_data) && isset($input_data['action'])) {
        $action = $input_data['action'];

        $result = array();

        if ($action == 'all_product_with_category' && isset($input_data['value'])) {
            $value = $input_data['value'];
            $list_product = $productController->getProductAndProductDetailCustommerWithCategoryID($value);
            $result[] = $list_product;

            echo json_encode($result);
            exit();
        }

        if ($action == 'home_nam_nu') {
            $list_product = $productController->getProductAndProductDetailCustommer("Nam");
            $list_product1 = $productController->getProductAndProductDetailCustommer("Nữ");
            $result[] = array_merge($list_product1, $list_product);

            echo json_encode($result);
            exit();
        }

        if ($action == 'all_product_customer') {
            $list_product = $productController->getAllProductAndProductDetailCustommer();
            $result[] = $list_product;

            echo json_encode($result);
            exit();
        }

        if ($action == 'all_product') {
            $list_product = $productController->getAllProductAndProductDetail();
            $result[] = $list_product;

            echo json_encode($result);
            exit();
        }

    }

    if (!empty($input_data) && isset($input_data['action']) && isset($input_data['name']) && isset($input_data['description']) && isset($input_data['price']) && isset($input_data['category_id'])) {
        $action = $input_data['action'];
        $name = $input_data['name'];
        $description = $input_data['description'];
        $price = $input_data['price'];
        $category_id = $input_data['category_id'];

        if ($action == 'add_product') {
            $priceReal = $number = floatval(str_replace(",", "", $price));
            $entityProduct = new EntityProduct(null, $name, $description, $priceReal, null, null, $category_id, null, null);

            $product_id = $productController->addProduct($entityProduct);

            echo json_encode($product_id);

            exit();
        }
    }

    if (!empty($input_data) && isset($input_data['action']) && isset($input_data['product_id']) && isset($input_data['name']) && isset($input_data['description']) && isset($input_data['price']) && isset($input_data['category_id'])) {
        $action = $input_data['action'];
        $product_id = $input_data['product_id'];
        $name = $input_data['name'];
        $description = $input_data['description'];
        $price = $input_data['price'];
        $category_id = $input_data['category_id'];

        if ($action == 'update_product') {
            $priceReal = $number = floatval(str_replace(",", "", $price));
            $entityProduct = new EntityProduct($product_id, $name, $description, $priceReal, null, null, $category_id, null, null);

            $product_id = $productController->updateProduct($entityProduct);

            echo json_encode($product_id);

            exit();
        }
    }

    if (
        !empty($input_data) && isset($input_data['action']) && isset($input_data['product_id']) && isset($input_data['img1']) && isset($input_data['img2'])
        && isset($input_data['size']) && isset($input_data['color'])
    ) {
        $action = $input_data['action'];
        $product_id = $input_data['product_id'];
        $img1 = $input_data['img1'];
        $img2 = $input_data['img2'];
        $img3 = $input_data['img3'];
        $img4 = $input_data['img4'];
        $img5 = $input_data['img5'];
        $img6 = $input_data['img6'];
        $size = $input_data['size'];
        $color = $input_data['color'];

        if ($action == 'add_product_detail') {
            $entityProductDetail = new EntityProductDetail(null, $product_id, $img1, $img2, $img3, $img4, $img5, $img6, $size, $color, 0);

            $result = $productController->addProductDetail($entityProductDetail);
            echo json_encode($result);
            exit();
        }
    }

    if (
        !empty($input_data) && isset($input_data['action']) && isset($input_data['productDetail_id']) && isset($input_data['img1']) && isset($input_data['img2'])
        && isset($input_data['size']) && isset($input_data['color'])
    ) {
        $action = $input_data['action'];
        $productDetail_id = $input_data['productDetail_id'];
        $img1 = $input_data['img1'];
        $img2 = $input_data['img2'];
        $img3 = $input_data['img3'];
        $img4 = $input_data['img4'];
        $img5 = $input_data['img5'];
        $img6 = $input_data['img6'];
        $size = $input_data['size'];
        $color = $input_data['color'];

        if ($action == 'update_product_detail') {
            $entityProductDetail = new EntityProductDetail($productDetail_id, null, $img1, $img2, $img3, $img4, $img5, $img6, $size, $color, 0);

            $result = $productController->updateProductDetail($entityProductDetail);

            echo json_encode($result);
            exit();
        }
    }


} else {
    echo "Yêu cầu không hợp lệ.";
}
?>