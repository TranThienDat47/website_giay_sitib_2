<?php
class EntitySupplier
{
    public $supplier_id;
    public $img;
    public $name;
    public $description;
    public $address;
    public $email;
    public $phone_number;
    public $isactive;

    public function __construct(
        $supplier_id,
        $name,
        $description,
        $address,
        $email,
        $phone_number,
        $isactive,
    ) {
        $this->supplier_id = $supplier_id;
        $this->name = $name;
        $this->description = $description;
        $this->address = $address;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->isactive = $isactive;
    }

    public function getId()
    {
        return $this->supplier_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function getIsActive()
    {
        return $this->isactive;
    }


    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    public function setIsActive($isactive)
    {
        $this->isactive = $isactive;
    }
}
?>