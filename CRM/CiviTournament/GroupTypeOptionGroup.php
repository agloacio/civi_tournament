<?php
/**
 * Persist GroupTypeOptionGroup Settings
 *
 * Creates and retrieves GroupTypeOptionGroup setting for CiviTournament Extension
 *
 * @version 1.0
 * @author steig
 */

require_once('CiviEntitySettings.php');

class GroupTypeOptionGroup extends CiviEntitySettings
{
  protected static function computeFields()
  {
    return [
      'name' => 'group_type',
      'title' => 'Group Type',
      'description' => null,
      'is_active' => TRUE,
      'is_reserved' => TRUE
    ];
  }

  public static function addWhere($getAction)
  {
    return $getAction->addWhere('title', '=', 'Group Type');
  }

  protected static function getEntity()
  {
    return \Civi\Api4\OptionGroup::class;
  }
}