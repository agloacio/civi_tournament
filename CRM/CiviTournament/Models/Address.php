<?php
require_once "TournamentObject.php";

/**
 * Postal Address
 *
 * Street, City, Region, PostalCode, etc.
 *
 * @version 1.0
 * @author msteigerwald
 */
class Address extends TournamentObject
{
  private string $_streetAddress;
  private string $_supplementalAddress;
  private string $_city;
  private string $_region;
  private string $_country;
  private string $_postalCode;
}