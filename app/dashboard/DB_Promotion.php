<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khuyến mãi</title>
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <?php include "./Layout/navbar.php"; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/header_db.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="./js/DB_Promotion.js"></script>
    <link rel="stylesheet" href="./css/DB_Promotion.css">
</head>


<body>
    <!-- Header -->
    <?php echo $header; ?>


    <!-- Main -->
    <main id="main">
        <div class="main-dashboard__promotion">
            <div class="main-dashboard__promotion-header">
                <h2 class="main-dashboard__promotion-title">Danh sách chương trình khuyến mãi</h2>
                <button class="btn main-dashboard__promotion-add">
                    <i class="fa-solid fa-plus"></i>
                    Thêm khuyến mãi
                </button>
            </div>
            <div class="main-dashboard__promotion-handle">
                <div class="main-dashboard__promotion-handle-search-wrapper">
                    <button class="main-dashboard__promotion-handle-search-icon">
                        <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"
                            style="pointer-events: none; display: block; width: 28px; height: 28px">
                            <g>
                                <path d="M21,6H3V5h18V6z M18,11H6v1h12V11z M15,17H9v1h6V17z"></path>
                            </g>
                        </svg>
                    </button>
                    <div class="main-dashboard__promotion-handle-search">
                        <input type="text" placeholder="Tìm kiếm..." />
                    </div>
                </div>
            </div>
            <table class="main-dashboard__promotion-table">
                <tr>
                    <th>Số khuyến mãi</th>
                    <th>Tên chương trình</th>
                    <th>Phần trăm giảm (%)</th>
                    <th>Sản phẩm áp dụng</th>
                    <th style="width: 7%"></th>
                </tr>
                <tbody class="main-dashboard__promotion-item-wrapper">
                    <tr class="main-dashboard__promotion-item">
                        <td class="main-dashboard__promotion-item-proc">
                            <p>1</p>
                        </td>
                        <td class="main-dashboard__promotion-item-id">
                            <p>Khuyến mãi đầu xuân</p>
                        </td>
                        <td class="main-dashboard__promotion-item-color">
                            <p>5</p>
                        </td>
                        <td class="main-dashboard__promotion-item-qty">
                            <a>Chi tiết</a>
                        </td>
                        <td class="main-dashboard__promotion-item-control">
                            <div>
                                <div
                                    class="main-dashboard__promotion-item-icon main-dashboard__promotion-item-pause-play pause">
                                    <i class="fa-regular fa-circle-pause pause"></i>
                                    <i class="fa-solid fa-play play"></i>
                                </div>
                                <div class="main-dashboard__promotion-item-icon main-dashboard__promotion-item-delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>



    <!-- TABLE ADD PPOMOTION PRODUCT -->


    <div class="dasboard-promotion-add">
        <div class="dasboard-promotion-add__wrapper">
            <h4>Nhập thông tin chương trình khuyến mãi</h4>
            <hr />
            <form class="dasboard-promotion-add__form">
                <div class="dasboard-promotion-add__wrapper-text">
                    <label for="id_product">Số khuyến mãi:</label>
                    <input type="text" name="id_product" value="0" id="id_product" disabled />
                </div>
                <div class="dasboard-promotion-add__wrapper-text">
                    <label for="name_product">Tên chương trình:</label>
                    <input type="text" name="name_product" id="name_product" placeholder="Nhập tên sản phẩm" />
                </div>
                <div class="dasboard-promotion-add__wrapper-text">
                    <label for="percent_promotion">Phần trăm giảm (%):</label>
                    <input type="number" name="percent_promotion" value="1" min="1" max="100" id="percent_promotion" />
                </div>
                <div class="dasboard-promotion-add__wrapper-text dasboard-promotion__list-proc-wrapper">
                    <label>Sản phẩm áp dụng:</label>
                    <div>
                        <table class="dasboard-promotion__list-proc">
                            <tr>
                                <th style="width: 18%">
                                    <div style="display: flex; flex-direction: row-reverse">
                                        <label style="user-select: none" for="select__all">Chọn tất cả</label>
                                        <input style="margin-right: 8px" id="select__all" type="checkbox"
                                            value="Chọn tất cả" name="select__all" />
                                    </div>
                                </th>
                                <th>Sản phẩm</th>
                                <th style="width: 14%">Giá</th>
                                <th style="width: 17%">Mã sản phẩm</th>
                            </tr>
                            <tbody class="dasboard-promotion__list-proc-item-wrapper">
                                <tr class="dasboard-promotion__list-proc-item">
                                    <td class="dasboard-promotion__list-proc-item-check">
                                        <div style="
                                       display: flex;
                                       justify-content: center;
                                       align-items: center;
                                    ">
                                            <input id="select__one" type="checkbox" value="select" name="select__one"
                                                class="select__one" />
                                        </div>
                                    </td>
                                    <td class="dasboard-promotion__list-proc-item-proc">
                                        <div>
                                            <div class="dasboard-promotion__list-proc-item-img">
                                                <img src="//product.hstatic.net/1000230642/product/deb009100xdd__2__8e67af4b404145d8a3e173c58a93dde1_medium.jpg"
                                                    alt="" />
                                            </div>
                                            <h4 class="dasboard-promotion__list-proc-item-title">
                                                Sandal Eva Bé Trai DEB009100XDD (Xanh Dương Đậm)
                                            </h4>
                                        </div>
                                    </td>
                                    <td class="dasboard-promotion__list-proc-item-price">
                                        <p>5</p>
                                    </td>
                                    <td class="dasboard-promotion__list-proc-item-id">
                                        <p>123</p>
                                    </td>
                                </tr>
                                <tr class="dasboard-promotion__list-proc-item">
                                    <td class="dasboard-promotion__list-proc-item-check">
                                        <div style="
                                       display: flex;
                                       justify-content: center;
                                       align-items: center;
                                    ">
                                            <input class="select__one" id="select__one" type="checkbox" value="select"
                                                name="select__one" />
                                        </div>
                                    </td>
                                    <td class="dasboard-promotion__list-proc-item-proc">
                                        <div>
                                            <div class="dasboard-promotion__list-proc-item-img">
                                                <img src="//product.hstatic.net/1000230642/product/deb009100xdd__2__8e67af4b404145d8a3e173c58a93dde1_medium.jpg"
                                                    alt="" />
                                            </div>
                                            <h4 class="dasboard-promotion__list-proc-item-title">
                                                Sandal Eva Bé Trai DEB009100XDD (Xanh Dương Đậm)
                                            </h4>
                                        </div>
                                    </td>
                                    <td class="dasboard-promotion__list-proc-item-price">
                                        <p>5</p>
                                    </td>
                                    <td class="dasboard-promotion__list-proc-item-id">
                                        <p>123</p>
                                    </td>
                                </tr>
                                <tr class="dasboard-promotion__list-proc-item">
                                    <td class="dasboard-promotion__list-proc-item-check">
                                        <div style="
                                       display: flex;
                                       justify-content: center;
                                       align-items: center;
                                    ">
                                            <input class="select__one" id="select__one" type="checkbox" value="select"
                                                name="select__one" />
                                        </div>
                                    </td>
                                    <td class="dasboard-promotion__list-proc-item-proc">
                                        <div>
                                            <div class="dasboard-promotion__list-proc-item-img">
                                                <img src="//product.hstatic.net/1000230642/product/deb009100xdd__2__8e67af4b404145d8a3e173c58a93dde1_medium.jpg"
                                                    alt="" />
                                            </div>
                                            <h4 class="dasboard-promotion__list-proc-item-title">
                                                Sandal Eva Bé Trai DEB009100XDD (Xanh Dương Đậm)
                                            </h4>
                                        </div>
                                    </td>
                                    <td class="dasboard-promotion__list-proc-item-price">
                                        <p>5</p>
                                    </td>
                                    <td class="dasboard-promotion__list-proc-item-id">
                                        <p>123</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <input class="btn button dasboard-promotion-add__form-submit" type="submit" value="Thêm sản phẩm" />
                <button type="button" class="btn button dasboard-promotion-add__form-submit cancle">
                    Thôi
                </button>
            </form>
        </div>
    </div>
</body>

</html>