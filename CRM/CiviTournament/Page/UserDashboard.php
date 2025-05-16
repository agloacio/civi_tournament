<?php

require_once("CRM/CiviTournament/Session.php");
require_once("CRM/CiviTournament/Factories/UserFactory.php");

class CRM_CiviTournament_Page_UserDashboard extends CRM_Core_Page
{

  public function run()
  {
    $userId = Session::getUserId();
    $user = UserFactory::Build($userId);
    $this->assign('user', $user);
    parent::run();
  }
}
