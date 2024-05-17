<?php
include_once "../models/E_CartDetail.php";
include_once "../controllers/CartController.php";

$cartController = new CartController();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_data = json_decode(file_get_contents('php://input'), true);


    if (
        !empty($input_data) && isset($input_data['action']) && isset($input_data['productID'])
        && isset($input_data['color']) && isset($input_data['size']) && isset($input_data['quantity'])
    ) {
        $action = $input_data['action'];
        $productID = $input_data['productID'];
        $color = $input_data['color'];
        $size = $input_data['size'];
        $quantity = $input_data['quantity'];


        if ($action == 'add_cart' || $action == 'plus_qty_cart_detail') {
            $cartController = new CartController();
            $cartDetailEntity = new EntityCartDetail(0, 0, $productID, $quantity, $color, $size);

            echo json_encode([$cartController->addProductToCart($cartDetailEntity)]);
        }
    }

    if (!empty($input_data) && isset($input_data['product_detail_id'])) {
        $action = $input_data['action'];
        $product_detail_id = $input_data['product_detail_id'];

        if ($action == 'minus_qty_cart_detail') {
            $cartController = new CartController();

            echo json_encode([$cartController->minusProductOfCart($product_detail_id)]);
        }

        if ($action == 'remove_cart_detail') {
            $cartController = new CartController();

            echo json_encode([$cartController->deleteProductOfCart($product_detail_id)]);
        }
    }


} else {
    echo json_encode("Yêu cầu không hợp lệ.");
}



?>