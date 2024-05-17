<?php
include_once "../config/database.php";

include_once "../models/E_Category.php";

class CategoryModel
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

    public function getAllCategoryWithParent()
    {
        try {
            $sql = "SELECT c.*, p.TITLE AS parent_category_title
            FROM categories c
            LEFT JOIN categories p ON c.PARENT_CATEGORY_ID = p.CATEGORY_ID;";

            $result = $this->db->fetchAll($sql);

            $categories = [];
            foreach ($result as $row) {

                $tempCategory = new EntityCategory(
                    $row['CATEGORY_ID'],
                    $row['PARENT_CATEGORY_ID'],
                    $row['TITLE'],
                    $row['DESCRIPTION'],
                    $row['ISACTIVE']
                );

                $tempCategory->category_parent = $row['parent_category_title'];

                $categories[] = $tempCategory;
            }

            return $categories;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function getAllCategory()
    {
        try {
            $sql = "SELECT * FROM categories";

            $result = $this->db->fetchAll($sql);

            $categories = [];
            foreach ($result as $row) {
                $categories[] = new EntityCategory(
                    $row['CATEGORY_ID'],
                    $row['PARENT_CATEGORY_ID'],
                    $row['TITLE'],
                    $row['DESCRIPTION'],
                    $row['ISACTIVE']
                );
            }



            return $categories;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getOneCategory($category_id)
    {
        try {

            $sql = "SELECT * FROM categories WHERE caregory_id = ?";

            $params = [$category_id];

            $result = $this->db->fetchOne($sql, $params);

            // Convert the result set into a Product object
            $categories = new EntityCategory(
                $result['CATEGORY_ID'],
                $result['PARENT_CATEGORY_ID'],
                $result['TITLE'],
                $result['DESCRIPTION'],
                $result['ISACTIVE']
            );


            return $categories;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addCategory($category)
    {
        try {
            $table = "categories";

            $data = [
                'parent_category_id' => $category->parent_category,
                'title' => $category->title,
                'description' => $category->description,
            ];

            $resul = $this->db->insertResultRow($table, $data);


            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function updateCategory($category)
    {
        try {
            $table = "categories";

            $data = [
                'parent_category_id' => $category->parent_category,
                'title' => $category->title,
                'description' => $category->description,
            ];

            $where = "caregory_id = " . $category->id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deleteCategory($category_id)
    {
        try {
            $table = "categories";
            $where = 'caregory_id =' . $category_id;

            $result = $this->db->delete($table, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}

?>