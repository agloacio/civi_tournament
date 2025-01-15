<?php
require_once "Form.php";
require_once "Field.php";

/**
 * Billing Organization Form controller class
 *
 * Create/Update Billing Organizations.
 * 
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 *
 * @version 1.0
 * @author msteigerwald
 */
class CRM_CiviTournament_Form_BillingOrganization extends CRM_CiviTournament_Form_Contact
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $entity = $this->getDefaultEntity();

    $this->_fields = array_merge(
      $this->_fields,
      array(
        new Field($entity, 'organization_name', 'Name', 'Text', TRUE),
        new Field($entity, 'email_primary.email', 'Email', 'Text', TRUE),
        new Field($entity, 'phone_billing.phone', 'Main Phone', 'Text', TRUE),
        new Field($entity, 'phone_primary.phone', 'On Site Phone', 'Text', TRUE, 'How can we reach you at the tournament?'),
        new Field($entity, 'address_primary.street_address', 'Address', 'Text', TRUE),
        new Field($entity, 'address_primary.supplemental_address_1', 'Address (cont.)', 'Text', FALSE),
        new Field($entity, 'address_primary.city', 'City', 'Text', TRUE),
        new Field($entity, 'address_primary.state_province_id', 'State', CRM_CiviTournament_Form::STATE_PROVINCE_SELECT, TRUE),
        new Field($entity, 'address_primary.postal_code', 'Postal Code', 'Text', TRUE),
        new Field($entity, 'address_primary.postal_code_suffix', 'Postal Code Suffix', 'Text', FALSE),
        new Field($entity, 'address_primary.country_id', 'Country', CRM_CiviTournament_Form::COUNTRY_SELECT, FALSE)
      )
    );
  }
}
