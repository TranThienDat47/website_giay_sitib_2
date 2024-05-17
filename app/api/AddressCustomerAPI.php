<?php
include_once "../models/E_Address.php";
include_once "../controllers/CustommerController.php";

$customerController = new CustommerController();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_data = json_decode(file_get_contents('php://input'), true);


    if (!empty($input_data) && isset($input_data['action'])) {
        $action = $input_data['action'];

        if ($action == 'get_all_address_customer') {
            $result = $customerController->getAllAddressOfCustomer();

            echo json_encode($result);
        }
    }

    if (
        !empty($input_data) && isset($input_data['action']) && isset($input_data['address_id']) && isset($input_data['address_name']) && isset($input_data['address_default']) && isset($input_data['address_phone'])
        && isset($input_data['address_detail']) && isset($input_data['address_province']) && isset($input_data['address_dictrict']) && isset($input_data['address_ward'])
    ) {

        $action = $input_data['action'];
        $address_id = $input_data['address_id'];
        $address_name = $input_data['address_name'];
        $address_phone = $input_data['address_phone'];
        $address_default = $input_data['address_default'];
        $address_detail = $input_data['address_detail'];
        $address_province = $input_data['address_province'];
        $address_dictrict = $input_data['address_dictrict'];
        $address_ward = $input_data['address_ward'];

        if ($action == 'update_address_customer') {
            $result = $customerController->updateAddressCustomer($address_id, $address_name, $address_default, $address_phone, $address_detail, $address_province, $address_dictrict, $address_ward);

            if ($address_default) {
                $result1 = $customerController->setDefaultAddress($address_id);
            }

            echo json_encode($result);

        }
    }

    if (
        !empty($input_data) && isset($input_data['action']) && isset($input_data['address_id'])
    ) {

        $action = $input_data['action'];
        $address_id = $input_data['address_id'];

        if ($action == 'delete_address_customer') {
            $result = $customerController->deleteAddressCustomer($address_id);


            echo json_encode($result);

        }
    }


} else {
    echo json_encode("Yêu cầu không hợp lệ.");
}
?>