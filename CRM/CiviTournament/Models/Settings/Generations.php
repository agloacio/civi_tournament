<?php
/**
 * Persist Settings
 *
 * Creates and retrieves Generation setting for CiviTournament Extension
 *
 * @version 1.0
 * @author steig
 */

require_once('Settings.php');
require_once('SuffixOptionGroup.php');

class Generations extends Settings
{
  /**
   * Retrieves all name suffixes.
   *
   * @return array An associative array of gender IDs and labels, or an empty array if none are found.
   *               Returns an error message string if there's an issue with the API call.
   */
  public static function get() : array
  {
    $SuffixOptionGroupId = SuffixOptionGroup::get()["id"];

    try {
      $records = static::getEntity()::get()
        ->addSelect('value', 'label')
        ->addWhere('option_group_id', '=', $SuffixOptionGroupId)
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
    $SuffixOptionGroup = SuffixOptionGroup::get()['id'];

    return [
      'name' => 'suffixes',
      'label' => 'Suffixes',
      'description' => 'Suffixes',
      'option_group_id' => $SuffixOptionGroup,
      'is_active' => TRUE,
      'is_reserved' => FALSE,
      'value' => null,
    ];
  }
  public static function addWhere($getAction)
  {
    $SuffixOptionGroup = SuffixOptionGroup::get()['id'];
    return $getAction->addWhere('option_group_id', '=', $SuffixOptionGroup);
  }

  protected static function getEntity()
  {
    return \Civi\Api4\OptionValue::class;
  }
}