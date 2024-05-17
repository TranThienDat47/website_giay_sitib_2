<?php
include_once '../controllers/AdminController.php';
include_once "../../libs/session.php";

$classAdmin = new AdminController();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (Session::checkLoginAdmin() == true) {
        header("Location: ./DB_Overview.php");
    }

    if (isset($_GET["value"]) && $_GET["value"] == "logout") {
        Session::destroy();
        //hủy tất cả các biến session sau khi logout 
        header("Location: ./login.php");
    }
}


//xử lý yêu cầu HTTP POST từ một biểu mẫu Login, để kiểm tra xem admin hay nhân viên có đăng nhập thành công hay không
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //kiểm tra xem có phương thức yêu cầu là POST
    //Sau đó, lấy giá trị của ba tham số từ yêu cầu HTTP POST để kiểm tra đăng nhập là admin hay nhân viên
    $type_user = $_POST['type_user'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login_check;
    //Kiểm tra user đăng nhập là admin hay staff
    //Sau đó sẽ lấy thông tin dữ liệu của user đăng nhập lưu vào session để dùng cho các trang khác
    if ($type_user === "admin") {
        $login_check = $classAdmin->login($email, $password);
    } else if ($type_user === "staff") {
        $login_check = $classAdmin->loginStaff($email, $password);
    }
}
?>