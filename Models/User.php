<?php
 {
  require_once "Person.php";

  class User extends Entity
  {
    private Person $_person;
    private ?array $_billingOrganizations;
    private ?array $_registrationGroups;

    public function __construct(Person $person, ?array $billingOrganizations, ?array $registrationGroups) {
      parent::__construct($person->_id, $person->_name, $person->_label, $person->_description);
      $this->_person = $person;
      $this->_billingOrganizations = $billingOrganizations;
      $this->_registrationGroups = $registrationGroups;
    }

    public function __get($name)
    {
      if ($name === 'person') {
        return $this->_person;
      }
      if ($name === 'billingOrganizations') {
        return $this->_billingOrganizations;
      }
      if ($name === 'registrationGroups') {
        return $this->_registrationGroups;
      }
      return parent::__get($name);
    }
  }
 }