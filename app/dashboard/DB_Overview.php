<?php
ob_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <?php include "./Layout/navbar.php"; ?>
    <link rel="stylesheet" href="./css/header_db.css">
    <link rel="stylesheet" href="./css/base.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./css/DB_Overview.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="./assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="./assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
</head>

<body>
    <!-- Header -->
    <?php echo $header; ?>

    <?php
    include_once "../config/database.php";
    include_once "../../libs/session.php";

    $db = new Database();


    function countProducts($db)
    {

        $sql = "SELECT SUM(pd.QTY) AS total_quantity
        FROM products p
        JOIN productdetails pd ON p.PRODUCT_ID = pd.PRODUCT_ID;";

        $result = $db->query($sql);
        $count = $result->fetch_assoc();

        echo $count['total_quantity'];
    }

    function countCustomers($db)
    {

        $sql = "SELECT COUNT(*) AS total_customers
        FROM customers;";

        $result = $db->query($sql);
        $count = $result->fetch_assoc();

        echo $count['total_customers'];
    }

    function countOrders($db)
    {

        $sql = "SELECT COUNT(*) AS total_orders
        FROM carts
        WHERE CART_STATUS != 'Chờ mua hàng';";

        $result = $db->query($sql);
        $count = $result->fetch_assoc();

        echo $count['total_orders'];
    }

    function countCategories($db)
    {

        $sql = "SELECT COUNT(*) AS total_categories
        FROM categories;";

        $result = $db->query($sql);
        $count = $result->fetch_assoc();

        echo $count['total_categories'];
    }

    function countStaff($db)
    {

        $sql = "SELECT COUNT(*) AS total_current_staffs
        FROM staffs
        WHERE ISACTIVE != 0;";

        $result = $db->query($sql);
        $count = $result->fetch_assoc();

        echo $count['total_current_staffs'];
    }

    function count30Day($db)
    {

        $sql = "SELECT COUNT(DISTINCT cp.CART_ID) AS total_orders
        FROM carts c
        JOIN customerpayments cp ON c.ID = cp.CART_ID
        WHERE c.CART_STATUS != 'Chờ mua hàng' AND cp.CREATED_AT >= DATE_SUB(NOW(), INTERVAL 30 DAY);";

        $result = $db->query($sql);
        $count = $result->fetch_assoc();

        echo $count['total_orders'];
    }

    function count30DaySuccess($db)
    {

        $sql = "SELECT COUNT(DISTINCT cp.CART_ID) AS total_orders
        FROM carts c
        JOIN customerpayments cp ON c.ID = cp.CART_ID
        WHERE c.CART_STATUS = 'Đã hoàn thành' AND cp.CREATED_AT >= DATE_SUB(NOW(), INTERVAL 30 DAY);";

        $result = $db->query($sql);
        $count = $result->fetch_assoc();

        echo $count['total_orders'];
    }

    function count30DayCancle($db)
    {

        $sql = "SELECT COUNT(DISTINCT cp.CART_ID) AS total_orders
        FROM carts c
        JOIN customerpayments cp ON c.ID = cp.CART_ID
        WHERE c.CART_STATUS = 'Đã hủy' AND cp.CREATED_AT >= DATE_SUB(NOW(), INTERVAL 30 DAY);";

        $result = $db->query($sql);
        $count = $result->fetch_assoc();

        echo $count['total_orders'];
    }

    function countTodayNew($db)
    {

        $sql = "SELECT COUNT(DISTINCT cp.CART_ID) AS total_orders
        FROM carts c
        JOIN customerpayments cp ON c.ID = cp.CART_ID
        WHERE c.CART_STATUS != 'Chờ mua hàng' AND DATE(cp.CREATED_AT) = CURDATE();";

        $result = $db->query($sql);
        $count = $result->fetch_assoc();

        echo $count['total_orders'];
    }

    function countTodayConfirm($db)
    {

        $sql = "SELECT COUNT(DISTINCT cp.CART_ID) AS total_orders
        FROM carts c
        JOIN customerpayments cp ON c.ID = cp.CART_ID
        WHERE c.CART_STATUS = 'Chờ xác nhận' AND DATE(cp.CREATED_AT) = CURDATE();";

        $result = $db->query($sql);
        $count = $result->fetch_assoc();

        echo $count['total_orders'];
    }

    function countTodayCancle($db)
    {

        $sql = "SELECT COUNT(DISTINCT cp.CART_ID) AS total_orders
        FROM carts c
        JOIN customerpayments cp ON c.ID = cp.CART_ID
        WHERE c.CART_STATUS = 'Đã hủy' AND DATE(cp.CREATED_AT) = CURDATE();";

        $result = $db->query($sql);
        $count = $result->fetch_assoc();

        echo $count['total_orders'];
    }

    function renderListSelling($db)
    {

        $sql = "SELECT p.PRODUCT_ID, p.NAME, p.PRICE, SUM(cd.QUANTITY) AS total_quantity
        FROM carts c
        JOIN customerpayments cp ON c.ID = cp.CART_ID
        JOIN cartdetails cd ON c.ID = cd.CART_ID
        JOIN products p ON cd.PRODUCT_ID = p.PRODUCT_ID
        WHERE c.CART_STATUS = 'Đã hoàn thành'
        GROUP BY p.PRODUCT_ID, p.NAME
        ORDER BY total_quantity DESC
        LIMIT 5;";

        $result = $db->query($sql);

        $rows = array();

        while ($temp = $result->fetch_assoc()) {
            $rows[] = $temp;
        }

        $view_parent = "";

        foreach ($rows as $temp) {
            $name = '(' . $temp['PRODUCT_ID'] . ') ' . $temp['NAME'];
            $count = $temp['total_quantity'];
            $price = number_format($temp['PRICE'], 0, '.', ',');
            $view_parent .= "
                    <tr class='main__trending-item'>
                        <td class='main__trending-item-proc'>
                            <div class='main__trending-item-inf'>
                                <h4 class='main__trending-item-title'>
                                $name
                                </h4>
                                <p class='main__trending-item-price'>$price ₫</p>
                            </div>
                        </td>
                        <td class='main__trending-item-qty'>
                            <p>$count</p>
                        </td>
                    </tr>
                    ";
        }

        echo $view_parent;
    }
    ?>

    <!-- Main -->
    <main id="main">

        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">

                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h1 class="pageheader-title">BẢNG ĐIỀU KHIỂN</h1>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->

                <div class="ecommerce-widget">
                    <div class="main__card-controls">
                        <div class="main__card-item main__card-item-product">
                            <h3 class="main__card-title">Sản phẩm</h3>
                            <h1>
                                <?php countProducts($db); ?>
                            </h1>
                            <div class="main__card-more">
                                <a href="./DB_Product.php">
                                    <span>Xem chi tiết</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="main__card-item main__card-item-custommer">
                            <h3 class="main__card-title">Khách hàng</h3>
                            <h1>
                                <?php countCustomers($db); ?>
                            </h1>
                            <div class="main__card-more">
                                <a href="./DB_User.php">
                                    <span>Xem chi tiết</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="main__card-item main__card-item-order">
                            <h3 class="main__card-title">Đơn hàng</h3>
                            <h1>
                                <?php countOrders($db); ?>
                            </h1>
                            <div class="main__card-more">
                                <a href="./DB_Oders.php">
                                    <span>Xem chi tiết</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="main__card-item main__card-item-menu">
                            <h3 class="main__card-title">Danh mục</h3>
                            <h1>
                                <?php countCategories($db); ?>
                            </h1>
                            <div class="main__card-more">
                                <a href="./DB_Catelory.php">
                                    <span>Xem chi tiết</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>

                <!-- Main -->

                <!-- Row 1 -->
                <div class="row">

                    <!-- ============================================================== -->
                    <!-- analysis data  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">

                            <h5 class="card-header " style="font-size: 20px; font-weight: 500; color:blueviolet;"> Số liệu phân tích về
                                cửa hàng (30 ngày qua)</h5>
                            <div class="card-body p-0">
                                <ul class="traffic-sales list-group list-group-flush">
                                    <li class="traffic-sales-content list-group-item "
                                        style=" margin-left: 10px "><span
                                            class="traffic-sales-name">Số nhân viên hiện tại:</span><span
                                            class="traffic-sales-amount"> <?php countStaff($db); ?>
                                            <!-- <span
                                                class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i
                                                    class="fa fa-fw fa-arrow-up"></i></span><span
                                                class="ml-1 text-success">1</span></span> -->
                                    </li>
                                </ul>
                            </div>

                            <h5 class="card-header"
                                style="border-top: 1px solid #e5e7eb; font-size: 20px; font-weight: 500; color:blueviolet; "> Tóm tắt cửa
                                hàng (30 ngày qua) </h5>
                            <div class="card-body p-0">
                                <ul class="traffic-sales list-group list-group-flush">
                                    <li class="traffic-sales-content list-group-item"
                                        style=" margin-left: 10px ">
                                        <span class="traffic-sales-name">Đơn hàng được đặt:
                                            <span class="traffic-sales-amount"><?php count30Day($db); ?> 
                                                <!-- <span class="icon-circle-small icon-box-xs text-danger ml-4 bg-danger-light">
                                                    <i class="fa fa-fw fa-arrow-down"></i>
                                                </span>
                                                <span class="ml-1 text-danger">4</span> -->
                                            </span>
                                        </span>
                                    </li>
                                </ul>
                                <ul class="traffic-sales list-group list-group-flush">
                                    <li class="traffic-sales-content list-group-item"
                                        style=" margin-left: 10px "><span
                                            class="traffic-sales-name">Đơn hàng đã thành công:<span
                                                class="traffic-sales-amount"><?php count30DaySuccess($db); ?>
                                                <!-- <span
                                                    class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i
                                                        class="fa fa-fw fa-arrow-up"></i></span><span
                                                    class="ml-1 text-success">0</span>
                                                </span> -->
                                        </span>
                                    </li>
                                </ul>
                                <ul class="traffic-sales list-group list-group-flush">
                                    <li class="traffic-sales-content list-group-item"
                                        style=" margin-left: 10px "><span
                                            class="traffic-sales-name">Đơn hàng bị hủy:<span
                                                class="traffic-sales-amount"><?php count30DayCancle($db); ?>
                                                <!-- <span
                                                    class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i
                                                        class="fa fa-fw fa-arrow-up"></i></span><span
                                                    class="ml-1 text-success">1</span>
                                                </span> -->
                                        </span>
                                    </li>
                                </ul>
                            </div>

                            <h5 class="card-header"
                                style="border-top: 1px solid #e5e7eb; font-size: 20px; font-weight: 500; color:blueviolet;"> Hôm nay </h5>
                            <div class="card-body p-0">
                                <ul class="traffic-sales list-group list-group-flush">
                                    <li class="traffic-sales-content list-group-item"
                                        style=" margin-left: 10px "><span
                                            class="traffic-sales-name">Đơn hàng mới:<span
                                                class="traffic-sales-amount"><?php countTodayNew($db); ?>
                                                <!-- <span class="icon-circle-small icon-box-xs text-danger ml-4 bg-danger-light"><i class="fa fa-fw fa-arrow-down"></i></span><span class="ml-1 text-danger">0</span> -->
                                            </span></span>
                                    </li>
                                </ul>
                                <ul class="traffic-sales list-group list-group-flush">
                                    <li class="traffic-sales-content list-group-item"
                                        style="margin-left: 10px "><span
                                            class="traffic-sales-name">Đơn hàng chờ xác nhận:<span
                                                class="traffic-sales-amount"><?php countTodayConfirm($db); ?>
                                                <!-- <span class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1 text-success">0</span> -->
                                            </span></span>
                                    </li>
                                </ul>
                                <ul class="traffic-sales list-group list-group-flush">
                                    <li class="traffic-sales-content list-group-item"
                                        style=" margin-left: 10px "><span
                                            class="traffic-sales-name">Đơn hàng bị hủy:<span
                                                class="traffic-sales-amount"><?php countTodayCancle($db); ?>
                                                <!-- <span class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1 text-success">0</span> -->
                                            </span></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end analysis data  -->
                    <!-- ============================================================== -->



                    <!-- ============================================================== -->
                    <!-- Product chart -->
                    <!-- ============================================================== -->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                        <h5 class="card-header"
                                style="border-top: 1px solid #e5e7eb; font-size: 20px; font-weight: 500; color:blueviolet;">Sản phẩm bán chạy</h5>
                                <div class="card-body p-0">
                                <table class="main__trending-table">
                                    <tr>
                                        <th style="width: 75%; padding-left:30px;">Sản phẩm</th>
                                        <th>Số lượng đã bán</th>
                                    </tr>
                                    <tbody class="main__trending-item-wrapper">
                                        <?php renderListSelling($db) ?>
                                    </tbody>
                                </table>
                            </div>    
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!--end Product chart  -->
                    <!-- ============================================================== -->

                </div>
                <!-- End row 1 -->

                <!-- Row 2 -->
                <div class="row">

                    <!-- ============================================================== -->
                    <!-- recent orders  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header" style="font-size: 20px; font-weight: 500; color:blueviolet;">Đơn hàng chờ xác nhận</h5>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
                                            <tr class="border-0">
                                                <th class="border-0">Mã HĐ</th>
                                                <th class="border-0">Địa chỉ</th>
                                                <th class="border-0">SĐT</th>
                                                <th class="border-0">Tổng tiền</th>
                                                <th class="border-0">Ngày đặt</th>
                                                <th class="border-0">Ngày giao</th>
                                                <th class="border-0">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
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
                                                JOIN address a ON p.ADDRESS_ID = a.ADDRESS_ID
                                                WHERE c.CART_STATUS LIKE 'Chờ xác nhận'";
                    
                                                $result = $db->query($sql);
                    
                                                $rows = array();
                    
                                                while ($temp = $result->fetch_assoc()) {
                                                    $rows[] = $temp;
                                                }
                    
                                                $view_parent = "";
                    
                                                foreach ($rows as $temp) {
                    
                                                    $qty = getQtyCart($db, $temp['ID']);
            
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
                                                        <td>{$temp["CART_STATUS"]}</td>
                                                    </tr>
                                                    ";
                                                }
                                                return $view_parent;
                                            }
                                            echo showAllOrders($db);
                                            ?>
                                                    <tr>
                                                        <td colspan="7">
                                                            <a href="./DB_Oders.php" class="btn btn-outline-light float-right" style="background-color: aqua; color:black">Details</a>
                                                        </td>
                                                    </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end recent orders  -->
                    <!-- ============================================================== -->

                </div>
                <!-- End Row 2 -->

            </div>
            <!-- End Main -->
        </div>
        </div>
    </main>

    <script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="./assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="./assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="./assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="./assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="./assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="./assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="./assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="./assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="./assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="./assets/libs/js/dashboard-ecommerce.js"></script>

    <script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="./assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="./assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="./assets/vendor/charts/morris-bundle/morris.js"></script>
    <script src="./assets/vendor/charts/morris-bundle/Morrisjs.js"></script>
    <script src="./assets/libs/js/main-js.js"></script>


</body>

</html>

<?php
ob_end_flush();

?>