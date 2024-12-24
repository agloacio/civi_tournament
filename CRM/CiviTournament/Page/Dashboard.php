<?php
use CRM_CiviTournament_ExtensionUtil as E;


//    CRM_CiviTournament_Page_Dashboard
class CRM_CiviTournament_Page_Dashboard extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('Dashboard'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));

    parent::run();
  }

}
