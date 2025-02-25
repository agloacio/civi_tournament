<?php
/**
 * Persist Settings
 *
 * Creates and retrieves BillingOrganizationRelationshipType setting for CiviTournament Extension
 *
 * @version 1.0
 * @author steig
 */

require_once('CiviEntitySettings.php');
require_once('BillingOrganizationContactType.php');

class BillingOrganizationRelationshipType extends CiviEntitySettings
{
  protected static function computeFields()
  {
    return [
      'name_a_b' => 'Billing Contact for',
      'label_a_b' => 'Billing Contact for',
      'name_b_a' => 'Billing Organization for',
      'label_b_a' => 'Billing Organization for',
      'description' => 'Relationship between a Billing Contact and their associated Billing Organization.',
      'contact_type_a' => 'Individual',
      'contact_type_b' => 'Organization',
      'contact_sub_type_b' => '',
      'is_active' => TRUE,
      'is_reserved' => FALSE
    ];
  }

  public static function addWhere($getAction)
  {
    return $getAction->addWhere('name_a_b', '=', 'Billing Contact for');
  }

  protected static function getEntity()
  {
    return \Civi\Api4\RelationshipType::class;
  }
}