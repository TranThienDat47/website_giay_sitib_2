<?php
include_once "../config/database.php";

include_once "../models/E_Custommer.php";

class CustommerModel
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

    // public function getAllCustommer()
    // {

    //     try {
    //         $sql = "SELECT * FROM customers";

    //         $result = $this->db->fetchAll($sql);

    //         $custommers = [];
    //         foreach ($result as $row) {
    //             $custommers[] = new EntityCustomer(
    //                 $row['customer_id'],
    //                 $row['email'],
    //                 $row['password'],
    //                 $row['gender'],
    //                 $row['firstName'],
    //                 $row['lastName'],
    //                 $row['isactive']
    //             );
    //         }



    //         return $custommers;
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

    public function getOneCustommerEmail($email)
    {
        if (empty($email)) {
            return false;
        }

        try {
            $sql = "SELECT COUNT(*) as count FROM customers WHERE email = ?";
            $params = [$email];

            $count = $this->db->fetchOne($sql, $params);


            return $count['count'] <= 0;
        } catch (\Throwable $th) {


            throw $th;
        }
    }

    public function login($email, $password)
    {
        if (empty($email)) {
            return false;
        }

        try {
            $sql = "SELECT * FROM customers WHERE email = ? and password = ?";
            $params = [$email, $password];

            $result = $this->db->fetchOne($sql, $params);
            $custommers = null;
            if ($result)

                $custommers = new EntityCustomer(
                    $result['CUSTOMER_ID'],
                    $result['EMAIL'],
                    $result['PASSWORD'],
                    $result['GENDER'],
                    $result['FIRSTNAME'],
                    $result['LASTNAME'],
                    $result['ISACTIVE']
                );



            return $custommers;
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
            $sql = "SELECT * FROM customers WHERE email = ? and password = ? and ISACTIVE = 1";
            $params = [$email, $password];

            $result = $this->db->fetchOne($sql, $params);
            $custommers = null;
            if ($result)

                $custommers = new EntityCustomer(
                    $result['CUSTOMER_ID'],
                    $result['EMAIL'],
                    $result['PASSWORD'],
                    $result['GENDER'],
                    $result['FIRSTNAME'],
                    $result['LASTNAME'],
                    $result['ISACTIVE']
                );



            return $custommers;
        } catch (\Throwable $th) {

            throw $th;
        }
    }

    // public function getOneCustommer($custommer_id)
    // {
    //     try {

    //         $sql = "SELECT * FROM  customers WHERE customer_id = ?";

    //         $params = [$custommer_id];

    //         $result = $this->db->fetchOne($sql, $params);

    //         // Convert the result set into a Product object
    //         $custommers = new EntityCustomer(
    //             $result['customer_id'],
    //             $result['email'],
    //             $result['password'],
    //             $result['GENDER'],
    //             $result['firstName'],
    //             $result['lastName'],
    //             $result['isactive']
    //         );


    //         return $custommers;
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

    public function addCustommer($custommer)
    {
        try {
            $table = "customers";

            $data = [
                'email' => $custommer->email,
                'password' => $custommer->password,
                'gender' => $custommer->gender,
                'firstName' => $custommer->firstName,
                'lastName' => $custommer->lastName
            ];

            $resul = $this->db->insert($table, $data);


            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function updateCustommer($id, $firstname, $lastname, $gender, $password)
    {
        try {
            $table = "customers";

            $data = [
                'customer_id'  => $id,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'gender' => $gender,
                'password' => $password
            ];

            $where = "customer_id = " . $id;

            $result = $this->db->update($table, $data, $where);

            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function bandCustommer($custommer_id)
    {
        try {
            $table = "customers";

            $data = [
                'isactive' => false,
            ];

            $where = "customer_id = " . $custommer_id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function unbandCustommer($custommer_id)
    {
        try {
            $table = "customers";

            $data = [
                'isactive' => false,
            ];

            $where = "customer_id = " . $custommer_id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

?>