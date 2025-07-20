<?php
require_once("SelectFormElement.php");

/**
 * states and provinces of the default country
 *
 * id, name, abbreviation of all the states and provinces of the default country
 *
 * @version 1.0
 * @author steig
 */
class RegionFormElement extends SelectFormElement
{
  public function __construct(string $name, ?string $label = null, ?bool $required = FALSE)
  {
    $regions = ContactService::GetRegions();
    $addDefaultOption = true;
    parent::__construct($name, $label, $required, $regions, $addDefaultOption);
  }

  public function GetEntityValue($organizationProfile)
  {
    $value = $organizationProfile->address->region->id;
    return $value;
  }
}