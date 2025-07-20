<?php
require_once("Repositories/CiviApi4Repository/CiviApi4Repository.php");
use CiviApi4Repository as ContactRepository;

require_once("Mappers/CivicrmTournamentMapper/CivicrmTournamentMapper.php");
use CivicrmTournamentMapper as Mapper;
session_start(); // Ensure the session is started at the beginning

require_once("Models/PersonProfile.php");

/**
 * Retrieve contact (e.g., person, organization) objects.
 *
 * ContactService description.
 *
 * @version 1.0
 * @author steig
 */
class ContactService
{
  public static function GetPerson($personId): Person
  {
    $personArray = ContactRepository::GetPerson($personId);
    return Mapper::BuildPerson($personArray[0]);
  }

  public static function SavePerson($person)
  {
    ContactRepository::SavePerson(Mapper::BuildIndividual($person));
  }

  public static function GetContactProfile($contactId): ContactProfile
  {
    $contactArray = ContactRepository::GetContactProfile($contactId);
    $contactProfile = Mapper::BuildContactProfile($contactArray[0]);
    return $contactProfile;
  }

  public static function GetPersonProfile($personId): PersonProfile
  {
    $personArray = ContactRepository::GetPersonProfile($personId);
    $contactProfile = Mapper::BuildPersonProfile($personArray[0]);
    return $contactProfile;
  }

  public static function SaveOrganizationProfile($organizationProfile)
  {
    ContactRepository::SaveOrganizationProfile(Mapper::BuildCivicrmOrganizationProfile($organizationProfile));
  }

  public static function SaveContactProfile($contactProfile)
  {
    ContactRepository::SaveContactProfile(Mapper::BuildCivicrmContactProfile($contactProfile));
  }

  public static function SavePersonProfile($personProfile)
  {
    Self::SaveContactProfile($personProfile);
  }

  public static function GetBillingOrganizations(Person $person): array
  {
    $civicrmOrganizations = ContactRepository::GetBillingOrganizations($person->id);
    return Mapper::BuildRelatedOrganizations($civicrmOrganizations);
  }

  public static function GetRegistrationGroups(Person $person): array
  {
    $civicrmRegistrationGroups = ContactRepository::GetRegistrationGroups($person->id);
    return Mapper::BuildGroups($civicrmRegistrationGroups);
  }

  public static function GetGenders(): array
  {
    if (!isset($_SESSION['genders'])) {
      $_SESSION['genders'] = Mapper::BuildOptions(ContactRepository::GetGenders());
    }
    return $_SESSION['genders'];
  }

  public static function GetSalutations(): array
  {
    if (!isset($_SESSION['salutations'])) {
      $_SESSION['salutations'] = Mapper::BuildOptions(ContactRepository::GetSalutations());
    }
    return $_SESSION['salutations'];
  }

  public static function GetGenerations(): array
  {
    if (!isset($_SESSION['generations'])) {
      $_SESSION['generations'] = Mapper::BuildOptions(ContactRepository::GetGenerations());
    }
    return $_SESSION['generations'];
  }

  public static function GetRegions(): array
  {
    if (!isset($_SESSION['regions'])) {
      $_SESSION['regions'] = Mapper::BuildRegions(ContactRepository::GetRegions());
    }
    return $_SESSION['regions'];
  }

  public static function GetOrganization($organizationId): Organization
  {
    $organizationArray = ContactRepository::GetOrganization($organizationId);
    return Mapper::BuildOrganization($organizationArray[0]);
  }

  public static function GetOrganizationProfile($organizationId): OrganizationProfile
  {
    $organizationArray = ContactRepository::GetOrganizationProfile($organizationId);
    return Mapper::BuildOrganizationProfile($organizationArray[0]);
  }

  public static function SaveOrganization($person)
  {
    ContactRepository::SavePerson(Mapper::BuildIndividual($person));
  }
}