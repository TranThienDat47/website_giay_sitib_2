<!DOCTYPE html>
<html lang="en">

<?php 
include_once "../config/database.php";
$db = new Database();

$sql = "SELECT c.CUSTOMER_ID, c.EMAIL, c.PASSWORD, c.GENDER, c.FIRSTNAME, c.LASTNAME, c.ISACTIVE, a.ADDRESS_ID, a.FULLNAME, a.IS_DEFAULT, a.PHONE_NUMBER, a.DETAIL, a.PROVINCE, a.DISTRICT, a.VILLAGE
FROM customers c
JOIN address a ON c.CUSTOMER_ID = a.CUSTOMER_ID WHERE IS_DEFAULT=1";

$result = $db->query(($sql));

$rows = array();

while ($row = $result->fetch_array()) {
    $rows[] = $row;
} 

//----------------kiem tra co goi action "updatetrangthai" -------------
if (isset($_GET['action']) && $_GET['action'] == "update_trangthai") {
    $makh = intval($_GET['user_id']);
    $newActive = $_GET['value'];
    echo $makh, $newActive;
    $sql_update_isactive = "UPDATE customers SET ISACTIVE=$newActive  WHERE CUSTOMER_ID=$makh";

    $db->query(($sql_update_isactive));

    header("Location: ./DB_User.php");
    exit();
}


?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khách hàng</title>
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <?php include "./Layout/navbar.php"; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/DB_User.css">
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
                <h2 class="main-dashboard__custommer-title">Danh sách khách hàng</h2>
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
                        <input id="input_find_name" type="text" placeholder="Tìm kiếm theo tên" />
                    </div>

                    <div class="main-dashboard__custommer-handle-search">
                        <input id="input_find_phone" type="text" placeholder="Tìm kiếm theo số điện thoại" />
                    </div>
                </div>
            </div>




            <table id="table_user">
                <thead>
                    <tr>
                        <th class="col-0" width="10%">Mã khách hàng</th>
                        <th class="col-1" width="10%">Khách Hàng <i class="fa-solid fa-sort" id="btn_sort_name"></i>
                        </th>
                        <th class="col-2" width="15%">Email</th>
                        <th class="col-3" width="10%">Số Điện Thoại</th>
                        <th class="col-4" width="10%">Giới Tính <i class="fa-solid fa-sort" id="btn_sort_gender"></i>
                        </th>
                        <th class=" col-5" width="40%">Địa chỉ</th>
                        <th class="col-6" width="10%">Trạng Thái <i class="fa-solid fa-sort" id="btn_sort_active"></i>
                        </th>
                    </tr>
                </thead>
                <tbody id="bodylistCustomer">
                    <?php 
                        $makh;
                        $name;
                        $email;
                        $gender;
                        $address;
                        $phonenum;
                    
                        for ($i = 0; $i < count($rows); $i++) {
                            $hoatdong = "";
                            $khonghoatdong = "";
                            $makh = $rows[$i]["CUSTOMER_ID"];
                            $name = $rows[$i]["FIRSTNAME"]." ".$rows[$i]["LASTNAME"];
                            $email = $rows[$i]["EMAIL"];
                            $gender = $rows[$i]["GENDER"];
                            $address = $rows[$i]["DETAIL"]." ".explode("=",$rows[$i]["VILLAGE"])[1].", ".explode("=",$rows[$i]["DISTRICT"])[1].", ".explode("=",$rows[$i]["PROVINCE"])[1];
                            $phonenum = $rows[$i]["PHONE_NUMBER"];
                            if ((int) $rows[$i]["ISACTIVE"] == 1) {
                                $hoatdong = "selected";
                            } else {
                                $khonghoatdong = "selected";
                            }
    
                            echo "<tr>
                            <td>". $makh ."</td>
                            <td>". $name ."</td>
                            <td>". $email ."</td>
                            <td>". $phonenum ."</td>
                            <td id=gender>". $gender ."</td>
                            <td>". $address ."</td>
                            <td>
                            <select name=trangthai id=trangthai>
                                <option value=hoatdong " . $hoatdong . ">Hoạt động</option>
                                <option value=khonghoatdong " . $khonghoatdong. ">Không hoạt động</option>
                            </select>
                            </td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <script src="./js/DB_User.js"></script>
</body>

</html>