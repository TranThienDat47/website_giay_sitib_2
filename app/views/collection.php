<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../public/css/collection/main.css">
    <link rel="stylesheet" href="../../public/css/collection/base.css">
    <link rel="stylesheet" href="../../public/css/main.css">
    <link rel="stylesheet" href="../../public/css/base.css">
    <link rel="stylesheet" href="../../public/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <script type="module" src="../../public/js/home.js"></script>
    <?php include_once './index.php' ?>

</head>

<body>
    <?php include_once '../others/checkLoginCustomer.php' ?>


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
    <main class="wrapperMain_content">
        <div class="layout-collection collection">
            <div class="breadcrumb-shop">
                <div class="container">
                    <div class="breadcrumb-list">
                        <ol class="breadcrumb breadcrumb-arrows" itemscope itemtype="http://schema.org/BreadcrumbList">
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a href="./home.php" target="_self" itemprop="item"><span itemprop="name">Trang
                                        chủ</span></a>
                                <meta itemprop="position" content="1" />
                            </li>
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a href="#" target="_self" itemprop="item"><span itemprop="name">Danh mục</span>
                                </a>
                                <meta itemprop="position" content="2" />
                            </li>
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <span itemprop="item" content="https://bitis.com.vn/collections/nam"><strong
                                        id="category__loaction" itemprop="name">
                                    </strong></span>
                                <meta itemprop="position" content="3" />
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="wrapper-mainCollection">
                <div class="collection-listproduct" id="collection-body">
                    <!--- Banner --->
                    <!-- <div class="collection-banner-header">
                     <img
                        class="lazyload"
                        data-src="https://file.hstatic.net/1000230642/collection/web_banner___phien_ban_40_nam_dcc89c653e48402e9d9b5d22b29612b9.png"
                        src="https://file.hstatic.net/1000230642/collection/web_banner___phien_ban_40_nam_dcc89c653e48402e9d9b5d22b29612b9.png"
                        alt="NAM"
                     />
                  </div> -->
                    <div class="slideshow-container">
                        <div class="mySlides fade">
                            <img src="https://file.hstatic.net/1000230642/file/z3852890425931_d965e3f74c7ba7d039c288f107d45ab1_68fef71d5f0d4275ab108d22e5287711.jpg"
                                style="width: 100%" />
                        </div>

                        <div class="mySlides fade">
                            <img src="https://file.hstatic.net/1000230642/file/z3812523573570_df5bb0a6413c29e0176db9d5223a50c6_c2e15d8184214224905fe5d615866b21.jpg"
                                style="width: 100%" />
                        </div>

                        <div class="mySlides fade">
                            <img src="https://file.hstatic.net/1000230642/file/bst-sandal_4810db1766c143d0a634f221fdd43b27.jpg"
                                style="width: 100%" />
                        </div>
                        <div style="
                           text-align: center;
                           position: absolute;
                           bottom: 10px;
                           left: 0;
                           right: 0;
                        ">
                            <span class="dot" slide_rank="1"></span>
                            <span class="dot" slide_rank="2"></span>
                            <span class="dot" slide_rank="3"></span>
                        </div>
                    </div>
                    <!-- Text Slide -->
                    <div class="text-slide"></div>

                    <!-- Container Product -->
                    <div class="container">
                        <div class="row">
                            <div class="collection-content">
                                <div class="collection-heading">
                                    <div class="row">
                                        <div class="collection-type">
                                            <div class="section-heading-type d-flex align-items-center">
                                                <h3 id="collection_title_category">
                                                </h3>
                                                <div class="menu-tab-item">
                                                    <ul id="collection_list_category" class="d-flex">

                                                        <?php

                                                        if (isset($_GET['value'])) {
                                                            $value = $_GET['value'];
                                                            $list_details = getChildCategory($db, $value);
                                                            echo $list_details;
                                                        }

                                                        ?>

                                                        <!-- <li>
                                                            <a class="" href="/collections/hunter-nam">Hunter</a>
                                                        </li>
                                                        <li>
                                                            <a class="" href="/collections/sandal-nam-1">Sandal</a>
                                                        </li>
                                                        <li>
                                                            <a class="" href="/collections/giay-the-thao-nam">Giày Thể
                                                                Thao</a>
                                                        </li>
                                                        <li>
                                                            <a class="" href="/collections/hunter-running-nam">Giày Chạy
                                                                Bộ</a>
                                                        </li>
                                                        <li>
                                                            <a class="" href="/collections/giay-da-banh">Giày Đá
                                                                Banh</a>
                                                        </li>
                                                        <li>
                                                            <a class="" href="/collections/giay-tay-nam">Giày Tây</a>
                                                        </li>
                                                        <li>
                                                            <a class="" href="/collections/giay-bao-ho">Giày Bảo Hộ</a>
                                                        </li>
                                                        <li>
                                                            <a class="" href="/collections/dep-nam">Dép</a>
                                                        </li>
                                                        <li>
                                                            <a class="" href="/collections/phu-kien/Phukien">Phụ
                                                                Kiện</a>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collection-filter">
                                            <div class="filter-left-box">
                                                <div class="filter-box">
                                                    <span class="title-count d-block d-sm-none"><b>153</b> sản
                                                        phẩm</span>
                                                    <div class="filter-desktop align-items-center d-flex">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-sliders2"
                                                            viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5ZM12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5ZM1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8Zm9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5Zm1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z" />
                                                        </svg>
                                                        <div class="filter-desktop-item">
                                                            Màu sắc
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-chevron-down" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd"
                                                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                                            </svg>
                                                            <div class="filter-list color">
                                                                <div class="filter-list-box filter-color">
                                                                    <ul class="checkbox-list clearfix">
                                                                        <li>
                                                                            <input type="checkbox" id="data-color-p1"
                                                                                value="Tím" name="color-filter"
                                                                                data-color="(variant:product contains Tím)" />
                                                                            <label for="data-color-p1"
                                                                                style="background-color: #eb11eb">Tím</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox" id="data-color-p2"
                                                                                value="Vàng" name="color-filter"
                                                                                data-color="(variant:product contains Vàng)" />
                                                                            <label for="data-color-p2"
                                                                                style="background-color: #ffff05">Vàng</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox" id="data-color-p3"
                                                                                value="Cam" name="color-filter"
                                                                                data-color="(variant:product contains Cam)" />
                                                                            <label for="data-color-p3"
                                                                                style="background-color: #f54105">Cam</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox" id="data-color-p4"
                                                                                value="Hồng" name="color-filter"
                                                                                data-color="(variant:product contains Hồng)" />
                                                                            <label for="data-color-p4"
                                                                                style="background-color: #f23895">Hồng</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox" id="data-color-p5"
                                                                                value="Đen" name="color-filter"
                                                                                data-color="(variant:product contains Đen)" />
                                                                            <label for="data-color-p5"
                                                                                style="background-color: #000000">Đen</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox" id="data-color-p6"
                                                                                value="Xám" name="color-filter"
                                                                                data-color="(variant:product contains Xám)" />
                                                                            <label for="data-color-p6"
                                                                                style="background-color: #cccaca">Xám</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox" id="data-color-p7"
                                                                                value="Trắng" name="color-filter"
                                                                                data-color="(variant:product contains Trắng)" />
                                                                            <label for="data-color-p7"
                                                                                style="background-color: #fffcfc">Trắng</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox" id="data-color-p8"
                                                                                value="Xanh dương" name="color-filter"
                                                                                data-color="(variant:product contains Xanh dương)" />
                                                                            <label for="data-color-p8"
                                                                                style="background-color: #1757eb">Xanh
                                                                                dương</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox" id="data-color-p9"
                                                                                value="Xanh" name="color-filter"
                                                                                data-color="(variant:product contains Xanh)" />
                                                                            <label for="data-color-p9"
                                                                                style="background-color: #099116">Xanh</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox" id="data-color-p10"
                                                                                value="Xanh lá" name="color-filter"
                                                                                data-color="(variant:product contains Xanh lá)" />
                                                                            <label for="data-color-p10"
                                                                                style="background-color: #52ff52">Xanh
                                                                                lá</label>
                                                                        </li>
                                                                        <li>
                                                                            <input type="checkbox" id="data-color-p11"
                                                                                value="Đỏ" name="color-filter"
                                                                                data-color="(variant:product contains Đỏ)" />
                                                                            <label for="data-color-p11"
                                                                                style="background-color: #ff0000">Đỏ</label>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="filter-desktop-item">
                                                            Kích thước
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-chevron-down" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd"
                                                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                                            </svg>
                                                            <div class="filter-list size">
                                                                <div class="filter-list-box filter-size">
                                                                    <ul class="checkbox-list">
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p1" value="24"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=24)" />
                                                                            <label for="data-size-p1">24</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p2" value="25"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=25)" />
                                                                            <label for="data-size-p2">25</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p3" value="26"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=26)" />
                                                                            <label for="data-size-p3">26</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p4" value="27"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=27)" />
                                                                            <label for="data-size-p4">27</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p5" value="28"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=28)" />
                                                                            <label for="data-size-p5">28</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p6" value="29"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=29)" />
                                                                            <label for="data-size-p6">29</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p7" value="30"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=30)" />
                                                                            <label for="data-size-p7">30</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p8" value="31"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=31)" />
                                                                            <label for="data-size-p8">31</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p9" value="32"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=32)" />
                                                                            <label for="data-size-p9">32</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p10" value="33"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=33)" />
                                                                            <label for="data-size-p10">33</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p11" value="34"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=34)" />
                                                                            <label for="data-size-p11">34</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p12" value="35"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=35)" />
                                                                            <label for="data-size-p12">35</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p13" value="36"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=36)" />
                                                                            <label for="data-size-p13">36</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p14" value="37"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=37)" />
                                                                            <label for="data-size-p14">37</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p15" value="38"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=38)" />
                                                                            <label for="data-size-p15">38</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p16" value="39"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=39)" />
                                                                            <label for="data-size-p16">39</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p17" value="40"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=40)" />
                                                                            <label for="data-size-p17">40</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p18" value="41"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=41)" />
                                                                            <label for="data-size-p18">41</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p19" value="42"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=42)" />
                                                                            <label for="data-size-p19">42</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p20" value="43"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=43)" />
                                                                            <label for="data-size-p20">43</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p21" value="44"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=44)" />
                                                                            <label for="data-size-p21">44</label>
                                                                        </li>
                                                                        <li>
                                                                            <input class="d-none" type="checkbox"
                                                                                id="data-size-p22" value="45"
                                                                                name="size-filter"
                                                                                data-size="(variant:product=45)" />
                                                                            <label for="data-size-p22">45</label>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="filter-desktop-item">
                                                            Giá
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-chevron-down" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd"
                                                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                                            </svg>
                                                            <div class="filter-list price">
                                                                <ul class="filter-list-box price-range">
                                                                    <li>
                                                                        <div class="amount-wrapper">
                                                                            <label for="amount">Giá từ:</label>
                                                                            <span id="amount-text">0 đ - 2,000,000
                                                                                đ</span>
                                                                            <input type="hidden" minpricesearch="0"
                                                                                maxpricesearch="2000000" id="amount"
                                                                                readonly style="
                                                                  border: 0;
                                                                  color: #f6931f;
                                                                  font-weight: bold;
                                                               " />
                                                                        </div>
                                                                        <div id="slider-range" data-value=""
                                                                            class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                                                            <div class="ui-slider-range ui-corner-all ui-widget-header"
                                                                                style="left: 0%; width: 100%"></div>
                                                                            <span tabindex="0"
                                                                                class="ui-slider-handle ui-corner-all ui-state-default"
                                                                                style="left: 0%"></span>
                                                                            <span tabindex="0"
                                                                                class="ui-slider-handle ui-corner-all ui-state-default"
                                                                                style="left: 100%"></span>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="filter-right-box">
                                                <div class="collection-sortbyfilter-container">
                                                    <div class="collection-sortby-filter">
                                                        <div class="collection-filterby">
                                                            <div class="layered_filter_title boxstyle-mb"
                                                                data-layered-click="#layered_filter_mobile">
                                                                <p class="title_filter">
                                                                    <span class="icon-filter"><svg viewBox="0 0 20 20">
                                                                            <path fill="none" stroke-width="2"
                                                                                stroke-linejoin="round"
                                                                                stroke-miterlimit="10"
                                                                                d="M12 9v8l-4-4V9L2 3h16z"></path>
                                                                        </svg>
                                                                    </span>
                                                                    <span class="icon-close"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24">
                                                                            <path
                                                                                d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z">
                                                                            </path>
                                                                        </svg>
                                                                    </span>
                                                                    Bộ lọc
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="collection-sortby">
                                                            <div class="layered_filter_title boxstyle-mb"
                                                                data-layered-click="#layered_sortby_mobile">
                                                                <p class="title_filter">
                                                                    <span class="icon-filter d-none"><i
                                                                            class="fa fa-sort-alpha-asc"
                                                                            aria-hidden="true"></i></span>
                                                                    <span class="icon-close"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24">
                                                                            <path
                                                                                d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z">
                                                                            </path>
                                                                        </svg>
                                                                    </span>
                                                                    Sắp xếp theo
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="collection-sortby-option layered_filter_mobileContent"
                                                        id="layered_sortby_mobile">
                                                        <ul class="sort-by sort-by-content">
                                                            <li class="d-none">
                                                                <span data-value="manual" data-filter="">Sản phẩm nổi
                                                                    bật</span>
                                                            </li>
                                                            <li>
                                                                <span data-value="price-ascending"
                                                                    data-filter="(price:product=asc)">Giá: Tăng
                                                                    dần</span>
                                                            </li>
                                                            <li>
                                                                <span data-value="price-descending"
                                                                    data-filter="(price:product=desc)">Giá: Giảm
                                                                    dần</span>
                                                            </li>
                                                            <li>
                                                                <span data-value="title-ascending"
                                                                    data-filter="(title:product=asc)">Tên:
                                                                    A-Z</span>
                                                            </li>
                                                            <li>
                                                                <span data-value="title-descending"
                                                                    data-filter="(title:product=desc)">Tên:
                                                                    Z-A</span>
                                                            </li>
                                                            <li>
                                                                <span data-value="created-ascending"
                                                                    data-filter="(updated_at:product=asc)">Cũ
                                                                    nhất</span>
                                                            </li>
                                                            <li>
                                                                <span data-value="created-descending"
                                                                    data-filter="(updated_at:product=desc)">Mới
                                                                    nhất</span>
                                                            </li>
                                                            <li class="d-none">
                                                                <span data-value="best-selling"
                                                                    data-filter="(sold_quantity:product=desc)">Bán
                                                                    chạy
                                                                    nhất</span>
                                                            </li>
                                                            <li class="d-none">
                                                                <span data-value="quantity-descending"
                                                                    data-filter="(quantity:product=desc)">Tồn
                                                                    kho giảm
                                                                    dần</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collection-description">
                                            <div class="active-filter">
                                                <div class="price d-none">
                                                    150,000 đ - 2,000,000 đ
                                                    <i class="fa-sharp fa-solid fa-circle-xmark"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wraplist-collection">
                                    <div class="row collection-list">
                                        <!-- Xem thêm -->
                                    </div>
                                    <div class="collection-loadmore text-center view-more-collection">
                                        <button class="button btn-loadmore">CÒN NHIỀU
                                            LẮM, XEM THÊM</button>
                                    </div>
                                </div>
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
<script type="module" src='../../public/js/collection.js'></script>

</html>