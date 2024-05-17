<?php
ob_start();
session_start();
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu nhập</title>
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <?php include "./Layout/navbar.php"; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/DB_Purchases.css">
    <script type="module" src="./js/DB_Purchases.js"></script>
    <link rel="stylesheet" href="./css/header_db.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <!-- Header -->
    <?php echo $header; ?>

    <!-- Main -->
    <main id="main">
        <div class="main-dashboard__custommer">
            <div class="main-dashboard__custommer-header">
                <h2 class="main-dashboard__custommer-title">Danh sách phiếu nhập hàng</h2>
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
                    <div class="main-dashboard__custommer-handle-search">
                        <input type="text" id="main_search" placeholder="Tìm kiếm theo mã" />
                    </div>


                </div>
            </div>
            <div class="phieunhap">
                <table>
                    <thead>
                        <tr>
                            <th class="col-1" width="10%">Mã Phiếu Nhập <i style="cursor: pointer;"
                                    class="fa-solid fa-sort"></i></th>
                            <th class="col-2" width="20%">Mã nhà Cung Cấp</th>
                            <th class="col-2" width="20%">Mã người nhập</th>
                            <th class="col-3" width="10%">Số Lượng</th>
                            <th class="col-4" width="15%">Tổng Tiền <i style="cursor: pointer;"
                                    class="fa-solid fa-sort"></i></th>
                            <th class="col-5" width="15%">Ngày Nhập</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        include_once "../../libs/session.php";
                        include_once "../config/database.php";

                        $db = new Database();



                        function showPurchase($db)
                        {
                            $sql = "SELECT DISTINCT p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID, 
                            SUM(pd.QUANTITY) AS total_qty,
                            SUM(pd.PURCHASE_PRICE * pd.QUANTITY) AS total_price
                     FROM purchase p
                     INNER JOIN purchasedetails pd ON p.PURCHASE_ID = pd.PURCHASE_ID
                     GROUP BY p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID;";


                            $result = $db->query($sql);

                            $rows = array();

                            while ($temp = $result->fetch_assoc()) {
                                $rows[] = $temp;
                            }

                            $view_parent = "";

                            foreach ($rows as $temp) {
                                $view_parent .= "
                                    <tr>
                                        <td class='clickable'>{$temp['PURCHASE_ID']}</td>
                                        <td>{$temp['SUPPLIER_ID']}</td>
                                        <td>{$temp['USER_ID']}</td>
                                        <td>{$temp['total_qty']}</td>
                                        <td>{$temp['total_price']}</td>
                                        <td>{$temp['PURCHASE_DATE']}</td>
                                    </tr>
                                ";
                            }
                            return $view_parent;
                        }


                        if (isset($_GET['action'])) {

                            $action = $_GET['action'];

                            function searchShow($db, $value_search)
                            {
                                $sql = "SELECT DISTINCT p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID, 
                            SUM(pd.QUANTITY) AS total_qty,
                            SUM(pd.PURCHASE_PRICE * pd.QUANTITY) AS total_price
                     FROM purchase p
                     INNER JOIN purchasedetails pd ON p.PURCHASE_ID = pd.PURCHASE_ID
                     where p.PURCHASE_ID = $value_search
                     GROUP BY p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID;";


                                $result = $db->query($sql);

                                $rows = array();

                                while ($temp = $result->fetch_assoc()) {
                                    $rows[] = $temp;
                                }

                                $view_parent = "";

                                foreach ($rows as $temp) {
                                    $view_parent .= "
                                    <tr>
                                        <td class='clickable'>{$temp['PURCHASE_ID']}</td>
                                        <td>{$temp['SUPPLIER_ID']}</td>
                                        <td>{$temp['USER_ID']}</td>
                                        <td>{$temp['total_qty']}</td>
                                        <td>{$temp['total_price']}</td>
                                        <td>{$temp['PURCHASE_DATE']}</td>
                                    </tr>
                                ";
                                }
                                return $view_parent;
                            }

                            function sortIDDescShow($db)
                            {
                                $sql = "SELECT DISTINCT p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID, 
                                SUM(pd.QUANTITY) AS total_qty,
                                SUM(pd.PURCHASE_PRICE * pd.QUANTITY) AS total_price
                         FROM purchase p
                         INNER JOIN purchasedetails pd ON p.PURCHASE_ID = pd.PURCHASE_ID
                         GROUP BY p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID
                         ORDER BY p.PURCHASE_ID DESC ;";


                                $result = $db->query($sql);

                                $rows = array();

                                while ($temp = $result->fetch_assoc()) {
                                    $rows[] = $temp;
                                }

                                $view_parent = "";

                                foreach ($rows as $temp) {
                                    $view_parent .= "
                                    <tr>
                                        <td class='clickable'>{$temp['PURCHASE_ID']}</td>
                                        <td>{$temp['SUPPLIER_ID']}</td>
                                        <td>{$temp['USER_ID']}</td>
                                        <td>{$temp['total_qty']}</td>
                                        <td>{$temp['total_price']}</td>
                                        <td>{$temp['PURCHASE_DATE']}</td>
                                    </tr>
                                ";
                                }
                                return $view_parent;
                            }

                            function sortIDAscShow($db)
                            {
                                $sql = "SELECT DISTINCT p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID, 
                                SUM(pd.QUANTITY) AS total_qty,
                                SUM(pd.PURCHASE_PRICE * pd.QUANTITY) AS total_price
                         FROM purchase p
                         INNER JOIN purchasedetails pd ON p.PURCHASE_ID = pd.PURCHASE_ID
                         GROUP BY p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID
                         ORDER BY p.PURCHASE_ID ASC;";


                                $result = $db->query($sql);

                                $rows = array();

                                while ($temp = $result->fetch_assoc()) {
                                    $rows[] = $temp;
                                }

                                $view_parent = "";

                                foreach ($rows as $temp) {
                                    $view_parent .= "
                                    <tr>
                                        <td class='clickable'>{$temp['PURCHASE_ID']}</td>
                                        <td>{$temp['SUPPLIER_ID']}</td>
                                        <td>{$temp['USER_ID']}</td>
                                        <td>{$temp['total_qty']}</td>
                                        <td>{$temp['total_price']}</td>
                                        <td>{$temp['PURCHASE_DATE']}</td>
                                    </tr>
                                ";
                                }
                                return $view_parent;
                            }

                            function sortPriceDescShow($db)
                            {
                                $sql = "SELECT DISTINCT p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID, 
                                SUM(pd.QUANTITY) AS total_qty,
                                SUM(pd.PURCHASE_PRICE * pd.QUANTITY) AS total_price
                         FROM purchase p
                         INNER JOIN purchasedetails pd ON p.PURCHASE_ID = pd.PURCHASE_ID
                         GROUP BY p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID
                         ORDER BY total_price DESC;";


                                $result = $db->query($sql);

                                $rows = array();

                                while ($temp = $result->fetch_assoc()) {
                                    $rows[] = $temp;
                                }

                                $view_parent = "";

                                foreach ($rows as $temp) {
                                    $view_parent .= "
                                    <tr>
                                        <td class='clickable'>{$temp['PURCHASE_ID']}</td>
                                        <td>{$temp['SUPPLIER_ID']}</td>
                                        <td>{$temp['USER_ID']}</td>
                                        <td>{$temp['total_qty']}</td>
                                        <td>{$temp['total_price']}</td>
                                        <td>{$temp['PURCHASE_DATE']}</td>
                                    </tr>
                                ";
                                }
                                return $view_parent;
                            }

                            function sortPriceAscShow($db)
                            {
                                $sql = "SELECT DISTINCT p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID, 
                                SUM(pd.QUANTITY) AS total_qty,
                                SUM(pd.PURCHASE_PRICE * pd.QUANTITY) AS total_price
                         FROM purchase p
                         INNER JOIN purchasedetails pd ON p.PURCHASE_ID = pd.PURCHASE_ID
                         GROUP BY p.PURCHASE_ID, p.SUPPLIER_ID, p.PURCHASE_DATE, p.USER_ID
                         ORDER BY total_price ASC;";


                                $result = $db->query($sql);

                                $rows = array();

                                while ($temp = $result->fetch_assoc()) {
                                    $rows[] = $temp;
                                }

                                $view_parent = "";

                                foreach ($rows as $temp) {
                                    $view_parent .= "
                                    <tr>
                                        <td class='clickable'>{$temp['PURCHASE_ID']}</td>
                                        <td>{$temp['SUPPLIER_ID']}</td>
                                        <td>{$temp['USER_ID']}</td>
                                        <td>{$temp['total_qty']}</td>
                                        <td>{$temp['total_price']}</td>
                                        <td>{$temp['PURCHASE_DATE']}</td>
                                    </tr>
                                ";
                                }
                                return $view_parent;
                            }

                            if (isset($_GET['value_search'])) {
                                $value_search = $_GET['value_search'];

                                if ($action === "search_purchase") {
                                    if (!empty(trim($value_search))) {
                                        if (is_numeric($value_search)) {
                                            echo searchShow($db, $value_search);
                                        } else {
                                            echo searchShow($db, -1);
                                        }
                                    } else {
                                        header("Location: ./DB_Purchases.php");
                                        exit();
                                    }
                                }
                            } else if ($action === "sort_id_desc") {
                                echo sortIDDescShow($db);
                            } else if ($action === "sort_id_asc") {
                                echo sortIDAscShow($db);
                            } else if ($action === "sort_price_desc") {
                                echo sortPriceDescShow($db);
                            } else if ($action === "sort_price_asc") {
                                echo sortPriceAscShow($db);
                            } else {
                                header("Location: ./DB_Purchases.php");
                                exit();
                            }
                        } else {
                            echo showPurchase($db);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div id="overlay">
                <div class="wrapper">
                    <div class="header">

                        <div class="header_top">
                            <h1>Chi tiết phiếu nhập</h1><i id="button_close" class="fa-solid fa-x"></i>
                        </div>
                        <div class="infor_cus id">
                            <h2>Mã Phiếu Nhập: </h2> <span id="id_cus"> 2k2 </span>
                        </div>
                        <div class="infor_cus name">
                            <h2>Mã nhà Cung Cấp: </h2> <span id="name_cus"> Khoa Đẹp Trai </span>
                        </div>
                        <div class="infor_cus name">
                            <h2>Mã người nhập: </h2> <span id="name_user"> Khoa Đẹp Trai </span>
                        </div>
                        <div class="infor_cus import_date">
                            <h2>Ngày Nhập: </h2> <span id="num_cus"> 3/1/1975 </span>
                        </div>
                    </div>

                    <div class="wrapper_table">
                        <table id="orderTable">
                            <thead>
                                <tr>
                                    <th class="col-1" width="10%">STT</th>
                                    <th class="col-3" width="10%">Mã sản phẩm</th>
                                    <th class="col-2" width="20%">Tên sản phẩm</th>
                                    <th class="col-3" width="10%">Màu</th>
                                    <th class="col-4" width="10%">Size</th>
                                    <th class="col-5" width="10%">Số lượng</th>
                                    <th class="col-6" width="20%">Giá nhập (Đồng)</th>
                                    <th class="col-7" width="20%">Giá bán (Đồng)</th>
                                </tr>
                            </thead>
                            <tbody id="inner_show_purchase_detail">
                                <tr>
                                    <td>1</td>
                                    <td>N001</td>
                                    <td>Giày thể thao Nike</td>
                                    <td>Đỏ</td>
                                    <td>2</td>
                                    <td>2</td>
                                    <td>1,500,000 </td>
                                    <td>3,000,000 </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>A002</td>
                                    <td>Giày bóng đá Adidas</td>
                                    <td>Đỏ</td>
                                    <td>3</td>
                                    <td>3</td>
                                    <td>1,200,000 </td>
                                    <td>3,600,000 </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="footer">
                        <div class="total tong_sl">Tổng Số Lượng: <span>696</span></div>
                        <div class="total tong_gia_nhap">Tổng Giá Nhập: <span>666.666.666</span> đồng</div>
                        <div class="total tong_gia_ban">Tổng Giá Bán: <span>666.666.666</span> đồng</div>
                    </div>
                </div>
            </div>
        </div>

        <div id="overlay2">
            <div class="wrapper" style="position: relative;">
                <div class="header">
                    <div class="header_top">
                        <h1>PHIẾU NHẬP HÀNG</h1><i id="button_close2" class="fa-solid fa-x"></i>
                    </div>
                    <div class="infor_cus name">
                        <h2>Nhà Cung Cấp: </h2>
                        <select id="name_stocker">
                            <option value='none'>Chọn nhà cung cấp</option>
                            <?php


                            function showSupplier($db)
                            {
                                $sql = "SELECT * FROM `supplier` WHERE ISACTIVE = 1";

                                $result = $db->query($sql);

                                $rows = array();

                                while ($temp = $result->fetch_assoc()) {
                                    $rows[] = $temp;
                                }

                                $view_parent = "";

                                foreach ($rows as $temp) {
                                    $view_parent .= "<option value='{$temp['SUPLIER_ID']}'>{$temp['SUPLIER_ID']} - {$temp['NAME']}</option>";
                                }
                                return $view_parent;
                            }
                            echo showSupplier($db);
                            ?>
                        </select>
                    </div>
                    <div class="infor_cus import_date">
                        <h2>Nhân Viên: </h2> <span id="num_staff">
                            <?php
                            include_once "../../libs/session.php";
                            if (Session::get("admin_login")) {
                                echo Session::get("admin_id") . " - " . Session::get("admin_fullName");
                            } else if (Session::get("staff_login")) {
                                echo Session::get("staff_id") . " - " . Session::get("staff_fullName");

                            }

                            ?>
                        </span>
                    </div>
                    <div class="infor_cus telephone">
                        <h2>Ngày Nhập: </h2> <span id="day_purchase">
                            <?php
                            date_default_timezone_set('Asia/Ho_Chi_Minh'); // Thiết lập múi giờ thành giờ Việt Nam
                            $date = date('Y-m-d H:i:s'); // Lấy ngày tháng năm và giờ hiện tại dưới định dạng yyyy-mm-dd hh:mm:ss
                            echo $date; // In ra ngày tháng năm và giờ hiện tại
                            ?>
                        </span>
                    </div>
                </div>
                <div class="warpper_tile_button">
                    <h1>Danh sách sản phẩm nhập hàng</h1>
                    <button id="btn_chon_sp">Chọn sản phẩm</button>
                </div>
                <div class="wrapper_table">
                    <table id="orderTable">
                        <thead>
                            <tr>
                                <th class="col-1" width="5%">STT</th>
                                <th class="col-3" width="10%">Mã sản phẩm</th>
                                <th class="col-2" width="20%">Tên sản phẩm</th>
                                <th class="col-3" width="10%">Màu</th>
                                <th class="col-4" width="10%">Size</th>
                                <th class="col-5" width="15%">Số lượng cần nhập</th>
                                <th class="col-6" width="20%">Giá nhập (Đồng)</th>
                                <th class="col-7" width="20%">Giá bán (Đồng)</th>
                            </tr>
                        </thead>
                        <tbody id="inner_purchase_detail">
                            <!-- <tr>
                                <td>1</td>
                                <td>N001</td>
                                <td>Giày thể thao Nike</td>
                                <td>Đỏ</td>
                                <td>2</td>
                                <td>2</td>
                                <td>1,500,000 </td>
                                <td>3,000,000 </td>
                            </tr> -->

                        </tbody>
                    </table>
                </div>
                <button id="btn_save_purchase" style=" background-color: #fff;position: absolute; right: 16px; bottom: 32px;border: 2px solid
                            blue; border-radius: 4px; color: blue; padding: 2px 6px;" type="button">Lưu phiếu
                    nhập</button>

            </div>
        </div>

        <div id="overlay3">
            <div class="wrapper">
                <div class="header">
                    <div class="header_top">
                        <h1>DANH DÁCH SẢN PHẨM KHO</h1><i id="button_close3" class="fa-solid fa-x"></i>
                    </div>
                    <div class="search">
                        <input id="search_name_pd" type=" text" placeholder="Tìm theo mã">
                    </div>

                </div>

                <div class="wrapper_table">
                    <table id="orderTable">
                        <thead>
                            <tr>
                                <th class="col-1" width="10%">Chọn</th>
                                <th class="col-3" width="10%">Mã sản phẩm</th>
                                <th class="col-2" width="20%">Tên sản phẩm</th>
                                <th class="col-3" width="10%">Màu</th>
                                <th class="col-4" width="10%">Size</th>
                                <th class="col-5" width="10%">Số lượng cần nhập</th>
                                <th class="col-6" width="20%">Giá nhập (Đồng)</th>
                                <th class="col-7" width="20%">Giá bán (Đồng)</th>
                            </tr>
                        </thead>
                        <tbody id="inner_select_detail">

                            <!-- <tr>
                                <td><input class="cb_choose_pd" type="checkbox"></td>
                                <td>N001</td>
                                <td>Giày thể thao Nike</td>
                                <td>Đỏ</td>
                                <td>2</td>
                                <td></td>
                                <td> </td>
                                <td>3,000,000 </td>
                            </tr>
                            <tr>
                                <td><input class="cb_choose_pd" type="checkbox"></td>
                                <td>N001</td>
                                <td>Giày thể thao Nike</td>
                                <td>Đỏ</td>
                                <td>2</td>
                                <td></td>
                                <td> </td>
                                <td>3,000,000 </td>
                            </tr>
                            <tr>
                                <td><input class="cb_choose_pd" type="checkbox"></td>
                                <td>N001</td>
                                <td>Giày thể thao Nike</td>
                                <td>Đỏ</td>
                                <td>2</td>
                                <td></td>
                                <td> </td>
                                <td>3,000,000 </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="fixed-icon">
            <i class="fa-solid fa-circle-plus" id="button_add_form_purchase" style="color: #005eff;"></i>
        </div>
    </main>

</body>

</html>