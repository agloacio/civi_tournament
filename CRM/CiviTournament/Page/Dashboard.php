<?php
use CRM_CiviTournament_ExtensionUtil as E;

require_once "CRM/CiviTournament/User.php";

class CRM_CiviTournament_Page_Dashboard extends CRM_Core_Page
{

  public function run()
  {
    $user = new User();
    $user->_name = 'Mike';
    $user->_contactUrl = 'http://localhost:45875/wp-admin/admin.php?page=CiviCRM&q=civicrm/tournament/person';
    $this->assign('user', $user);

    parent::run();
  }
}
