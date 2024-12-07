<?php
use \Civi\Api4\Individual as Api;
require_once "CRM/Tournament/Session.php";

class User
{
  public $_id;
  public $_name;
  public $_contactUrl;

  public function __construct($id = null)
  {
    if (empty($id)) {
      $id = Session::getLoggedInContactID();
    }

    $this->_id = $id;
  }
}