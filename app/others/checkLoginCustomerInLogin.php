<?php
include_once '../controllers/CustommerController.php';
include_once "../../libs/session.php";

$class = new CustommerController();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (Session::checkLoginCustomer() == true) {
        header("Location: ./home.php");
    }

    if (isset($_GET['action']) && $_GET['action'] === 'login') {
        $email = $_GET['email'];
        $password = $_GET['password'];

        $login_check = $class->login($email, $password);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login_check = $class->login($email, $password);
}
?>