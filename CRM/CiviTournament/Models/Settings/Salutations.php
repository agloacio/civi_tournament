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
require_once('GenderOptionGroup.php');

class Salutations extends Settings
{
  /**
   * Retrieves all Genders.
   *
   * @return array An associative array of gender IDs and labels, or an empty array if none are found.
   *               Returns an error message string if there's an issue with the API call.
   */
  public static function get() : array
  {
    $GenderOptionGroupId = GenderOptionGroup::get()["id"];

    try {
      $records = static::getEntity()::get()
        ->addSelect('value', 'label')
        ->addWhere('option_group_id', '=', $GenderOptionGroupId)
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
    $GenderOptionGroup = GenderOptionGroup::get()['id'];

    return [
      'name' => 'Genders',
      'label' => 'Genders',
      'description' => 'Genders',
      'option_group_id' => $GenderOptionGroup,
      'is_active' => TRUE,
      'is_reserved' => FALSE,
      'value' => null,
    ];
  }
  public static function addWhere($getAction)
  {
    $GenderOptionGroup = GenderOptionGroup::get()['id'];
    return $getAction->addWhere('option_group_id', '=', $GenderOptionGroup);
  }

  protected static function getEntity()
  {
    return \Civi\Api4\OptionValue::class;
  }
}