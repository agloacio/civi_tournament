<?php
require_once "Contact.php";
require_once "Field.php";
require_once "CRM/CiviTournament/Session.php";

use \Civi\Api4\Individual as Entity;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_CiviTournament_Form_Person extends CRM_CiviTournament_Form_Contact 
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $entity = $this->getDefaultEntity();
    $this->_fields = array(
      new Field($entity, 'last_name', 'Last Name', 'Text', TRUE),
      new Field($entity, 'first_name', 'First Name', 'Text', TRUE),
      new Field($entity, 'middle_name', 'Middle Name', 'Text', FALSE),
      new Field($entity, 'gender_id', 'Gender', 'Radio', FALSE),
      new Field($entity, 'birth_date', 'Birth Date', 'Select Date', FALSE),
      new Field($entity, 'prefix_id', 'Prefix', 'Select', FALSE),
      new Field($entity, 'suffix_id', 'Suffix', 'Select', FALSE)
    );
  }

  public function preProcess()
  {
    parent::preProcess();
  }

  public function buildQuickForm() {
    parent::buildQuickForm();
  }

  public function postProcess() {
    $this->_values = $this->exportValues();
    $this->_recordName = $this->displayName();
    parent::postProcess();
  }

  protected function initializeGetSingleRecordAction()
  {
    $this->_id = $this->_id ?? Session::getLoggedInContactID();
    return parent::initializeGetSingleRecordAction();
  }

  private function displayName(){
    return $this->_values['first_name'] . ' ' . $this->_values['last_name'];
  }


  protected function updateTitle()
  {
    $this->_recordName = $this->displayName();
    parent::updateTitle();
  }

}
