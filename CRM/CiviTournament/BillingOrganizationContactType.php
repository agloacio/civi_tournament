<?php
use \Civi\Api4\ContactType as Entity;
/**
 * Persist Settings
 *
 * Creates and retrieves settings for CiviTournament Extension
 *
 * @version 1.0
 * @author steig
 */
class BillingOrganizationContactType
{
  public static function getBillingOrganizationContactType()
  {
    $result = \Civi\Api4\ContactType::get(TRUE)
      ->setLimit(1)
      ->addSelect('name')
      ->addSelect('label')
      ->addSelect('description')
      ->addWhere('label', '=', 'Billing Organization')
      ->execute();

    if (is_array($result[0]) && !empty($result[0])) {
      return $result[0];
    }

    return self::createBillingOrganiztionContactType();
  }

  private static function createBillingOrganiztionContactType()
  {
    $contactTypes = Entity::create(TRUE)
      ->addValue('name', 'Billing_Organization')
      ->addValue('label', 'Billing Organization')
      ->addValue('description', 'Organization (e.g., School District) responsible for billing.')
      ->addValue('icon', 'fa-file-invoice-dollar')
      ->addValue('parent_id', 3)
      ->addValue('is_active', TRUE)
      ->addValue('is_reserved', FALSE)
      ->execute();

    return $contactTypes[0];
  }
}