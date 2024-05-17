<?php
class EntityPaymentMethod
{
    public $payment_method_id;
    public $name;
    public $description;
    public $isactive;

    // Constructor
    public function __construct($payment_method_id, $name, $description, $isactive)
    {
        $this->payment_method_id = $payment_method_id;
        $this->name = $name;
        $this->description = $description;
        $this->isactive = $isactive;
    }

    // Getter and Setter methods
    public function getPaymentMethodId()
    {
        return $this->payment_method_id;
    }

    public function setPaymentMethodId($payment_method_id)
    {
        $this->payment_method_id = $payment_method_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
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