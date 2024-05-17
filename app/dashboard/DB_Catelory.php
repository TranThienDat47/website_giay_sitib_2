<?php
ob_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../public/access/fonts/fontawesome-free-6.2.0-web/css/all.min.css" />
    <?php include "./Layout/navbar.php"; ?>
    <link rel="stylesheet" href="./css/header_db.css">
    <link rel="stylesheet" href="./css/base.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./css/DB_Catelory.css">
</head>

<body>
    <!-- Header -->
    <?php echo $header; ?>


    <!-- Main -->
    <main id="main">
        <ul class="list-category">

            <?php
         include_once "../config/database.php";
         include_once "../../libs/session.php";

         $db = new Database();

         if ($_SERVER['REQUEST_METHOD'] == "GET") {

            if (isset($_GET['action']) && isset($_GET['title'])) {

               function addCategoryNoParent($db, $title)
               {
                  $table = "categories";

                  $data = [
                     'TITLE' => $title,
                  ];

                  $resul = $db->insertResultRow($table, $data);

                  return $resul;
               }

               $action = $_GET['action'];
               $title = $_GET['title'];

               if ($action === "add_category_no_parent") {
                  if (addCategoryNoParent($db, $title)) {
                     header("Location: ./DB_Catelory.php", true, 302);
                     exit();
                  }
               }

            }

            if (isset($_GET['action']) && isset($_GET['title']) && isset($_GET['parent_id'])) {

               function addCategory($db, $title, $parent_id)
               {
                  $table = "categories";

                  $data = [
                     'PARENT_CATEGORY_ID' => $parent_id,
                     'TITLE' => $title,
                  ];

                  $resul = $db->insertResultRow($table, $data);

                  return $resul;
               }

               $action = $_GET['action'];
               $title = $_GET['title'];
               $parent_id = $_GET['parent_id'];

               if ($action === "add_category") {
                  if (addCategory($db, $title, $parent_id)) {
                     header("Location: ./DB_Catelory.php", true, 302);
                     exit();
                  }
               }

            }

            if (isset($_GET['action']) && isset($_GET['category_id'])) {
               function delCategory($db, $category_id)
               {
                  try {
                     $table = "categories";

                     $condition = 'CATEGORY_ID = ' . $category_id;

                     $table = filter_var($table, FILTER_SANITIZE_STRING);
                     $condition = filter_var($condition, FILTER_SANITIZE_STRING);

                     $query = "DELETE FROM $table WHERE $condition";

                     $stmt = $db->query($query);

                     return $stmt;
                  } catch (\Throwable $th) {
                     return false;
                  }
               }

               $action = $_GET['action'];
               $category_id = $_GET['category_id'];

               if ($action === "delete_category_no_parent") {
                  if (delCategory($db, $category_id)) {
                     header("Location: ./DB_Catelory.php", true, 302);
                     exit();
                  } else {

                     echo "<script> 
                     alert('Bạn không thể xóa danh mục này!')
                        window.location.href = './DB_Catelory.php';
                     </script>";

                  }
               }

            }

         }

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
                                 <div>
                                    <div>
                                    {$row['TITLE']}
                                       <button class='btn__del' data-id='{$row['CATEGORY_ID']}'>
                                          <i class='fa-regular fa-trash-can'></i>
                                       </button>
                                    </div>
                                 </div>
                              ";
            }

            return $list_details;
         }

         $view_parent = "";

         foreach ($rows as $temp) {
            $list_details = getChildCategory($db, $temp['CATEGORY_ID']);


            $view_parent .= "
                     <li class='item-category'>
                        <h2 class='item-category__title'> {$temp['TITLE']}</h2>
                        <hr />
                        <div class='item-category__second'>
                        $list_details
                           <button class='btn button btn__add' data-id='{$temp['CATEGORY_ID']}'>
                              Thêm
                              <i class='fa-solid fa-circle-plus'></i>
                           </button>
                        </div>
                        <button class='btn__del-li' data-id='{$temp['CATEGORY_ID']}'>
                           <i class='fa-solid fa-xmark'></i>
                        </button>
                     </li>  
                     ";
         }

         $view_parent .= "

         <li class='item-category item-category__add'>
           <h3>Thêm danh mục</h3>
           <i class='fa-solid fa-circle-plus'></i>
         </li>`
         ";

         echo $view_parent;

         ?>

        </ul>
    </main>
</body>
<script type="module" src="./js/DB_Catelory.js"></script>

</html>

<?php
ob_end_flush();

?>