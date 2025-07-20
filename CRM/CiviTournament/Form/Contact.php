<?php
require_once "Form.php";
require_once("Elements/HiddenFormElement.php");

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
  public function postProcess() {
    $this->values = $this->exportValues();
    $this->setEntityLabel();
    $this->updateAction = Entity::update(FALSE)->addWhere('id', '=', $this->values["id"]);
    parent::postProcess();
  }

  public function getDefaultEntity()
  {
    return 'contact';
  }

  protected function initializeGetSingleRecordAction(int $id)
  {
    return entity::get(true)
      ->addselect("display_name", "sort_name")
      ->addwhere('id', '=', $id)
      ->setlimit(1);
  }

  protected function setEntityLabel()
  {
    $this->entityLabel = $this->values['name'];
  }
}
