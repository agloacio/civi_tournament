<?php
class Session
{

  /**
   * Get the contact ID of the currently logged-in user.
   *
   * @return int|null The contact ID, or null if the user is not logged in.
   */
  static function getUserId()
  {
    $session = CRM_Core_Session::singleton();
    return $session->get('userID');
  }
}