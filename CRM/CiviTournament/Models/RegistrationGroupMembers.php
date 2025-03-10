<?php

/**
 * RegistrationGroupMembers short summary.
 *
 * RegistrationGroupMembers description.
 *
 * @version 1.0
 * @author msteigerwald
 */
class RegistrationGroupMembers
{
  public function get(){
    $groupContacts = \Civi\Api4\GroupContact::get(TRUE)
      ->addSelect('group_id:label', 'contact_id.contact_type', 'contact_id.sort_name')
      ->addWhere('status', '=', 'Added')
      ->addWhere('group_id.group_type', '=', 4)
      ->addWhere('contact_id.contact_type', '=', 'Individual')
      ->setLimit(25)
      ->execute();
  }
}