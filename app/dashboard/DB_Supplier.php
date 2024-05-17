<!DOCTYPE html>
<html lang="en">

<?php
include_once "../config/database.php";
$db = new Database();

$sql = "select * from supplier";
$result = $db->query(($sql));

$rows = array();

while ($row = $result->fetch_array()) {
    $rows[] = $row;
}



//----------------kiem tra co goi action "updatetrangthai" -------------
if (isset($_GET['action']) && $_GET['action'] == "update_trangthai") {
    $mancc = intval($_GET['supplier_id']);
    $newActive = $_GET['value'];
    echo $mancc, $newActive;
    $sql_update_isactive = "UPDATE supplier SET ISACTIVE=$newActive  WHERE SUPLIER_ID=$mancc";

    $db->query(($sql_update_isactive));

    //can cai nay de lam j a, gg di
    header("Location: ./DB_Supplier.php", true, 302);
    exit();
}
//----------------kiem tra co goi action "update_supplier" -------------
if (isset($_GET['action']) && $_GET['action'] == "update_supplier") {
    $mancc = intval($_GET['id']);
    $tenncc = $_GET['ten'];
    $emailncc = $_GET['email'];
    $diachincc = $_GET['diachi'];
    $sdtncc = $_GET['sdt'];
    echo $mancc, $tenncc, $emailncc, $diachincc, $sdtncc;
    $sql_update_supplier = "UPDATE `supplier` SET `NAME`='$tenncc',`ADDRESS`='$diachincc',`EMAIL`='$emailncc',`PHONE_NUMBER`='$sdtncc' WHERE `SUPLIER_ID`='$mancc'";

    $result = $db->query(($sql_update_supplier));
    if ($result === false) {
        // Xử lý lỗi truy vấn SQL
        echo "Query failed: ";
    }
    //F5 á hehe
    header("Location: ./DB_Supplier.php", true, 302);
    exit();
}





//----------insert new staff-----------------
$name = "";
$email = "";
$phone = "";
$address = "";

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

    //Code xử lý, insert dữ liệu vào table
    $sql_add_staff = "INSERT INTO supplier ( `NAME`,`ADDRESS`, `EMAIL`, `PHONE_NUMBER`, `ISACTIVE`)
    VALUES ('$name', '$address', '$email','$phone',1)";
    $db->query(($sql_add_staff));
    header("Location: ./DB_Supplier.php", true, 302);
    exit();
}

?>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhà cung cấp</title>
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <?php include "./Layout/navbar.php"; ?>
    <link rel="stylesheet" href="./css/base.css">

    <link rel="stylesheet" href="./css/DB_Supplier.css">
    <script type="module" src="./js/DB_Supplier.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./css/header_db.css">
</head>

<body>
    <!-- Header -->
    <?php echo $header; ?>

    <!-- Main -->
    <main id="main">
        <div class="main-dashboard__custommer">
            <div class="main-dashboard__custommer-header">
                <h2 class="main-dashboard__custommer-title">Danh sách nhà cung cấp</h2>
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
                    <div class="main-dashboard__custommer-handle-search">
                        <input id="input_find_name" type="text" placeholder="Tìm kiếm theo tên" />
                    </div>

                    <div class="main-dashboard__custommer-handle-search">
                        <input id="input_find_number" type="number" placeholder="Tìm kiếm theo số điện thoại" />
                    </div>
                </div>
            </div>

            <table id="table_suppliers">
                <thead>
                    <tr>
                        <th class="col-0" width="10%">Mã NCC</th>
                        <th class="col-1" width="20%">Nhà cung cấp<i id="btn_sort_name" class="fa-solid fa-sort" style="margin-left: 5px;"></i></th>
                        <th class="col-2" width="20%">Email</th>
                        <th class="col-4" width="15%">Số Điện thoại</th>
                        <th class="col-5" width="25%">Địa Chỉ</th>
                        <th class="col-6" width="15%">Trạng Thái <i id="btn_sort_active" class="fa-solid fa-sort"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $mancc;
                    $tenncc;
                    $email;
                    $sdt;
                    $diachi;

                    for ($i = 0; $i < count($rows); $i++) {
                        $hoatdong = "";
                        $khonghoatdong = "";
                        $mancc = $rows[$i][0];
                        $tenncc = $rows[$i][1];
                        $email = $rows[$i][3];
                        $sdt = $rows[$i][4];
                        $diachi = $rows[$i][2];
                        if ((int) $rows[$i][5] == 1) {
                            $hoatdong = "selected";
                        } else {
                            $khonghoatdong = "selected";
                        }

                        echo "<tr>
                        <td class=clickable>" . $mancc . "</td>
                        <td>" . $tenncc . "</td>
                        <td>" . $email . "</td>

                        <td>" . $sdt . "</td>
                        <td>" . $diachi . "</td>
                        <td>
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

    <div id="show-stocker-modal" class="modal">
        <div class="modal-content">
            <div class="title">
                <h1>
                    nhà cung cấp
                </h1>
            </div>
            <div class="modal-close" id="button_close">
                <i class="fa-solid fa-x"></i>
            </div>
            <form id="form_show_detai">
                <label for="name">Mã NCC (Không được chinh sửa):</label>
                <input type="text" id="mancc" name="mancc" readonly>
                <label for="name">Tên nhà cung cấp:</label>
                <input type="text" id="name" name="name">

                <label for="email" class="label-email">Email (Không được chinh sửa):</label>
                <input type="email" id="email" name="email" readonly>

                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}">

                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address">
                <div class="submit">
                    <button id="btn_edit_supplier" type="button">Sửa</button>
                </div>
            </form>
        </div>
    </div>


    <div id="add-stocker-modal" class="modal">
        <div class="modal-content">
            <div class="title">
                <h1>
                    Thêm nhà cung cấp
                </h1>
            </div>
            <div class="modal-close">
                <i class="fa-solid fa-x"></i>
            </div>
            <form action="  " method="post">
                <label for="name">Tên nhà cung cấp:</label>
                <input type="text" id="name" name="name">

                <label for="email" class="label-email">Email:</label>
                <input type="email" id="email" name="email">

                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}">

                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address">
                <div class="submit">
                    <button style="
    background-color: #d93825ed;
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
" type="submmit">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>