<?php
include_once "../config/database.php";

include_once "../models/E_Storekeeper.php";

class StorekeeperModel
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

    public function getAllStorekeeper()
    {
        try {
            $sql = "SELECT * FROM storekeepers";

            $result = $this->db->fetchAll($sql);

            $storekeepers = [];
            foreach ($result as $row) {
                $storekeepers[] = new EntityStorekeeper(
                    $row['STOREKEEPER_ID'],
                    $row['EMAIL'],
                    $row['PASSWORD'],
                    $row['FULL_NAME'],
                    $row['PHONE_NUMBER'],
                    $row['ISACTIVE'],
                    $row['ADDRESS']
                );
            }



            return $storekeepers;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getOneStorekeeper($storekeeper_id, $close = true)
    {
        try {
            $sql = "SELECT * FROM  storekeepers WHERE storekeeper_id = ?";

            $params = [$storekeeper_id];

            $result = $this->db->fetchOne($sql, $params);

            // Convert the result set into a Product object
            $storekeepers = new EntityStorekeeper(
                $result['STOREKEEPER_ID'],
                $result['EMAIL'],
                $result['PASSWORD'],
                $result['FULL_NAME'],
                $result['PHONE_NUMBER'],
                $result['ISACTIVE'],
                $result['ADDRESS']
            );
            if ($close)


                return $storekeepers;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addStorekeeper($storekeeper)
    {
        try {
            $table = "storekeepers";

            $data = [
                'email' => $storekeeper->email,
                'password' => $storekeeper->password,
                'full_name' => $storekeeper->full_name,
                'phone_number' => $storekeeper->phone_number,
                'address' => $storekeeper->address,
            ];

            $resul = $this->db->insert($table, $data);


            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function updateStorekeeper($storekeeper)
    {
        try {
            $table = "storekeepers";

            $data = [
                'password' => $storekeeper->password,
                'full_name' => $storekeeper->full_name,
                'phone_number' => $storekeeper->phone_number,
                'address' => $storekeeper->address,
            ];

            $where = "storekeeper_id = " . $storekeeper->id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function bandStorekeeper($storekeeper_id)
    {
        try {
            $table = "storekeepers";

            $data = [
                'isactive' => false,
            ];

            $where = "storekeeper_id = " . $storekeeper_id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function unbandStorekeeper($storekeeper_id)
    {
        try {
            $table = "storekeepers";

            $data = [
                'isactive' => false,
            ];

            $where = "storekeeper_id = " . $storekeeper_id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

?>