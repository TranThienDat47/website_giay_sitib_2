<?php
include_once "../config/database.php";

include_once "../models/E_Supplier.php";

class SupplierModel
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

    public function getAllSupplier()
    {
        try {
            $sql = "SELECT * FROM supplier";

            $result = $this->db->fetchAll($sql);

            $suppliers = [];
            foreach ($result as $row) {
                $suppliers[] = new EntitySupplier(
                    $row['SUPLIER_ID'],
                    $row['NAME'],
                    $row['DESCRIPTION'],
                    $row['ADDRESS'],
                    $row['EMAIL'],
                    $row['PHONE_NUMBER'],
                    $row['ISACTIVE']
                );
            }



            return $suppliers;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getOneSupplier($supplier_id, $close = true)
    {
        try {
            $sql = "SELECT * FROM  supplier WHERE supplier_id = ?";

            $params = [$supplier_id];

            $result = $this->db->fetchOne($sql, $params);

            // Convert the result set into a Product object
            $suppliers = new EntitySupplier(
                $result['SUPLIER_ID'],
                $result['NAME'],
                $result['DESCRIPTION'],
                $result['ADDRESS'],
                $result['EMAIL'],
                $result['PHONE_NUMBER'],
                $result['ISACTIVE']
            );
            if ($close)


                return $suppliers;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addSupplier($supplier)
    {
        try {
            $table = "supplier";

            $data = [
                'NAME' => $supplier->name,
                'DESCRIPTION' => $supplier->description,
                'ADDRESS' => $supplier->address,
                'EMAIL' => $supplier->email,
                'PHONE_NUMBER' => $supplier->phone_number,
            ];

            $resul = $this->db->insert($table, $data);


            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function updateSupplier($supplier)
    {
        try {
            $table = "supplier";

            $data = [
                'NAME' => $supplier->name,
                'DESCRIPTION' => $supplier->description,
                'ADDRESS' => $supplier->address,
                'EMAIL' => $supplier->email,
                'PHONE_NUMBER' => $supplier->phone_number,
                'ISACTIVE' => $supplier->isactive,
            ];

            $where = "supplier_id = " . $supplier->id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function bandSupplier($supplier_id)
    {
        try {
            $table = "supplier";

            $data = [
                'ISACTIVE' => false,
            ];

            $where = "supplier_id = " . $supplier_id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function unbandSupplier($supplier_id)
    {
        try {
            $table = "supplier";

            $data = [
                'ISACTIVE' => false,
            ];

            $where = "supplier_id = " . $supplier_id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

?>