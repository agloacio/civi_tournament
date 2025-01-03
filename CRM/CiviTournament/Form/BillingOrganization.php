<?php
require_once "Form.php";
require_once "Field.php";

use \Civi\Api4\Organization as Entity;

/**
 * Billing Organization Form controller class
 *
 * Create/Update Billing Organizations.
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 *
 * @version 1.0
 * @author msteigerwald
 */
class CRM_CiviTournament_Form_BillingOrganization extends CRM_CiviTournament_Form
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $entity = $this->getDefaultEntity();

    $this->_fields = array(
      new Field($entity, 'organization_name', 'Name', 'Text', TRUE),
      new Field($entity, 'email_primary.email', 'Email', 'Text', TRUE),
      new Field($entity, 'phone_billing.phone', 'Phone', 'Text', TRUE),
      new Field($entity, 'phone_primary.phone', 'Phone (On Site)', 'Text', TRUE, 'How can we reach you at the tournament?'),
      new Field($entity, 'address_primary.street_address', 'Address', 'Text', TRUE),
      new Field($entity, 'address_primary.supplemental_address_1', '', 'Text', FALSE),
      new Field($entity, 'address_primary.city', 'City', 'autocomplete', TRUE),
      new Field($entity, 'address_primary.state_province_id', 'State', 'Select', TRUE),
      new Field($entity, 'address_primary.postal_code', 'Postal Code', 'Text', TRUE),
      new Field($entity, 'address_primary.postal_code_suffix', 'Postal Code Suffix', 'Text', FALSE),
      new Field($entity, 'address_primary.country_id', 'Country', 'Select', FALSE)
    );
  }

  public function preProcess()
  {
    $this->_id = CRM_Utils_Request::retrieve('cid', 'Positive');
    parent::preProcess();
  }

  public function buildQuickForm()
  {
    parent::buildQuickForm();
  }

  public function getDefaultEntity()
  {
    return 'contact';
  }

  protected function initializeGetSingleRecordAction()
  {
    return Entity::get(TRUE)
      ->addWhere('id', '=', $this->_id)
      ->setLimit(1);
  }
}