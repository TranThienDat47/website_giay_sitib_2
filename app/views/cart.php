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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <link rel="" type="module" href="../../public/js/index.js">

    <link rel="stylesheet" href="../../public/css/cart.css">
    <?php include_once './index.php' ?>

</head>

<body>
    <?php include_once '../others/checkLoginCustomer.php' ?>


    <script>
        setTimeout(() => {
            <?php
            if (isset($list_detail_not_active)) {
                // echo json_encode($list_detail_not_active);
                foreach ($list_detail_not_active as $temp) {
                    echo 'alert("Sản phẩm \"' . $temp[0][1] . ' (' . $temp[0][2] . ' - ' . $temp[0][3] . ') giá ' . $temp[0][5] . ' ₫\" chỉ còn ' . $temp[1] . ' sản phẩm. \nVui lòng cập nhật lại số lượng hợp lệ!");';
                }
            }
            ?>
        }, 500)
    </script>

    <!-- Header -->
    <header class="header">
        <div class="header__topbar">
            <div class="header__topbar-container">
                <div class="header__topbar-content">
                    <div class="header__topbar-lef">
                        <div class="header__topbar-hotline-left">
                            <span>Hotline:</span>
                            <span><a href="tel:0966158666">0966 158 666</a></span>
                            <span>(8h - 12h, 13h30 - 17h)</span>
                        </div>
                        <div class="header__topbar-aff-left">
                            <a href="/pages/lien-he-hop-tac">Liên hệ hợp tác</a>
                        </div>
                    </div>
                    <div class="header__topbar-right">
                        <ul class="header__topbar-right-list">
                            <li><a href="/pages/he-thong-cua-hang">Tìm cửa hàng</a></li>
                            <li><a href="/pages/tra-cuu-tinh-trang-don-hang">Kiểm tra đơn hàng</a></li>
                            <li><a href="https://bitis.com/">Mua hàng tại Shopify</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__main">
            <div class="header__main-container-fluid">
                <div class="header__main-containner">
                    <div class="header__main-wrap-logo">
                        <div class="header__main-logo" itemscope="" itemtype="http://schema.org/Organization">
                            <a href='./home.php' itemprop='url'>
                                <img id='logo' src='../../public/access/imgs/RedEVIL.svg' alt='' />

                                <style>
                                    /* Áp dụng CSS cho thẻ <img> */
                                    #logo {
                                        width: 200px;
                                        /* Chiều rộng ảnh */
                                        height: 50px;
                                        /* Chiều cao ảnh được tự động tính toán để giữ nguyên tỉ lệ */
                                    }
                                </style>
                            </a>
                            <h1 style="display: none">
                                <a href="https://bitis.com.vn" itemprop="url">Biti's</a>
                            </h1>
                        </div>
                    </div>
                    <div class="header__main-wrap-menu">
                        <nav class="header__main-navbar-menu">
                            <ul class="header__main-menuList-primary">

                                <?php
                                include_once "../config/database.php";
                                include_once "../../libs/session.php";

                                $db = new Database();

                                $sql = "SELECT TITLE, CATEGORY_ID
                                FROM categories 
                                WHERE PARENT_CATEGORY_ID IS NULL;";

                                $result = $db->query($sql);

                                $rows = array();

                                while ($temp = $result->fetch_assoc()) {
                                    $rows[] = $temp;
                                }

                                function getChildCategory($db, $parent_id)
                                {
                                    $sql = "SELECT TITLE, CATEGORY_ID
                                    FROM categories 
                                    WHERE PARENT_CATEGORY_ID = $parent_id;";
                                    $list_details = "";

                                    $result = $db->fetchAll($sql);

                                    foreach ($result as $row) {
                                        $list_details .= "
                                                <li class=''>
                                                    <a href='./collection.php?value={$row['CATEGORY_ID']}&title={$row['TITLE']}'>
                                                        {$row['TITLE']}
                                                    </a>
                                                </li>
                                                ";
                                    }

                                    return $list_details;
                                }

                                $view_parent = "<li class='header__main-has-submenu'>
                                                    <a href='./home.php'> VỀ RedDEVIL </a>
                                                </li>";

                                foreach ($rows as $temp) {
                                    $check_parent = "";
                                    $list_details = getChildCategory($db, $temp['CATEGORY_ID']);

                                    if ($list_details !== "") {
                                        $check_parent = "<i class='fa fa-chevron-down' aria-hidden='true'></i>";
                                    }

                                    $view_parent .= "
                                    <li class='header__main-has-submenu'>
                                        <a href='./collection.php?value={$temp['CATEGORY_ID']}&title={$temp['TITLE']}'>
                                            {$temp['TITLE']}
                                            $check_parent
                                        </a>
                                        <ul class='header__main-menuList-submain'>
                                            $list_details
                                        </ul>
                                    </li>   
                                    ";
                                }

                                //     $view_parent .= "<li class='header__main-has-submenu'>
                                //     <a href='./promotion.php'> KHUYẾN MÃI </a>
                                // </li>";
                                
                                echo $view_parent;

                                ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="header__action">
                        <div class="header__action-inner">
                            <div class="header__action-item header__action-search-wrap">
                                <div class="header__action-search sitenav-content sitenav-search">
                                    <div class="header__action-search-box">
                                        <form action="/search" class="searchform searchform-categoris ultimate-search">
                                            <div class="wpo-search-inner">
                                                <input type="hidden" name="type" value="product" />
                                                <input value="" required="" id="inputSearchAuto" class="input-search"
                                                    name="value" maxlength="40" autocomplete="off" type="text" size="20"
                                                    placeholder="Bạn cần tìm gì..." />
                                            </div>
                                            <button type="submit" class="btn-search btn" id="search-header-btn"
                                                aria-label="button search">
                                                <svg version="1.1" class="svg search" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    viewBox="0 0 24 27" style="enable-background: new 0 0 24 27"
                                                    xml:space="preserve">
                                                    <path
                                                        d="M10,2C4.5,2,0,6.5,0,12s4.5,10,10,10s10-4.5,10-10S15.5,2,10,2z M10,19c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7S13.9,19,10,19z">
                                                    </path>
                                                    <rect x="17" y="17"
                                                        transform="matrix(0.7071 -0.7071 0.7071 0.7071 -9.2844 19.5856)"
                                                        width="4" height="8"></rect>
                                                </svg>
                                            </button>
                                        </form>
                                        <div id="search-results" class="smart-search-wrapper search-results">
                                            <div class="results-content" style="display: none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="header__action-item header__action-account">
                                <div class="header__action-item-text">
                                    <div class="header__action-item-link" id="site-account-handle"
                                        aria-label="Tài khoản" title="Tài khoản">
                                        <span class="box-icon">
                                            <svg class="svg-ico-account" xmlns="http://www.w3.org/2000/svg"
                                                version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0"
                                                y="0" viewBox="0 0 512 512" style="enable-background: new 0 0 512 512"
                                                xml:space="preserve">
                                                <g>
                                                    <g xmlns="http://www.w3.org/2000/svg">
                                                        <g>
                                                            <path
                                                                d="M510.702,438.722c-2.251-10.813-12.84-17.754-23.657-15.503c-10.814,2.251-17.755,12.843-15.503,23.656 c1.297,6.229-0.248,12.613-4.236,17.519c-2.31,2.841-7.461,7.606-15.999,7.606H60.693c-8.538,0-13.689-4.766-15.999-7.606 c-3.989-4.905-5.533-11.29-4.236-17.519c20.756-99.695,108.691-172.521,210.24-174.977c1.759,0.068,3.526,0.102,5.302,0.102 c1.782,0,3.556-0.035,5.322-0.103c71.532,1.716,137.648,37.947,177.687,97.66c6.151,9.175,18.574,11.625,27.75,5.474 c9.174-6.151,11.625-18.575,5.473-27.749c-32.817-48.944-80.47-84.534-134.804-102.417C370.538,220.036,392,180.477,392,136 C392,61.01,330.991,0,256,0S120,61.01,120,136c0,44.504,21.488,84.084,54.633,108.911c-30.368,9.998-58.863,25.555-83.803,46.069 c-45.732,37.617-77.529,90.086-89.532,147.742c-3.762,18.067,0.745,36.623,12.363,50.909C25.222,503.847,42.365,512,60.693,512 h390.613c18.329,0,35.472-8.153,47.032-22.369C509.958,475.345,514.464,456.789,510.702,438.722z M160,136 c0-52.935,43.065-96,96-96s96,43.065,96,96c0,51.305-40.455,93.339-91.141,95.878c-1.617-0.03-3.237-0.045-4.859-0.045 c-1.614,0-3.228,0.016-4.84,0.046C200.465,229.35,160,187.312,160,136z"
                                                                fill="#000000" data-original="#000000"></path>
                                                        </g>
                                                    </g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                    <g xmlns="http://www.w3.org/2000/svg"></g>
                                                </g>
                                            </svg>
                                            <span class="box-icon--close">
                                                <svg viewBox="0 0 19 19" role="presentation">
                                                    <path
                                                        d="M9.1923882 8.39339828l7.7781745-7.7781746 1.4142136 1.41421357-7.7781746 7.77817459 7.7781746 7.77817456L16.9705627 19l-7.7781745-7.7781746L1.41421356 19 0 17.5857864l7.7781746-7.77817456L0 2.02943725 1.41421356.61522369 9.1923882 8.39339828z"
                                                        fill-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                    <span class="box-triangle">
                                        <svg viewBox="0 0 20 9" role="presentation">
                                            <path
                                                d="M.47108938 9c.2694725-.26871321.57077721-.56867841.90388257-.89986354C3.12384116 6.36134886 5.74788116 3.76338565 9.2467995.30653888c.4145057-.4095171 1.0844277-.40860098 1.4977971.00205122L19.4935156 9H.47108938z"
                                                fill="#ffffff"></path>
                                        </svg>
                                    </span>
                                </div>
                                <!-- fomr login -->
                                <div class="header__action-dropdown">
                                    <?php
                                    if (isset($is_login)) {
                                        echo $is_login;
                                    } else {
                                        echo $nologin;
                                    }
                                    ?>
                                </div>
                                <!-- end -->
                            </div>
                            <div class="header__action-item header__action-wishlist">
                                <div class="header__action-item-text">
                                    <div class="header__action-item-link">
                                        <span class="box-icon">
                                            <svg class="svg-ico-wishlist" xmlns="http://www.w3.org/2000/svg"
                                                version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0"
                                                y="0" viewBox="0 0 512 512" style="enable-background: new 0 0 512 512"
                                                xml:space="preserve">
                                                <g>
                                                    <g xmlns="http://www.w3.org/2000/svg" id="_1_Heart"
                                                        data-name="1 Heart">
                                                        <path
                                                            d="m256.1 506a25 25 0 0 1 -17.68-7.35l-.2-.2-197.55-197.45c-54.12-54.13-54.12-142.2 0-196.33s142.2-54.12 196.33 0l19.1 19.1 18.9-18.9a138.83 138.83 0 0 1 196.33 0c54.12 54.13 54.12 142.2 0 196.33l-81.22 81.21a25 25 0 0 1 -35.35-35.41l81.24-81.2a88.82 88.82 0 0 0 -125.64-125.61l-36.58 36.58a25 25 0 0 1 -35.36 0l-36.78-36.77a88.82 88.82 0 0 0 -125.64 125.6l180.1 180.07 19.13-19.13a25 25 0 0 1 35.36 35.35l-36.81 36.82a25 25 0 0 1 -17.68 7.29z"
                                                            fill="#000000" data-original="#000000" class=""></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <span class="box-icon--close">
                                                <svg viewBox="0 0 19 19" role="presentation">
                                                    <path
                                                        d="M9.1923882 8.39339828l7.7781745-7.7781746 1.4142136 1.41421357-7.7781746 7.77817459 7.7781746 7.77817456L16.9705627 19l-7.7781745-7.7781746L1.41421356 19 0 17.5857864l7.7781746-7.77817456L0 2.02943725 1.41421356.61522369 9.1923882 8.39339828z"
                                                        fill-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                            <span class="count-holder">
                                                <span class="count" id="onAppWishList_numberLike"
                                                    style="display: block">0</span>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="header__action-item header__action-cart">
                                <div class="header__action-item-text">
                                    <div class="header__action-item-link header__action-item-clicked"
                                        id="site-cart-handle" aria-label="Giỏ hàng" title="Giỏ hàng">
                                        <span class="box-icon">
                                            <svg class="svg-ico-cart" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0"
                                                y="0" viewBox="0 0 32 32" style="enable-background: new 0 0 512 512"
                                                xml:space="preserve">
                                                <g>
                                                    <g xmlns="http://www.w3.org/2000/svg" id="Layer_2"
                                                        data-name="Layer 2">
                                                        <path
                                                            d="m16 17.82a6 6 0 0 1 -5.89-4.82 1 1 0 0 1 1-1.15 1 1 0 0 1 1 .83 4 4 0 0 0 7.83 0 1 1 0 0 1 1-.83 1 1 0 0 1 1 1.15 6 6 0 0 1 -5.94 4.82z"
                                                            fill="#000000" data-original="#000000" class=""></path>
                                                        <path
                                                            d="m24.9 31h-17.8a3 3 0 0 1 -3-3.15l.81-17.24a3 3 0 0 1 3-2.87h16.18a3 3 0 0 1 3 2.87l.81 17.24a3 3 0 0 1 -3 3.15zm-16.99-21.25a1 1 0 0 0 -1 1l-.81 17.2a1 1 0 0 0 1 1.05h17.8a1 1 0 0 0 1-1.05l-.81-17.24a1 1 0 0 0 -1-1z"
                                                            fill="#000000" data-original="#000000" class=""></path>
                                                        <path
                                                            d="m22 8.75h-2v-1.75a4 4 0 0 0 -8 0v1.75h-2v-1.75a6 6 0 0 1 12 0z"
                                                            fill="#000000" data-original="#000000" class=""></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <span class="box-icon--close">
                                                <svg viewBox="0 0 19 19" role="presentation">
                                                    <path
                                                        d="M9.1923882 8.39339828l7.7781745-7.7781746 1.4142136 1.41421357-7.7781746 7.77817459 7.7781746 7.77817456L16.9705627 19l-7.7781745-7.7781746L1.41421356 19 0 17.5857864l7.7781746-7.77817456L0 2.02943725 1.41421356.61522369 9.1923882 8.39339828z"
                                                        fill-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                            <span class="count-holder">
                                                <span id="cartCount" class="count">
                                                    <?php
                                                    if (isset($count_cart)) {
                                                        echo $count_cart;
                                                    } else {
                                                        echo 0;
                                                    }
                                                    ?>
                                                </span>
                                            </span>
                                        </span>
                                    </div>
                                    <span class="box-triangle">
                                        <svg viewBox="0 0 20 9" role="presentation">
                                            <path
                                                d="M.47108938 9c.2694725-.26871321.57077721-.56867841.90388257-.89986354C3.12384116 6.36134886 5.74788116 3.76338565 9.2467995.30653888c.4145057-.4095171 1.0844277-.40860098 1.4977971.00205122L19.4935156 9H.47108938z"
                                                fill="#ffffff"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="header__action-dropdown">
                                    <div class="header__action-dropdown_content">
                                        <div class="sitenav-content sitenav-cart">
                                            <p class="boxtitle">Giỏ hàng</p>
                                            <div class="cart-view clearfix">
                                                <div class="cart-view-scroll">
                                                    <?php
                                                    if (isset($customer_cart)) {
                                                        echo $customer_cart;
                                                    }
                                                    ?>
                                                </div>
                                                <div class="cart-view-line"></div>
                                                <div class="cart-view-total">
                                                    <table class="table-total">
                                                        <tbody>
                                                            <tr>
                                                                <td class="mnc-total text-left">TỔNG TIỀN:</td>
                                                                <td class="mnc-total text-right" id="total-view-cart">
                                                                    <?php
                                                                    if (isset($total_cart)) {
                                                                        $price_string = number_format($total_cart, 0, ',', '.');
                                                                        echo $price_string;
                                                                    }
                                                                    ?>
                                                                    ₫
                                                                </td>
                                                            </tr>
                                                            <tr class="mini-cart__button">
                                                                <td colspan="2">
                                                                    <a href="#" onclick="checkLogin()"
                                                                        class="linktocart button">Xem
                                                                        giỏ
                                                                        hàng</a>
                                                                </td>
                                                            </tr>
                                                            <script>
                                                                function checkLogin() {
                                                                    const url = '../api/CustommerAPI.php';
                                                                    const data = {
                                                                        action: 'login',
                                                                    };

                                                                    fetch(url, {
                                                                        method: 'POST',
                                                                        headers: {
                                                                            'Content-Type': 'application/json'
                                                                        },
                                                                        body: JSON.stringify(data)
                                                                    })
                                                                        .then(response => {
                                                                            if (response.ok) {
                                                                                return response.json();
                                                                            } else {
                                                                                throw new Error('Error:', response
                                                                                    .statusText);
                                                                            }
                                                                        })
                                                                        .then(data => {
                                                                            if (data[0] === true) {
                                                                                window.location.href = './cart.php';
                                                                            } else {
                                                                                alert(
                                                                                    'Bạn cần đăng nhập để xem giỏ hàng.'
                                                                                );
                                                                            }
                                                                        })
                                                                        .catch(error => {
                                                                            console.error(error);
                                                                        });
                                                                }
                                                            </script>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="header__action-item">
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-sidebar wishlist">
            <div class="header-sidebar__header">
                <svg class="close" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                    y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                    <g>
                        <path
                            d="M500,442.7L79.3,22.6C63.4,6.7,37.7,6.7,21.9,22.5C6.1,38.3,6.1,64,22,79.9L442.6,500L22,920.1C6,936,6.1,961.6,21.9,977.5c15.8,15.8,41.6,15.8,57.4-0.1L500,557.3l420.7,420.1c16,15.9,41.6,15.9,57.4,0.1c15.8-15.8,15.8-41.5-0.1-57.4L557.4,500L978,79.9c16-15.9,15.9-41.5,0.1-57.4c-15.8-15.8-41.6-15.8-57.4,0.1L500,442.7L500,442.7z">
                        </path>
                    </g>
                </svg>
                Yêu thích
            </div>
            <div id="onAppWishList_page" class="header-sidebar__content" style="display: block">
                <div>
                    <div class="header-sidebar__main-content_bottom clearfix">
                        <div class="header-sidebar__main-content-left clearfix">
                            <div>
                                <table class="table-wishlist">
                                    <thead>
                                        <tr>
                                            <th class="customer-wishlist-item-info" colspan="2">
                                                Mô tả sản phẩm
                                            </th>
                                            <th class="customer-wishlist-item-info">Giá</th>
                                            <th class="customer-wishlist-item-info"></th>
                                            <th class="customer-wishlist-item-remove"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="wish-list"></tbody>
                                </table>
                                <div class="wishlist_empty_wrap" style="display: none"></div>
                            </div>
                        </div>
                    </div>
                    <div id="onAppWishList_nextPageWishList" class="clearfix text-center" style="display: none">
                        <button id="nextPageWishList" class="col-md-2 col-md-push-5 btn btn-info">
                            XEM THÊM
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-sidebar__modal"></div>
    </header>



    <!-- Main -->

    <main class="main">
        <!-- MAIN HEHE -->
        <div class="layout_cart">
            <div class="header_cart">
                <div class="container">
                    <h2><a href="#">Trang chủ</a></h2>
                    <h2>/</h2>
                    <h2>Giỏ Hàng</h2>
                </div>
            </div>
            <div class="content_cart">
                <div class="container">
                    <div class="row">
                        <div class="row_left">
                            <div class="main_cart_detail">
                                <h1 class="heading-cart">Giỏ hàng của bạn</h1>

                                <div class="content_detail">
                                    <div class="cart_row">
                                        <p class="title-number-cart">
                                            Bạn đang có
                                            <strong class="count-cart">
                                                <?php
                                                if (isset($count_cart)) {
                                                    echo $count_cart;
                                                } else {
                                                    echo 0;
                                                } ?> sản phẩm
                                            </strong>
                                            trong giỏ hàng
                                        </p>

                                        <div class="table_product_cart">

                                            <?php
                                            if (isset($customer_cart_page)) {
                                                echo $customer_cart_page;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="cart_note">
                                        <label class="note-label">Ghi chú đơn hàng</label>
                                        <div class="text_area">
                                            <textarea class="form-note" id="note" name="note" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row_right">
                            <div class="block_1">
                                <h2 class="summary-title">Thông tin đơn hàng</h2>

                                <div class="summary-total">
                                    <p>Tổng tiền: <span>
                                            <?php
                                            if (isset($total_cart)) {
                                                $price_string = number_format($total_cart, 0, ',', '.');
                                                echo $price_string;
                                            }
                                            ?> ₫
                                        </span></p>
                                </div>
                                <div class="summary-action">
                                    <p>Phí vận chuyển sẽ được tính ở trang thanh toán.</p>

                                    <div class="summary-alert alert alert-danger"></div>
                                </div>
                                <button id="btn_payment" class="btn_thanhtoan">THANH TOÁN NGAY</button>

                                <script>
                                    const btnPayment = document.querySelector("#btn_payment");

                                    btnPayment.onclick = (e) => {
                                        var check_count_active;
                                        <?php

                                        if (isset($count_cart) && $count_cart > 0) {
                                            echo "check_count_active = true";
                                        }
                                        ?>

                                        if (check_count_active) {
                                            window.location.href = './payment.php'
                                        } else {
                                            alert("Bạn phải mua hàng trước khi thanh toán!")
                                        }
                                    }
                                </script>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php echo $footer; ?>
</body>

<script type="module" src='../../public/js/header.js'></script>
<script src='../../public/js/cart.js'></script>

</html>