<?php

require_once("CRM/CiviTournament/Models/User.php");
require_once("CRM/CiviTournament/Repositories/CiviApi4Repository.php");
require_once("CRM/CiviTournament/Mapper.php");

class UserFactory
{
  public static function Build($userId) : User {
    $civiRecords = CiviApi4Repository::GetPerson($userId);
    $person = Mapper::MapCiviToPerson($civiRecords[0]);

    $civiRecords = CiviApi4Repository::GetBillingOrganizations($userId);
    $billingOrganizations = Mapper::MapCiviToBillingOrganizations($civiRecords);

    return new User($person, $billingOrganizations);
  }
}