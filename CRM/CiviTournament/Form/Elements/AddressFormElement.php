<?php

/**
 * AddressFormElement short summary.
 *
 * AddressFormElement description.
 *
 * @version 1.0
 * @author steig
 */
class AddressFormElement extends TextFormElement
{
  public function GetEntityValue($organizationProfile)
  {
    $property = $this->name;
    return $organizationProfile->address->$property;
  }
}