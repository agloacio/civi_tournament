<?php
require_once("Contact.php");
require_once("Services/ContactService.php");
require_once("Elements/TextFormElement.php");
require_once("Elements/SelectFormElement.php");
require_once("Elements/AddressFormElement.php");
require_once("Elements/RegionFormElement.php");

/**
 * Peron Form controller class
 *
 * Form to add and update people.
 * 
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */

class CRM_CiviTournament_Form_ContactProfile extends CRM_CiviTournament_Form
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $formElements = array_merge($this->_formElements, array(
      new TextFormElement('email', 'Email', FormElement::REQUIRED),

      new TextFormElement('mainPhone', 'Main Phone', FormElement::REQUIRED),
      new TextFormElement('extension', 'Extension', FormElement::OPTIONAL),
      new TextFormElement('onsitePhone', 'On Site Phone', FormElement::REQUIRED, 'How can we reach you at the tournament?'),

      new AddressFormElement('streetAddress', 'Address', FormElement::REQUIRED),
      new AddressFormElement('supplementalAddress', 'Address (cont.)', FormElement::OPTIONAL),
      new AddressFormElement('city', 'City', FormElement::REQUIRED),
      new RegionFormElement('region', 'State', FormElement::REQUIRED),
      new AddressFormElement('postalCode', 'Postal Code', FormElement::REQUIRED),
      new AddressFormElement('postalCodeSuffix', 'Postal Code Suffix', FormElement::OPTIONAL),
    ));

    $this->_formElements = $formElements;
  }

  protected function getPersistedEntity(int $contactId)
  {
    return ContactService::GetContactProfile($contactId);
  }

  protected function getValuesForUpdate(): array
  {
    $values = parent::getValuesForUpdate();

    $values["email"] = $this->_entity->email?->email;

    $values["mainPhone"] = $this->_entity->mainPhone?->phone;

    $values["extension"] = $this->_entity->mainPhone?->extension;
    $values["onsitePhone"] = $this->_entity->mobilePhone?->phone;
    $values["streetAddress"] = $this->_entity->address?->streetAddress;
    $values["supplementalAddress"] = $this->_entity->address?->streetAddress1;
    $values["city"] = $this->_entity->address?->city;
    $values["region"] = $this->_entity->address?->region;
    $values["postalCode"] = $this->_entity->address?->postalCode;
    $values["postalCodeSuffix"] = $this->_entity->address?->postalCodeSuffix;
    return $values;
  }

  protected function saveValues($contactProfile)
  {
    return ContactService::SaveContactProfile($contactProfile);
  }
}
