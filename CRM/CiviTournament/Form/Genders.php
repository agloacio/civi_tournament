<?php
require_once "CRM/CiviTournament/Genders.php";

/**
 * CRM_CiviTournament_Form_Genders poplulates a select element with the available genders.
 *
 * @version 1.0
 * @author msteigerwald
 */

class CRM_CiviTournament_Form_Genders extends CRM_Core_Form {
  public function __construct(
    $state = NULL,
    $action = CRM_Core_Action::VIEW,
    $method = 'get',
    $name = NULL
  )
  {
    parent::__construct($state, $action ?? CRM_Core_Action::VIEW, $method, $name);
  }

  public function buildQuickForm() {
    $required = true;
    $genders = Genders::get();

    $this->addElement('select', 'gender_id', ts('Gender'), $genders);

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
  }

  public function postProcess() {
    parent::postProcess();
  }

  public function getDefaultEntity()
  {
    return 'OptionValue';
  }

  private function getRenderableElementNames()
  {
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