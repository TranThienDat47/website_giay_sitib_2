<?php
include_once '../controllers/CustommerController.php';
include_once '../controllers/CartController.php';
include_once "../../libs/session.php";
$class = new CustommerController();
$classCart = new CartController();

include_once "../config/database.php";


function RenderAddressCustomer($address_id, $fullName, $is_default, $phone, $detail, $province, $district, $ward)
{
    if ($is_default) {
        $text_default = "<span style='color: red; font-size: 17px; font-weight: 700;' class='default_address note'>(Địa chỉ mặc định)</span>";
    } else {
        $text_default = "";
    }
    return "
    <div id='address_tables'>
        <div class='row'>
            <div class='col-lg-12 col-xs-12 clearfix'>
                <div class='address_title '>
                    <h3>
                        <strong>$fullName</strong>
                        $text_default
                    </h3>
                    <p class='address_actions text-right'>
                        <span class='action_link action_edit'><a><i
                                    class='fa fa-pencil-square-o'
                                    aria-hidden='true'></i></a></span>
                        <span data-address_id = '$address_id' class='action_link action_delete'><a href='#'><i
                                    class='fa fa-times' aria-hidden='true'></i></a></span>
                    </p>
                </div>
            </div>
        </div>
        <div class='address_table'>
            <div id='view_address_1125532830' class='customer_address show_infor_account'>
                <div class='view_address '>
                    <div class='col-lg-12 col-md-12 large_view'>
                        <div class='lb-left'><b>Địa chỉ:</b></div>
                        <div class='lb-right'>
                            <p>$detail</p>
                            <p>$ward, $district, $province</p>
                        </div>
                    </div>
                    <div class='col-lg-12 col-md-12 large_view'>
                        <div class='lb-left'><b>Số điện thoại:</b></div>
                        <div class='lb-right'>$phone</div>
                    </div>
                </div>
            </div>
            <div id='edit_address_1125532830' class='customer_address edit_address'
                style='display:none;'>
                <div id = 'inner_edit_address'>
                
                </div>
                <div class='action_bottom'>
                    <input data-address_id = '$address_id' id='btn_update_address' class='btn bt-primary' type='button' value='Cập nhật'>
                    <span class=''>hoặc <a data-address_id = '$address_id' >Hủy</a></span>
                </div>
            </div>
        </div>
    </div>
    ";
}

function CartView($namePro, $linkTo, $img, $color, $size, $qty, $price)
{

    $price_string = number_format($price, 0, ',', '.');

    return '
         <table id="cart-view">
             <tbody>
                 <tr data-promotion="false" class="mini-cart__item">
                     <td class="mini-cart__left">
                         <a class="mnc-link"
                             href="./product.php?id=' . $linkTo . '">
                               <img src="' . $img . '"
                                 alt="' . $namePro . '(' . $color . ')' . '"
                                 onerror="this.onerror=null;this.src=\'../../access/img/error-image-generic.png\';"
                                 >
                         </a>
                     </td>
                     <td class="mini-cart__right">
                         <p class="mini-cart__title">
                             <a class="mnc-title mnc-link"
                                 href="./product.php?id=' . $linkTo . '"
                                 title="' . $namePro . '(' . $color . ')' . '"
                             >
                                 ' . $namePro . '(' . $color . ')' . '
                             </a>
                             <span class="mnc-variant">
                                ' . $color . '/' . $size . '
                             </span>
                         </p>
                         <div class="mini-cart__quantity">
                             <input class="qty-value" type="text"
                                 name="mnc-quantity"
                                 readonly
                                 min="0"
                                 value="' . $qty . '">
                         </div>
                         <div class="mini-cart__price">
                             <span class="mnc-price">' . $price_string . ' ₫</span>
                             <del class="mnc-ori-price"></del>
                         </div>
                     </td>
                 </tr>
             </tbody>
         </table>
     ';
}

function CartViewPage($namePro, $linkTo, $img, $color, $size, $qty, $price, $product_detail_id)
{

    $price_string = number_format($price, 0, ',', '.');
    $price_string_total = number_format((int) $price * (int) $qty, 0, ',', '.');

    return "
    <div class='product_buy'>
        <div class='media_left'>
            <div class='item-img'>
                <a href='./product.php?id=$linkTo'>
                    <img src='$img'
                        alt='$namePro ($color)' />
                </a>
            </div>

            <button data-product_detail_id='$product_detail_id' class='item-remove'>
                <i class='fa-sharp fa-solid fa-xmark'></i>
            </button>
        </div>

        <div class='media_right'>
            <div class='item-info'>
                <h3 class='item--title'>
                    $namePro
                    ($color)
                </h3>
            </div>
            <div class='item-price'>
                <p>
                    <span>$price_string ₫</span>
                </p>
            </div>

            <div class='item-size'>
                Kích thước:
                <span>$size</span>
            </div>

            <div class='item-sl'>
                <button data-product_detail_id='$product_detail_id' class='giam_sl'>-</button>
                <h2 id='count_sl'>$qty</h2>
                <button data-color='$color' data-size='$size' data-product_id='$linkTo' class='tang_sl'>+</button>
            </div>

            <div class='item-total-price'>
                <div class='price'>
                    <span class='line-item-total'>$price_string_total ₫</span>
                </div>
            </div>
        </div>
    </div>
     ";
}

function SidebarPayment($namePro, $linkTo, $img, $color, $size, $qty, $price, $product_detail_id)
{

    $price_string = number_format($price, 0, ',', '.');
    $price_string_total = number_format((int) $price * (int) $qty, 0, ',', '.');

    return "
    <div class='sidebar_item_proc'>
        <div class='sidebar_item_img'>
            <img src='$img'
                alt='$namePro ($color)' />
            <div class='sidebar_item_count'>$qty</div>
        </div>
        <div class='sidebar_item_inf'>
            <h4 class='sidebar_item_title'>$namePro ($color)</h4>
            <p class='sidebar_item_description'>$color / $size</p>
        </div>
        <div class='sidebar_item_price'>$price_string_total ₫</div>
    </div>
     ";
}


if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (Session::checkLoginCustomer() == true) {
        $cus_id = Session::get("customer_id");
        $name_user = Session::get("customer_firstName") . " " . Session::get("customer_lastName");
        $is_login = "<div style='padding: 20px;' class='site_account sitenav-account  sitenav-account_info ' id='siteNav-account'>
                        <div class='site_account_panel_list'>
                            <div class='site_account_info'>
                                    <div class='site_account_header'>
                                    <h2 class='site_account_title size-small heading'>Thông tin tài khoản</h2>
                                </div>
                                <div class='site_account_inner'>
                                    <ul>
                                        <li class='user-name'><span>$name_user</span></li>
                                        <li><a href='./information_account.php?id={$cus_id}'>Tài khoản của tôi</a></li>
                                        <li><a href='./information_account.php?value=logout'>Đăng xuất</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>";

        $list_cart = $classCart->getCartOfUser(Session::get("customer_id"));
        $customer_cart = "";
        $customer_cart_page = "";
        $customer_sidebar_payment = "";
        $count_cart = 0;

        $list_detail_not_active = [];

        foreach ($list_cart as $temp) {
            $check_qty_valid = $classCart->checkProductQuantity($temp[0], $temp[3], $temp[2], $temp[5]);
            if ($check_qty_valid === false) {
            } else {
                $list_detail_not_active[] = [$temp, $check_qty_valid];
            }
        }

        array_map(function ($element) use (&$customer_cart, &$count_cart, &$customer_cart_page, &$customer_sidebar_payment) {
            $customer_cart .= CartView($element[1], $element[0], $element[4], $element[2], $element[3], $element[5], $element[6]) . " ";
            $customer_cart_page .= CartViewPage($element[1], $element[0], $element[4], $element[2], $element[3], $element[5], $element[6], $element[7]) . " ";
            $customer_sidebar_payment .= SidebarPayment($element[1], $element[0], $element[4], $element[2], $element[3], $element[5], $element[6], $element[7]) . " ";
            $count_cart += $element[5];
        }, $list_cart);

        $total_cart = $classCart->totalCart();

        $email_user = Session::get("customer_email");

        //address
        $address_customer = "";
        $list_address = $class->getAllAddressOfCustomer();
        foreach ($list_address as $temp) {
            $address_customer .= RenderAddressCustomer($temp[0], $temp[2], $temp[3], $temp[04], $temp[5], explode("=", $temp[6])[1], explode("=", $temp[7])[1], explode("=", $temp[8])[1]);
        }


    }
}

$filename = basename($_SERVER['PHP_SELF']);

$nologin = " <div class='header__action-dropdown_content'>
    <div id='header-login-panel' class='site_account_panel site_account_default is-selected'>
        <div class='site_account_header'>
            <h2 class='site_account_title heading'>
                Đăng nhập tài khoản
            </h2>
            <p class='site_account_legend'>
                Nhập email và mật khẩu của bạn:
            </p>
        </div>
        <div class='site_account_inner'>
            <form action='$filename' method='post' id='customer_login'>
                <input name='form_type' type='hidden' value='customer_login' />
                <input name='utf8' type='hidden' value='✓' />
                <div class='form__input-wrapper form__input-wrapper--labelled'>
                    <input name='email' type='email' id='login-customer[email]' class='form__field form__field--text'
                        name='customer_email' required='required' />
                    <label for='login-customer[email]' class='form__floating-label'>Email</label>
                </div>
                <div class='form__input-wrapper form__input-wrapper--labelled'>
                    <input name='password' type='password' id='login-customer[password]' class='form__field form__field--text'
                        name='customer_password' required='required' autocomplete='current-password' />
                    <label for='login-customer[password]' class='form__floating-label'>Mật khẩu</label>
                    <div id='account_incorrect' style='display: none'>
                        <p style='color: red; margin: 10px 0 18px 4px'>
                            Tài khoản hoặc mật khẩu không đúng!
                        </p>
                    </div>
                    <div class='sitebox-recaptcha'>
                        This site is protected by reCAPTCHA and the Google
                        <a href='https://policies.google.com/privacy' target='_blank' rel='noreferrer'>Privacy
                            Policy</a>
                        and
                        <a href='https://policies.google.com/terms' target='_blank' rel='noreferrer'>Terms of
                            Service</a>
                        apply.
                    </div>
                </div>
                <button type='submit' class='form__submit button dark' id='form_submit-login'>
                    Đăng nhập
                </button>
            </form>
            <div class='site_account_secondary-action'>
                <p>
                    Khách hàng mới?
                    <a class='link' href='./register.php'>Tạo tài khoản</a>
                </p>
            </div>
        </div>
    </div>
</div>
";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($email) && isset($password))
        header("Location: ./login.php?action=login&email=$email&password=$password");
}



?>