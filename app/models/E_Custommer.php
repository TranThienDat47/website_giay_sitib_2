<?php
class EntityCustomer
{
  public $customer_id;
  public $email;
  public $password;
  public $gender;
  public $firstName;
  public $lastName;
  public $isactive;

  // Constructor
  public function __construct($customer_id, $email, $password, $gender, $firstName, $lastName, $isactive)
  {
    $this->customer_id = $customer_id;
    $this->email = $email;
    $this->password = $password;
    $this->gender = $gender;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->isactive = $isactive;
  }

  // Getter and Setter methods
  public function getId()
  {
    return $this->customer_id;
  }

  public function setId($customer_id)
  {
    $this->customer_id = $customer_id;
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

  public function getGender()
  {
    return $this->gender;
  }

  public function setGender($gender)
  {
    $this->gender = $gender;
  }

  public function getFirstName()
  {
    return $this->firstName;
  }

  public function setFirstName($firstName)
  {
    $this->firstName = $firstName;
  }

  public function getLastName()
  {
    return $this->lastName;
  }

  public function setLastName($lastName)
  {
    $this->lastName = $lastName;
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