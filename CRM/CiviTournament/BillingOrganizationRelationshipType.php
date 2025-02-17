<?php
use \Civi\Api4\RelationshipType as Entity;
/**
 * Persist Settings
 *
 * Creates and retrieves settings for CiviTournament Extension
 *
 * @version 1.0
 * @author steig
 */
class BillingOrganizationRelationshipType
{
  const FIELDS = [
      'name_a_b' => 'Billing Contact for',
      'label_a_b' => 'Billing Contact for',
      'name_b_a' => 'Billing Organization for',
      'label_b_a' => 'Billing Organization for',
      'description' => 'Relationship between a Billing Contact and their associated Billing Organization.',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Billing_Organization',
      'contact_sub_type_b' => '',
      'is_active' => TRUE,
      'is_reserved' => FALSE
    ];

  public static function get()
  {
    $getAction = Entity::get(TRUE)->setLimit(1);
    $getAction = self::addWhere($getAction);

    foreach (self::FIELDS as $key => $value) {
      $getAction = $getAction->addSelect($key);
    }

    $result = $getAction->execute();

    if (is_array($result[0]) && !empty($result[0])) {
      return $result[0];
    }

    return self::create();
  }

  public static function addWhere($getAction) {
    return $getAction->addWhere('name_a_b', '=', 'Billing Contact for');
  }

  private static function create()
  {
    $createAction = Entity::create(TRUE);

    foreach (self::FIELDS as $key => $value) {
      $createAction = $createAction->addValue($key, $value);
    }

    $results = $createAction->execute();

    return $results[0];
  }
}