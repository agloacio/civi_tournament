<?php

/**
 * Group of contacts registered together
 *
 * For competition-type events, participants are usually registered as a group, especially for billing purposes.
 *
 * @version 1.0
 * @author msteigerwald
 */
require_once("RegistrationGroupType.php");

class RegistrationGroup extends TournamentObject
{
  /**
   * Retrieves all "Registration Group" groups that a contact has permission to edit.
   *
   * @param int $contactId The ID of the contact.
   *
   * @return array An associative array of group IDs and titles, or an empty array if none are found.
   *               Returns an error message string if there's an issue with the API call.
   */
  public function __construct($id, $name = null)
  {
    parent::__construct($id, $name);
  }

  public static function getEditableRegistrationGroups($contactId)
  {
    $registrationGroupTypeId = RegistrationGroupType::get()["value"];
    try {
      $registrationGroups = \Civi\Api4\Group::get()
        ->addSelect('id', 'title')
        ->addWhere('group_type', '=', $registrationGroupTypeId)
        ->addWhere('is_active', '=', true)
        ->execute();

      $editableRegistrationGroups = [];
      foreach ($registrationGroups as $group) {
        try {
          \Civi\Api4\Group::update()
            ->addWhere('id', '=', $group['id'])
            ->addValue('title', $group['title']) 
            ->execute();

          // If no exception, they have edit permission.
          $editableRegistrationGroups[] = new RegistrationGroup($group['id'], $group['title']);

        } catch (\Exception $e) { 
          if ($e->getMessage() === 'Permission denied') {
            // The contact does not have permission to edit this group.  Do nothing.
          } else {
            // Some other API error occurred.  Handle it appropriately.
            return "CiviCRM API Error: " . $e->getMessage(); 
          }
        }
      }
      return $editableRegistrationGroups;

    } catch (\Exception $e) {
      return "An unexpected error occurred: " . $e->getMessage();
    }
  }

  private function createRegistrationGroup()
  {
    $results = \Civi\Api4\Group::create(TRUE)
      ->addValue('name', 'Example School')
      ->addValue('title', 'Example School')
      ->addValue('description', 'Example School')
      ->addValue('is_active', TRUE)
      ->addValue('group_type', [
        3,
      ])
      ->addValue('parents', [
        2,
      ])
      ->execute();
    foreach ($results as $result) {
      // do something
    }
  }
}