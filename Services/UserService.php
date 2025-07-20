<?php

require_once("Models/User.php");
require_once("ContactService.php");

require_once("Repositories/CiviApi4Repository/CiviApi4Repository.php");

class UserService
{
  public static function Get($userId) : User {
    $person = ContactService::GetPerson($userId);
    $billingOrganizations = ContactService::GetBillingOrganizations($person);
    $registrationGroups = ContactService::GetRegistrationGroups($person);

    return new User($person, $billingOrganizations, $registrationGroups);
  }
}