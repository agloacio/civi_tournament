<?php
require_once("BillingOrganizationRelationshipType.php");

/**
 * Billing Organization
 *
 * Organization (e.g., School District) responsible for billing.
 *
 * @version 1.0
 * @author steig
 */
class BillingOrganization extends TournamentObject
{
  public function __construct($id, $name = null)
  {
    parent::__construct($id, $name);
  }

  public static function getBillingOrganizations($personId)
  {
    $billingOrganizationRelationshipTypeID = BillingOrganizationRelationshipType::get()["id"];

    if ($billingOrganizationRelationshipTypeID) {
      $entities = \Civi\Api4\Relationship::get(FALSE)
        ->addSelect('contact_id_b', 'contact_id_b.display_name')
        ->addWhere('contact_id_a', '=', $personId)
        ->addWhere('relationship_type_id', '=', $billingOrganizationRelationshipTypeID)
        ->addWhere('is_active', '=', TRUE)
        ->execute();

      $billingOrganizations = [];
      foreach ($entities as $entity) {
        $billingOrganizations[] = new BillingOrganization($entity['contact_id_b'], $entity['contact_id_b.display_name']);
      }

      return $billingOrganizations;
    }

  }
}