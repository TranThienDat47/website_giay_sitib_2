<?php
include_once "../config/database.php";

include_once "../models/E_Admin.php";

class AdminModel
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

    public function login($email, $password)
    {
        if (empty($email)) {
            return false;
        }

        try {
            $sql = "SELECT * FROM admin WHERE email = ? and password = ?";
            $params = [$email, $password];

            $result = $this->db->fetchOne($sql, $params);
            $admins = null;
            if ($result)
                $admins = new EntityAdmin(
                    $result['ADMIN_ID'],
                    $result['EMAIL'],
                    $result['PASSWORD'],
                    $result['FULL_NAME']
                );

            return $admins;
        } catch (\Throwable $th) {

            throw $th;
        }
    }

    public function getOneAdmin($admin_id)
    {
        try {
            $sql = "SELECT * FROM admin WHERE admin_id = ?";

            $params = [$admin_id];

            $result = $this->db->fetchOne($sql, $params);

            // Convert the result set into a Product object
            $admins = new EntityAdmin(
                $result['ADMIN_ID'],
                $result['EMAIL'],
                $result['PASSWORD'],
                $result['FULL_NAME']
            );


            return $admins;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


}

?>