<?php
/**
 * Persist Settings
 *
 * Creates and retrieves BillingOrganizationContactType setting for CiviTournament Extension
 *
 * @version 1.0
 * @author steig
 */
require_once('Settings.php');
class BillingOrganizationContactType extends Settings
{
  protected static function computeFields()
  {
    $contactTypes = \Civi\Api4\ContactType::get(TRUE)
      ->addSelect('id')
      ->addWhere('label', '=', 'Organization')
      ->setLimit(25)
      ->execute();
    foreach ($contactTypes as $contactType) {
      $parent_id = $contactType["id"];
    }

    return [
      'name' => 'Billing Organization',
      'label' => 'Billing Organization',
      'description' => 'Organization (e.g., School District) responsible for billing.',
      'parent_id' => $parent_id,
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