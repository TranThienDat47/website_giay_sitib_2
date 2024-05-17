<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <?php include "./Layout/navbar.php"; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/header_db.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <?php
    include_once "../../libs/session.php";
    include_once "../config/database.php";

    $db = new Database();

    $user_login;
    if (Session::get("admin_login")) {
        //Nếu phiên đăng nhập đang là admin
        $user_login = "admin";
        //Kiểm tra có tồn tại biến type_user trong yêu cầu POST 
        if (isset($_POST['type_user']) && $_POST['type_user'] === 'admin') {
            //Cập nhận mật khẩu mới cho admin
            function updateUser($db, $password, $newpassword)
            {
                $admin_id = Session::get("admin_id");
                $sql = "UPDATE `admin` SET `PASSWORD` = '{$newpassword}' WHERE `admin`.`ADMIN_ID` = $admin_id and `PASSWORD` = '{$password}'";

                return $db->query($sql);
            }

            //Kiểm tra mật khẩu có trùng khớp với mật khẩu trong db dùng để xác thực mật khẩu cũ khi admin nhập
            function checkUser($db, $password)
            {
                $admin_id = Session::get("admin_id");
                $sql = "SELECT * FROM `admin` WHERE `admin`.`ADMIN_ID` = $admin_id and `PASSWORD` = '{$password}'";
                $result = $db->query($sql);

                $rows = [];

                while ($temp = $result->fetch_assoc()) {
                    $rows[] = $temp;
                }

                if (count($rows)) {
                    return true;
                }
                return false;
            }

            $password;
            $newpassword;
            if (isset($_POST['password']) && $_POST['newpassword']) {
                $password = $_POST['password'];
                $newpassword = $_POST['newpassword'];
            }

            //Admin 
            if (empty(trim($newpassword))) {
                if (checkUser($db, $password)) {
                    header("Location: ./DB_InforAccount.php");
                    exit();
                } else {
                    echo "<script> 
                    alert('Mật khẩu củ không đúng!');
                    window.location.href = './DB_InforAccount.php';
                    </script>";
                }

            } else {
                if (!checkUser($db, $password)) {
                    echo "<script> 
                    alert('Mật khẩu cũ không đúng vui lòng nhập lại!');
                    window.location.href = './DB_InforAccount.php';
                    </script>";

                } else if (updateUser($db, $password, $newpassword)) {
                    echo "<script> 
                    alert('Cập nhật mật khẩu mới thành công!');
                    window.location.href = './DB_InforAccount.php';
                    </script>";
                }
            }
        }

    } else if (Session::get("staff_login")) {
        //Nếu phiên đăng nhập đang là nhân viên
        $user_login = "staff";
        ////Kiểm tra có tồn tại biến type_user trong yêu cầu POST và type_user có bằng staff
        if (isset($_POST['type_user']) && $_POST['type_user'] === 'staff') {

            //update mật khẩu mới nhân viên
            function updateUser($db, $password, $newpassword)
            {
                $staff_id = Session::get("staff_id");
                $sql = "UPDATE `staffs` SET `PASSWORD` = '{$newpassword}' WHERE `staffs`.`STAFF_ID` = $staff_id and `PASSWORD` = '{$password}'";

                return $db->query($sql);
            }

            //update thông tin nhân viên
            function updateUserInf($db, $fullname, $phone, $address)
            {
                $staff_id = Session::get("staff_id");
                $sql = "UPDATE `staffs` SET `FULL_NAME` = '$fullname', `PHONE_NUMBER` = '$phone', `ADRESS` = '$address' WHERE `staffs`.`STAFF_ID` = $staff_id";

                return $db->query($sql);
            }

            //Kiểm tra tính hợp lệ của mật khẩu
            function checkUser($db, $password)
            {
                $staff_id = Session::get("staff_id");
                $sql = "SELECT * FROM `staffs` WHERE `staffs`.`STAFF_ID` = $staff_id and `PASSWORD` = '{$password}'";
                $result = $db->query($sql);

                if ($result) {
                    $rows = [];

                    while ($temp = $result->fetch_assoc()) {
                        $rows[] = $temp;
                    }

                    if (count($rows)) {
                        return true;
                    }
                    return false;
                }
            }

            $password = $_POST['password'];
            $newpassword = $_POST['newpassword'];
            $fullname = $_POST['fullname'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            //Nhân viên muốn thay đổi thông tin phải nhập mật khẩu cũ chính xác để thay đổi
            if (empty(trim($newpassword))) {
                //Chỉ cập nhật thông tin, không thay đổi mật khẩu
                if (checkUser($db, $password)) {
                    if (updateUserInf($db, $fullname, $phone, $address)) {
                        Session::set("staff_fullName", $fullname);
                        Session::set("staff_phone", $phone);
                        Session::set("staff_address", $address);

                        echo "<script> 
                        alert('Cập nhật thông tin thành công!');
                        window.location.href = './DB_InforAccount.php';
                        </script>";
                    } else {
                        echo "<script> 
                        alert('Cập nhật thông tin thất bại!');
                        window.location.href = './DB_InforAccount.php';
                        </script>";
                    }
                } else {
                    echo "<script> 
                    alert('Mật khẩu cũ không đúng!');
                    window.location.href = './DB_InforAccount.php';
                    </script>";
                }

            } else {
                if (!checkUser($db, $password)) {
                    echo "<script> 
                    alert('Mật khẩu cũ không đúng vui lòng nhập lại!');
                    window.location.href = './DB_InforAccount.php';
                    </script>";

                } else if (updateUser($db, $password, $newpassword)) {
                    if (updateUserInf($db, $fullname, $phone, $address)) {
                        //Cập nhật cả thông tin và thay đổi mật khẩu
                        Session::set("staff_fullName", $fullname);
                        Session::set("staff_phone", $phone);
                        Session::set("staff_address", $address);

                        echo "<script> 
                        alert('Cập nhật thông tin thành công!');
                        window.location.href = './DB_InforAccount.php';
                        </script>";
                    } else {
                        echo "<script> 
                        alert('Cập nhật thông tin thất bại!');
                        window.location.href = './DB_InforAccount.php';
                        </script>";
                    }
                } else {
                    echo "<script> 
                        alert('Cập nhật thông tin thất bại!');
                        window.location.href = './DB_InforAccount.php';
                        </script>";
                }
            }
        }
    }



    ?>
    <!-- Header -->
    <?php echo $header; ?>


    <!-- Main -->
    <div id="main">
        <h1>Thông tin tài khoản</h1>
        <form action='./DB_InforAccount.php' method="POST">
            <?php

            if (isset($user_login) && $user_login === "admin") {
                //Sử dụng các biến session lưu trữ thông tin của tài khoản admin đăng nhập đã đc set khi ĐĂNG NHẬP để hiển thị thông tin admin 
                //các biến session này được set bên AdminController
                $name_admin = Session::get("admin_fullName");
                $email_admin = Session::get("admin_email");
                echo "
                <input type='hidden' name='type_user' id='type_user' value='admin'>
                
                <label for='fullname'>Họ tên:</label>
                <input type='text' name='fullname' id='fullname' value='{$name_admin}' disabled required style='
                opacity: 0.5;
                '>

                <label for='email'>Email:</label>
                <input type='text' name='email' id='email' value='{$email_admin}' disabled required style='
                opacity: 0.5;
                '>

                <label for='password'>Mật khẩu cũ:</label>
                <input type='password' name='password' id='password' placeholder = 'Nhập mật khẩu củ' required>

                <label for='newpassword'>Mật khẩu mới:</label>
                <input type='password' name='newpassword' placeholder = 'Nhập mật khẩu mới' id='newpassword'>
                ";

            } elseif (isset($user_login) && $user_login === "staff") {

                $name_staff = Session::get("staff_fullName");
                $address_staff = Session::get("staff_address");
                $phone_staff = Session::get("staff_phone");
                $email_staff = Session::get("staff_email");

                echo "
                <input type='hidden' name='type_user' id='type_user' value='staff'>
                
                <label for='fullname'>Họ tên:</label>

                <input type='text' name='fullname' id='fullname' value='{$name_staff}' required>

                <label for='phone'>Số điện thoại:</label>
                <input type='number' name='phone' id='phone' value='{$phone_staff}' required>

                <label for='address'>Địa chỉ:</label>
                <input type='text' name='address' id='address' value='{$address_staff}' required>

                <label for='email'>Email:</label>
                <input type='text' name='email' id='email' value='{$email_staff}' disabled required style='
                opacity: 0.5;
                '>


                <label for='password'>Mật khẩu cũ:</label>
                <input type='password' name='password' id='password' placeholder = 'Nhập mật khẩu củ' required>

                <label for='newpassword'>Mật khẩu mới:</label>
                <input type='password' name='newpassword' placeholder = 'Nhập mật khẩu mới' id='newpassword'>
                ";
            }


            ?>
            <button type="submit">Cập nhật thông tin</button>
        </form>
    </div>

</body>
<link rel="stylesheet" href="./css/DB_inforAccount.css">

</html>
<?php
ob_end_flush();

?>