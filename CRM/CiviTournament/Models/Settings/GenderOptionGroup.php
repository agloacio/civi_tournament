<?php
/**
 * Persist GroupTypeOptionGroup Settings
 *
 * Creates and retrieves GroupTypeOptionGroup setting for CiviTournament Extension
 *
 * @version 1.0
 * @author steig
 */

require_once('Settings.php');

class GenderOptionGroup extends Settings
{
  protected static function computeFields()
  {
    return [
      'name' => 'gender',
      'title' => 'Gender',
      'description' => null,
      'is_active' => TRUE,
      'is_reserved' => TRUE
    ];
  }

  public static function addWhere($getAction)
  {
    return $getAction->addWhere('name', '=', 'gender');
  }

  protected static function getEntity()
  {
    return \Civi\Api4\OptionGroup::class;
  }
}