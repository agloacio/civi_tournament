<?php
require_once "TournamentObject.php";

use \Civi\Api4\Individual as Entity;

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
  public string $_firstName;
  public ?string $_middleName;
  public string $_lastName;
  public $_gender;
  public ?DateTime $_birthDate;
  public ?string $_prefix;
  public ?string $_suffix;

  public function __construct(?int $id = null){
    parent::__construct($id);
    if (!empty($this->_id)) {
      /** @var array $individuals */
       $individuals = Entity::get(TRUE)
        ->addSelect('display_name', 'sort_name', 'first_name', 'middle_name', 'last_name', 'gender_id', 'gender_id:label', 'birth_date', 'prefix_id', 'prefix_id:label', 'suffix_id', 'suffix_id:label')
        ->addWhere('id', '=', $this->_id)
        ->setLimit(1)
        ->execute();

      if ($individuals) {
        $individual = $individuals[0];

        if (!empty($individual['id'])) {
          $this->_name = $individual['sort_name'];
          $this->_label = $individual['display_name'];
          $this->_firstName = $individual['first_name'];
          $this->_middleName = $individual['middle_name'];
          $this->_lastName = $individual['last_name'];
          $this->_gender = $individual['gender_id:label'];
          $this->_birthDate = new DateTime($individual['birth_date']);
          $this->_prefix = $individual['prefix_id:label'];
          $this->_suffix = $individual['suffix_id:label'];
        }

      }
    }
  }
}