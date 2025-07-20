<?php
require_once "Country.php";

/**
 * Region short summary.
 *
 * Region description.
 *
 * @version 1.0
 * @author steig
 */
class Region extends Entity
{
  private Country $_country;
  public function __construct(?int $id, ?string $name = null, ?string $label = null, ?string $description = null, ?country $country = null){
    parent::__construct($id, $name, $label, $description);
    $this->_country = $country;
  }
}