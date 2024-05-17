<?php
include_once "../../libs/session.php";
include_once "../config/database.php";

include_once "../models/CategoryModel.php";

class CategoryController
{

    public $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllCategoryWithParent()
    {
        $categoryModel = new CategoryModel();

        $listCategory = $categoryModel->getAllCategoryWithParent();

        $result = array();

        foreach ($listCategory as $temp) {
            $result[] = [
                $temp->getId(), $temp->getTitle(), $temp->category_parent
            ];
        }

        return $result;

    }


}