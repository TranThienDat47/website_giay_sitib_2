<?php
include_once "../models/E_Category.php";
include_once "../controllers/CategoryController.php";

$cartController = new CategoryController();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_data = json_decode(file_get_contents('php://input'), true);


    if (!empty($input_data) && isset($input_data['action'])) {
        $action = $input_data['action'];


        if ($action == 'get_all_category_with_parent') {
            $categoryController = new CategoryController();

            $result = $categoryController->getAllCategoryWithParent();

            echo json_encode($result);
        }
    }


} else {
    echo json_encode("Yêu cầu không hợp lệ.");
}

?>