<?php
require_once "Form.php";
require_once "Field.php";

/**
 * Registration Group Form controller class
 *
 * Create/Update Registration Groups.
 * 
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 *
 * @version 1.0
 * @author msteigerwald
 */
class CRM_CiviTournament_Form_RegistrationGroup extends CRM_CiviTournament_Form_Contact
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $entity = $this->getDefaultEntity();

    $this->_fields = array_merge(
      $this->_fields,
      array(
        new Field($entity, 'organization_name', 'Name', 'Text', TRUE)
      )
    );
  }

  public function preProcess()
  {
    parent::getId();
    parent::preProcess();
  }
}
