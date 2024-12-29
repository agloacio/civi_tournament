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
  public $_firstName;

  public function __construct($id = null){
    $this->_id = $id;
    if (!empty($this->_id)) {
      $individuals = Entity::get(TRUE)
        ->addWhere('id', '=', $this->_id)
        ->setLimit(1)
        ->execute();
      if ($individuals) {

        $individual = $individuals[0];

        if (!empty($individual['id'])) {
          $this->_firstName = $individual['first_name'];
        }

      }
    }
  }
}