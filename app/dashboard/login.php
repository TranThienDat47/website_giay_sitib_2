<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>

    <?php include_once "../others/adminAccount.php";

    include_once "../../libs/session.php";

    if (Session::get('staff_login') === true || Session::get('admin_login') === true) {
        header("Location: ./DB_Overview.php");
    }
    ?>

    <main id="main">
        <div class="wrapper">
            <div class="left">
                <div>


                    <div class="title">
                        <h2 style="margin-bottom: 16px;">Login to RedEVIL</h2>
                        <span style="opacity: 0.3;">Welcome back to the store. Have a great day at work!</span>
                    </div>

                    <form action="login.php" method="POST">

                        <input type="radio" id="user_admin" name="type_user" value="admin" checked />
                        <label for="user_admin">Admin</label>

                        <input type="radio" id="user_staff" name="type_user" value="staff" />
                        <label for="user_staff">Staff</label>

                        <?php
                        if (isset($login_check)) {
                            echo "<br/><span style='color: red;'>$login_check</span><br/>";
                        }
                        ?>

                        <label for="user_name">Email</label>
                        <br />
                        <input class="login_input" id="user_name" type="email" name="email"
                            placeholder="your-email@gmail.com" required />
                        <br />
                        <label for="pass_word">Password</label>
                        <br />
                        <input class="login_input" id="pass_word" type="password" name="password" placeholder="********"
                            required />

                        <br />
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <input type="checkbox" id="remember" />
                                <label for="remember">Remember me</label>
                            </div>
                            <a href="#" id="forgot_password">Forgot Password</a>
                        </div>

                        <button class="btn button btn_login">Login</button>
                    </form>
                </div>
            </div>
            <div class=" right">
                <img class="watch_img-login" src="access/imgs/img_login.svg" alt="Login" />
            </div>
        </div>
    </main>
</body>

</html>