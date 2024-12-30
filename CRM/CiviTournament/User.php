<?php
require_once "TournamentObject.php";
require_once "Session.php";
require_once "CiviTournament_Utils_System.php";
require_once "Person.php";
require_once 'includes/CiviTournament_Util_Cache.php';

class User extends TournamentObject
{
  public $_contactUrl;
  public $_billingOrganizations;

  public function __construct($id = null)
  {
    if (empty($id)) {
      $id = Session::getLoggedInContactID();
    }

    $this->_id = $id;

    $person = new Person($id);

    $this->_label = $person->_firstName;
    $this->_contactUrl = CiviTournament_Utils_System::civi_tournament_get_person_url($this->_id);

    $billingOrganizationContactTypeID = CiviTournament_Util_Cache::getBillingOrganizationRelationshipTypeID();

    if ($billingOrganizationContactTypeID) {
      $this->_billingOrganizations = \Civi\Api4\Relationship::get(FALSE)
        ->addSelect('contact_id_b', 'contact_id_b.display_name')
        ->addWhere('contact_id_a', '=', $this->_id)
        ->addWhere('relationship_type_id', '=', $billingOrganizationContactTypeID)
        ->addWhere('is_active', '=', TRUE)
        ->execute();
    } 
  }
}