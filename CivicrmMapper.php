<?php

/**
 * CivicrmMapper short summary.
 *
 * CivicrmMapper description.
 *
 * @version 1.0
 * @author msteigerwald
 */
class CivicrmMapper
{
  public static function entityMap(): array
  {
    return array(
      "id" => "id",
      "name" => "name",
      "label" => "label",
      "description" => "description"
    );
  }

  public static function contactMap(): array
  {
    return array(
      "id" => "id"
    );
  }

  public static function organizationMap(): array
  {
    return array(
      "id" => "id",
      "name" => "name"
    );
  }

  public static function personMap(): array
  {
    return array(
      "id" => "id",
      "name" => "sort_name",
      "label" => "display_name",
      "lastName" => "last_name",
      "firstName" => "first_name",
      "middleName" => "middle_name",
      "gender" => "gender_id:label",
      "generation" => "suffix_id:label",
      "salutation" => "prefix_id:label",
      "birthdate" => "birth_date"
    );
  }

  public static function emailAddressMap(): array
  {
    return array(
      "email" => "email"
    );
  }

  public static function phoneMap(): array
  {
    return array(
      "phoneNumber" => "phone"
    );
  }

  public static function addressMap(): array
  {
    return array(
      "streetAddress" => "street_address",
      "supplementalAddress" => "supplemental_address_1",
      "city" => "city",
      "country" => "country_id:label",
      "region" => "state_province_id:label",
      "postalCode" => "postal_code"
    );
  }
}