<?php

require_once("Services/UserService.php");
require_once("Models/Tournament.php");

class CRM_CiviTournament_Page_UserDashboard extends CRM_Core_Page
{
  public function run()
  {
    $session = CRM_Core_Session::singleton();
    $userId = $session->get('userID'); 

    $user = UserService::Get($userId);
    $this->assign('user', $user);

    $tournament = new Tournament(null, "AGLOA2026", "AGLOA 2026", "AGLOA 2026", new DateTimeImmutable("2026-03-21"));
    $this->assign('tournament', $tournament);

    parent::run();
  }
}
