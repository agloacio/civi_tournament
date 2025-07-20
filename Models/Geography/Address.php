<?php
require_once "Region.php";

/**
 * Postal Address
 *
 * Street, City, Region, PostalCode, etc.
 *
 * @version 1.0
 * @author msteigerwald
 */
class Address extends Entity
{
  private string $_streetAddress;
  private ?string $_streetAddress1;
  private string $_city;
  private Region $_region;
  private string $_postalCode;

  public function __construct(?int $id, string $streetAddress, ?string $streetAddress1, string $city, ?Region $region, ?string $postalCode)
  {
    $name = $streetAddress . ";" . $city . ";" . $region->name . ";" . $postalCode;
    parent::__construct($id, $name, $name);

    $this->_streetAddress = $streetAddress;
    $this->_streetAddress1 = $streetAddress1;
    $this->_city = $city;
    $this->_region = $region;
    $this->_postalCode = $postalCode;
  }

  public function __get($name) {
    if ($name == 'streetAddress')
      return $this->_streetAddress;
    if ($name == 'streetAddress1')
      return $this->_streetAddress1;
    if ($name == 'city')
      return $this->_city;
    if ($name == 'region')
      return $this->_region;
    if ($name == 'postalCode')
      return $this->_postalCode;
    return parent::__get($name);
  }
}