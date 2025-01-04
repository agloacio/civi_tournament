<?php
require_once "TournamentObject.php";
require_once "Session.php";
require_once "CiviTournament_Utils_System.php";
require_once "Person.php";
require_once 'includes/CiviTournament_Util_Cache.php';
require_once "BillingOrganization.php";

class User extends TournamentObject
{
  public $_billingOrganizations;

  public function __construct($id = null)
  {
    if (empty($id)) {
      $id = Session::getLoggedInContactID();
    }

    $this->_id = $id;

    $person = new Person($id);

    $this->_label = $person->_firstName;
    $this->_billingOrganizations = BillingOrganization::getBillingOrganizations($this->_id);
  }
}