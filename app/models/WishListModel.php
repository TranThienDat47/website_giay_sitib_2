<?php
include_once "../config/database.php";

include_once "../models/E_WishList.php";

class WishListModel
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

    public function getAllWishList()
    {
        try {
            $sql = "SELECT * FROM wishlist";

            $result = $this->db->fetchAll($sql);

            $wishlists = [];
            foreach ($result as $row) {
                $wishlists[] = new EntityWishList(
                    $row['CUSTOMER_ID'],
                    $row['PRODUCT_ID']
                );
            }



            return $wishlists;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getOneWishList($custommer_id, $close = true)
    {
        try {
            $sql = "SELECT * FROM wishlist WHERE CUSTOMER_ID = ?";

            $params = [$custommer_id];

            $result = $this->db->fetchOne($sql, $params);

            // Convert the result set into a Product object
            $wishlists = new EntityWishList(
                $result['CUSTOMER_ID'],
                $result['PRODUCT_ID']
            );
            if ($close)


                return $wishlists;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addWishList($wishlist)
    {
        try {
            $table = "wishlist";

            $data = [
                'CUSTOMER_ID' => $wishlist->custommer_id,
                'PRODUCT_ID' => $wishlist->product_id,
            ];

            $resul = $this->db->insert($table, $data);


            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function deleteWishList($wishlist_id)
    {
        try {
            $table = "wishlist";
            $where = 'CUSTOMER_ID =' . $wishlist_id;

            $result = $this->db->delete($table, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}

?>