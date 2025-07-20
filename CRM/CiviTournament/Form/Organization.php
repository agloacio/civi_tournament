<?php
require_once("Form.php");
require_once("Elements/TextFormElement.php");
require_once("Elements/AddressFormElement.php");
require_once("Elements/RegionFormElement.php");
require_once("Services/ContactService.php");
/**
 * Billing Organization Form controller class
 *
 * Create/Update Organizations.
 * 
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 *
 * @version 1.0
 * @author msteigerwald
 */
class CRM_CiviTournament_Form_Organization extends CRM_CiviTournament_Form_Contact
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $this->_formElements = array_merge(
      $this->_formElements,
      array(
        new TextFormElement('name', 'Name', TRUE),
        new TextFormElement('email', 'Email', TRUE),
        new TextFormElement('mainPhone', 'Main Phone', TRUE),
        new TextFormElement('mobilePhone', 'On Site Phone', TRUE, 'How can we reach you at the tournament?'),
        new AddressFormElement('streetAddress', 'Address', TRUE),
        new AddressFormElement('supplementalAddress', 'Address (cont.)', FALSE),
        new AddressFormElement('city', 'City', TRUE),
        //new TextFormElement('country', 'Country', CRM_CiviTournament_Form::COUNTRY_SELECT, FALSE),
        new RegionFormElement('region', 'State', TRUE),
        new AddressFormElement('postalCode', 'Postal Code', TRUE),
        new AddressFormElement('postalCodeSuffix', 'Postal Code Suffix', FALSE),
      )
    );
  }

  protected function getPersistedEntity(int $organizationId)
  {
    return ContactService::GetOrganizationProfile($organizationId);
  }

  protected function saveValues($organizationProfile)
  {
    return ContactService::SaveOrganizationProfile($organizationProfile);
  }
}
