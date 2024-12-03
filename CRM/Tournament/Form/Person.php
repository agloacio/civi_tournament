<?php

use \Civi\Api4\Individual as Api;
require_once "Form.php";
require_once "Field.php";

class CRM_Tournament_Form_Person extends Tournament_Core_Form
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
    $this->_updateAction = Api::update(FALSE)->addWhere('id', '=', $this->_id);
    parent::postProcess();
  }

  public function getDefaultEntity()
  {
    return 'contact';
  }

  protected function getGetSingleRecordAction()
  {
    $this->_id = $this->getContactID();
    return Api::get(TRUE)
      ->addWhere('id', '=', $this->_id)
      ->setLimit(1);
  }

  private function displayName(){
    return $this->_values['first_name'] . ' ' . $this->_values['last_name'];
  }

}
