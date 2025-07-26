<?php
require_once("Repositories/IContactRepository.php");
require_once("Settings/BillingOrganizationRelationshipType.php");
require_once("Settings/RegistrationGroupType.php");

use Civi\Api4\Contact;
use Civi\Api4\Individual;
use Civi\Api4\Email;
use Civi\Api4\Address;
use Civi\Api4\StateProvince;
use Civi\Api4\Phone;
use Civi\Api4\Generic\DAOGetAction;

class CiviApi4Repository implements IContactRepository
{
  public static function GetContact($id): array
  {
    $getAction = Contact::get(TRUE)->addSelect('*')->addWhere('id', '=', $id);
    $result = $getAction->execute();
    return self::ToArray($result);
  }

  public static function GetContactProfile(int $contactId): array
  {
    $getAction = Contact::get(TRUE)->addSelect('*', 'email_primary.*', 'phone_primary.*', 'phone_billing.*', 'address_primary.*')->addWhere('id', '=', $contactId);
    $result = $getAction->execute();
    return self::ToArray($result);
  }

  public static function SaveContactProfile(array $contactProfile): array
  {
    $results = [];
    $transaction = new CRM_Core_Transaction(); // Start transaction for atomicity

    try {
      $contactSaveResult = Contact::save(FALSE)
        ->addRecord([
          'id' => $contactProfile["id"],
          'display_name' => $contactProfile["name"]
        ])
        ->execute();
      $results['contact'] = $contactSaveResult->getArrayCopy();

      $contactProfile['contact_id'] = $contactSaveResult->first()['id'];

      $emailData = $contactProfile;
      $emailData['id'] = $contactProfile["email_primary.id"];
      $emailData['email'] = $contactProfile["email_primary.email"];
      $emailData['is_primary'] = TRUE;
      $emailData['location_type_id'] = 3; // TODO
      $results['primary_email'] = self::SaveEmail($emailData);

      $mainPhoneData = $contactProfile;
      $mainPhoneData['id'] = $contactProfile['phone_billing.id'];
      $mainPhoneData['is_primary'] = TRUE;
      $mainPhoneData['location_type_id'] = 3;
      $mainPhoneData['is_billing'] = TRUE;
      $mainPhoneData['phone'] = $contactProfile['phone_billing.phone'];
      $mainPhoneData['phone_type_id'] = 1;
      $results['phone_billing'] = self::SavePhone($mainPhoneData);

      $mobilePhoneData = $contactProfile;
      $mobilePhoneData['id'] = $contactProfile['phone_primary.id'];
      $mobilePhoneData['is_primary'] = FALSE;
      $mobilePhoneData['location_type_id'] = 4;
      $mobilePhoneData['is_billing'] = FALSE;
      $mobilePhoneData['phone'] = $contactProfile['phone_primary.phone'];
      $mobilePhoneData['phone_type_id'] = 2;
      $results['phone_primary'] = self::SavePhone($mobilePhoneData);

      $addressData = $contactProfile;
      $addressData['is_primary'] = TRUE;
      $addressData['location_type_id'] = 3;
      $addressData['is_billing'] = TRUE;

      $addressData["street_address"] = $contactProfile['address_primary.street_address'];
      $addressData["supplemental_address_1"] = $contactProfile['address_primary.supplementalAddress'];
      $addressData["city"] = $contactProfile['address_primary.city'];
      $addressData["state_province_id"] = $contactProfile['address_primary.state_province'];
      $addressData["postal_code"] = $contactProfile['address_primary.postal_code'];
      $addressData["postal_code_suffix"] = $contactProfile['address_primary.postal_code_suffix'];

      $results['primary_address'] = self::SaveAddress($addressData);

      $transaction->commit();
      return $results;
    } catch (Exception $e) {
      $transaction->rollback();
      throw new Exception("Failed to save CiviCRM contact profile: " . $e->getMessage(), $e->getCode(), $e->getPrevious());
    }
  }

  public static function GetPersonProfile($personId): array
  {
    $getAction = Individual::get(TRUE)->addSelect('*'
      , "gender_id:name", "gender_id:label"
      , "prefix_id:name", "prefix_id:label"
      , "suffix_id:name", "suffix_id:label"
      , 'email_primary.*', 'phone_primary.*', 'phone_billing.*', 'address_primary.*')
      ->addWhere('id', '=', $personId);
    $result = $getAction->execute();
    return self::ToArray($result);
  }

  public static function GetPerson($id): array
  {
    $getAction = \Civi\Api4\Individual::get(TRUE)
      ->addSelect(
        'first_name',
        'middle_name',
        'last_name'
        ,
        'gender_id',
        'gender_id:name',
        'gender_id:label'
        ,
        'birth_date'
        ,
        'prefix_id',
        'prefix_id:name',
        'prefix_id:label'
        ,
        'suffix_id',
        'suffix_id:name',
        'suffix_id:label'
      )
      ->addWhere('id', '=', $id);

    $result = $getAction->execute();
    return self::ToArray($result);
  }

  public static function SavePerson($individual) {
    $results = \Civi\Api4\Individual::update(TRUE)
      ->addValue('last_name', $individual->last_name)
      ->addValue('first_name', $individual->first_name)
      ->addValue('middle_name', $individual->middle_name)
      ->addValue('birth_date', $individual->birth_date)
      ->addValue('gender_id', $individual->gender_id)
      ->addValue('prefix_id', $individual->prefix_id)
      ->addValue('suffix_id', $individual->suffix_id)
      ->addWhere('id', '=', $individual->id)
      ->execute();

    return self::ToArray($results);
  }

  public static function GetBillingOrganizations($personId): array
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

  /**
   * Saves (updates or creates) CiviCRM records for an organization based on an OrganizationProfile object.
   * Uses APIv4 save action with match for efficient handling of related entities.
   *
   * @param array $organizationData The organization profile object with data to save.
   * @return array An array containing the results of the API calls.
   * @throws \CRM_Core_Exception If a CiviCRM API call fails.
   */

  public static function SaveOrganizationProfile(array $organizationData): array
  {
    $results = [];
    $transaction = new CRM_Core_Transaction(); // Start transaction for atomicity

    try {
      $contactSaveResult = Contact::save(FALSE)
        ->addRecord([
          'id' => $organizationData["id"], // Include ID to trigger update for existing
          'organization_name' => $organizationData["organization_name"],
          'contact_type' => 'Organization', // Ensure contact type if creating new orgs
        ])
        ->execute();
      $results['contact'] = $contactSaveResult->getArrayCopy();

      $organizationData['contact_id'] = $contactSaveResult->first()['id'];

      $emailData = $organizationData;
      $emailData['email'] = $organizationData["email_primary.email"];
      $emailData['is_primary'] = TRUE;
      $emailData['location_type_id'] = 3;
      $results['primary_email'] = self::SaveEmail($emailData);

      $mainPhoneData = $organizationData;
      $mainPhoneData['is_primary'] = TRUE;
      $mainPhoneData['location_type_id'] = 3;
      $mainPhoneData['is_billing'] = TRUE;
      $mainPhoneData['phone'] = $organizationData['phone_billing.phone'];
      $mainPhoneData['phone_type_id'] = 1;
      $results['phone_billing'] = self::SavePhone($mainPhoneData);

      $mobilePhoneData = $organizationData;
      $mobilePhoneData['is_primary'] = FALSE;
      $mobilePhoneData['location_type_id'] = 4;
      $mobilePhoneData['is_billing'] = FALSE;
      $mobilePhoneData['phone'] = $organizationData['phone_primary.phone'];
      $mobilePhoneData['phone_type_id'] = 2;
      $results['phone_primary'] = self::SavePhone($mobilePhoneData);

      $addressData = $organizationData;
      $addressData['is_primary'] = TRUE;
      $addressData['location_type_id'] = 3;
      $addressData['is_billing'] = TRUE;

      $addressData["street_address"] = $organizationData['address_primary.street_address'];
      $addressData["supplemental_address_1"] = $organizationData['address_primary.supplementalAddress'];
      $addressData["city"] = $organizationData['address_primary.city'];
      $addressData["state_province_id"] = $organizationData['address_primary.state_province'];
      $addressData["postal_code"] = $organizationData['address_primary.postal_code'];
      $addressData["postal_code_suffix"] = $organizationData['address_primary.postal_code_suffix'];

      $results['primary_address'] = self::SaveAddress($addressData);

      $transaction->commit(); // Commit if all successful
      return $results;

    } catch (Exception $e) {
      $transaction->rollback(); 
      throw new Exception("Failed to save CiviCRM organization profile: " . $e->getMessage(), $e->getCode(), $e->getPrevious());
    }
  }

  public static function SaveEmail(array $emailData)
  {
    $results = Email::save()
      ->addRecord($emailData) // <--- THIS IS THE CORRECT METHOD for single records in the chain
      ->execute();

    $results = Email::save()
      ->addValue('id', '=', $emailData['id'])
      ->addValue('is_primary', $emailData['is_primary'])
      ->addValue('location_type_id', $emailData['location_type_id'])
      ->addValue('email', $emailData['email'])
      ->addValue('contact_id', $emailData['contact_id'])
      ->execute();
    return $results->getArrayCopy();
  }

  public static function SavePhone(array $phoneData)
  {
    $results = Phone::save()
      ->addWhere('id', '=', $phoneData['id'])
      ->addValue('contact_id', $phoneData['contact_id'])
    ->addValue('phone', $phoneData['phone'])
    ->addValue('phone_type_id', $phoneData['phone_type_id']) 
    ->addValue('location_type_id', $phoneData['location_type_id']) 
    ->addValue('is_primary', $phoneData['is_primary'])
    ->execute();
    return $results->getArrayCopy();
  }

  public static function SaveAddress(array $addressData)
  {
    $results = Address::update(TRUE)
      ->addValue('is_primary', $addressData['is_primary'])
      ->addValue('is_billing', $addressData['is_billing'])
      ->addValue('location_type_id', $addressData['location_type_id'])
      ->addValue('street_address', $addressData['street_address'])
      ->addValue('city', $addressData['city'])
      ->addValue('state_province_id', $addressData['state_province_id'])
      ->addValue('postal_code', $addressData['postal_code'])
      ->addValue('postal_code_suffix', $addressData['postal_code_suffix'])
      ->addWhere('contact_id', '=', $addressData['contact_id'])
      ->execute();
    return $results->getArrayCopy();
  }

  public static function GetRegistrationGroups(int $personId): array
  {
    $registrationGroupType = RegistrationGroupType::get()["option_group_id"];

    $groupContacts = \Civi\Api4\GroupContact::get(TRUE)
      ->addSelect('group_id', 'group_id:label', 'contact_id.display_name')
      ->addWhere('contact_id', '=', $personId)
      ->addWhere('group_id.group_type', '=', $registrationGroupType)
      ->execute();

    $registrationGroups = [];
    foreach ($groupContacts as $groupContact) {
      $registrationGroups[] = $groupContact;
    }

    return $registrationGroups;
  }

  public static function GetGenders(): array
  {
    return self::GetOptionValues('Gender');
  }

  public static function GetSalutations(): array
  {
    return self::GetOptionValues('Individual contact prefixes');
  }

  public static function GetGenerations(): array
  {
    return self::GetOptionValues('Individual contact suffixes');
  }

  public static function GetRegions(): array
  {
    try {
      $defaultContactCountryResult = \Civi\Api4\Setting::get(TRUE)
        ->addSelect('defaultContactCountry')
        ->execute();

      foreach ($defaultContactCountryResult as $defaultContactCountry) {
        $defaultCountryId = $defaultContactCountry['value'];
      }

      if (!$defaultCountryId) {
        echo "Could not determine the default country ID from CiviCRM settings.\n";
        exit;
      }

      $statesAndProvinces = StateProvince::get(FALSE)
        ->addSelect('id', 'name', 'abbreviation')
        ->addWhere('country_id', '=', $defaultCountryId)
        ->execute();

      if ($statesAndProvinces->count() > 0) {
        return self::ToArray($statesAndProvinces);
      } else {
        echo "No states or provinces found for the default country.\n";
      }

    } catch (CRM_Core_Exception $e) {
      echo "An error occurred: " . $e->getMessage() . "\n";
      // You might want more detailed error logging in a production environment
    }
  }

  public static function GetContactEmail($contactId): array
  {    
    $daoGetAction = Email::get(TRUE);
    $result = self::GetContactPrimaryEntity($daoGetAction, $contactId)->execute();
    return self::ToArray($result);
  }

  public static function GetContactPhone($contactId): array
  {
    $daoGetAction = Phone::get(TRUE);
    $result = self::GetContactPrimaryEntity($daoGetAction, $contactId)->execute();
    return self::ToArray($result);
  }

  public static function GetContactAddress($contactId): array
  {
    $daoGetAction = Phone::get(TRUE);
    $result = self::GetContactPrimaryEntity($daoGetAction, $contactId)->execute();
    return self::ToArray($result);
  }

  public static function GetContactMobilePhone($contactId): array
  {
    $daoGetAction = Phone::get(TRUE);
    $result = self::GetContactPrimaryEntity($daoGetAction, $contactId)->addWhere('phone_type_id', '=', 2)->execute();
    return self::ToArray($result);
  }

  private static function GetContactPrimaryEntity(DAOGetAction $daoGetAction, int $contactId)
  {
    return $daoGetAction
      ->addSelect('*')
      ->addWhere('contact_id', '=', $contactId)
      ->addOrderBy('is_primary', 'DESC')
      ->setLimit(1);
  }

  public static function GetOrganization($id): array
  {
    $organizations = \Civi\Api4\Organization::get(TRUE)
      ->addSelect('organization_name', 'display_name', )
      ->addWhere('id', '=', $id)
      ->execute();
    return self::ToArray($organizations);
  }

  public static function GetOrganizationProfile($id): array
  {
    $organizations = \Civi\Api4\Organization::get(TRUE)
      ->addSelect(
        'organization_name',
        'display_name'
        ,
        'address_primary',
        'address_primary.street_address',
        'address_primary.supplemental_address_1',
        'address_primary.city',
        'address_primary.postal_code',
        'address_primary.postal_code_suffix'
        ,
        'address_primary.state_province_id',
        'address_primary.state_province_id:label',
        'address_primary.state_province_id:abbr'
        ,
        'address_primary.country_id',
        'address_primary.country_id:abbr',
        'address_primary.country_id:label'
        ,
        'phone_primary',
        'phone_primary.phone',
        'phone_billing',
        'phone_billing.phone'
        ,
        'email_primary',
        'email_primary.email'
      )
      ->addWhere('id', '=', $id)
      ->execute();
    return self::ToArray($organizations);
  }

  public static function GetOptionValues(string $groupLabel): array
  {
    $optionValues = \Civi\Api4\OptionValue::get(TRUE)
      ->addSelect('label', 'value')
      ->addWhere('option_group_id:label', '=', $groupLabel)
      ->execute();

    return self::ToArray($optionValues);
  }

  public static function ToArray($result): array
  {
    $array = [];
    foreach ($result as $element) {
      $array[] = $element;
    }
    return $array;
  }
}