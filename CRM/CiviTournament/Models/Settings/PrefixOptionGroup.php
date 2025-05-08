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

class PrefixOptionGroup extends Settings
{
  protected static function computeFields()
  {
    return [
      'name' => 'individual_prefix',
      'title' => 'Individual contact prefixes',
      'description' => 'CiviCRM is pre-configured with standard options for individual contact prefixes (Ms., Mr., Dr. etc.). Customize these options and add new ones as needed for your installation.',
      'is_active' => TRUE,
      'is_reserved' => TRUE
    ];
  }

  public static function addWhere($getAction)
  {
    return $getAction->addWhere('name', '=', 'individual_prefix');
  }

  protected static function getEntity()
  {
    return \Civi\Api4\OptionGroup::class;
  }
}