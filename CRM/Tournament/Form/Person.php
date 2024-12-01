<?php
require_once "Form.php";

class CRM_Tournament_Form_Person extends Tournament_Core_Form {
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);
    $this->_fieldNames = array('first_name', 'middle_name', 'last_name', 'birth_date', 'gender_id', 'prefix_id', 'suffix_id');
  }

  protected function getGetSingleRecordAction(){
    $this->_id = $this->getContactID();
    return \Civi\Api4\Individual::get(TRUE)
      ->addWhere('id', '=', $this->_id)
      ->setLimit(1);
  }

  public function buildQuickForm() {
    $entity = $this->getDefaultEntity();

    $this->addField('last_name', ['placeholder' => ts('Last Name'), 'label' => ts('Last Name')], true);
    $this->addField('first_name', ['placeholder' => ts('First Name'), 'label' => ts('First Name')], true);
    $this->addField('middle_name', ['placeholder' => ts('Middle Name'), 'label' => ts('Middle Name')]);

    $this->addField('gender_id', ['entity' => $entity, 'type' => 'Radio', 'allowClear' => TRUE]);

    $this->addField('birth_date', ['entity' => $entity], FALSE, FALSE);

    $this->addField('prefix_id', ['entity' => $entity, 'placeholder' => ts('Prefix'), 'label' => ts('Prefix')]);
    $this->addField('suffix_id', ['entity' => $entity, 'placeholder' => ts('Suffix'), 'label' => ts('Suffix')]);

    parent::buildQuickForm();
  }

  public function postProcess() {
    $this->_values = $this->exportValues();
    $this->_recordName = $this->displayName();
    $this->_updateAction = \Civi\Api4\Individual::update(FALSE)->addWhere('id', '=', $this->_id);
    parent::postProcess();
  }

  /**
   * Explicitly declare the entity api name.
   */
  public function getDefaultEntity()
  {
    return 'contact';
  }

  private function displayName(){
    return $this->_values['first_name'] . ' ' . $this->_values['last_name'];
  }

}
