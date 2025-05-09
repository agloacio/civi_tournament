<?php
require_once("Settings/BillingOrganizationRelationshipType.php");

/**
 * School, District, Company, etc.
 *
 * Non-person Contact.
 *
 * @version 1.0
 * @author steig
 */
class Organization extends TournamentObject
{
  public function __construct(?int $id, ?string $name = null)
  {
    parent::__construct($id, $name);
  }

  public static function getBillingOrganizations(int $personId)
  {
    /** @var int $billingOrganizationRelationshipTypeID */
    $billingOrganizationRelationshipTypeID = BillingOrganizationRelationshipType::get()["id"];

    if ($billingOrganizationRelationshipTypeID) {
      /** @var array $entities */
      $entities = \Civi\Api4\Relationship::get(FALSE)
        ->addSelect('contact_id_b', 'contact_id_b.display_name')
        ->addWhere('contact_id_a', '=', $personId)
        ->addWhere('relationship_type_id', '=', $billingOrganizationRelationshipTypeID)
        ->addWhere('is_active', '=', TRUE)
        ->execute();

      $billingOrganizations = [];
      foreach ($entities as $entity) {
        $billingOrganizations[] = new Organization($entity['contact_id_b'], $entity['contact_id_b.display_name']);
      }

      return $billingOrganizations;
    }

  }
}