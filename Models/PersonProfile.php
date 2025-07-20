<?php

/**
 * Profile (inc. email, phone, address) for, e.g., Teacher, Coach, Coordinator, etc.
 *
 * @version 1.0
 * @author msteigerwald
 */
class PersonProfile extends ContactProfile
{
  private Person $_person;

  public function __construct(Person $person, ?EmailAddress $email, ?Address $address, ?PhoneNumber $mainPhone, ?PhoneNumber $mobilePhone = null)
  {
    $this->_person = $person;
    parent::__construct($person->id, $person->name, $person->label, $email, $address, $mainPhone, $mobilePhone);
  }

  public function __get($name)
  {
    if ($name === 'person') {
      return $this->_person;
    }
    return parent::__get($name);
  }
}