<?php
require_once("Mappers/ITournamentMapper.php");
require_once("Models/Person.php");
require_once("Models/OrganizationProfile.php");
require_once("Models/Organization.php");
require_once("Models/EmailAddress.php");
require_once("Models/PhoneNumber.php");
require_once("Models/Geography/Address.php");
require_once("Models/Geography/Region.php");

class CivicrmTournamentMapper implements ITournamentMapper
{
  public static function BuildContact($contact): Contact
  {
    return new Contact($contact["id"], $contact["sort_name"], $contact["display_name"]);
  }

  public static function BuildPerson($invividual): Person
  {
    $gender = self::BuildGender($invividual["gender_id"], $invividual["gender_id:name"], $invividual["gender_id:label"]);
    $salutation = self::BuildSalutation($invividual["prefix_id"], $invividual["prefix_id:name"], $invividual["prefix_id:label"]);
    $generation = self::BuildGeneration($invividual["suffix_id"], $invividual["suffix_id:name"], $invividual["suffix_id:label"]);

    if (isset($invividual["birth_date"]))
      $birthDate = new DateTime($invividual["birth_date"]);

    return new Person($invividual["id"], $invividual["last_name"], $invividual["first_name"], $invividual["middle_name"], $gender, $birthDate, $generation, $salutation);
  }

  public static function BuildGender($id, ?string $name, ?string $label): Gender
  {
    return new Gender($id, $name, $label);
  }

  public static function BuildSalutation($id, ?string $name, ?string $label): Salutation
  {
    return new Salutation($id, $name, $label);
  }

  public static function BuildGeneration($id, ?string $name, ?string $label): Generation
  {
    return new Generation($id, $name, $label);
  }

  public static function BuildRelatedOrganizations(array $civicrmRelatedOrganizations): array
  {
    $organizations = array();

    foreach ($civicrmRelatedOrganizations as $civicrmRelatedOrganization)
      $organizations[] = self::BuildRelatedOrganization($civicrmRelatedOrganization);
    
    return $organizations;
  }

  public static function BuildRelatedOrganization($civicrmRelatedOrganization): Organization
  {
    $displayName = $civicrmRelatedOrganization["contact_id_b.display_name"];
    return new Organization($civicrmRelatedOrganization["contact_id_b"], $displayName);
  }

  public static function BuildOrganization($civicrmOrganization): Organization
  {
    return new Organization($civicrmOrganization["id"], $civicrmOrganization["organization_name"], $civicrmOrganization["organization_name"]);
  }

  public static function BuildContactProfile($civicrmContactProfile): ContactProfile
  {
    $contact = self::BuildContact($civicrmContactProfile);
    if ($civicrmContactProfile["email_primary.email"])
      $emailAddress = self::BuildEmailAddress($civicrmContactProfile);
    if ($civicrmContactProfile["address_primary.address"])
      $address = self::BuildAddress($civicrmContactProfile);
    if ($civicrmContactProfile["phone_billing.phone"])
      $mainPhone = self::BuildPrimaryPhone($civicrmContactProfile);
    if ($civicrmContactProfile["phone_primary.phone"])
      $mobilePhone = self::BuildMobilePhone($civicrmContactProfile);

    return new ContactProfile($contact->id, $contact->name, $contact->label, $emailAddress, $address, $mainPhone, $mobilePhone);
  }

  public static function BuildPersonProfile($civicrmPersonProfile): PersonProfile
  {
    $person = self::BuildPerson($civicrmPersonProfile);

    $emailAddress = $civicrmPersonProfile["email_primary.email"] ?? null;
    if ($emailAddress) $emailAddress = self::BuildEmailAddress($civicrmPersonProfile);

    $address = $civicrmPersonProfile["address_primary.street_address"] ?? null;
    if ($address) $address = self::BuildAddress($civicrmPersonProfile);

    $mainPhone = $civicrmPersonProfile["phone_billing.phone"] ?? null;
    if ($mainPhone) $mainPhone = self::BuildPrimaryPhone($civicrmPersonProfile);

    $mobilePhone = $civicrmPersonProfile["phone_primary.phone"] ?? null;
    if ($mobilePhone) $mobilePhone = self::BuildMobilePhone($civicrmPersonProfile);

    return new PersonProfile($person, $emailAddress, $address, $mainPhone, $mobilePhone);
  }

  public static function BuildOrganizationProfile($civicrOrganizationProfile): OrganizationProfile
  {
    $organization = self::BuildOrganization($civicrOrganizationProfile);
    $emailAddress = self::BuildEmailAddress($civicrOrganizationProfile);
    $address = self::BuildAddress($civicrOrganizationProfile);
    $mainPhone = self::BuildPrimaryPhone($civicrOrganizationProfile);
    $mobilePhone = self::BuildMobilePhone($civicrOrganizationProfile);

    return new OrganizationProfile($organization, $emailAddress, $address, $mainPhone, $mobilePhone);
  }

  public static function BuildRegion($civicrmEntity): Region
  {
    $country = new Country($civicrmEntity["address_primary.country_id"], $civicrmEntity["address_primary.country_id:abbr"], $civicrmEntity["address_primary.country_id:label"]);
    return new Region($civicrmEntity["address_primary.state_province_id"], $civicrmEntity["address_primary.state_province_id:abbr"], $civicrmEntity["address_primary.state_province_id:label"],null, $country);
  }

  public static function BuildAddress($civicrmEntity): Address
  {
    $region = self::BuildRegion($civicrmEntity);

    $postalCode = $civicrmEntity["address_primary.postal_code"];
    $postalSuffix = $civicrmEntity["address_primary.postal_code_suffix"];
    if (isset($postalSuffix) && trim($postalSuffix) !== '')
      $postalCode .= "-{$postalSuffix}";

    return new Address(
      $civicrmEntity["address_primary"],
      $civicrmEntity["address_primary.street_address"],
      $civicrmEntity["address_primary.supplemental_address_1"],
      $civicrmEntity["address_primary.city"],
      $region,
      $postalCode
    );
  }

  public static function BuildEmailAddress($civicrmEntity): EmailAddress
  {
    return new EmailAddress($civicrmEntity["email_primary.id"], $civicrmEntity["email_primary.email"]);
  }

  public static function BuildPrimaryPhone($civicrmEntity): PhoneNumber
  {
    return new PhoneNumber($civicrmEntity["phone_billing.id"], $civicrmEntity["phone_billing.phone"]);
  }

  public static function BuildMobilePhone($civicrmEntity): PhoneNumber
  {
    return new PhoneNumber($civicrmEntity["phone_primary.id"], $civicrmEntity["phone_primary.phone"]);
  }

  public static function BuildCivicrmOrganization($organization)
  {
    $civicrmOrganization = new stdClass();
    $civicrmOrganization->id = $organization["id"];
    $civicrmOrganization->organization_name = $organization["name"];
      //    ->addSelect('', 'display_name'
      //, 'address_primary', 'address_primary.street_address', 'address_primary.supplemental_address_1', 'address_primary.city',
      //  'address_primary.postal_code',
      //  'address_primary.postal_code_suffix'
      //, 'address_primary.state_province_id', 'address_primary.state_province_id:label', 'address_primary.state_province_id:abbr'
      //, 'address_primary.country_id', 'address_primary.country_id:abbr', 'address_primary.country_id:label'
      //, 'phone_primary', 'phone_primary.phone', 'phone_billing', 'phone_billing.phone'
      //  ,
      //  'email_primary',
      //  'email_primary.email')
    return $civicrmOrganization;
  }

  public static function BuildCivicrmContactProfile($contactProfile): array
  {
    $civicrmContact = array();
    $civicrmContact["id"] = $contactProfile["id"];
    $civicrmContact["display_name"] = $contactProfile["name"];
    $civicrmContact["email_primary.email"] = $contactProfile["email"];

    $civicrmContact["address_primary.street_address"] = $contactProfile["streetAddress"];
    $civicrmContact["address_primary.supplementalAddress"] = $contactProfile["supplementalAddress"];
    $civicrmContact["address_primary.city"] = $contactProfile["city"];
    $civicrmContact["address_primary.state_province"] = $contactProfile["region"];
    $civicrmContact["address_primary.postal_code"] = $contactProfile["postalCode"];
    $civicrmContact["address_primary.postal_code_suffix"] = $contactProfile["postalCodeSuffix"];

    $civicrmContact["phone_primary.phone"] = $contactProfile["mobilePhone"];
    $civicrmContact["phone_billing.phone"] = $contactProfile["mainPhone"];
    $civicrmContact["phone_billing.phone_ext"] = $contactProfile["extension"];

    return $civicrmContact;
  }

  public static function BuildCivicrmOrganizationProfile($organizationProfile): array
  {
    $civicrmOrganization = array();
    $civicrmOrganization["id"] = $organizationProfile["id"];
    $civicrmOrganization["organization_name"] = $organizationProfile["name"];
    $civicrmOrganization["email_primary.email"] = $organizationProfile["email"];

    $civicrmOrganization["address_primary.street_address"] = $organizationProfile["streetAddress"];
    $civicrmOrganization["address_primary.supplementalAddress"] = $organizationProfile["supplementalAddress"];
    $civicrmOrganization["address_primary.city"] = $organizationProfile["city"];
    $civicrmOrganization["address_primary.state_province"] = $organizationProfile["region"];
    $civicrmOrganization["address_primary.postal_code"] = $organizationProfile["postalCode"];
    $civicrmOrganization["address_primary.postal_code_suffix"] = $organizationProfile["postalCodeSuffix"];

    $civicrmOrganization["phone_primary.phone"] = $organizationProfile["mobilePhone"];
    $civicrmOrganization["phone_billing.phone"] = $organizationProfile["mainPhone"];

    return $civicrmOrganization;
  }

  public static function BuildGroups(array $civicrmGroups): array
  {
    $groups = array();

    foreach ($civicrmGroups as $civicrmGroup) {
      $groups[] = new Group($civicrmGroup["id"], $civicrmGroup["name"]);
    }
    return $groups;
  }

  public static function BuildIndividual($person) {
    $individual = new \Civi\Api4\Individual();

    $individual->id = $person["id"];
    $individual->last_name = $person["lastName"];
    $individual->first_name = $person["firstName"];
    $individual->middle_name = $person["middleName"];
    $individual->birth_date = $person["birthDate"];
    $individual->gender_id = $person["gender"];
    $individual->prefix_id = $person["salutation"];
    $individual->suffix_id = $person["generation"];

    return $individual;
  }

  public static function BuildOptions(array $civicrmOptions): array
  {
    $options = array();

    foreach ($civicrmOptions as $civicrmOption) {
      $options[$civicrmOption["value"]] = $civicrmOption["label"];
    }
    return $options;
  }

  public static function BuildRegions(array $civicrmStateProvinces): array
  {
    $options = array();

    foreach ($civicrmStateProvinces as $civicrmStateProvince) {
      $options[$civicrmStateProvince["id"]] = $civicrmStateProvince["abbreviation"];
    }
    return $options;
  }
}