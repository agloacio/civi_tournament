<?php
require_once("Contact.php");
require_once("Services/ContactService.php");
require_once("Elements/TextFormElement.php");
require_once("Elements/SelectFormElement.php");
require_once("Elements/GenderFormElement.php");
require_once("Elements/SalutationFormElement.php");
require_once("Elements/GenerationFormElement.php");
require_once("Elements/DateTimeFormElement.php");

/**
 * Peron Form controller class
 *
 * Form to add and update people.
 * 
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */

class CRM_CiviTournament_Form_Person extends CRM_CiviTournament_Form_Contact 
{
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $this->_formElements = array_merge(
      $this->_formElements,
      array(
        new TextFormElement('lastName', 'Last Name',  FormElement::REQUIRED),
        new TextFormElement('firstName', 'First Name',  FormElement::REQUIRED),
        new TextFormElement('middleName', 'Middle Name', FormElement::OPTIONAL),
        new GenderFormElement('gender', 'Gender', FormElement::OPTIONAL),
        new DateTimeFormElement('birthDate', 'Birth Date', FormElement::OPTIONAL),        
        new SalutationFormElement('salutation', 'Salutation', FormElement::OPTIONAL),
        new GenerationFormElement('generation', 'Generation', FormElement::OPTIONAL)
      )
    );
  }

  protected function saveValues($person){
    return ContactService::SavePerson($person);
  }

  protected function getPersistedEntity(int $personId)
  {
    return ContactService::GetPerson($personId);
  }
}
