<?php
require_once("Entity.php");

/**
 * Male, female, etc.
 *
 * Extend person identificaiton to include gender. Could be useful for demographics and housing arrangements.
 *
 * @version 1.0
 * @author steig
 */
class Gender extends Entity
{
  public function __construct($id = null, ?string $name = null, ?string $label = null)
  {
    parent::__construct($id, $name, $label);
  }
}
