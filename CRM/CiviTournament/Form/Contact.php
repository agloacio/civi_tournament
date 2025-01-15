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
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $entity = $this->getDefaultEntity();

    $this->_fields = array(
      new Field($entity, 'id', 'id', 'Hidden', FALSE)
    );
  }

  public function preProcess()
  {
    $this->_id = $this->_id ?? CRM_Utils_Request::retrieve('cid', 'Positive') ?? Session::getLoggedInContactID();
    parent::preProcess();
  }

  public function postProcess() {
    $this->_values = $this->exportValues();
    $this->_updateAction = Entity::update(FALSE)->addWhere('id', '=', $this->_values["id"]);
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
