<?php
require_once "Form.php";
require_once "Field.php";

use \Civi\Api4\Address as Entity;

/**
 * Address Form controller class
 *
 * Create/Update Addresses.
 * 
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 *
 * @version 1.0
 * @author msteigerwald
 */
class CRM_CiviTournament_Form_Address extends CRM_CiviTournament_Form
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $entity = $this->getDefaultEntity();

    $this->_fields = array(
      new Field($entity, 'contact_id', 'contact_id', 'Hidden', TRUE),
      new Field($entity, 'street_address', 'Address', 'Text', TRUE),
      new Field($entity, 'supplemental_address_1', 'Address (cont.)', 'Text', FALSE),
      new Field($entity, 'city', 'City', 'Text', TRUE),
      new Field($entity, 'country_id', 'Country', CRM_CiviTournament_Form::COUNTRY_SELECT, FALSE),
      new Field($entity, 'state_province_id', 'State', CRM_CiviTournament_Form::STATE_PROVINCE_SELECT, TRUE),
      new Field($entity, 'postal_code', 'Postal Code', 'Text', TRUE),
      new Field($entity, 'postal_code_suffix', 'Suffix', 'Text', FALSE)
    );
  }

  public function getDefaultEntity()
  {
    return 'address';
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
