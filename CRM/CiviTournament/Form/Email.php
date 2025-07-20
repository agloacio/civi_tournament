<?php
require_once "Form.php";
require_once "Field.php";

use \Civi\Api4\Email as Entity;

/**
 * Email Form controller class
 *
 * Create/Update Email Addresses.
 * 
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 *
 * @version 1.0
 * @author msteigerwald
 */
class CRM_CiviTournament_Form_Email extends CRM_CiviTournament_Form
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $entity = $this->getDefaultEntity();

    $this->_formElements = array(
      new FormElement($entity, 'contact_id', 'contact_id', 'Hidden', TRUE),
      new FormElement($entity, 'location_type_id', 'location_type_id', 'Hidden', TRUE),
      new FormElement($entity, 'is_primary', 'Is primary?', 'Hidden', TRUE),
      new FormElement($entity, 'is_billing', 'Is billing?', 'Hidden', TRUE),
      new FormElement($entity, 'email', 'Email', 'Text', TRUE)
    );
  }

  public function getDefaultEntity()
  {
    return 'email';
  }


  protected function initializeGetSingleRecordAction(int $id)
  {
    return Entity::get(TRUE)
      ->addWhere('id', '=', $id)
      ->setLimit(1);
  }
}
