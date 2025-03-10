<?php
require_once "CRM/CiviTournament/Session.php";
require_once "TournamentObject.php";
require_once "Person.php";
require_once "BillingOrganization.php";
require_once "RegistrationGroup.php";

class User extends Person
{
  /** @var BillingOrganization $_billingOrganizations */

  public array $_billingOrganizations;
  public array $_registrationGroups;

  public function __construct(?int $id = null)
  {
    if (empty($id)) {
      $id = Session::getLoggedInContactID();
    }

    parent::__construct($id);
    $this->_billingOrganizations = BillingOrganization::getBillingOrganizations($this->_id);
    $this->_registrationGroups = RegistrationGroup::getEditableRegistrationGroups($this->_id);
  }
}