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

class SuffixOptionGroup extends Settings
{
  protected static function computeFields()
  {
    return [
      'name' => 'individual_suffix',
      'title' => 'Individual contact sufixes',
      'description' => 'Individual contact sufixes',
      'is_active' => TRUE,
      'is_reserved' => TRUE
    ];
  }

  public static function addWhere($getAction)
  {
    return $getAction->addWhere('name', '=', 'individual_suffix');
  }

  protected static function getEntity()
  {
    return \Civi\Api4\OptionGroup::class;
  }
}