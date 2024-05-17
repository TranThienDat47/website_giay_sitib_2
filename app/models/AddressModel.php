<?php
include_once "../config/database.php";

include_once "../models/E_Address.php";

class AddressModel
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

    public function getAllAddressOfCustommer($custommer_id)
    {

        try {
            $sql = "SELECT * FROM address WHERE customer_id = ? and ISACTIVE = 1";

            $params = [$custommer_id];

            $result = $this->db->fetchAllParams($sql, $params);

            if ($result) {
                $address = [];
                foreach ($result as $row) {
                    $address[] = new EntityAddress(
                        $row['ADDRESS_ID'],
                        $row['CUSTOMER_ID'],
                        $row['FULLNAME'],
                        $row['IS_DEFAULT'],
                        $row['PHONE_NUMBER'],
                        $row['DETAIL'],
                        $row['PROVINCE'],
                        $row['DISTRICT'],
                        $row['VILLAGE']
                    );
                }
                return $address;
            }

            return false;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getOneAddressOfCustommer($custommer_id, $address_id)
    {
        try {
            $sql = "SELECT * FROM address WHERE custommer_id = ? and address_id = ? and ISACTIVE = 1";

            $params = [$custommer_id, $address_id];

            $result = $this->db->fetchOne($sql, $params);

            // Convert the result set into a Product object
            $address = new EntityAddress(
                $result['ADDRESS_ID'],
                $result['CUSTOMER_ID'],
                $result['FULLNAME'],
                $result['IS_DEFAULT'],
                $result['PHONE_NUMBER'],
                $result['DETAIL'],
                $result['PROVINCE'],
                $result['DISTRICT'],
                $result['VILLAGE']
            );

            return $address;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getOneAddressOfCustommerWithDetail($custommer_id, $fullname, $phone, $detail_address, $provicce, $district, $village)
    {
        try {
            $sql = "SELECT * FROM address WHERE customer_id = ? and ISACTIVE = 1 and fullname = ? and phone_number = ? and detail = ? and province = ? and district = ? and village = ?";

            $params = [$custommer_id, $fullname, $phone, $detail_address, $provicce, $district, $village];

            $result = $this->db->fetchOne($sql, $params);

            if ($result) {
                // Convert the result set into a Product object
                $address = new EntityAddress(
                    $result['ADDRESS_ID'],
                    $result['CUSTOMER_ID'],
                    $result['FULLNAME'],
                    $result['IS_DEFAULT'],
                    $result['PHONE_NUMBER'],
                    $result['DETAIL'],
                    $result['PROVINCE'],
                    $result['DISTRICT'],
                    $result['VILLAGE']
                );

                return $address;
            }
            return false;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addAddressOfCustommer($address)
    {
        try {
            $table = "address";

            $data = [
                'CUSTOMER_ID' => $address->customer_id,
                'FULLNAME' => $address->fullname,
                'is_default' => $address->is_default,
                'PHONE_NUMBER' => $address->phone_number,
                'DETAIL' => $address->detail,
                'PROVINCE' => $address->province,
                'DISTRICT' => $address->district,
                'VILLAGE' => $address->village,
            ];

            $resul = $this->db->insertResultRow($table, $data);

            return $resul;
        } catch (\Throwable $th) {
            //throw $th;

        }
    }

    public function addAddressAndGetIDOfCustommer($address)
    {
        try {
            $table = "address";

            $data = [
                'customer_id' => $address->customer_id,
                'fullname' => $address->fullname,
                'is_default' => $address->is_default,
                'phone_number' => $address->phone_number,
                'detail' => $address->detail,
                'province' => $address->province,
                'district' => $address->district,
                'village' => $address->village,
            ];
            $resul = $this->db->insert($table, $data);

            return $resul;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function updateAddressOfCustommer($address)
    {
        try {
            $table = "address";

            $data = [
                'CUSTOMER_ID' => $address->customer_id,
                'FULLNAME' => $address->fullname,
                'IS_DEFAULT' => $address->is_default,
                'PHONE_NUMBER' => $address->phone_number,
                'DETAIL' => $address->detail,
                'PROVINCE' => $address->province,
                'DISTRICT' => $address->district,
                'VILLAGE' => $address->village,
            ];


            $where = "ADDRESS_ID = " . $address->address_id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function updateAddressOfCustommerDelete($address_id)
    {
        try {
            $table = "address";

            $data = [
                'ISACTIVE' => 0,
            ];


            $where = "ADDRESS_ID = " . $address_id;

            $result = $this->db->update($table, $data, $where);


            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // public function setDefaultAddressOfCustommer($address)
    // {
    //     try {
    //         $table = "address";

    //         $data = [
    //             'is_default' => true,
    //         ];

    //         $where = "address_id = " . $address->id;

    //         $result = $this->db->update($table, $data, $where);


    //         return $result;
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

    public function setDefaultAddressOfCustommer($address_id)
    {
        try {
            $table = "address";

            $data = [
                'IS_DEFAULT' => false,
            ];

            $where = "ADDRESS_ID <> " . $address_id;

            $result = $this->db->update($table, $data, $where);

            return $result > 0;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deleteAddressCustomer($address_id)
    {
        try {
            $table = "address";
            $where = 'ADDRESS_ID = ' . $address_id;

            $result = $this->db->delete($table, $where);

            if ($result <= 0) {
                return $this->updateAddressOfCustommerDelete($address_id);
            }

            return $result > 0;
        } catch (\Throwable $th) {
            //throw $th;
            return $this->updateAddressOfCustommerDelete($address_id);
        }
    }

}

?>