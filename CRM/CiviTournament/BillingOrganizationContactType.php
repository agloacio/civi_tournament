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
  const FIELDS = [
    'name' => 'Billing Organization',
    'label' => 'Billing Organization',
    'description' => 'Organization (e.g., School District) responsible for billing.',
    'icon' => 'fa-file-invoice-dollar',
    'parent_id:label.name' => 'Organization',
    'is_active' => TRUE,
    'is_reserved' => FALSE
  ];

  public static function addWhere($getAction)
  {
    return $getAction->addWhere('label', '=', 'Billing Organization');
  }

  protected static function getEntity()
  {
    return \Civi\Api4\ContactType::class;
  }
}