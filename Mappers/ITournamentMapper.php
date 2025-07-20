<?php
require_once("Models/Person.php");
require_once("Models/Organization.php");

/**
 * ITournamentMapper short summary.
 *
 * ITournamentMapper description.
 *
 * @version 1.ITournamentMapperauthor steig
 */
interface ITournamentMapper
{
  public static function BuildPerson($personId): Person;
  public static function BuildSalutation($id, ?string $name, ?string $label): Salutation;
  public static function BuildGeneration($id, ?string $name, ?string $label): Generation;

  public static function BuildOrganization($organization): Organization;
  public static function BuildRelatedOrganization($relatedOrganization): Organization;
  public static function BuildRelatedOrganizations(array $organizations): array;

  public static function BuildContactProfile($contactProfile): ContactProfile;
  public static function BuildOrganizationProfile($organization): OrganizationProfile;

  public static function BuildEmailAddress($entity): EmailAddress;
  public static function BuildRegion($entity): Region;
  public static function BuildAddress($entity): Address;
  public static function BuildPrimaryPhone($entity): PhoneNumber;
  public static function BuildMobilePhone($entity): PhoneNumber;

  public static function BuildGroups(array $groups): array;  
}
