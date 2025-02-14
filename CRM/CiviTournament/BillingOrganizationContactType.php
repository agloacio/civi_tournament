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
    $contactTypes = \Civi\Api4\ContactType::create(TRUE)
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

  public static function getBillingOrganizationRelationshipType()
  {
    $fields = [
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

    $getAction = Entity::get(TRUE)
      ->setLimit(1)
      ->addWhere('name_a_b', '=', 'Billing Contact for');

    foreach ($fields as $key => $value) {
      $getAction = $getAction->addSelect($key);
    }

    $result = $getAction->execute();

    if (is_array($result[0]) && !empty($result[0])) {
      return $result[0];
    }

    return self::createBillingOrganizationRelationshipType();
  }

  private static function createBillingOrganizationRelationshipType()
  {
    $results = RelationshipType::create(TRUE)
      ->addValue('name_a_b', 'Billing Contact for')
      ->addValue('label_a_b', 'Billing Contact for')
      ->addValue('name_b_a', 'Billing Organization for')
      ->addValue('label_b_a', 'Billing Organization for')
      ->addValue('description', 'Relationship between a Billing Contact and their associated Billing Organization.')
      ->addValue('contact_type_a', 'Individual')
      ->addValue('contact_type_b', 'Organization')
      ->addValue('contact_sub_type_b', 'Billing_Organization')
      ->addValue('is_active', TRUE)
      ->addValue('is_reserved', FALSE)
      ->execute();

    return $results[0];
  }
}