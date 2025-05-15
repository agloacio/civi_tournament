<?php
require_once "Contact.php";
require_once "Field.php";
require_once "CRM/CiviTournament/Session.php";

/**
 * Peron Form controller class
 *
 * Form to add and update people.
 * 
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */

class CRM_CiviTournament_Form_Person extends CRM_CiviTournament_Form_Contact 
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $entity = $this->getDefaultEntity();

    $this->_fields = array_merge(
      $this->_fields,
      array(
        new Field($entity, 'last_name', 'Last Name', 'Text', TRUE),
        new Field($entity, 'first_name', 'First Name', 'Text', TRUE),
        new Field($entity, 'middle_name', 'Middle Name', 'Text', FALSE),
        new Field($entity, 'gender_id', 'Gender', 'Radio', FALSE),
        new Field($entity, 'birth_date', 'Birth Date', 'Select Date', FALSE),
        new Field($entity, 'prefix_id', 'Prefix', 'Select', FALSE),
        new Field($entity, 'suffix_id', 'Suffix', 'Select', FALSE)
      )
    );
  }

  public function preProcess() {
    parent::getId();
    $this->_id = $this->_id ?? Session::getLoggedInContactID();
    parent::preProcess();
  }

  public function postProcess() {
    $this->_values = $this->exportValues();
    $this->_entityLabel = $this->displayName();
    parent::postProcess();
  }

  private function displayName(){
    return $this->_values['first_name'] . ' ' . $this->_values['last_name'];
  }
}
