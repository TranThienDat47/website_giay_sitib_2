<?php
include_once "../config/database.php";

include_once "../models/E_Category.php";

class PurchaseDetailModel
{
    public $db;

    public function __construct()
    {
        try {
            $this->db = new Database();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function getAllPurchaseDetailOfPurchase($purchase_id)
    {
        try {
            $sql = "SELECT * FROM purchasedetails WHERE purchase_id = ?";

            $params = [$purchase_id];

            $result = $this->db->fetchOne($sql, $params);
            $cartdetails = [];
            foreach ($result as $row) {
                $cartdetails[] = new EntityCartDetail(
                    $row['cart_detail_id'],
                    $row['cart_id'],
                    $row['product_id'],
                    $row['quantity']
                );
            }




            return $cartdetails;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getOneCategory($category_id)
    {
        try {
            $sql = "SELECT * FROM category WHERE id = ?";

            $params = [$category_id];

            $result = $this->db->fetchOne($sql, $params);

            // Convert the result set into a Product object
            $categories = new EntityCategory(
                $result['id'],
                $result['parent_category'],
                $result['title'],
                $result['description'],
                $result['isactive']
            );



            return $categories;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addCategory($category)
    {
        try {
            $table = "category";

            $data = [
                'parent_category' => $category->parent_category,
                'title' => $category->title,
                'description' => $category->description,
            ];

            $resul = $this->db->insert($table, $data);


            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function updateCategory($category)
    {
        try {
            $table = "category";

            $data = [
                'parent_category' => $category->parent_category,
                'title' => $category->title,
                'description' => $category->description,
            ];

            $where = "id = " . $category->id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deleteCategory($category_id)
    {
        try {
            $table = "category";
            $where = 'id =' . $category_id;

            $result = $this->db->delete($table, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}

?>