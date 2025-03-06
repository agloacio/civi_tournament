<?php
require_once "CRM/CiviTournament/Genders.php";

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

    $genders = Genders::get();
    $this->add('select', 'gender_id', ts('Gender'), $genders);

    $this->applyFilter('__ALL__', 'trim');
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Save'),
        'isDefault' => TRUE,
      ),
    ));

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