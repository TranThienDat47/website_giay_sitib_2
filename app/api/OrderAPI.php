<?php
include_once "../config/database.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_data = json_decode(file_get_contents('php://input'), true);
    $db = new Database();

    if (!empty($input_data) && isset($input_data['action']) && isset($input_data['cart_id'])) {
        $action = $input_data['action'];
        $cart_id = $input_data['cart_id'];

        if ($action == 'get_all_product_detail_order') {

            $sql = "SELECT c.PRODUCT_ID, p.NAME, c.COLOR, c.SIZE, c.QUANTITY, p.PRICE, (c.QUANTITY * p.PRICE) AS total
            FROM cartdetails c
            JOIN products p ON c.PRODUCT_ID = p.PRODUCT_ID
            WHERE c.CART_ID = '$cart_id';";

            $result = $db->query($sql);

            $rows = array();

            while ($temp = $result->fetch_assoc()) {
                $rows[] = $temp;
            }

            $list_product = [];

            foreach ($rows as $temp) {
                $list_product[] = [$temp['PRODUCT_ID'], $temp['NAME'], $temp['COLOR'], $temp['SIZE'], $temp['QUANTITY'], number_format($temp['PRICE'], 0, ".", ","), number_format($temp['total'], 0, ".", ",")];
            }

            echo json_encode($list_product);
            exit();
        }
    }


} else {
    echo json_encode("Yêu cầu không hợp lệ.");
}
?>