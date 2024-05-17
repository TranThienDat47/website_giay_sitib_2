<!DOCTYPE html>
<html lang="en">
<?php
include_once "../config/database.php";
$db = new Database();

$sql = "select * from staffs";
$result = $db->query(($sql));

$rows = array();

while ($row = $result->fetch_array()) {
    $rows[] = $row;
}

//----------------kiem tra co goi action "updatetrangthai" -------------
if (isset($_GET['action']) && $_GET['action'] == "update_trangthai") {
    $manv = intval($_GET['staff_id']);
    $newActive = $_GET['value'];

    $sql_update_isactive = "UPDATE staffs SET ISACTIVE=$newActive  WHERE STAFF_ID=$manv";
    // $sql1 = "UPDATE `staffs` SET `ISACTIVE`=$newActive WHERE `STAFF_ID`=$manv"; //vẫn được nha
    $db->query(($sql_update_isactive));

    //can cai nay de lam j a, gg di
    header("Location: ./DB_Staff.php", true, 302);
    exit();
}


//----------insert new staff-----------------
$name = "";
$email = "";
$phone = "";
$address = "";
$pass = "";
//Lấy giá trị POST từ form vừa submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"])) {
        $name = $_POST['name'];
    }
    if (isset($_POST["email"])) {
        $email = $_POST['email'];
    }
    if (isset($_POST["phone"])) {
        $phone = $_POST['phone'];
    }
    if (isset($_POST["address"])) {
        $address = $_POST['address'];
    }
    if (isset($_POST["pass"])) {
        $pass = $_POST['pass'];
    }
    //Code xử lý, insert dữ liệu vào table
    $sql_add_staff = "INSERT INTO staffs ( `EMAIL`, `PASSWORD`, `FULL_NAME`, `PHONE_NUMBER`, `ADRESS`, `ISACTIVE`)
    VALUES ('$email', '$pass', '$name', '$phone','$address',1)";
    $db->query(($sql_add_staff));
    header("Location: ./DB_Staff.php", true, 302);
    exit();
}
?>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhân viên</title>
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <?php include "./Layout/navbar.php"; ?>
    <link rel="stylesheet" href="./css/base.css">

    <link rel="stylesheet" href="./css/DB_Staff.css">
    <script src="https://cdn.tailwindcss.com"></script>


    <link rel="stylesheet" href="./css/header_db.css">
</head>

<body>
    <!-- Header -->
    <?php echo $header; ?>


    <?php



    ?>
    </script>
    <!-- Main -->
    <main id="main">
        <div class="main-dashboard__custommer">
            <div class="main-dashboard__custommer-header">
                <h2 class="main-dashboard__custommer-title">Danh sách nhân viên</h2>
            </div>
            <div class="main-dashboard__custommer-handle">
                <div class="main-dashboard__custommer-handle-search-wrapper">
                    <button class="main-dashboard__custommer-handle-search-icon">
                        <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" style="pointer-events: none; display: block; width: 28px; height: 28px">
                            <g>
                                <path d="M21,6H3V5h18V6z M18,11H6v1h12V11z M15,17H9v1h6V17z"></path>
                            </g>
                        </svg>
                    </button>
                    <div class="     main-dashboard__custommer-handle-search">
                        <input id="input_find_name" type="text" placeholder="Tìm kiếm theo tên" />
                    </div>

                    <div class="main-dashboard__custommer-handle-search">
                        <input id="input_find_number" type="number" placeholder="Tìm kiếm theo số điện thoại" />
                    </div>
                </div>
            </div>
            <table id="table_staffs">
                <thead>
                    <tr>
                        <th class="col-3">Mã NV</th>
                        <th class="col-1">Nhân viên<i id="btn_sort_name" class="fa-solid fa-sort"></i></th>
                        <th class="col-2">Email</th>

                        <th class="col-4">Số Điện thoại</th>
                        <th class="col-5">Địa Chỉ</th>
                        <th class="col-6">Trạng Thái <i id="btn_sort_active" class="fa-solid fa-sort"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $manv;
                    $tennv;
                    $email;
                    $sdt;
                    $diachi;


                    for ($i = 0; $i < count($rows); $i++) {
                        $hoatdong = "";
                        $khonghoatdong = "";
                        $manv = $rows[$i][0];
                        $tennv = $rows[$i][3];
                        $email = $rows[$i][1];
                        $sdt = $rows[$i][4];
                        $diachi = $rows[$i][5];
                        if ((int) $rows[$i][6] == 1) {
                            $hoatdong = "selected";
                        } else {
                            $khonghoatdong = "selected";
                        }
                        //echo json_encode($rows[$i]);
                        echo "<tr>
                        <td>" . $manv . "</td>
                        <td>" . $tennv . "</td>
                        <td>" . $email . "</td>

                        <td>" . $sdt . "</td>
                        <td>" . $diachi . "</td>
                        <td >
                      
                        <select name=trangthai id=trangthai>

                            <option value=hoatdong " . $hoatdong . ">Hoạt động</option>
                            <option value=khonghoatdong " . $khonghoatdong
                            . ">Không hoạt động</option>
                        </select>
                
                    </td>
                    </tr>";
                    }


                    ?>


                </tbody>
            </table>
            <div class="fixed-icon">
                <i class="fa-solid fa-circle-plus" style="color: #005eff;"></i>
            </div>
        </div>
    </main>


    <div id="add-stocker-modal" class="modal">
        <div class="modal-content">
            <div class="title">
                <h1>
                    Thêm nhân viên
                </h1>
            </div>
            <div class="modal-close">
                <i id="button_close" class="fa-solid fa-x"></i>
            </div>
            <form action="" method="post">
                <label for="name">Họ tên:</label>
                <input type="text" id="name" name="name">



                <label for="email" class="label-email">Email:</label>
                <input type="email" id="email" name="email">

                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}">

                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address">
                <label for="address">Mật khẩu:</label>
                <input type="text" id="pass" name="pass">
                <div class="submit">
                    <button type="submit">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script type="module" src="./js/DB_Staff.js"></script>

</html>