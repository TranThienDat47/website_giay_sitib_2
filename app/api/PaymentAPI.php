<?php
include_once "../models/E_CustommerPayment.php";
include_once "../controllers/CustommerController.php";
include_once "../controllers/CartController.php";

$customerController = new CustommerController();
$cartController = new CartController();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_data = json_decode(file_get_contents('php://input'), true);

    if (
        !empty($input_data) && isset($input_data['action']) && isset($input_data['payment_method_id']) && isset($input_data['address_id']) && isset($input_data['address_name']) && isset($input_data['address_phone'])
        && isset($input_data['address_detail']) && isset($input_data['address_province']) && isset($input_data['address_dictrict']) && isset($input_data['address_ward'])
    ) {
        $action = $input_data['action'];
        $payment_method_id = $input_data['payment_method_id'];
        $address_id = $input_data['address_id'];
        $address_name = $input_data['address_name'];
        $address_phone = $input_data['address_phone'];
        $address_detail = $input_data['address_detail'];
        $address_province = $input_data['address_province'];
        $address_dictrict = $input_data['address_dictrict'];
        $address_ward = $input_data['address_ward'];

        if ($action == 'payment_method_id') {
            $check_address = $customerController->checkAddress($address_name, $address_phone, $address_detail, $address_province, $address_dictrict, $address_ward);

            $result = null;
            if ($check_address) {
                // $customerController->setDefaultAddress($check_address);
                $result = $cartController->paymentCart($check_address, $payment_method_id);
            } else {
                $result = $cartController->paymentCart($address_id, $payment_method_id);
            }
            echo json_encode($result);

        } else {
            echo json_encode("Yêu cầu không hợp lệ.");
        }

    }


} else {
    echo json_encode("Yêu cầu không hợp lệ.");
}
?>