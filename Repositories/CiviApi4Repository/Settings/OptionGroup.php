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

class OptionGroup extends Settings
{
  protected static function computeFields()
  {
    return [
      'name' => self::$_name,
      'title' => self::$_title,
      'description' => self::$_description,
      'is_active' => TRUE,
      'is_reserved' => TRUE
    ];
  }

  public static function addWhere($getAction)
  {
    return $getAction->addWhere('name', '=', self::$_name);
  }

  protected static function getEntity()
  {
    return \Civi\Api4\OptionGroup::class;
  }

  protected $_name;
  protected $_title;
  protected $_description;
}