<?php
include_once "../../libs/session.php";
include_once "../config/database.php";

include_once "../models/AdminModel.php";
include_once "../models/StaffModel.php";

class AdminController
{

    public $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($email, $password)
    {
        $adminModel = new AdminModel();
        
        if (empty($email) || empty($password)) {
            return false;
        } else {
            $result = $adminModel->login($email, $password);
            /*Lấy dữ liệu tài khoản admin sau khi đăng nhập thông qua lớp model
            truy vấn db lấy dữ liệu admin qua 2 biến email và password*/
            //Sẽ trả về 1 đối tượng admin-EntityAdmin gồm các thuộc tính dữ liệu thông tin của admin hoặc null nếu truy vấn không tìm thấy
            //Sau đó, kiểm tra nếu tài khoản admin tồn tại thì tiếp tục lưu các giá trị dữ liệu của admin bằng session để sử dụng cho các trang khác
            if ($result) {
                //Set các giá trị dữ liệu của admin vào các biến session tương ứng
                Session::set("admin_login", true);
                Session::set("admin_id", $result->getId());
                Session::set("admin_email", $result->getEmail());
                Session::set("admin_fullName", $result->getFullName());

                header("Location: ./DB_Overview.php");
                return true;
            } else {
                //Nếu $result = null nghĩa là email hoặc mk không chính xác hoặc tk không tồn tại
                return "Tài khoản hoặc mật khẩu không chính xác!";
            }
        }
    }

    public function loginStaff($email, $password)
    {
        $staffModel = new StaffModel();

        if (empty($email) || empty($password)) {
            return false;
        } else {
            $result = $staffModel->login($email, $password);
            //Lấy dữ liệu tài khoản nhân viên thông qua lớp model - truy vấn db lấy dữ liệu nhân viên qua 2 biến email và password
            //Sẽ trả về 1 mảng gồm các phần tử là dữ liệu thông tin của nhân viên hoặc null nếu truy vấn không tìm thấy
            //Sau đó, kiểm tra nếu biến tài khoản admin tồn tại thì tiếp tục lưu các giá trị dữ liệu của nv bằng session để sử dụng cho các trang khác
            if ($result) {
                $check_activ = $staffModel->checkActive($email, $password);
                //Lưu y chỗ này: Cần kiểm tra tk nhân viên có hoạt động không bằng cách truy vấn db kiểm tra thuộc tính ISACTIVE = true ?
                if ($check_activ) {
                    //Set các giá trị dữ liệu của nv vào các biến session tương ứng
                    Session::set("staff_login", true);
                    Session::set("staff_id", $result[0]);
                    Session::set("staff_email", $result[1]);
                    Session::set("staff_fullName", $result[2]);
                    Session::set("staff_phone", $result[3]);
                    Session::set("staff_address", $result[4]);

                    header("Location: ./DB_Overview.php");
                    return true;
                } else {
                    return "Tài khoản của bạn đã bị khóa!";
                }
            } else {
                //Nếu $result = null nghĩa là email hoặc mk không chính xác hoặc tk không tồn tại
                return "Tài khoản hoặc mật khẩu không chính xác!";
            }
        }
    }


}