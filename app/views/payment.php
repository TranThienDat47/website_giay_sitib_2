<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../public/css/main.css">
    <link rel="stylesheet" href="../../public/css/base.css">
    <link rel="stylesheet" href="../../public/css/responsive.css">
    <link rel="stylesheet" href="../../public/css/payment.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />

    <link rel="stylesheet" href="../../public/css/payment.css">

    <?php include './index.php' ?>
</head>

<body>

    <?php include_once '../others/checkLoginCustomer.php' ?>


    <div class="content">
        <div class="wrap">
            <div class="sidebar">
                <div class="list_proc">
                    <?php
                    if (isset($customer_sidebar_payment)) {
                        echo $customer_sidebar_payment;
                    }
                    ?>
                </div>
                <div class="order-summary-section order-summary-section-total-lines payment-lines"
                    data-order-summary-section="payment-lines">
                    <table class="total-line-table">
                        <tfoot class="total-line-table-footer">
                            <tr class="total-line">
                                <td class="total-line-name payment-due-label">
                                    <span class="payment-due-label-total">Tổng cộng</span>
                                </td>
                                <td class="total-line-name payment-due">
                                    <span class="payment-due-currency">VND</span>
                                    <span class="payment-due-price">
                                        <?php
                                        if (isset($total_cart)) {
                                            $price_string = number_format($total_cart, 0, ',', '.');
                                            echo $price_string;
                                        }
                                        ?> ₫
                                    </span>
                                    <span class="checkout_version" display:none="" data_checkout_version="19">
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="payment-container">
                    <p>
                        Để thanh toán bằng chuyển khoản, vui lòng thực hiện các bước sau:
                    </p>
                    <p>
                        Bước 1. Quét mã QR bên dưới.
                    </p>
                    <p>
                        Bước 2. Kiểm tra thông tin tài khoản ngân hàng của chúng tôi và số tiền cần thanh toán. Thực
                        hiện chuyển khoản với nội dung "sdt(là số điện thoại thanh toán),tên khách hàng"
                        ví dụ: 0322323456,TranVanNam
                    </p>
                    <p>
                        Lưu ý: Vui lòng kiểm tra đúng thông tin tài khoản và số
                        tiền cần thanh toán.
                    </p>
                    <p>
                        Chúng tôi sẽ kiểm tra thông tin của bạn và gửi sản phẩm của bạn đến
                        địa chỉ được cung cấp. Nếu bạn có bất kỳ câu hỏi hoặc yêu cầu gì về thanh toán bằng chuyển khoản
                        ngân hàng, xin vui
                        lòng liên hệ với chúng tôi để được hỗ trợ. Chúng tôi sẽ luôn sẵn sàng để giúp đỡ bạn trong
                        quá trình thanh toán.
                    </p>
                    <p>RedEVIL xin chân thành cám ơn!</p>

                    <div class="qrcode">
                        <img src="http://t3.gstatic.com/licensed-image?q=tbn:ANd9GcSh-wrQu254qFaRcoYktJ5QmUhmuUedlbeMaQeaozAVD4lh4ICsGdBNubZ8UlMvWjKC"
                            alt="" style="width: 200px; height: 200px">
                    </div>
                </div>
                <div class="payment-container">
                    <p>
                        Khi bạn đặt mua sản phẩm của chúng tôi, bạn có thể chọn phương thức thanh toán
                        khi nhận hàng. Đây là phương thức thanh toán đơn giản và an toàn nhất cho khách hàng.
                    </p>
                    <p>
                        Khi nhận được sản phẩm, bạn có thể kiểm tra hàng hóa để đảm bảo rằng sản phẩm đáp ứng yêu cầu
                        và
                        mong
                        đợi của bạn. Sau đó, bạn có thể thanh toán trực tiếp cho nhân viên giao hàng của chúng tôi,
                        bằng tiền mặt hoặc thẻ tín dụng.

                    </p>
                    <p>
                        Nếu bạn chọn phương thức thanh toán khi nhận hàng, vui lòng
                        hãy kiểm tra điện thoại, nhân viên chúng tôi sẽ gọi cho bạn khi giao hàng đến.
                    </p>
                    <p>
                        Nếu bạn có bất kỳ câu hỏi
                        hoặc yêu cầu gì về thanh toán bằng tiền mặt, xin vui
                        lòng liên hệ với chúng tôi để được hỗ trợ. Chúng tôi sẽ luôn sẵn sàng để giúp đỡ bạn trong
                        quá trình thanh toán.
                    </p>
                    <p>
                        RedEVIL xin trân thành cám ơn!
                    </p>
                </div>
            </div>
            <div class="main">
                <div class="main-header">
                    <a href="./home.php" class="logo" style="width: fit-content">
                        <h1 class="logo-text">Biti's</h1>
                    </a>
                    <style>
                    a.logo {
                        display: block;
                    }

                    .logo-cus {
                        width: 100%;
                        padding: 15px 0;
                        text-align: center;
                    }

                    .logo-cus img {
                        max-height: 4.2857142857em;
                    }

                    .logo-text {
                        text-align: center;
                    }

                    @media (max-width: 767px) {
                        .banner a {
                            display: block;
                        }
                    }
                    </style>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item breadcrumb-item-current">
                            <a href="./cart.php">Giỏ hàng</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" class="breadcrumb-link">
                                Thông tin và phương thức giao hàng
                            </a>
                        </li>
                        <!-- <li class="breadcrumb-item breadcrumb-item-current">
                            <a href="/cart">Phương thức giao hàng</a>
                        </li> -->
                    </ul>
                </div>
                <div style="display: flex;justify-content: space-between;align-items: center;">
                    <h1 class="main-title">Thông tin giao hàng</h1>
                    <a href="./information_account.php?value=logout">
                        <h4 style="margin: 20px 0;">Đăng xuất</h4>
                    </a>
                </div>
                <!-- FORM -->
                <form id="form_inf_delivery" action="/checkout/payment.html">
                    <input id="btnSubmit" type="submit" style="display: none" />
                    <h4>Khách hàng</h4>
                    <input style="outline: none; border: 1px solid rgba(0, 0, 0, 0.04);" id="name_user" type="text"
                        required readonly value="<?php
                        if (isset($name_user)) {
                            echo $name_user;
                        }
                        ?>" />
                    <h4>Email</h4>
                    <input style="outline: none; border: 1px solid rgba(0, 0, 0, 0.04);" id="email_user" type="email"
                        required readonly value="<?php
                        if (isset($email_user)) {
                            echo $email_user;
                        }
                        ?>" />
                    <h4>Thêm địa chỉ mới...</h4>
                    <select name="address_method" id="cb_adress" required>
                        <option value="default">Địa chỉ đã lưu trữ</option>
                    </select>
                    <input id="reception_name" type="text" placeholder="Họ và tên người nhận" required />
                    <input id="phone_user" type="tel" placeholder="Số điện thoại" required />
                    <input id="new_address_user" type="text" placeholder="Địa chỉ chi tiết" required />
                    <div class="address">
                        <div>
                            <label class="field-label" for="customer_shipping_province">
                                Tỉnh / thành
                            </label>
                            <select id="province" class="province-select" name="province">
                                <option value="">--Chọn tỉnh/thành phố--</option>
                            </select>
                        </div>
                        <div>
                            <label class="field-label" for="customer_shipping_district">Quận / huyện</label>
                            <select id="district" name="district">
                                <option value="">--Chọn quận/huyện--</option>
                            </select>
                        </div>
                        <div>
                            <label class="field-label" for="customer_shipping_ward">Phường / xã</label>
                            <select id="ward" name="ward">
                                <option value="">--Chọn phường/xã--</option>
                            </select>
                        </div>
                    </div>
                    <select name="payment_method" id="cb_payment" required>
                        <option value="default">-- Vui lòng chọn phương thức thanh toán --</option>
                        <option value="2">Thanh toán qua ngân hàng</option>
                        <option value="3">Thanh toán bằng tiền mặt (COD)</option>
                    </select>
                </form>
                <div class="btn_control">
                    <a href="./cart.php">
                        <button type="submit" class="step-footer-cart-btn btn">
                            <span class="btn-content">Giỏ hàng</span>
                        </button>
                    </a>
                    <button id="btn_finish_payment" class="payment_finish_btn btn button">
                        <span class="btn-content">Thanh toán</span>
                        <i class="btn-spinner icon icon-button-spinner"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
        integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../public/js/payment.js"></script>
</body>
</script>


</html>