<?php
require_once "CRM/CiviTournament/Models/Settings/Genders.php";

/**
 * CRM_CiviTournament_Form_AccountRequest lets a new user apply for an account.
 *
 * An account combines an individual, an organization and a registration group. If approved the indivdial gets full access to the organizationa and all contacts in the registration group.
 *
 * @version 1.0
 * @author msteigerwald
 */

class CRM_CiviTournament_Form_AccountRequest extends CRM_Core_Form {
  public function __construct(
    $state = NULL,
    $action = CRM_Core_Action::ADD,
    $method = 'post',
    $name = NULL
  )
  {
    parent::__construct($state, $action ?? CRM_Core_Action::ADD, $method, $name);
  }

  public function buildQuickForm() {
    $required = true;  

    $this->add('text', 'email', ts('Email'), array('placeholder' => ts('Your Email')), $required);
    $this->add('text', 'organizationName', ts('Organization Name (e.g., School or School District)'), array('placeholder' => ts('School or District Name')), $required);
    $this->add('text', 'firstName', ts('First Name'), array('placeholder' => ts('First Name')), $required);
    $this->add('text', 'lastName', ts('Last Name'), array('placeholder' => ts('Last Name')), $required);
    $this->add('select', 'gender_id', ts('Gender'), array_merge([0 => '-- Select Gender --'], Genders::get()));
    $this->add('text', 'address', ts('Address'), array('placeholder' => ts('Address')), $required);
    $this->add('text', 'city', ts('City'), array('placeholder' => ts('City')), $required);
    $this->add('text', 'postalCode', ts('Zip'), array('placeholder' => ts('Zip')), $required);
    $this->add('text', 'phone', ts('Land Line'), array('placeholder' => ts('Land Line')), $required);
    $this->add('text', 'mobile_phone', ts('Mobile Phone'), array('placeholder' => ts('Mobile Phone')));

    $this->applyFilter('__ALL__', 'trim');
    $this->addButtons([
      [
        'type' => 'submit',
        'name' => ts('Save'),
        'isDefault' => TRUE,
      ],
    ]);

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());

    //parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->controller->exportValues($this->getName());
    parent::postProcess();
  }

  private function getRenderableElementNames()
  {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }
}