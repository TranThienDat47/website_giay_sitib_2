<?php
include_once "../config/database.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_data = json_decode(file_get_contents('php://input'), true);
    $db = new Database();




    if (!empty($input_data) && isset($input_data['action'])) {
        $action = $input_data['action'];

        if ($action == 'get_all_product_detail_purchase') {

            $sql = "SELECT products.*, productdetails.*, categories.title as cur_category, parent_category.title AS parent_category_name
            FROM products
            LEFT JOIN productdetails ON products.product_id = productdetails.product_id
            LEFT JOIN categories ON products.category_id = categories.category_id
            LEFT JOIN categories AS parent_category ON categories.PARENT_CATEGORY_ID = parent_category.category_id
            WHERE (products.product_status = 'Hoạt động' or products.product_status = 'Tạm dừng' or products.product_status = 'Hết hàng') and productdetails.qty >= 0";

            $result = $db->query($sql);

            $rows = array();

            while ($temp = $result->fetch_assoc()) {
                $rows[] = $temp;
            }

            $list_product = [];

            foreach ($rows as $temp) {
                $list_product[] = [$temp['PRODUCT_ID'], $temp['NAME'], $temp['COLOR'], $temp['SIZE'], number_format($temp['PRICE'], 0, ".", ","), $temp['PRODUCTDETAIL_ID']];
            }

            echo json_encode($list_product);
            exit();
        }
    }

    if (!empty($input_data) && isset($input_data['action']) && isset($input_data['product_id']) && isset($input_data['color']) && isset($input_data['size']) && isset($input_data['qty'])) {

        function updateQty($db, $product_id, $color, $size, $qty)
        {
            $query = "UPDATE productdetails
            SET QTY = QTY + {$qty}
            WHERE PRODUCT_ID = {$product_id}
            AND COLOR = '{$color}'
            AND SIZE = '{$size}'
            AND QTY >= 0;";


            $result = $db->query($query);

            return $result;
        }

        $action = $input_data['action'];
        $product_id = $input_data['product_id'];
        $color = $input_data['color'];
        $size = $input_data['size'];
        $qty = $input_data['qty'];

        if ($action === "update_purchase_detail") {
            if (updateQty($db, $product_id, $color, $size, $qty)) {
                echo json_encode(true);
                exit();

            } else {
                echo json_encode(false);
                exit();
            }
        }

    }

    if (!empty($input_data) && isset($input_data['action']) && isset($input_data['supplier_id']) && isset($input_data['user_id'])) {
        function addPurchase($db, $supplier_id, $user_id)
        {
            try {
                $table = "purchase";

                $data = [
                    'SUPPLIER_ID' => $supplier_id,
                    'USER_ID' => $user_id,
                ];
                $resul = $db->insert($table, $data);

                return $resul;
            } catch (\Throwable $th) {
                //throw $th;
                return false;
            }
        }

        $action = $input_data['action'];
        $supplier_id = $input_data['supplier_id'];
        $user_id = $input_data['user_id'];

        if ($action === "add_purchase") {
            echo json_encode(addPurchase($db, $supplier_id, $user_id));
            exit();
        }
    }

    if (
        !empty($input_data) && isset($input_data['action']) && isset($input_data['purchase_id']) && isset($input_data['product_id'])
        && isset($input_data['qty']) && isset($input_data['price']) && isset($input_data['color']) && isset($input_data['size'])
    ) {
        function addPurchaseDetail($db, $purchase_id, $product_id, $qty, $price, $color, $size)
        {
            try {
                $table = "purchasedetails";

                $data = [
                    'PURCHASE_ID' => $purchase_id,
                    'PRODUCT_ID' => $product_id,
                    'QUANTITY' => $qty,
                    'PURCHASE_PRICE' => $price,
                    'COLOR' => $color,
                    'SIZE' => $size,
                ];
                $resul = $db->insert($table, $data);

                return $resul;
            } catch (\Throwable $th) {
                //throw $th;
                return false;
            }
        }

        $action = $input_data['action'];
        $purchase_id = $input_data['purchase_id'];
        $product_id = $input_data['product_id'];
        $qty = $input_data['qty'];
        $price = intval($input_data['price']);
        $color = $input_data['color'];
        $size = $input_data['size'];

        if ($action === "add_purchase_detail") {
            echo json_encode(addPurchaseDetail($db, $purchase_id, $product_id, $qty, $price, $color, $size));
            exit();
        }
    }


    if (!empty($input_data) && isset($input_data['action']) && isset($input_data['purchase_id'])) {
        function getAllPurchases($db, $purchase_id)
        {
            try {
                $sql = "SELECT pd.PRODUCT_ID, pr.NAME, pd.COLOR, pd.SIZE, pd.QUANTITY,
                pd.QUANTITY * pd.PURCHASE_PRICE AS total_nhap,
                pd.QUANTITY * pr.PRICE AS total_ban
         FROM purchasedetails pd
         INNER JOIN products pr ON pd.PRODUCT_ID = pr.PRODUCT_ID where PURCHASE_ID = $purchase_id";


                $result = $db->query($sql);

                $rows = array();

                while ($temp = $result->fetch_assoc()) {
                    $rows[] = $temp;
                }

                $view_parent = [];

                foreach ($rows as $temp) {
                    $view_parent[] = [$temp['PRODUCT_ID'], $temp['NAME'], $temp['COLOR'], $temp['SIZE'], $temp['QUANTITY'], number_format($temp['total_nhap'], 0, ".", ","), number_format($temp['total_ban'], 0, ".", ",")];
                }

                return $view_parent;
            } catch (\Throwable $th) {
                //throw $th;
                return false;
            }
        }

        $action = $input_data['action'];
        $purchase_id = $input_data['purchase_id'];

        if ($action === "get_all_purchase_detail_") {
            echo json_encode(getAllPurchases($db, $purchase_id));
            exit();
        }
    }


} else {
    echo json_encode("Yêu cầu không hợp lệ.");
}
?>