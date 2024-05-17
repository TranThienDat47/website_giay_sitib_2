<?php
ob_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <?php include "./Layout/navbar.php"; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/DB_Oders.css">
    <script type="module" src="./js/DB_Report.js"></script>
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
            <div class="main-dashboard__custommer-header" style="display: flex;">
                <h2 class="main-dashboard__custommer-title" style="font-weight: 700;width:90%; font-size: 1.4rem; ">Danh
                    sách báo cáo thống kê hàng hóa</h2>
                <button id="add_report_btn" class="find-date-btn"
                    style="background-color: green; width: 10%; margin: 10px;">Thêm</button>
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

                    <div class="main-dashboard__custommer-handle-search" style="width:800px">
                        <label style="margin-left: 20px; width:300px;" id="cc" for="date">Ngày lập báo cáo</label>
                        <input style="margin-left: 20px;" type="date" id="date" name="date">
                    </div>

                    <button id="find_date_report" class="find-date-btn">Tìm ngày lập</button>
                    <button id="reset_date_report" class="find-date-btn">Thiết lập lại</button>
                </div>
            </div>

            <div class="hoadon">
                <table>
                    <thead>
                        <tr>
                            <th class="col-1" width="10%">Mã báo cáo <i class="fa-solid fa-sort"></i></th>
                            <th class="col-2" width="20%">Ngày tạo</th>
                            <th class="col-3" width="10%">Số lượng sản phẩm </th>
                            <th class="col-4" width="15%">Số lượng danh mục </th>
                            <th class=" col-5" width="15%">Được tạo bởi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        include_once "../../libs/session.php";
                        include_once "../config/database.php";

                        $db = new Database();

                        function showAllReport($db)
                        {
                            $sql = "SELECT * FROM reports;";

                            $result = $db->query($sql);

                            $rows = array();

                            while ($temp = $result->fetch_assoc()) {
                                $rows[] = $temp;
                            }

                            $view_parent = "";

                            foreach ($rows as $temp) {

                                $id = $temp['Report_ID'];

                                $date = $temp['create_at'];
                                $stock_prod = $temp['stock_prod'];
                                $stock_cat = $temp['stock_cat'];
                                $_name = $temp["report_by"];


                                $view_parent .= "
                                <tr>
                                    <td>{$id}</td>
                                    <td>{$date}</td>
                                    <td>{$stock_prod}</td>
                                    <td>{$stock_cat}</td>
                                    <td>{$_name}</td>
                                </tr>
                                ";
                            }
                            return $view_parent;
                        }

                        function countProducts($db)
                        {

                            $sql = "SELECT SUM(pd.QTY) AS total_quantity
                            FROM products p
                            JOIN productdetails pd ON p.PRODUCT_ID = pd.PRODUCT_ID;";

                            $result = $db->query($sql);
                            $count = $result->fetch_assoc();

                            return $count['total_quantity'];
                        }

                        function countCategories($db)
                        {

                            $sql = "SELECT COUNT(*) AS total_categories
                            FROM categories;";

                            $result = $db->query($sql);
                            $count = $result->fetch_assoc();

                            return $count['total_categories'];
                        }



                        if (isset($_GET['action'])) {
                            if ($_GET['action'] === "search_date" && isset($_GET['date'])) {

                                function searchShow($db, $date)
                                {
                                    $sql = "SELECT * FROM `reports` WHERE CREATE_AT LIKE '$date%'";


                                    $result = $db->query($sql);

                                    $rows = array();

                                    while ($temp = $result->fetch_assoc()) {
                                        $rows[] = $temp;
                                    }

                                    $view_parent = "";

                                    foreach ($rows as $temp) {

                                        $id = $temp['Report_ID'];

                                        $date = $temp['create_at'];
                                        $stock_prod = $temp['stock_prod'];
                                        $stock_cat = $temp['stock_cat'];
                                        $_name = $temp["report_by"];


                                        $view_parent .= "
                                        <tr>
                                            <td>{$id}</td>
                                            <td>{$date}</td>
                                            <td>{$stock_prod}</td>
                                            <td>{$stock_cat}</td>
                                            <td>{$_name}</td>
                                        </tr>
                                        ";
                                    }
                                    return $view_parent;
                                }

                                $date = $_GET['date'];

                                if (trim($date) !== "") {
                                    echo searchShow($db, $date);
                                } else {
                                    echo showAllOrders($db);
                                }
                            }

                            if ($_GET['action'] === "add-report") {

                                function addReport($db, $stock_prod, $stock_cat, $name)
                                {

                                    $query = "INSERT INTO `reports` (`Report_ID`, `create_at`, `stock_prod`, `stock_cat`, `report_by`) VALUES (NULL, current_timestamp(), $stock_prod, $stock_cat, '$name');";

                                    $result = $db->query($query);

                                    return $result;
                                }
                                if (addReport($db, countProducts($db), countCategories($db), $name)) {
                                    header("location: ./Db_Report.php");
                                }
                            }

                        } else {
                            echo showAllReport($db);
                        }



                        ?>

                    </tbody>
                </table>
            </div>

    </main>
</body>

</html>

<?php
ob_end_flush();

?>