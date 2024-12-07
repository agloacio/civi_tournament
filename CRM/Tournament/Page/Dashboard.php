<?php
use Civi\Api4\Contact;
use CRM_Tournament_ExtensionUtil as E;

require_once "CRM/Tournament/User.php";

class CRM_Tournament_Page_Dashboard extends CRM_Core_Page
{

  public function run()
  {
    $user = new User();
    $user->_name = 'Mike';
    $user->_contactUrl = 'http://localhost:45875/wp-admin/admin.php?page=CiviCRM&q=civicrm%2Fperson';
    $this->assign('user', $user);

    parent::run();
  }
}
