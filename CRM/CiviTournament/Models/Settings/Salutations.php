<?php
/**
 * Persist Salutations
 *
 * Creates and retrieves Salutations setting for CiviTournament Extension
 *
 * @version 1.0
 * @author steig
 */

require_once('Settings.php');
require_once('PrefixOptionGroup.php');

class Salutations extends Settings
{
  /**
   * Retrieves all name prefixes.
   *
   * @return array An associative array of gender IDs and labels, or an empty array if none are found.
   *               Returns an error message string if there's an issue with the API call.
   */
  public static function get() : array
  {
    $PrefixOptionGroupId = PrefixOptionGroup::get()["id"];

    try {
      $records = static::getEntity()::get()
        ->addSelect('value', 'label')
        ->addWhere('option_group_id', '=', $PrefixOptionGroupId)
        ->addWhere('is_active', '=', true)
        ->execute();

      $genders = array_column($records->getArrayCopy(), 'label', 'value');

      return $genders;

    } catch (\Exception $e) {
      return "An unexpected error occurred: " . $e->getMessage();
    }
  }

  protected static function computeFields()
  {
    $PrefixOptionGroup = PrefixOptionGroup::get()['id'];

    return [
      'name' => 'prefixes',
      'label' => 'Prefixes',
      'description' => 'Prefixes',
      'option_group_id' => $PrefixOptionGroup,
      'is_active' => TRUE,
      'is_reserved' => FALSE,
      'value' => null,
    ];
  }
  public static function addWhere($getAction)
  {
    $PrefixOptionGroup = PrefixOptionGroup::get()['id'];
    return $getAction->addWhere('option_group_id', '=', $PrefixOptionGroup);
  }

  protected static function getEntity()
  {
    return \Civi\Api4\OptionValue::class;
  }
}