<?php
class EntityCustommerPayment
{
  public $cart_id;
  public $payment_method_id;
  public $created_at;
  public $address_id;
  public $delivery_begin;
  public $delivery_end;

  // Constructor
  public function __construct($cart_id, $payment_method_id, $address_id, $created_at, $delivery_begin, $delivery_end)
  {
    $this->cart_id = $cart_id;
    $this->payment_method_id = $payment_method_id;
    $this->address_id = $address_id;
    $this->created_at = $created_at;
    $this->delivery_begin = $delivery_begin;
    $this->delivery_end = $delivery_end;
  }

  // Getter and Setter methods
  public function getCartId()
  {
    return $this->cart_id;
  }

  public function setCartId($cart_id)
  {
    $this->cart_id = $cart_id;
  }

  public function getPaymentMethodID()
  {
    return $this->payment_method_id;
  }

  public function setPaymentMethodID($payment_method_id)
  {
    $this->payment_method_id = $payment_method_id;
  }

  public function getAddressID()
  {
    return $this->address_id;
  }

  public function setAddressID($address_id)
  {
    $this->address_id = $address_id;
  }

  public function getDeliveryBegin()
  {
    return $this->delivery_begin;
  }

  public function setDeliveryBegin($delivery_begin)
  {
    $this->delivery_begin = $delivery_begin;
  }

  public function getDeliveryEnd()
  {
    return $this->delivery_end;
  }

  public function setDeliveryEnd($delivery_end)
  {
    $this->delivery_end = $delivery_end;
  }

  public function getCreatedAt()
  {
    return $this->created_at;
  }

  public function setCreatedAt($created_at)
  {
    $this->created_at = $created_at;
  }

}
?>