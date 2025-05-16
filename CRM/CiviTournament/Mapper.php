<?php
require_once("CRM/CiviTournament/Models/Person.php");
require_once("CRM/CiviTournament/Models/Organization.php");

class Mapper
{
  public static function MapCiviToPerson($civi)
  {
    $genderLabel = $civi["gender_id:label"];
    if (isset($genderLabel))
      $gender = new Gender(substr($genderLabel, 0, 1), $genderLabel);
    if (isset($civi["prefix_id:label"]))
      $salutation = new Salutation($civi["prefix_id:label"], $civi["prefix_id:label"]);
    if (isset($civi["prefix_id:label"]))
      $generation = new Generation($civi["suffix_id:label"], $civi["suffix_id:label"]);
    if (isset($civi["birth_date"]))
      $birthDate = new DateTime($civi["birth_date"]);
    $person = new Person($civi["id"], $civi["last_name"], $civi["first_name"], $civi["middle_name"], $gender, $birthDate, $generation, $salutation);
    return $person;
  }

  public static function MapCiviToBillingOrganizations(array $civiRecords)
  {
    $billingOrganizations = array();

    foreach ($civiRecords as $civiRecord) {
      $billingOrganizations[] = new Organization($civiRecord["contact_id_b"], $civiRecord["contact_id_b.display_name"]);
    }
    return $billingOrganizations;
  }
}