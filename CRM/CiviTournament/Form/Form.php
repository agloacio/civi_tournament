<?php

use CRM_CiviTournament_ExtensionUtil as E;

class CRM_CiviTournament_Form extends CRM_Core_Form
{
  protected $_values;
  protected $_id;
  protected $_fields;
  protected $_recordName;
  protected $_updateAction;

  public function preProcess()
  {
    parent::preProcess();
    $this->initializeAction();

    if ($this->isNewRecord()) {
      $this->startNewRecord();
    } else if ($this->needsUpdate()) {
      $this->reloadExistingRecord();
    } 
  }

  public function buildQuickForm()
  {
    $legacyDate = FALSE;

    $organizations = \Civi\Api4\Contact::get(FALSE)
      ->addSelect('email_primary.email')
      ->setLimit(25)
      ->execute();

    foreach ($this->_fields as $field) {
      $this->addField($field->_name, $field->_props, $field->_required, $legacyDate);
    }

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

  public function postProcess()
  {
    foreach ($this->_fields as $field) {
      $this->_updateAction->addValue($field->_name, $this->_values[$field->_name]);
    }

    $this->_updateAction->execute();

    $session = CRM_Core_Session::singleton();
    $session->setStatus($this->_recordName, "$this->_name Saved", 'success');

    $this->updateTitle();
  }

  /**
   * Set default values for the form.
   *
   * Note that in edit/view mode the default values are retrieved from the database
   */
  public function setDefaultValues()
  {
    $defaults = $this->_values;
    return $defaults;
  }  

  /**
   * Default form context used as part of addField()
   */
  public function getDefaultContext(): string
  {
    return 'create';
  }

  public function getRenderableElementNames()
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

  protected function reloadExistingRecord()
  {
    $getAction = $this->initializeGetSingleRecordAction();

    foreach ($this->_fields as &$field) {
      $getAction = $getAction->addSelect($field->_name);
    }

    $result = $getAction->execute();

    // Check if record was found
    if (!$result) {
      CRM_Core_Error::statusBounce(ts("Could not find $this->_name with id = $this->_id"));
    }

    $this->_values = $result[0];

    if (empty($this->_values['id'])) {
      CRM_Core_Error::statusBounce(ts("Could not find $this->_name with id = $this->_id"));
    }

    if (!CRM_Core_Permission::check('edit ' . $this->getDefaultEntity() . 's', $this->_id)) {
      CRM_Utils_System::permissionDenied();
      CRM_Utils_System::civiExit();
    }

    $this->updateTitle();
  }

  protected function updateTitle()
  {
    $this->setTitle(ts('Edit %1', [1 => $this->_recordName]));
  }

  protected function startNewRecord()
  {
    // check for add contacts permissions
    if (!CRM_Core_Permission::check('add ' . $this->getDefaultEntity() . 's')) {
      CRM_Utils_System::permissionDenied();
      CRM_Utils_System::civiExit();
    }

    $this->setTitle(ts('New %1', [1 => $this->_name]));

    $session = CRM_Core_Session::singleton();
    $session->pushUserContext(CRM_Utils_System::url('civicrm/dashboard', 'reset=1'));
  }

  private function initializeAction()
  {
    $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this, FALSE, 'update');
  }

  private function isNewRecord() {
    return $this->_action == CRM_Core_Action::ADD;
  }

  private function needsUpdate()
  {
    return $this->_action == CRM_Core_Action::UPDATE;
  }

}