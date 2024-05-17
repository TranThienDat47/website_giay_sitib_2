<?php
class EntityAddress
{
  public $address_id;
  public $customer_id;
  public $fullname;
  public $is_default;
  public $phone_number;
  public $detail;
  public $province;
  public $district;
  public $village;

  // Constructor
  public function __construct($address_id, $customer_id, $fullname, $is_default, $phone_number, $detail, $province, $district, $village)
  {
    $this->address_id = $address_id;
    $this->customer_id = $customer_id;
    $this->fullname = $fullname;
    $this->is_default = $is_default;
    $this->phone_number = $phone_number;
    $this->detail = $detail;
    $this->province = $province;
    $this->district = $district;
    $this->village = $village;
  }

  // Getter and Setter methods
  public function getId()
  {
    return $this->address_id;
  }

  public function setId($address_id)
  {
    $this->address_id = $address_id;
  }

  public function getCustomerId()
  {
    return $this->customer_id;
  }

  public function setCustomerId($customer_id)
  {
    $this->customer_id = $customer_id;
  }

  public function getFullname()
  {
    return $this->fullname;
  }

  public function setFullname($fullname)
  {
    $this->fullname = $fullname;
  }

  public function getIsDefault()
  {
    return $this->is_default;
  }

  public function setIsDefault($is_default)
  {
    $this->is_default = $is_default;
  }

  public function getPhoneNumber()
  {
    return $this->phone_number;
  }

  public function setPhoneNumber($phone_number)
  {
    $this->phone_number = $phone_number;
  }

  public function getDetail()
  {
    return $this->detail;
  }

  public function setDetail($detail)
  {
    $this->detail = $detail;
  }

  public function getProvince()
  {
    return $this->province;
  }

  public function setProvince($province)
  {
    $this->province = $province;
  }

  public function getDistrict()
  {
    return $this->district;
  }

  public function setDistrict($district)
  {
    $this->district = $district;
  }

  public function getVillage()
  {
    return $this->village;
  }

  public function setVillage($village)
  {
    $this->village = $village;
  }
}
?>