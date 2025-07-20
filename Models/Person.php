<?php

require_once("Contact.php");
require_once("Gender.php");
require_once("Generation.php");
require_once("Salutation.php");

/**
 * Person properties, similar to CiviCRM Individual.
 *
 * Person identity characteristics, e.g., name, DOB & gender.
 *
 * @version 1.0
 * @author msteigerwald
 */
class Person extends Contact
{
  private string $_lastName;
  private string $_firstName;
  private ?string $_middleName;
  private ?Gender $_gender;
  private ?DateTime $_birthDate;
  private ?Generation $_generation;
  private ?Salutation $_salutation;

  public function __construct(?int $id, string $lastName, string $firstName, ?string $middleName, ?Gender $gender, ?DateTime $birthDate, ?Generation $generation, ?Salutation $salutation)
  {
    $displayName = $firstName . " " . $middleName . " " . $lastName;
    parent::__construct($id, $firstName . $lastName, $displayName, $displayName);
    $this->_lastName = $lastName;
    $this->_firstName = $firstName;
    $this->_middleName = $middleName;
    $this->_gender = $gender;
    $this->_birthDate = $birthDate;
    $this->_generation = $generation;
    $this->_salutation = $salutation;
  }


  public function __get($name)
  {
    switch ($name) {
      case "lastName":
        return $this->_lastName;
      case "firstName":
        return $this->_firstName;
      case "middleName":
        return $this->_middleName;
      case "gender":
        return $this->_gender;
      case "birthDate":
        return $this->_birthDate;
      case "generation":
        return $this->_generation;
      case "salutation":
        return $this->_salutation;
      default:
        return parent::__get($name);
    }
  }
}