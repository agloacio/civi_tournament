<?php
require_once "TournamentObject.php";
require_once "Session.php";
require_once "Person.php";
require_once 'includes/CiviTournament_Util_Cache.php';
require_once "BillingOrganization.php";

class User extends Person
{
  public $_billingOrganizations;

  public function __construct($id = null)
  {
    if (empty($id)) {
      $id = Session::getLoggedInContactID();
    }

    parent::__construct($id);
    $this->_billingOrganizations = BillingOrganization::getBillingOrganizations($this->_id);
  }
}