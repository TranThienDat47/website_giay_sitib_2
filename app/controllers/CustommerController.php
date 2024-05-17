<?php
include_once "../../libs/session.php";

include_once "../models/CartModel.php";
include_once "../models/CustommerModel.php";
include_once "../models/AddressModel.php";

class CustommerController
{
    public function __construct()
    {

    }

    public function register($custommer)
    {

        $custommerModel = new CustommerModel();
        $cartModel = new CartModel();

        $checkEmail = $custommerModel->getOneCustommerEmail($custommer->getEmail());
        if ($checkEmail == true) {

            $custommerId = $custommerModel->addCustommer($custommer);

            if ($custommerId) {
                $cartModel->addCart($custommerId);

                return $custommerId;
            }
        }
        return false;
    }

    public function login($email, $password)
    {

        $custommerModel = new CustommerModel();

        if (empty($email) || empty($password)) {
            return false;
        } else {
            $result = $custommerModel->login($email, $password);

            if ($result) {
                $checkActive = $custommerModel->checkActive($email, $password);
                if ($checkActive) {
                    Session::set("customer_login", true);
                    Session::set("customer_id", $result->getId());
                    Session::set("customer_email", $result->getEmail());
                    Session::set("customer_firstName", $result->getFirstName());
                    Session::set("customer_lastName", $result->getLastName());
                    Session::set("customer_isActive", $result->getIsActive());

                    header("Location: ./home.php");
                    return true;
                } else {
                    return "Tài khoản khoản của bạn đã bị khóa, vui lòng liên hệ với nhân viên để được hỗ trợ!";
                }
            } else {
                return "Tài khoản hoặc mật khẩu không chính xác!";
            }
        }
    }

    public function addAddress($address)
    {
        $addressModel = new AddressModel();

        return $addressModel->addAddressOfCustommer($address);
    }

    public function getAllAddressOfCustomer()
    {
        $addressModel = new AddressModel();
        $list_product = $addressModel->getAllAddressOfCustommer(Session::get("customer_id"));
        $result = [];

        if ($list_product) {
            foreach ($list_product as $temp) {
                $result[] = [
                    $temp->getId(), $temp->getCustomerId(), $temp->getFullname(), $temp->getIsDefault(), $temp->getPhoneNumber(),
                    $temp->getDetail(), $temp->getProvince(), $temp->getDistrict(), $temp->getVillage()
                ];
            }
        }

        return $result;
    }

    public function checkAddress($name, $phone, $detail, $provice, $dictrict, $ward)
    {
        $addressModel = new AddressModel();
        $check_address = $addressModel->getOneAddressOfCustommerWithDetail(Session::get("customer_id"), $name, $phone, $detail, $provice, $dictrict, $ward);
        if ($check_address) {

        } else {
            $tempAddress = new EntityAddress(0, Session::get("customer_id"), $name, false, $phone, $detail, $provice, $dictrict, $ward);
            return $addressModel->addAddressAndGetIDOfCustommer($tempAddress);
        }

        return false;
    }

    public function setDefaultAddress($addres_id)
    {
        $addressModel = new AddressModel();

        return $addressModel->setDefaultAddressOfCustommer($addres_id);
    }

    public function updateAddressCustomer($addres_id, $name, $is_default, $phone, $detail, $provice, $dictrict, $ward)
    {
        $addressModel = new AddressModel();
        $tempAddress = new EntityAddress($addres_id, Session::get("customer_id"), $name, $is_default, $phone, $detail, $provice, $dictrict, $ward);

        return $addressModel->updateAddressOfCustommer($tempAddress);
    }

    public function deleteAddressCustomer($addres_id)
    {
        $addressModel = new AddressModel();
        return $addressModel->deleteAddressCustomer($addres_id);
    }

    public function updateCustomer()
    {
        $id = $_POST['id'];
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $gender = $_POST['gender'];
        $mk = $_POST['mk'];

        $customer = new CustommerModel();
        $customer->updateCustommer($id, $last_name, $first_name, $gender, $mk);
        return true;
        header("Location: edit_information_account.php?id=$id");
    }
}