<?php
/**
 * Persist Settings
 *
 * Creates and retrieves RegistrationGroupType setting for CiviTournament Extension
 *
 * @version 1.0
 * @author steig
 */

require_once('Settings.php');
require_once('GroupTypeOptionGroup.php');

class RegistrationGroupType extends Settings
{
  protected static function computeFields()
  {
    $GroupTypeOptionGroup = GroupTypeOptionGroup::get()['id'];

    return [
      'name' => 'Registration Group',
      'label' => 'Registration Group',
      'description' => 'For competition-type events, participants are usually registered as a group, especially for billing purposes.',
      'option_group_id' => $GroupTypeOptionGroup,
      'is_active' => TRUE,
      'is_reserved' => FALSE,
      'value' => null,
    ];
  }
  public static function addWhere($getAction)
  {
    return $getAction->addWhere('label', '=', 'Registration Group');
  }

  protected static function getEntity()
  {
    return \Civi\Api4\OptionValue::class;
  }
}