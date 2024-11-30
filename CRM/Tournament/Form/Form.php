<?php

/**
 * Form short summary.
 *
 * Form description.
 *
 * @version 1.0
 * @author msteigerwald
 */
  
class Tournament_Core_Form extends CRM_Core_Form
{
  protected $_values;
  protected $_id;
  protected $_fieldNames;

  public function preProcess()
  {
    parent::preProcess();

    $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this, FALSE, 'update');
  }

  protected function update(){
    $getAction = $this->getGetSingleRecordAction();

    foreach ($this->_fieldNames as &$fieldName) {
      $getAction = $getAction->addSelect($fieldName);
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

    if (!CRM_Core_Permission::check($this->getDefaultEntity(), $this->_id, 'edit')) {
      CRM_Utils_System::permissionDenied();
      CRM_Utils_System::civiExit();
    }

    $this->updateTitle();
  }
}