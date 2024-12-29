<?php
require_once "TournamentObject.php";
require_once "CRM/CiviTournament/Session.php";

class User extends TournamentObject
{
  public $_contactUrl;

  public function __construct($id = null)
  {
    if (empty($id)) {
      $id = Session::getLoggedInContactID();
    }

    $this->_id = $id;

    $this->_label = 'Mike';
    $this->_contactUrl = "http://localhost:45875/wp-admin/admin.php?page=CiviCRM&q=civicrm/tournament/person&cid={$this->_id}";
  }
}