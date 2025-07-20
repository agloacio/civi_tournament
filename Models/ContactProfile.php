<?php

/**
 * Profile (inc. email, phone, address) for a contact.
 *
 * @version 1.0
 * @author msteigerwald
 */
class ContactProfile extends Entity
{
  protected ?EmailAddress $_email;
  protected ?Address $_address;
  protected ?PhoneNumber $_mainPhone;
  protected ?PhoneNumber $_mobilePhone;

  public function __construct(?int $id, ?string $name, ?string $label, ?EmailAddress $email, ?Address $address, ?PhoneNumber $mainPhone, ?PhoneNumber $mobilePhone)
  {
    $this->_email = $email;
    $this->_address = $address;
    $this->_mainPhone = $mainPhone;
    $this->_mobilePhone = $mobilePhone;
    parent::__construct($id, $name, $label);
  }

  public function __get($name)
  {
    if ($name === 'email') {
      return $this->_email;
    }

    if ($name === 'address') {
      return $this->_address;
    }

    if ($name === 'mainPhone') {
      return $this->_mainPhone;
    }

    if ($name === 'mobilePhone') {
      return $this->_mobilePhone;
    }

    return parent::__get($name);
  }
}