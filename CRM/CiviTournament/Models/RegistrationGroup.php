<?php

/**
 * Group of contacts registered together
 *
 * For competition-type events, participants are usually registered as a group, especially for billing purposes.
 *
 * @version 1.0
 * @author msteigerwald
 */
require_once("Settings/RegistrationGroupType.php");

class RegistrationGroup extends Group
{
  public function __construct($id, $name = null)
  {
    parent::__construct($id, $name);
  }

  /**
   * Retrieves all "Registration Group" groups that a contact has permission to edit.
   *
   * @param int $contactId The ID of the contact.
   *
   * @return array An associative array of group IDs and titles, or an empty array if none are found.
   *               Returns an error message string if there's an issue with the API call.
   */
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

  public static function create($name)
  {
    $group_type = RegistrationGroupType::get()["value"];

    \Civi\Api4\Group::create(TRUE)
      ->addValue('name', $name)
      ->addValue('title', $name)
      ->addValue('description', $name)
      ->addValue('is_active', TRUE)
      ->addValue('group_type', [$group_type])
      ->execute();
  }
}