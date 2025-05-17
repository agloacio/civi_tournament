<?php
require_once("CRM/CiviTournament/Repositories/ITournamentRepository.php");
require_once("Settings/BillingOrganizationRelationshipType.php");

class CiviApi4Repository implements ITournamentRepository
{
  public static function GetPerson($id) : array
  {
    $personResult = \Civi\Api4\Individual::get(TRUE)
      ->addSelect('first_name', 'middle_name', 'last_name', 'gender_id', 'gender_id:label', 'birth_date', 'prefix_id', 'prefix_id:label', 'suffix_id', 'suffix_id:label')
      ->addWhere('id', '=', $id)
      ->setLimit(1)
      ->execute();

    $people = array();

    foreach ($personResult as $person) {
      $people[] = $person;
    }
    return $people;
  }

  public static function GetBillingOrganizations(int $personId): array
  {
    $billingOrganizationRelationshipTypeID = BillingOrganizationRelationshipType::get()["id"];

    $result = \Civi\Api4\Relationship::get(FALSE)
      ->addSelect('contact_id_b', 'contact_id_b.display_name')
      ->addWhere('contact_id_a', '=', $personId)
      ->addWhere('relationship_type_id', '=', $billingOrganizationRelationshipTypeID)
      ->addWhere('is_active', '=', TRUE)
      ->execute();

    $billingOrganizations = [];
    foreach ($result as $organization) {
      $billingOrganizations[] = $organization;
    }

    return $billingOrganizations;
  }
}