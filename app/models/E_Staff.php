<?php
class EntityStaff
{
  public $staff_id;
  public $email;
  public $password;
  public $full_name;
  public $phone_number;
  public $isactive;
  public $address;

  // Constructor
  public function __construct($staff_id, $email, $password, $full_name, $phone_number, $isactive, $address)
  {
    $this->staff_id = $staff_id;
    $this->email = $email;
    $this->password = $password;
    $this->full_name = $full_name;
    $this->phone_number = $phone_number;
    $this->isactive = $isactive;
    $this->address = $address;
  }

  // Getter and Setter methods
  public function getId()
  {
    return $this->staff_id;
  }

  public function setId($staff_id)
  {
    $this->staff_id = $staff_id;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function getFullName()
  {
    return $this->full_name;
  }

  public function setFullName($full_name)
  {
    $this->full_name = $full_name;
  }
  public function getPhoneNumber()
  {
    return $this->phone_number;
  }

  public function setPhoneNumber($phone_number)
  {
    $this->phone_number = $phone_number;
  }

  public function getAddress()
  {
    return $this->address;
  }

  public function setAddress($address)
  {
    $this->address = $address;
  }
  public function getIsActive()
  {
    return $this->isactive;
  }

  public function setIsActive($isactive)
  {
    $this->isactive = $isactive;
  }


}
?>