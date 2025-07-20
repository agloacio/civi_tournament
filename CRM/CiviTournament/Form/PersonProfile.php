<?php
require_once("Contact.php");
require_once("Services/ContactService.php");
require_once("Elements/TextFormElement.php");
require_once("Elements/SelectFormElement.php");
require_once("Elements/GenderFormElement.php");
require_once("Elements/SalutationFormElement.php");
require_once("Elements/GenerationFormElement.php");
require_once("Elements/DateTimeFormElement.php");
require_once("Elements/AddressFormElement.php");
require_once("Elements/RegionFormElement.php");

/**
 * Peron Form controller class
 *
 * Form to add and update people.
 * 
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */

class CRM_CiviTournament_Form_PersonProfile extends CRM_CiviTournament_Form_ContactProfile 
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $this->_formElements = array_merge(
      array(
        new TextFormElement('lastName', 'Last Name', FormElement::REQUIRED),
        new TextFormElement('firstName', 'First Name', FormElement::REQUIRED),
        new TextFormElement('middleName', 'Middle Name', FormElement::OPTIONAL),
        new GenderFormElement('gender', 'Gender', FormElement:: OPTIONAL),
        new DateTimeFormElement('birthDate', 'Birth Date', FormElement::OPTIONAL),        
        new SalutationFormElement('salutation', 'Salutation', FormElement::OPTIONAL),
        new GenerationFormElement('generation', 'Generation', FormElement::OPTIONAL)
      ),
      $this->_formElements
    );
  }


  public function getDefaultEntity()
  {
    return 'personProfile';
  }

  protected function getPersistedEntity(int $personId)
  {
    return ContactService::GetPersonProfile($personId);
  }

  protected function getValuesForUpdate() : array
  {
    $values = parent::getValuesForUpdate();

    $values["lastName"] = $this->_entity->person->lastName;
    $values["firstName"] = $this->_entity->person->firstName;
    $values["middleName"] = $this->_entity->person->middleName;
    $values["gender"] = $this->_entity->person->gender->id;
    $values["birthDate"] = $this->_entity->person->birthDate->format("Y-m-d");
    $values["generation"] = $this->_entity->person->generation->id;
    $values["salutation"] = $this->_entity->person->salutation->id;
    return $values;
  }

  protected function saveValues($personProfile)
  {
    $personProfile["name"] = "{$personProfile['lastName']}, {$personProfile['firstName']}";
    return ContactService::SavePersonProfile($personProfile);
  }
}
