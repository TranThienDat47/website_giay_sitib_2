<?php
class EntityAdmin
{
  public $admin_id;
  public $email;
  public $password;
  public $full_name;

  // Constructor
  public function __construct($admin_id, $email, $password, $full_name)
  {
    $this->admin_id = $admin_id;
    $this->email = $email;
    $this->password = $password;
    $this->full_name = $full_name;
  }

  // Getter and Setter methods
  public function getId()
  {
    return $this->admin_id;
  }

  public function setId($admin_id)
  {
    $this->admin_id = $admin_id;
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

}
?>