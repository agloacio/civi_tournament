<?php
require_once "Form.php";

use \Civi\Api4\Contact as Entity;

/**
 * Contact Form controller class
 *
 * Common form methods that apply to BOTH people and organizations.
 * 
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_CiviTournament_Form_Contact extends CRM_CiviTournament_Form 
{
  public function preProcess()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $this->_id = CRM_Utils_Request::retrieve('cid', 'Positive');
    }
    parent::preProcess();
  }

  public function buildQuickForm() {
    parent::buildQuickForm();
  }

  public function postProcess() {
    $this->_values = $this->_values ?? $this->exportValues();
    $this->_updateAction = Entity::update(FALSE)->addWhere('id', '=', $this->_id);
    parent::postProcess();
  }

  public function getDefaultEntity()
  {
    return 'contact';
  }

  protected function initializeGetSingleRecordAction()
  {
    return Entity::get(TRUE)
      ->addSelect("display_name", "sort_name")
      ->addWhere('id', '=', $this->_id)
      ->setLimit(1);
  }

  protected function setRecordName()
  {
    $this->_recordName = $this->_values['display_name'];
  }
}
