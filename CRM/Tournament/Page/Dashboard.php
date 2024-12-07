<?php
use Civi\Api4\Contact;
use CRM_Tournament_ExtensionUtil as E;

require_once "CRM/Tournament/User.php";

class CRM_Tournament_Page_Dashboard extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('Dashboard'));

    //$contact = new Contact();
    //$contact->fir

    $user = new User();
    $user->_name = 'Mike';
    $user->_contactUrl = 'http://localhost:45875/wp-admin/admin.php?page=CiviCRM&q=civicrm%2Fperson';

    //$user->_contact = $contact;

    //$this->assign('user', $user);

    // Example: Assign a variable for use in a template
    $this->assign('user', $user);

    parent::run();
  }

}
