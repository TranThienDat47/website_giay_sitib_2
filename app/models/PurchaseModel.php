<?php
include_once "../config/database.php";

include_once "../models/E_Purchase.php";

class PurchaseModel
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

    public function getAllPurchase()
    {
        try {
            $sql = "SELECT * FROM purchase";

            $result = $this->db->fetchAll($sql);

            $purchases = [];
            foreach ($result as $row) {
                $purchases[] = new EntityPurchase(
                    $row['PURCHASE_ID'],
                    $row['SUPPLIER_ID'],
                    $row['PURCHASE_DATE'],
                    $row['TOTAL_AMOUNT'],
                    $row['QTY']
                );
            }



            return $purchases;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getOnePurchase($purchase_id, $close = true)
    {
        try {
            $sql = "SELECT * FROM purchase WHERE PURCHASE_ID = ?";

            $params = [$purchase_id];

            $result = $this->db->fetchOne($sql, $params);

            // Convert the result set into a Product object
            $purchases = new EntityPurchase(
                $result['PURCHASE_ID'],
                $result['SUPPLIER_ID'],
                $result['PURCHASE_DATE'],
                $result['TOTAL_AMOUNT'],
                $result['QTY']
            );
            if ($close)


                return $purchases;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getOnePurchaseCurrentOfUser($supplier_id, $close = true)
    {
        try {
            $sql = "SELECT * FROM purchase WHERE supplier_id = ?";
            $params = [$supplier_id];

            $result = $this->db->fetchOne($sql, $params);

            $purchases = new EntityPurchase(
                $result['PURCHASE_ID'],
                $result['SUPPLIER_ID'],
                $result['PURCHASE_DATE'],
                $result['TOTAL_AMOUNT'],
                $result['QTY']
            );
            if ($close)


                return $purchases;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addPurchase($purchase)
    {
        try {
            $table = "purchase";

            $data = [
                'supplier_id' => $purchase->supplier_id,
                'total_amount' => $purchase->supplier_id,
                'qty' => $purchase->supplier_id,
            ];

            $resul = $this->db->insertResultRow($table, $data);


            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deletePurchase($id)
    {
        try {
            $table = "purchase";
            $where = 'PURCHASE_ID =' . $id;

            $result = $this->db->delete($table, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}
?>