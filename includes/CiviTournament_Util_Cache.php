<?php

/**
 * Cache CiviTournament settings.
 *
 * Use CiviCRM's caching mechanism to avoid repeated database queries.
 *
 * @version 1.0
 * @author msteigerwald
 */

class CiviTournament_Util_Cache
{
  /**
   * Gets the ID of the "Billing Organization" contact type.
   *
   * @return int|null The ID of the contact type, or null if not found.
   */
  public static function getBillingOrganizationContactTypeID()
  {
    $cacheKey = 'civi_tournament_billing_organization_contact_type_id';
    $contactTypeID = CRM_Utils_Cache::singleton()->get($cacheKey);

    if ($contactTypeID === null) {
      $contactTypes = \Civi\Api4\ContactType::get(FALSE)
        ->addSelect('id')
        ->addWhere('label', '=', 'Billing Organization')
        ->setLimit(1)
        ->execute();

      $contactTypeID = $contactTypes[0]['id'];
      CRM_Utils_Cache::singleton()->set($cacheKey, $contactTypeID);
    }

    return $contactTypeID;
  }

  /**
   * Gets the ID of the "Billing Contact for" relationship type.
   *
   * @return int|null The ID of the relationship type, or null if not found.
   */
  public static function getBillingOrganizationRelationshipTypeID()
  {
    $cacheKey = 'civi_tournament_billing_organization_relationship_type_id';
    $relationshipTypeID = CRM_Utils_Cache::singleton()->get($cacheKey);

    if ($relationshipTypeID === null) {
      $relationshipTypes = \Civi\Api4\RelationshipType::get(FALSE)
        ->addSelect('id')
        ->addWhere('name_a_b', '=', 'Billing Contact for')
        ->setLimit(1)
        ->execute();

      $relationshipTypeID = $relationshipTypes[0]['id'];
      CRM_Utils_Cache::singleton()->set($cacheKey, $relationshipTypeID);
    }

    return $relationshipTypeID;
  }

  /**
   * Gets the value of a specific option.
   *
   * @param string $optionName The name of the option.
   * @return mixed|null The value of the option, or null if not found.
   */
  public static function getOptionValue($optionName)
  {
    $cacheKey = "civi_tournament_option_{$optionName}";
    $optionValue = CRM_Utils_Cache::singleton()->get($cacheKey);

    if ($optionValue === null) {
      $options = \Civi\Api4\OptionValue::get(FALSE)
        ->addSelect('value')
        ->addWhere('name', '=', $optionName)
        ->setLimit(1)
        ->execute();

      $optionValue = $options[0]['value'];
      CRM_Utils_Cache::singleton()->set($cacheKey, $optionValue);
    }

    return $optionValue;
  }

}