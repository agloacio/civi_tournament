<?php
/**
 * Persist Settings
 *
 * Creates and retrieves BillingOrganizationContactType setting for CiviTournament Extension
 *
 * @version 1.0
 * @author steig
 */
require_once('CiviEntitySettings.php');
class BillingOrganizationContactType extends CiviEntitySettings
{
  protected static function computeFields()
  {
    return [
      'name' => 'Billing Organization',
      'label' => 'Billing Organization',
      'description' => 'Organization (e.g., School District) responsible for billing.',
      'parent_id' => 'Individual',
      'icon' => 'fa-file-invoice-dollar',
      'is_active' => TRUE,
      'is_reserved' => FALSE
    ];
  }

  public static function addWhere($getAction)
  {
    return $getAction->addWhere('label', '=', 'Billing Organization');
  }

  protected static function getEntity()
  {
    return \Civi\Api4\ContactType::class;
  }
}