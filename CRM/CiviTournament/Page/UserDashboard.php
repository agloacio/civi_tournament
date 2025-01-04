<?php
use CRM_CiviTournament_ExtensionUtil as E;

require_once "CRM/CiviTournament/User.php";

class CRM_CiviTournament_Page_UserDashboard extends CRM_Core_Page
{

  public function run()
  {
    $user = new User();
    $this->assign('user', $user);

    parent::run();
  }
}
