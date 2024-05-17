<?php
include_once "../config/database.php";

include_once "../models/E_Staff.php";

class StaffModel
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
            $sql = "SELECT * FROM staffs WHERE email = ? and password = ?";
            $params = [$email, $password];

            $result = $this->db->fetchOne($sql, $params);
            $staff = null;
            if ($result)
                $staff = [
                    $result['STAFF_ID'],
                    $result['EMAIL'],
                    $result['FULL_NAME'],
                    $result['PHONE_NUMBER'],
                    $result['ADRESS'],
                ];

            return $staff;
        } catch (\Throwable $th) {

            throw $th;
        }
    }

    public function checkActive($email, $password)
    {
        if (empty($email)) {
            return false;
        }

        try {
            $sql = "SELECT * FROM staffs WHERE email = ? and password = ? and ISACTIVE = true";
            $params = [$email, $password];

            $result = $this->db->fetchOne($sql, $params);
            $staff = null;
            if ($result)
                $staff = [
                    $result['STAFF_ID'],
                    $result['EMAIL'],
                    $result['FULL_NAME'],
                    $result['PHONE_NUMBER'],
                    $result['ADRESS'],
                ];

            return $staff;
        } catch (\Throwable $th) {

            throw $th;
        }
    }
}

?>