<?php

include_once "../../libs/session.php";
$check_admin;

$check_admin = Session::get('admin_login');
$header;
$tong_quan_active = "";
$khach_hang_active = "";
$nhan_vien_active = "";
$ncc_active = "";
$don_dat_hang_active = "";
$phieu_nhap_active = "";
$san_pham_active = "";
$danh_muc_active = "";
$khuyen_mai_active = "";
$report_active = "";
$account_active = "";

$url = $_SERVER['REQUEST_URI'];
$file_name = basename($url);

if (strpos($file_name, 'DB_Overview.php') !== false) {
    $tong_quan_active = "class='sidebar-active'";
} else if (strpos($file_name, 'DB_User.php') !== false) {
    $khach_hang_active = "class='sidebar-active'";
} else if (strpos($file_name, 'DB_Staff.php') !== false) {
    $nhan_vien_active = "class='sidebar-active'";
} else if (strpos($file_name, 'DB_Supplier.php') !== false) {
    $ncc_active = "class='sidebar-active'";
} else if (strpos($file_name, 'DB_Oders.php') !== false) {
    $don_dat_hang_active = "class='sidebar-active'";
} else if (strpos($file_name, 'DB_Purchases.php') !== false) {
    $phieu_nhap_active = "class='sidebar-active'";
} else if (strpos($file_name, 'DB_Product.php') !== false) {
    $san_pham_active = "class='sidebar-active'";
} else if (strpos($file_name, 'DB_Catelory.php') !== false) {
    $danh_muc_active = "class='sidebar-active'";
} else if (strpos($file_name, 'DB_Promotion.php') !== false) {
    $khuyen_mai_active = "class='sidebar-active'";
} else if (strpos($file_name, 'DB_Report.php') !== false) {
    $report_active = "class='sidebar-active'";
} else if (strpos($file_name, 'DB_InforAccount.php') !== false) {
    $account_active = "class='sidebar-active'";
}


if (Session::get('staff_login') === true) {
    $name = Session::get('staff_fullName');
    $header = "
    <header id='header'>
        <div class='block bl1' style='border-bottom: 2px solid rgba(0,0,0,0.07);'>
            <div class='headerlogo'>
                <img id='logo' src='../../public/access/imgs/RedEVIL.svg' alt='' />
            </div>
            <div id = 'name' class='headername' value = '$name'>$name</div>
            <div>Chức vụ : <span class='position'> Nhân viên</span></div>

        </div>
        <div class='block bl2'>
            <ul style=' overflow-y: auto; max-height: 54vh;'>

                <a href='./DB_Overview.php'>
                    <li $tong_quan_active>
                        <div class='icon-list'><i class='fa-solid fa-bars-progress'></i></div>
                        <div class='name-list'>Trang Tổng Quan</div>
                    </li>
                </a>
                <a href='./DB_User.php'>
                    <li $khach_hang_active;'>
                        <div class='icon-list'><i class='fa-solid fa-users'></i> </div>
                        <div class='name-list'>Khách Hàng</div>
                    </li>
                </a>
                <a href='./DB_Supplier.php'>
                    <li $ncc_active>
                        <div class='icon-list'><i class='fa-solid fa-users'></i> </div>
                        <div class='name-list'>Nhà cung cấp</div>
                    </li>
                </a>
                <a href='./DB_Oders.php'>
                    <li $don_dat_hang_active>
                        <div class='icon-list'><i class='fa-solid fa-receipt'></i> </div>
                        <div class='name-list'>Đơn Đặt Hàng</div>
                    </li>
                </a>
                <a href='./DB_Purchases.php'>
                    <li $phieu_nhap_active>
                        <div class='icon-list'><i class='fa-solid fa-receipt'></i> </div>
                        <div class='name-list'>Phiếu nhập hàng</div>
                    </li>
                </a>
                <a href='./DB_Product.php'>
                    <li $san_pham_active>
                        <div class='icon-list'> <i class='fa-solid fa-database'></i> </div>
                        <div class='name-list'>Sản Phẩm</div>
                    </li>
                </a>
                <a href='./DB_Catelory.php'>
                    <li $danh_muc_active>
                        <div class='icon-list'><i class='fa-solid fa-layer-group'></i> </div>
                        <div class='name-list'>Danh Mục Sản Phẩm</div>
                    </li>
                </a>
                
            </ul>
            <ul>
                <a href='./DB_Report.php'>
                    <div style='border-bottom: 2px solid rgba(0,0,0,0.07);'></div>
                    <li $report_active>
                        <div class='icon-list'><i class='fa-solid fa-chart-pie'></i> </div>
                        <div class='name-list'>Thống Kê</div>
                    </li>
                </a>
                <a href='./DB_InforAccount.php'>
                    <li $account_active>
                        <div class='icon-list'><i class='fa-solid fa-pencil'></i> </div>

                        <div class='name-list'>Thông Tin Tài Khoản</div>
                    </li>
                </a>
                <a href='./login.php?value=logout'>
                    <li>
                        <div class='icon-list'><i class='fa-solid fa-right-from-bracket'></i> </div>

                        <div class='name-list'>Đăng Xuất</div>
                    </li>
                </a>
            </ul>
        </div>
    </header>";
} else if (Session::get('admin_login') === true) {
    $name = Session::get('admin_fullName');

    $header = "
    <header id='header'>
        <div class='block bl1' style='border-bottom: 2px solid rgba(0,0,0,0.07);'>
            <div class='headerlogo'>
                <img id='logo' src='../../public/access/imgs/RedEVIL.svg' alt='' />
            </div>
            <div id = 'name' class='headername' value = '$name'>$name</div>
            <div>Chức vụ : <span class='position'> Admin</span></div>

        </div>
        <div class='block bl2'>
            <ul style=' overflow-y: auto; max-height: 54vh;'>

                <a href='./DB_Overview.php'>
                    <li $tong_quan_active>
                        <div class='icon-list'><i class='fa-solid fa-bars-progress'></i></div>
                        <div class='name-list'>Trang Tổng Quan</div>
                    </li>
                </a>
                <a href='./DB_User.php'>
                    <li $khach_hang_active>
                        <div class='icon-list'><i class='fa-solid fa-users'></i> </div>
                        <div class='name-list'>Khách Hàng</div>
                    </li>
                </a>
                <a href='./DB_Staff.php'>
                    <li $nhan_vien_active>
                        <div class='icon-list'><i class='fa-solid fa-users'></i> </div>
                        <div class='name-list'>Nhân viên</div>
                    </li>
                </a>
                <a href='./DB_Supplier.php'>
                    <li $ncc_active>
                        <div class='icon-list'><i class='fa-solid fa-users'></i> </div>
                        <div class='name-list'>Nhà cung cấp</div>
                    </li>
                </a>
                <a href='./DB_Oders.php'>
                    <li $don_dat_hang_active>
                        <div class='icon-list'><i class='fa-solid fa-receipt'></i> </div>
                        <div class='name-list'>Đơn Đặt Hàng</div>
                    </li>
                </a>
                <a href='./DB_Purchases.php'>
                    <li $phieu_nhap_active>
                        <div class='icon-list'><i class='fa-solid fa-receipt'></i> </div>
                        <div class='name-list'>Phiếu nhập hàng</div>
                    </li>
                </a>
                <a href='./DB_Product.php'>
                    <li $san_pham_active>
                        <div class='icon-list'> <i class='fa-solid fa-database'></i> </div>
                        <div class='name-list'>Sản Phẩm</div>
                    </li>
                </a>
                <a href='./DB_Catelory.php'>
                    <li $danh_muc_active>
                        <div class='icon-list'><i class='fa-solid fa-layer-group'></i> </div>
                        <div class='name-list'>Danh Mục Sản Phẩm</div>
                    </li>
                </a>
                
            </ul>
            <ul>
                <a href='./DB_Report.php'>
                    <div style='border-bottom: 2px solid rgba(0,0,0,0.07);'></div>
                    <li $report_active>
                        <div class='icon-list'><i class='fa-solid fa-chart-pie'></i> </div>
                        <div class='name-list'>Thống Kê</div>
                    </li>
                </a>
                <a href='./DB_InforAccount.php'>
                    <li $account_active>
                        <div class='icon-list'><i class='fa-solid fa-pencil'></i> </div>

                        <div class='name-list'>Thông Tin Tài Khoản</div>
                    </li>
                </a>
                <a href='./login.php?value=logout'>
                    <li>
                        <div class='icon-list'><i class='fa-solid fa-right-from-bracket'></i> </div>

                        <div class='name-list'>Đăng Xuất</div>
                    </li>
                </a>
            </ul>
        </div>
    </header>";
} else {
    header("Location: ./login.php");
}
?>
<!-- 
<a href='./DB_Promotion.php'>
                    <li $khuyen_mai_active>
                        <div class='icon-list'><i class='fa-solid fa-percent'></i> </div>
                        <div class='name-list'>Khuyến Mãi</div>
                    </li>
                </a> -->

<!-- <a href='./DB_Promotion.php'>
                    <li $khuyen_mai_active>
                        <div class='icon-list'><i class='fa-solid fa-percent'></i> </div>
                        <div class='name-list'>Khuyến Mãi</div>
                    </li>
                </a> -->