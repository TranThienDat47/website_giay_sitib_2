<?php
ob_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn đặt hàng</title>
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <?php include "./Layout/navbar.php"; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/DB_Oders.css">
    <script type="module" src="./js/DB_Oders.js"></script>
    <link rel="stylesheet" href="./css/header_db.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
</head>

<body>
    <!-- Header -->
    <?php echo $header; ?>

    <!-- Main -->
    <main id="main">
        <div class="main-dashboard__custommer">
            <div class="main-dashboard__custommer-header">
                <h2 class="main-dashboard__custommer-title">Danh sách đơn đặt hàng</h2>
            </div>
            <div class="main-dashboard__custommer-handle">
                <div class="main-dashboard__custommer-handle-search-wrapper">
                    <button class="main-dashboard__custommer-handle-search-icon">
                        <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"
                            style="pointer-events: none; display: block; width: 28px; height: 28px">
                            <g>
                                <path d="M21,6H3V5h18V6z M18,11H6v1h12V11z M15,17H9v1h6V17z"></path>
                            </g>
                        </svg>
                    </button>
                    <div class="main-dashboard__custommer-handle-search" style="width: 44%;">
                        <input id="input_search_real" type="text"
                            placeholder="Tìm kiếm theo địa chỉ, mã hóa đơn, trạng thái" />
                    </div>
                    <div class="main-dashboard__custommer-handle-search">
                        <label id="cc" for="date">Ngày giao</label>
                        <label for="date_begin"> Từ :</label>
                        <input type="date" id="date_begin" name="date">
                    </div>
                    <div class="main-dashboard__custommer-handle-search">
                        <label for="date_end"> Đến :</label>
                        <input type="date" id="date_end" name="date">
                    </div>
                    <button id="find_date_btn" class="find-date-btn">Tìm ngày giao</button>
                </div>
            </div>

            <div class="hoadon">
                <table>
                    <thead>
                        <tr>
                            <th class="col-1" width="10%">Mã Hóa Đơn <i style="cursor: pointer;"
                                    class="fa-solid fa-sort"></i>
                            </th>
                            <th class="col-2" width="20%">Địa chỉ</th>
                            <th class="col-3" width="10%">Số Điện Thoại</th>
                            <th class="col-4" width="15%">Tổng Tiền <i style="cursor: pointer;"
                                    class="fa-solid fa-sort"></i></th>
                            <th class=" col-5" width="15%">Ngày Đặt</th>
                            <th class=" col-6" width="15%">Ngày Giao</th>
                            <th class="col-7" width="15%">Trạng Thái </i></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        include_once "../../libs/session.php";
                        include_once "../config/database.php";

                        $db = new Database();

                        function getAllStatusOrder($db, $title)
                        {
                            $sql = "SELECT * FROM `cartstatus` WHERE TITLE != 'Chờ mua hàng';";

                            $result = $db->query($sql);

                            $rows = array();

                            while ($temp = $result->fetch_assoc()) {
                                $rows[] = $temp;
                            }

                            $view_parent = "";

                            foreach ($rows as $temp) {
                                if ($temp['TITLE'] === $title) {
                                    $view_parent .= "
                                    <option value='{$temp['TITLE']}' selected>{$temp['TITLE']}</option>
                                    ";
                                } else {
                                    $view_parent .= "
                                    <option value='{$temp['TITLE']}'>{$temp['TITLE']}</option>
                                    ";
                                }
                            }
                            return $view_parent;
                        }

                        function getTotalCart($db, $cart_id)
                        {
                            $sql = "SELECT SUM(cd.QUANTITY * p.PRICE) AS total_price
                            FROM cartdetails cd
                            JOIN products p ON cd.PRODUCT_ID = p.PRODUCT_ID where CART_ID = $cart_id;";

                            $result = $db->query($sql);

                            $rows = array();

                            while ($temp = $result->fetch_assoc()) {
                                $rows[] = $temp;
                            }

                            $totals = "";

                            foreach ($rows as $temp) {
                                $totals = $temp['total_price'];
                            }
                            return $totals;
                        }

                        function getPaymentMethod($db, $payment_method_id)
                        {
                            $sql = "SELECT NAME FROM paymentmethods
                                where PAYMENT_METHOD_ID = $payment_method_id;";

                            $result = $db->query($sql);

                            $rows = array();

                            while ($temp = $result->fetch_assoc()) {
                                $rows[] = $temp;
                            }

                            $totals = "";

                            foreach ($rows as $temp) {
                                $totals = $temp['NAME'];
                            }
                            return $totals;
                        }

                        function getQtyCart($db, $cart_id)
                        {
                            $sql = "SELECT SUM(QUANTITY) as qty FROM cartdetails WHERE CART_ID = '$cart_id';";

                            $result = $db->query($sql);

                            $rows = array();

                            while ($temp = $result->fetch_assoc()) {
                                $rows[] = $temp;
                            }

                            $totals = "";

                            foreach ($rows as $temp) {
                                $totals = $temp['qty'];
                            }
                            return $totals;
                        }


                        function showAllOrders($db)
                        {
                            $sql = "SELECT DISTINCT c.ID, c.CUSTOMER_ID, c.CART_STATUS,
                            p.CREATED_AT, p.DELIVERY_BEGIN, p.DELIVERY_END,
                            a.FULLNAME, a.PHONE_NUMBER, a.DETAIL, a.PROVINCE, a.DISTRICT, a.VILLAGE, p.PAYMENT_METHOD_ID
                            FROM carts c
                            JOIN customerpayments p ON c.ID = p.CART_ID
                            JOIN address a ON p.ADDRESS_ID = a.ADDRESS_ID;";

                            $result = $db->query($sql);

                            $rows = array();

                            while ($temp = $result->fetch_assoc()) {
                                $rows[] = $temp;
                            }

                            $view_parent = "";

                            foreach ($rows as $temp) {

                                $qty = getQtyCart($db, $temp['ID']);

                                $status_temp = getAllStatusOrder($db, $temp['CART_STATUS']);
                                $total_cart = getTotalCart($db, $temp['ID']);
                                $formatted_number = number_format($total_cart, 0, ',', '.') . " đ";
                                $address_customer = $temp['DETAIL'] . ", " . explode("=", $temp['VILLAGE'])[1] . ", " . explode("=", $temp['DISTRICT'])[1] . ", " . explode("=", $temp['PROVINCE'])[1];
                                $name_payment_method = getPaymentMethod($db, $temp['PAYMENT_METHOD_ID']);

                                $view_parent .= "
                                <tr>
                                    <td class='clickable'>{$temp['ID']}</td>
                                    <td>{$address_customer}</td>
                                    <td id='get_id_customer' data-qty='{$qty}' data-name='{$temp['FULLNAME']}' data-payment='{$name_payment_method}' data-address='{$address_customer}'>{$temp['PHONE_NUMBER']}</td>
                                    <td>{$formatted_number}</td>
                                    <td>{$temp['CREATED_AT']}</td>
                                    <td>{$temp['DELIVERY_BEGIN']} đến {$temp['DELIVERY_END']}</td>
                                    <td>
                                        <select name='trangthai' class='list_trangthai'>
                                            {$status_temp}
                                        </select>
                                    </td>
                                </tr>
                                ";
                            }
                            return $view_parent;
                        }


                        if (isset($_GET['action'])) {

                            if ($_GET['action'] === "update_status_cart" && isset($_GET['cart_id']) && isset($_GET['new_status'])) {
                                $cart_id = $_GET['cart_id'];
                                $new_status = $_GET['new_status'];
                                function updateStatus($db, $cart_id, $new_status)
                                {
                                    $query = "UPDATE carts SET CART_STATUS = '$new_status' WHERE ID = $cart_id;";

                                    $result = $db->query($query);

                                    return $result;
                                }

                                if (updateStatus($db, $cart_id, $new_status)) {
                                    echo "<script> 
                                        alert('Cập nhật trạng thái thành công!');
                                        window.location.href = './DB_Oders.php';
                                        </script>";
                                }
                            }

                            if ($_GET['action'] === "search_ordeer") {

                                function searchShow($db, $value_search)
                                {
                                    $sql = "SELECT DISTINCT c.ID, c.CUSTOMER_ID, c.CART_STATUS, 
                                    p.CREATED_AT, p.DELIVERY_BEGIN, p.DELIVERY_END,
                                    a.FULLNAME, a.PHONE_NUMBER, a.DETAIL, a.PROVINCE, a.DISTRICT, a.VILLAGE, p.PAYMENT_METHOD_ID
                                    FROM carts c
                                    JOIN customerpayments p ON c.ID = p.CART_ID
                                    JOIN address a ON p.ADDRESS_ID = a.ADDRESS_ID where c.ID LIKE '%$value_search%' or c.CART_STATUS LIKE '%$value_search%' or 
                                    a.DETAIL LIKE '%$value_search%' or a.PROVINCE LIKE '%$value_search%' or a.DISTRICT LIKE '%$value_search%' or a.VILLAGE LIKE '%$value_search%' GROUP BY c.ID;";

                                    $result = $db->query($sql);

                                    $rows = array();

                                    while ($temp = $result->fetch_assoc()) {
                                        $rows[] = $temp;
                                    }

                                    $view_parent = "";

                                    foreach ($rows as $temp) {

                                        $qty = getQtyCart($db, $temp['ID']);


                                        $status_temp = getAllStatusOrder($db, $temp['CART_STATUS']);
                                        $total_cart = getTotalCart($db, $temp['ID']);
                                        $formatted_number = number_format($total_cart, 0, ',', '.') . " đ";
                                        $address_customer = $temp['DETAIL'] . ", " . explode("=", $temp['VILLAGE'])[1] . ", " . explode("=", $temp['DISTRICT'])[1] . ", " . explode("=", $temp['PROVINCE'])[1];
                                        $name_payment_method = getPaymentMethod($db, $temp['PAYMENT_METHOD_ID']);

                                        $view_parent .= "
                                        <tr>
                                            <td class='clickable'>{$temp['ID']}</td>
                                            <td>{$address_customer}</td>
                                            <td id='get_id_customer' data-qty='{$qty}' data-name='{$temp['FULLNAME']}' data-payment='{$name_payment_method}' data-address='{$address_customer}'>{$temp['PHONE_NUMBER']}</td>
                                            <td>{$formatted_number}</td>
                                            <td>{$temp['CREATED_AT']}</td>
                                            <td>{$temp['DELIVERY_BEGIN']} đến {$temp['DELIVERY_END']}</td>
                                            <td>
                                                <select name='trangthai' class='list_trangthai'>
                                                    {$status_temp}
                                                </select>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                    return $view_parent;
                                }

                                if (isset($_GET['value_search'])) {
                                    $value_search = $_GET['value_search'];

                                    if (trim($value_search) !== "") {
                                        echo searchShow($db, $value_search);
                                    } else {
                                        echo showAllOrders($db);
                                    }
                                }
                            }

                            if ($_GET['action'] === "sort_id_desc") {
                                function srotIDDescShow($db)
                                {
                                    $sql = "SELECT DISTINCT c.ID, c.CUSTOMER_ID, c.CART_STATUS, 
                                    p.CREATED_AT, p.DELIVERY_BEGIN, p.DELIVERY_END,
                                    a.FULLNAME, a.PHONE_NUMBER, a.DETAIL, a.PROVINCE, a.DISTRICT, a.VILLAGE, p.PAYMENT_METHOD_ID
                                    FROM carts c
                                    JOIN customerpayments p ON c.ID = p.CART_ID
                                    JOIN address a ON p.ADDRESS_ID = a.ADDRESS_ID GROUP BY c.ID DESC;";

                                    $result = $db->query($sql);

                                    $rows = array();

                                    while ($temp = $result->fetch_assoc()) {
                                        $rows[] = $temp;
                                    }

                                    $view_parent = "";

                                    foreach ($rows as $temp) {

                                        $qty = getQtyCart($db, $temp['ID']);


                                        $status_temp = getAllStatusOrder($db, $temp['CART_STATUS']);
                                        $total_cart = getTotalCart($db, $temp['ID']);
                                        $formatted_number = number_format($total_cart, 0, ',', '.') . " đ";
                                        $address_customer = $temp['DETAIL'] . ", " . explode("=", $temp['VILLAGE'])[1] . ", " . explode("=", $temp['DISTRICT'])[1] . ", " . explode("=", $temp['PROVINCE'])[1];
                                        $name_payment_method = getPaymentMethod($db, $temp['PAYMENT_METHOD_ID']);

                                        $view_parent .= "
                                        <tr>
                                            <td class='clickable'>{$temp['ID']}</td>
                                            <td>{$address_customer}</td>
                                            <td id='get_id_customer' data-qty='{$qty}' data-name='{$temp['FULLNAME']}' data-payment='{$name_payment_method}' data-address='{$address_customer}'>{$temp['PHONE_NUMBER']}</td>
                                            <td>{$formatted_number}</td>
                                            <td>{$temp['CREATED_AT']}</td>
                                            <td>{$temp['DELIVERY_BEGIN']} đến {$temp['DELIVERY_END']}</td>
                                            <td>
                                                <select name='trangthai' class='list_trangthai'>
                                                    {$status_temp}
                                                </select>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                    return $view_parent;
                                }

                                echo srotIDDescShow($db);
                            }


                            if ($_GET['action'] === "sort_id_asc") {
                                function srotIDAscShow($db)
                                {
                                    $sql = "SELECT DISTINCT c.ID, c.CUSTOMER_ID, c.CART_STATUS, 
                                    p.CREATED_AT, p.DELIVERY_BEGIN, p.DELIVERY_END,
                                    a.FULLNAME, a.PHONE_NUMBER, a.DETAIL, a.PROVINCE, a.DISTRICT, a.VILLAGE, p.PAYMENT_METHOD_ID
                                    FROM carts c
                                    JOIN customerpayments p ON c.ID = p.CART_ID
                                    JOIN address a ON p.ADDRESS_ID = a.ADDRESS_ID GROUP BY c.ID ASC;";

                                    $result = $db->query($sql);

                                    $rows = array();

                                    while ($temp = $result->fetch_assoc()) {
                                        $rows[] = $temp;
                                    }

                                    $view_parent = "";

                                    foreach ($rows as $temp) {

                                        $qty = getQtyCart($db, $temp['ID']);


                                        $status_temp = getAllStatusOrder($db, $temp['CART_STATUS']);
                                        $total_cart = getTotalCart($db, $temp['ID']);
                                        $formatted_number = number_format($total_cart, 0, ',', '.') . " đ";
                                        $address_customer = $temp['DETAIL'] . ", " . explode("=", $temp['VILLAGE'])[1] . ", " . explode("=", $temp['DISTRICT'])[1] . ", " . explode("=", $temp['PROVINCE'])[1];
                                        $name_payment_method = getPaymentMethod($db, $temp['PAYMENT_METHOD_ID']);

                                        $view_parent .= "
                                        <tr>
                                            <td class='clickable'>{$temp['ID']}</td>
                                            <td>{$address_customer}</td>
                                            <td id='get_id_customer' data-qty='{$qty}' data-name='{$temp['FULLNAME']}' data-payment='{$name_payment_method}' data-address='{$address_customer}'>{$temp['PHONE_NUMBER']}</td>
                                            <td>{$formatted_number}</td>
                                            <td>{$temp['CREATED_AT']}</td>
                                            <td>{$temp['DELIVERY_BEGIN']} đến {$temp['DELIVERY_END']}</td>
                                            <td>
                                                <select name='trangthai' class='list_trangthai'>
                                                    {$status_temp}
                                                </select>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                    return $view_parent;
                                }

                                echo srotIDAscShow($db);

                            }

                            if ($_GET['action'] === "sort_price_desc") {
                                function srotPriceDescShow($db)
                                {
                                    $sql = "SELECT DISTINCT c.ID, c.CUSTOMER_ID, c.CART_STATUS, 
                                    cp.CREATED_AT, cp.DELIVERY_BEGIN, cp.DELIVERY_END,
                                    a.FULLNAME, a.PHONE_NUMBER, a.DETAIL, a.PROVINCE, a.DISTRICT, a.VILLAGE, cp.PAYMENT_METHOD_ID, SUM(cd.QUANTITY * pr.PRICE) AS total_price
                                    FROM carts c
                                    JOIN cartdetails cd ON c.ID = cd.CART_ID
                                    JOIN products pr ON cd.PRODUCT_ID = pr.PRODUCT_ID
                                    JOIN customerpayments cp ON c.ID = cp.CART_ID
                                    JOIN address a ON cp.ADDRESS_ID = a.ADDRESS_ID
                                    GROUP BY c.ID
                                    ORDER BY total_price desc;";

                                    $result = $db->query($sql);

                                    $rows = array();

                                    while ($temp = $result->fetch_assoc()) {
                                        $rows[] = $temp;
                                    }

                                    $view_parent = "";

                                    foreach ($rows as $temp) {

                                        $qty = getQtyCart($db, $temp['ID']);


                                        $status_temp = getAllStatusOrder($db, $temp['CART_STATUS']);
                                        $total_cart = getTotalCart($db, $temp['ID']);
                                        $formatted_number = number_format($total_cart, 0, ',', '.') . " đ";
                                        $address_customer = $temp['DETAIL'] . ", " . explode("=", $temp['VILLAGE'])[1] . ", " . explode("=", $temp['DISTRICT'])[1] . ", " . explode("=", $temp['PROVINCE'])[1];
                                        $name_payment_method = getPaymentMethod($db, $temp['PAYMENT_METHOD_ID']);

                                        $view_parent .= "
                                        <tr>
                                            <td class='clickable'>{$temp['ID']}</td>
                                            <td>{$address_customer}</td>
                                            <td id='get_id_customer' data-qty='{$qty}' data-name='{$temp['FULLNAME']}' data-payment='{$name_payment_method}' data-address='{$address_customer}'>{$temp['PHONE_NUMBER']}</td>
                                            <td>{$formatted_number}</td>
                                            <td>{$temp['CREATED_AT']}</td>
                                            <td>{$temp['DELIVERY_BEGIN']} đến {$temp['DELIVERY_END']}</td>
                                            <td>
                                                <select name='trangthai' class='list_trangthai'>
                                                    {$status_temp}
                                                </select>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                    return $view_parent;
                                }

                                echo srotPriceDescShow($db);
                            }

                            if ($_GET['action'] === "sort_price_asc") {
                                function srotPriceAscShow($db)
                                {
                                    $sql = "SELECT DISTINCT c.ID, c.CUSTOMER_ID, c.CART_STATUS, 
                                    cp.CREATED_AT, cp.DELIVERY_BEGIN, cp.DELIVERY_END,
                                    a.FULLNAME, a.PHONE_NUMBER, a.DETAIL, a.PROVINCE, a.DISTRICT, a.VILLAGE, cp.PAYMENT_METHOD_ID, SUM(cd.QUANTITY * pr.PRICE) AS total_price
                                    FROM carts c
                                    JOIN cartdetails cd ON c.ID = cd.CART_ID
                                    JOIN products pr ON cd.PRODUCT_ID = pr.PRODUCT_ID
                                    JOIN customerpayments cp ON c.ID = cp.CART_ID
                                    JOIN address a ON cp.ADDRESS_ID = a.ADDRESS_ID
                                    GROUP BY c.ID
                                    ORDER BY total_price asc;";

                                    $result = $db->query($sql);

                                    $rows = array();

                                    while ($temp = $result->fetch_assoc()) {
                                        $rows[] = $temp;
                                    }

                                    $view_parent = "";

                                    foreach ($rows as $temp) {

                                        $qty = getQtyCart($db, $temp['ID']);


                                        $status_temp = getAllStatusOrder($db, $temp['CART_STATUS']);
                                        $total_cart = getTotalCart($db, $temp['ID']);
                                        $formatted_number = number_format($total_cart, 0, ',', '.') . " đ";
                                        $address_customer = $temp['DETAIL'] . ", " . explode("=", $temp['VILLAGE'])[1] . ", " . explode("=", $temp['DISTRICT'])[1] . ", " . explode("=", $temp['PROVINCE'])[1];
                                        $name_payment_method = getPaymentMethod($db, $temp['PAYMENT_METHOD_ID']);

                                        $view_parent .= "
                                        <tr>
                                            <td class='clickable'>{$temp['ID']}</td>
                                            <td>{$address_customer}</td>
                                            <td id='get_id_customer' data-qty='{$qty}' data-name='{$temp['FULLNAME']}' data-payment='{$name_payment_method}' data-address='{$address_customer}'>{$temp['PHONE_NUMBER']}</td>
                                            <td>{$formatted_number}</td>
                                            <td>{$temp['CREATED_AT']}</td>
                                            <td>{$temp['DELIVERY_BEGIN']} đến {$temp['DELIVERY_END']}</td>
                                            <td>
                                                <select name='trangthai' class='list_trangthai'>
                                                    {$status_temp}
                                                </select>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                    return $view_parent;
                                }

                                echo srotPriceAscShow($db);
                            }

                            if ($_GET['action'] === "search_date" && isset($_GET['date_begin']) && isset($_GET['date_end'])) {

                                function searchShow($db, $date_begin, $date_end)
                                {
                                    $sql = "SELECT DISTINCT c.ID, c.CUSTOMER_ID, c.CART_STATUS, 
                                    p.CREATED_AT, p.DELIVERY_BEGIN, p.DELIVERY_END,
                                    a.FULLNAME, a.PHONE_NUMBER, a.DETAIL, a.PROVINCE, a.DISTRICT, a.VILLAGE, p.PAYMENT_METHOD_ID
                                    FROM carts c
                                    JOIN customerpayments p ON c.ID = p.CART_ID
                                    JOIN address a ON p.ADDRESS_ID = a.ADDRESS_ID where (p.DELIVERY_BEGIN >= '$date_begin' and p.DELIVERY_BEGIN <= '$date_end') or 
                                    (p.DELIVERY_END >= '$date_begin' and p.DELIVERY_END <= '$date_end')";

                                    $result = $db->query($sql);

                                    $rows = array();

                                    while ($temp = $result->fetch_assoc()) {
                                        $rows[] = $temp;
                                    }

                                    $view_parent = "";

                                    foreach ($rows as $temp) {

                                        $qty = getQtyCart($db, $temp['ID']);


                                        $status_temp = getAllStatusOrder($db, $temp['CART_STATUS']);
                                        $total_cart = getTotalCart($db, $temp['ID']);
                                        $formatted_number = number_format($total_cart, 0, ',', '.') . " đ";
                                        $address_customer = $temp['DETAIL'] . ", " . explode("=", $temp['VILLAGE'])[1] . ", " . explode("=", $temp['DISTRICT'])[1] . ", " . explode("=", $temp['PROVINCE'])[1];
                                        $name_payment_method = getPaymentMethod($db, $temp['PAYMENT_METHOD_ID']);

                                        $view_parent .= "
                                        <tr>
                                            <td class='clickable'>{$temp['ID']}</td>
                                            <td>{$address_customer}</td>
                                            <td id='get_id_customer' data-qty='{$qty}' data-name='{$temp['FULLNAME']}' data-payment='{$name_payment_method}' data-address='{$address_customer}'>{$temp['PHONE_NUMBER']}</td>
                                            <td>{$formatted_number}</td>
                                            <td>{$temp['CREATED_AT']}</td>
                                            <td>{$temp['DELIVERY_BEGIN']} đến {$temp['DELIVERY_END']}</td>
                                            <td>
                                                <select name='trangthai' class='list_trangthai'>
                                                    {$status_temp}
                                                </select>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                    return $view_parent;
                                }

                                $date_begin = $_GET['date_begin'];
                                $date_end = $_GET['date_end'];

                                if (trim($date_begin) !== "" || trim($date_end) !== "") {
                                    echo searchShow($db, $date_begin, $date_end);
                                } else {
                                    echo showAllOrders($db);
                                }
                            }

                        } else {
                            echo showAllOrders($db);
                        }

                        ?>
                        <!-- <tr>
                            <td class="clickable">Ô 1-1</td>
                            <td>Ô 1-2</td>
                            <td>Ô 1-3</td>
                            <td>Ô 1-4</td>
                            <td>Ô 1-5</td>
                            <td>Ô 1-6</td>
                            <td>
                                <select name="trangthai" id="trangthai">
                                    <option value="">None</option>
                                    <option value="chuaxacnhan">Chưa Xác Nhân</option>
                                    <option value="daxacnhan">Đã Xác Nhận</option>
                                    <option value="danggiao">Đang Giao</option>
                                    <option value="dahuy">Đã Hủy</option>
                                </select>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>

            <div id="overlay">
                <div class="wrapper">
                    <div class="header">
                        <div class="header_top">
                            <h1>Chi tiết hóa đơn</h1><i id="button_close" class="fa-solid fa-x"></i>
                        </div>

                        <div class="wrapper_content">
                            <div class="wrapper_content_left">
                                <div class="infor_label id">
                                    <h2>Mã Khách Hàng: </h2>
                                    <div class="infor_content id">
                                        <span id="id_content"> </span>
                                    </div>
                                </div>
                                <div class="infor_label name">
                                    <h2>Họ và tên : </h2>
                                    <div class="infor_content name">
                                        <span id="name_content"> </span>
                                    </div>
                                </div>
                                <div class="infor_label sdt">
                                    <h2>Số điện thoại: </h2>
                                    <div class="infor_content sdt">
                                        <span id="num_content"> </span>
                                    </div>
                                </div>
                                <div class="infor_label address">
                                    <h2>Địa chỉ: </h2>
                                    <div class="infor_content address">
                                        <span id="address_content"> </span>
                                    </div>
                                </div>
                                <div class="infor_label order_date">
                                    <h2>Ngày đặt hàng: </h2>
                                    <div class="infor_content order_date">
                                        <span id="order_date_content"> </span>
                                    </div>
                                </div>
                                <div class="infor_label ship_date">
                                    <h2>Ngày giao hàng: </h2>
                                    <div class="infor_content ship_date">
                                        <span id="ship_date_content"> </span>
                                    </div>
                                </div>
                                <div class="infor_label payment_method">
                                    <h2>Phương thức thanh toán: </h2>
                                    <div class="infor_content payment_method">
                                        <span id="payment_method_content"> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wrapper_table">
                        <table id="orderTable">
                            <thead>
                                <tr>
                                    <th class="col-1">STT</th>
                                    <th class="col-2">Tên sản phẩm</th>
                                    <th class="col-3">Mã sản phẩm</th>
                                    <th class="col-4">Số lượng</th>
                                    <th class="col-5">Đơn giá (Đồng)</th>
                                    <th class="col-6">Thành tiền (Đồng)</th>
                                </tr>
                            </thead>
                            <tbody id="inner_show_oder_detail">
                                <tr>
                                    <td>1</td>
                                    <td>Giày thể thao Nike</td>
                                    <td>N001</td>
                                    <td>2</td>
                                    <td>1,500,000 </td>
                                    <td>3,000,000 </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="footer">
                        <div class="tong_tien">Tổng Thành Tiền : <span id="tong_tien">0</span></div>
                        <div class="tong_sl">Tổng Số Lượng : <span id="tong_so_luong">0</span> (Sản Phẩm)</div>
                    </div>
                </div>
            </div>



    </main>
</body>

</html>

<?php
ob_end_flush();

?>