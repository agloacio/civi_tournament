<?php
require_once "TournamentObject.php";

/**
 * Person properties, similar to CiviCRM Individual.
 *
 * Person identity characteristics, e.g., name, DOB & gender.
 *
 * @version 1.0
 * @author msteigerwald
 */
class Person extends TournamentObject
{
  private string $_lastName;
  private string $_firstName;
  private ?string $_middleName;
  private ?Gender $_gender;
  private ?DateTime $_birthDate;
  private ?Generation $_generation;
  private ?Salutation $_salutation;

  public function __construct(string $lastName, string $firstName, ?string $middleName, ?Gender $gender, ?DateTime $birthDate, ?Generation $generation, ?Salutation $salutation)
  {
    $displayName = $firstName . " " . $middleName . " " . $lastName;
    parent::__construct(null, $firstName . $lastName, $displayName, $displayName);
    $this->_lastName = $lastName;
    $this->_firstName = $firstName;
    $this->_middleName = $middleName;
    $this->_gender = $gender;
    $this->_birthDate = $birthDate;
    $this->_generation = $generation;
    $this->_salutation = $salutation;
  }

  //public function __construct(?int $id = null){
  //  parent::__construct($id);
  //  if (!empty($this->_id)) {
  //    /** @var array $individuals */
  //     $individuals = Entity::get(TRUE)
  //      ->addSelect('display_name', 'sort_name', 'first_name', 'middle_name', 'last_name', 'gender_id', 'gender_id:label', 'birth_date', 'prefix_id', 'prefix_id:label', 'suffix_id', 'suffix_id:label')
  //      ->addWhere('id', '=', $this->_id)
  //      ->setLimit(1)
  //      ->execute();

  //    if ($individuals) {
  //      $individual = $individuals[0];

  //      if (!empty($individual['id'])) {
  //        $this->_name = $individual['sort_name'];
  //        $this->_label = $individual['display_name'];
  //        $this->_firstName = $individual['first_name'];
  //        $this->_middleName = $individual['middle_name'];
  //        $this->_lastName = $individual['last_name'];
  //        $this->_gender = $individual['gender_id:label'];
  //        $this->_birthDate = new DateTime($individual['birth_date']);
  //        $this->_prefix = $individual['prefix_id:label'];
  //        $this->_suffix = $individual['suffix_id:label'];
  //      }

  //    }
  //  }
  //}
}