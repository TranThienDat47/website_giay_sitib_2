<?php
include_once "../models/E_Custommer.php";
include_once "../models/E_Address.php";
include_once "../models/CustommerModel.php";
include_once "../controllers/CustommerController.php";

$custommerController = new CustommerController();

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_data = json_decode(file_get_contents('php://input'), true);

    if (!empty($input_data) && isset($input_data['action'])) {
        $action = $input_data['action'];

        if ($action == 'login') {
            if (Session::checkLoginCustomer() == true) {
                echo json_encode([true]);
                exit();
            } else {
                echo json_encode([false]);
                exit();
            }
        }

    }

    if (
        !empty($input_data) && isset($input_data['action']) && isset($input_data['email']) && isset($input_data['password']) && isset($input_data['gender'])
        && isset($input_data['firstName']) && isset($input_data['lastName']) && isset($input_data['phone']) && isset($input_data['address'])
        && isset($input_data['province']) && isset($input_data['district']) && isset($input_data['village'])
    ) {
        $action = $input_data['action'];
        $email = $input_data['email'];
        $password = $input_data['password'];
        $gender = $input_data['gender'];
        $firstName = $input_data['firstName'];
        $lastName = $input_data['lastName'];
        $phone = $input_data['phone'];
        $address = $input_data['address'];
        $province = $input_data['province'];
        $district = $input_data['district'];
        $village = $input_data['village'];


        if ($action == 'register') {

            $fullName = trim($firstName) . " " . trim($lastName);
            $custommer = new EntityCustomer(0, trim($email), trim($password), trim($gender), trim($firstName), trim($lastName), null);
            $custommer_id = $custommerController->register($custommer);
            if ($custommer_id) {
                $address = new EntityAddress(0, $custommer_id, $fullName, true, $phone, $address, $province, $district, $village);
                if ($custommerController->addAddress($address)) {
                    echo json_encode([true]);
                    exit();
                }
            }
        }

    }
} else {
    echo "Yêu cầu không hợp lệ.";
}




// if (isset($_POST['action']) && !empty($_POST['action'])) {
//     $action = $_POST['action'];

//     if ($action == 'register') {
//         $fullName = trim($_POST['firstName']) . " " . trim($_POST['lastName']);
//         $custommer = new EntityCustomer(0, trim($_POST['email']), trim($_POST['password']), trim($_POST['firstName']), trim($_POST['lastName']), null);
//         $custommer_id = $custommerController->register($custommer);
//         if ($custommer_id) {
//             $address = new EntityAddress(0, $custommer_id, $fullName, true, $_POST['phone'], $_POST['address'], $_POST['province'], $_POST['district'], $_POST['village']);
//             $custommerController->addAddress($address);

//         }
//     }

//     if ($action == 'login') {

//         $email = $_POST['email'];
//         $password = $_POST['password'];
//         $custommerController->login($email, $password);
//     }
// }

?>