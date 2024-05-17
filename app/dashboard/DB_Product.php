<?php
ob_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhân viên</title>
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <?php include "./Layout/navbar.php"; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/header_db.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="./css/product.css">
</head>


<body>

    <?php
    include_once "../config/database.php";
    include_once "../../libs/session.php";

    $db = new Database();


    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        if (isset($_GET['action']) && isset($_GET['product_id']) && isset($_GET['new_status'])) {

            function updateStatus($db, $product_id, $new_status)
            {
                $query = "UPDATE products SET PRODUCT_STATUS = '$new_status' WHERE PRODUCT_ID = $product_id;";

                $result = $db->query($query);

                return $result;
            }

            $action = $_GET['action'];
            $product_id = $_GET['product_id'];
            $new_status = $_GET['new_status'];

            if ($action === "update_status_product") {
                if (updateStatus($db, $product_id, $new_status)) {
                    // header("Location: ./DB_Product.php", true, 302);
                    // exit();
                    echo "<script> 
                        alert('Cập nhật trạng thái sản phẩm thành công!');
                        window.location.href = './DB_Product.php';
                        </script>";
                }
            }

        }

        if (isset($_GET['action']) && isset($_GET['product_id'])) {

            function updateStatus($db, $product_id, $new_status)
            {
                $query = "UPDATE products SET PRODUCT_STATUS = '$new_status' WHERE PRODUCT_ID = $product_id;";

                $result = $db->query($query);

                return $result;
            }

            function deleteProduct($db, $product_id)
            {
                try {
                    $table = "products";

                    $condition = 'PRODUCT_ID = ' . $product_id;

                    $table = filter_var($table, FILTER_SANITIZE_STRING);
                    $condition = filter_var($condition, FILTER_SANITIZE_STRING);

                    $query = "DELETE FROM $table WHERE $condition";

                    $stmt = $db->query($query);

                    return $stmt;
                } catch (\Throwable $th) {
                    return true;
                }
            }

            $action = $_GET['action'];
            $product_id = $_GET['product_id'];

            if ($action === "delete_product") {
                if (updateStatus($db, $product_id, "Không hoạt động")) {
                    if (deleteProduct($db, $product_id)) {
                        // header("Location: ./DB_Product.php", true, 302);
                        // exit();
                        echo "<script> 
                        alert('Xóa sản phẩm thành công!');
                        window.location.href = './DB_Product.php';
                        </script>";
                    }
                }

            }
        }

        if (isset($_GET['action']) && isset($_GET['product_detail_id']) && isset($_GET['product_detail_qty'])) {

            function updateQty($db, $product_detail_id, $product_detail_qty)
            {
                $query = "UPDATE productdetails SET QTY = '$product_detail_qty' WHERE PRODUCTDETAIL_ID = $product_detail_id;";

                $result = $db->query($query);

                return $result;
            }
            function deleteProductDetail($db, $product_detail_id, $product_detail_qty)
            {
                try {
                    $table = "productdetails";

                    $condition = 'PRODUCTDETAIL_ID = ' . $product_detail_id;

                    $table = filter_var($table, FILTER_SANITIZE_STRING);
                    $condition = filter_var($condition, FILTER_SANITIZE_STRING);

                    $query = "DELETE FROM $table WHERE $condition";

                    $stmt = $db->query($query);

                    return $stmt;
                } catch (\Throwable $th) {
                    return updateQty($db, $product_detail_id, (int) -$product_detail_qty);
                }
            }


            $action = $_GET['action'];
            $product_detail_id = $_GET['product_detail_id'];
            $product_detail_qty = $_GET['product_detail_qty'];

            if ($action === "delete_product_detail") {
                if (deleteProductDetail($db, $product_detail_id, $product_detail_qty)) {
                    // header("Location: ./DB_Product.php", true, 302);
    
                    echo "<script> 
                        alert('Xóa chi tiết sản phẩm thành công!');
                        window.location.href = './DB_Product.php';
                        </script>";
                }

            }

        }

        if (isset($_GET['action']) && isset($_GET['product_detail_id'])) {

            function updateQty($db, $product_detail_id)
            {
                $query = "UPDATE productdetails SET QTY = 0 WHERE PRODUCTDETAIL_ID = $product_detail_id;";

                $result = $db->query($query);

                return $result;
            }

            $action = $_GET['action'];
            $product_detail_id = $_GET['product_detail_id'];

            if ($action === "delete_product_detail") {
                if (updateQty($db, $product_detail_id)) {
                    // header("Location: ./DB_Product.php", true, 302);
                    // exit();
                    echo "<script> 
                        alert('Ngưng hoạt động chi tiết sản phẩm thành công!');
                        window.location.href = './DB_Product.php';
                        </script>";
                }

            }

        }
    }
    ?>


    <!-- Header -->
    <?php echo $header; ?>

    <!-- Main -->
    <main id="main">
        <div class="main-dashboard__product">
            <div class="main-dashboard__product-header">
                <h2 class="main-dashboard__product-title">Danh sách sản phẩm</h2>
                <button class="btn main-dashboard__product-add">
                    <i class="fa-solid fa-plus"></i>
                    Thêm sản phẩm
                </button>
            </div>
            <div class="main-dashboard__product-handle">
                <div class="main-dashboard__product-handle-search-wrapper">
                    <button class="main-dashboard__product-handle-search-icon">
                        <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"
                            style="pointer-events: none; display: block; width: 28px; height: 28px">
                            <g>
                                <path d="M21,6H3V5h18V6z M18,11H6v1h12V11z M15,17H9v1h6V17z"></path>
                            </g>
                        </svg>
                    </button>
                    <div class="main-dashboard__product-handle-search">
                        <input name="name-search" type="text"
                            placeholder="Tìm kiếm theo từ khóa như:tên, id, trạng thái, giá" />
                    </div>
                </div>
                <div class="main-dashboard__product-handle-filter-wrapper">
                    <select class="main-dashboard__product-handle-filter" name="category">
                        <option value="no">Danh mục</option>
                        <?php
                        include_once "../config/database.php";
                        include_once "../../libs/session.php";

                        $db = new Database();

                        $sql = "SELECT c.TITLE, p.TITLE as parent_title
                        FROM categories c
                        LEFT JOIN categories p ON c.PARENT_CATEGORY_ID = p.CATEGORY_ID;";

                        $result = $db->query($sql);

                        $rows = array();

                        while ($temp = $result->fetch_assoc()) {
                            $rows[] = $temp;
                        }

                        $view_parent = "";

                        foreach ($rows as $temp) {
                            if (!$temp['parent_title']) {
                                $view_parent .= "<option value='{$temp['TITLE']} - null'>{$temp['TITLE']}</option>";
                            } else {
                                $view_parent .= "<option value='{$temp['parent_title']} - {$temp['TITLE']}'>{$temp['parent_title']} - {$temp['TITLE']}</option>";
                            }
                        }

                        echo $view_parent;

                        ?>
                    </select>
                </div>
            </div>
            <table class="main-dashboard__product-table">
                <tr>
                    <th style="width: 35%">Sản phẩm</th>
                    <th>Mã sản phẩm</th>
                    <th>Màu sắc (Kích thước - Số lượng)</th>
                    <th>Tống SL</th>
                    <th style="width: 12%">Giá bán</th>
                    <th style="width: 14%">Danh mục</th>
                    <th style="width: 8%"></th>
                </tr>
                <tbody class="main-dashboard__product-item-wrapper">
                </tbody>
            </table>
            <div id="nextPageWishList" class="clearfix text-center"
                style="display: none; justify-content: center; margin: 16px 0">
                <button
                    style="border: 1px solid rgb(74, 74, 235); border-radius: 4px; padding: 0 4px;  color: rgb(74, 74, 235);"
                    id="nextPageWishList" class="col-md-2 col-md-push-5 btn btn-info">
                    XEM THÊM
                </button>
            </div>
        </div>
    </main>
    <div class="dasboard-product-add">
        <div class="dasboard-product-add__wrapper">
            <h4>Nhập thông tin sản phẩm</h4>
            <hr />
            <form class="dasboard-product-add__form">
                <div class="dasboard-product-add__wrapper-text" style="display: none;">
                    <label for="id_product">Mã sản phẩm:</label>
                    <input style="border: 2px solid rgba(0,0,0,0.1);" type="text" name="id_product" value="-1"
                        id="id_product" disabled />
                </div>
                <div class="dasboard-product-add__wrapper-text">
                    <label for="name_product">Tên sản phẩm:</label>
                    <input type="text" name="name_product" id="name_product" placeholder="Nhập tên sản phẩm"
                        required="required" />
                </div>
                <div class="dasboard-product-add__wrapper-text">
                    <label for="description_product">Mô tả sản phẩm:</label>
                    <textarea name="description_product" rows="4" cols="50" placeholder="Nhập mô tả sản phẩm"
                        id="description_product" required="required"></textarea>
                </div>
                <div class="dasboard-product-add__wrapper-text">
                    <label for="price_product">Giá bán (vnđ):</label>
                    <input type="number" value="1" name="price_product" id="price_product" min="0" max="9999999999"
                        required="required" />
                </div>
                <!-- <div class="dasboard-product-add__wrapper-text">
                    <label>Dành cho:</label>
                    <input type="radio" name="gender_product" value="Nam" id="male" checked />
                    <label for="male">Nam</label>
                    <input type="radio" name="gender_product" value="Nữ" id="female" />
                    <label for="female">Nữ</label>
                </div> -->
                <div class="dasboard-product-add__wrapper-text">
                    <label for="category_product">Danh mục:</label>
                    <select name="category_product" id="category_product" required="required">

                    </select>
                </div>
                <div class="dasboard-product-add__wrapper-text dasboard-product-add__list-color-size">
                    <label>Màu sắc - Kích thước:</label>
                    <div class="dasboard-product-add__color-size-list">
                        <div class="dasboard-product-add__color-size-item 1">
                            <div class="dasboard-product-add__color">
                                <div>
                                    <input type="radio" name="c_1-color" value="Trắng" id="c_1-white" />
                                    <label class="dashboard__add-color" style="background-color: white"
                                        for="c_1-white"></label>
                                </div>
                                <div>
                                    <input type="radio" name="c_1-color" value="Đen" id="c_1-black" />
                                    <label class="dashboard__add-color" style="background-color: black"
                                        for="c_1-black"></label>
                                </div>
                                <div>
                                    <input type="radio" name="c_1-color" value="Xanh lá" id="c_1-green" />
                                    <label class="dashboard__add-color" style="background-color: green"
                                        for="c_1-green"></label>
                                </div>
                                <div>
                                    <input type="radio" name="c_1-color" value="Xanh dương" id="c_1-blue" />
                                    <label class="dashboard__add-color" style="background-color: blue"
                                        for="c_1-blue"></label>
                                </div>
                                <div>
                                    <input type="radio" name="c_1-color" value="Hồng" id="c_1-pink" />
                                    <label class="dashboard__add-color" style="background-color: pink"
                                        for="c_1-pink"></label>
                                </div>
                                <div>
                                    <input type="radio" name="c_1-color" value="Xám" id="c_1-grey" />
                                    <label class="dashboard__add-color" style="background-color: grey"
                                        for="c_1-grey"></label>
                                </div>
                                <div>
                                    <input type="radio" name="c_1-color" value="Vàng" id="c_1-yellow" />
                                    <label class="dashboard__add-color" style="background-color: yellow"
                                        for="c_1-yellow"></label>
                                </div>
                                <div>
                                    <input type="radio" name="c_1-color" value="Tím" id="c_1-violet" />
                                    <label class="dashboard__add-color" style="background-color: violet"
                                        for="c_1-violet"></label>
                                </div>
                            </div>
                            <div class="dasboard-product-add__size">
                                <div>
                                    <input type="checkbox" name="s_1-size-35" value="35" id="s_1-size-35"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-35">35</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                                <div>
                                    <input type="checkbox" name="s_1-size-36" value="36" id="s_1-size-36"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-36">36</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                                <div>
                                    <input type="checkbox" name="s_1-size-37" value="37" id="s_1-size-37"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-37">37</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                                <div>
                                    <input type="checkbox" name="s_1-size-38" value="38" id="s_1-size-38"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-38">38</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                                <div>
                                    <input type="checkbox" name="s_1-size-39" value="39" id="s_1-size-39"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-39">39</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                                <div>
                                    <input type="checkbox" name="s_1-size-40" value="40" id="s_1-size-40"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-40">40</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                                <div>
                                    <input type="checkbox" name="s_1-size-41" value="41" id="s_1-size-41"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-41">41</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                                <div>
                                    <input type="checkbox" name="s_1-size-42" value="42" id="s_1-size-42"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-42">42</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                                <div>
                                    <input type="checkbox" name="s_1-size-43" value="43" id="s_1-size-43"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-43">43</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                                <div>
                                    <input type="checkbox" name="s_1-size-44" value="44" id="s_1-size-44"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-44">44</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                                <div>
                                    <input type="checkbox" name="s_1-size-45" value="45" id="s_1-size-45"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-45">45</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                                <div>
                                    <input type="checkbox" name="s_1-size-46" value="46" id="s_1-size-46"
                                        class="dashboard__add-size" />
                                    <label for="s_1-size-46">46</label>
                                    <input type="number" min="1" max="10000" class="dasboard-product-add__size-qty"
                                        value="0" readonly />
                                </div>
                            </div>
                            <div class="dasboard-product-add__imgs">
                                <label for="img_1-first_img">Ảnh chính:</label>
                                <input type="text" name="img_1-first_img" id="img_1-first_img" value=""
                                    placeholder="Nhập đường dẩn ảnh..." />
                                <label for="img_1-second_img">Ảnh phụ:</label>
                                <input type="text" name="img_1-second_img" id="img_1-second_img" value=""
                                    placeholder="Nhập đường dẩn ảnh..." />
                                <label>Ảnh khác (tối đa 4 ảnh):</label>
                                <input type="text" name="img_1-orther_1" id="img_1-orther_1" value=""
                                    placeholder="Nhập đường dẩn ảnh..." />
                                <input type="text" name="img_1-orther_2" id="img_1-orther_2" value=""
                                    placeholder="Nhập đường dẩn ảnh..." />
                                <input type="text" name="img_1-orther_3" id="img_1-orther_3" value=""
                                    placeholder="Nhập đường dẩn ảnh..." />
                                <input type="text" name="img_1-orther_4" id="img_1-orther_4" value=""
                                    placeholder="Nhập đường dẩn ảnh..." />
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn button" id="btnAddColor_Size">
                        <i class="fa-solid fa-plus"></i>
                        Thêm màu sắc - kích thước
                    </button>
                </div>
                <input class="btn button dasboard-product-add__form-submit" id="add_proc_form" type="button"
                    value="Lưu sản phẩm" />
                <button type="button" class="btn button dasboard-product-add__form-submit cancle">
                    Thôi
                </button>
            </form>
        </div>
    </div>

    <div class="dasboard-product-update">
        <div class="dasboard-product-update__wrapper">
            <h4>Nhập thông tin sản phẩm</h4>
            <hr />
            <form class="dasboard-product-update__form">
                <div class="dasboard-product-update__wrapper-text" style="display: none;">
                    <label for="id_product_update">Mã sản phẩm:</label>
                    <input style="border: 2px solid rgba(0,0,0,0.1);" type="text" name="id_product_update" value="-1"
                        id="id_product_update" disabled />
                </div>
                <div class="dasboard-product-update__wrapper-text">
                    <label for="name_product_update">Tên sản phẩm:</label>
                    <input type="text" name="name_product_update" id="name_product_update"
                        placeholder="Nhập tên sản phẩm" required="required" />
                </div>
                <div class="dasboard-product-update__wrapper-text">
                    <label for="description_product_update">Mô tả sản phẩm:</label>
                    <textarea name="description_product_update" rows="4" cols="50" placeholder="Nhập mô tả sản phẩm"
                        id="description_product_update" required="required"></textarea>
                </div>
                <div class="dasboard-product-update__wrapper-text">
                    <label for="price_product_update">Giá bán (vnđ):</label>
                    <input type="number" value="1" name="price_product_update" id="price_product_update" min="0"
                        max="9999999999" required="required" />
                </div>
                <div class="dasboard-product-update__wrapper-text">
                    <label for="category_product_update">Danh mục:</label>
                    <select name="category_product_update" id="category_product_update" required="required">
                    </select>
                </div>

                <div>
                    <button id="btn_add_product_detail"
                        style="border: 1px solid blue; border-radius: 4px; padding: 4px; margin-top: 14px; margin-bottom: 14px; margin-left: 32px; color: blue;"
                        type="button">Thêm chi
                        tiết</button>
                </div>


                <div class="dasboard-product-update__wrapper-text dasboard-product-update__list-color-size">
                    <table id="orderTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="col-3">Img 1</th>
                                <th class="col-3">Img 2</th>
                                <th class="col-3">Img 3</th>
                                <th class="col-3">Img 4</th>
                                <th class="col-3">Img 5</th>
                                <th class="col-3">Img 6</th>
                                <th class="col-3">Màu</th>
                                <th class="col-4">Size</th>
                                <th class="col-5">Số lượng</th>
                                <th class="col-7" width="20%"></th>
                            </tr>
                        </thead>
                        <tbody id="main_innerProductDetailUpdate">
                            <!-- <tr>
                                <td><input class="input_detail_product" type="text" value="" disabled /></td>
                                <td><input class="input_detail_product" type="text" value="" disabled /></td>
                                <td><input class="input_detail_product" type="text" value="" disabled /></td>
                                <td><input class="input_detail_product" type="text" value="" disabled /></td>
                                <td><input class="input_detail_product" type="text" value="" disabled /></td>
                                <td><input class="input_detail_product" type="text" value="" disabled /></td>
                                <td><input class="input_detail_product" type="text" value="" disabled /></td>
                                <td><input class="input_detail_product" type="text" value="" disabled /></td>
                                <td><input class="input_detail_product" type="text" value="" disabled /></td>
                                <td class="main-dashboard__product-item-control">
                                    <div>
                                        <button style="display: none;" type="button">Lưu</button>
                                        <div id="update_detail" style="color: blue; margin: 0 10px;"
                                            class="main-dasboard__product-item-icon ">
                                            <i class="fa-solid fa-file-pen"></i>
                                        </div>
                                        <div id="delete_detail" style="color: red;"
                                            class="main-dasboard__product-item-icon ">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>

                <input class="btn button dasboard-product-update__form-submit" id="update_proc_form" type="button"
                    value="Lưu sản phẩm" />
                <button type="button" class="btn button dasboard-product-update__form-submit cancle">
                    Thôi
                </button>
            </form>
        </div>
    </div>
</body>
<script type="module" src="./js/product.js"> </script>

</html>

<?php
ob_end_flush();

?>