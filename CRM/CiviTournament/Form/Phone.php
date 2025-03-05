<?php
require_once "Form.php";
require_once "Field.php";

use \Civi\Api4\Phone as Entity;

/**
 * Phone # Form controller class
 *
 * Create/Update Phone #s.
 * 
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 *
 * @version 1.0
 * @author msteigerwald
 */
class CRM_CiviTournament_Form_Phone extends CRM_CiviTournament_Form
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $entity = $this->getDefaultEntity();

    $this->_fields = array(
      new Field($entity, 'contact_id', 'contact_id', 'Hidden', TRUE),
      new Field($entity, 'location_type_id', 'location_type_id', 'Hidden', TRUE),
      new Field($entity, 'is_primary', 'Is primary?', 'Hidden', TRUE),
      new Field($entity, 'is_billing', 'Is billing?', 'Hidden', TRUE),
      new Field($entity, 'phone_type_id', 'phone_type_id', 'Hidden', TRUE),
      new Field($entity, 'phone', 'Phone #', 'Text', TRUE),
      new Field($entity, 'phone_ext', 'Extension', 'Text', TRUE)
    );
  }

  public function getDefaultEntity()
  {
    return 'phone';
  }


  protected function initializeGetSingleRecordAction()
  {
    return Entity::get(TRUE)
      ->addWhere('id', '=', $this->_id)
      ->setLimit(1);
  }

  public function preProcess()
  {
    parent::getId();
    parent::preProcess();
  }
}
