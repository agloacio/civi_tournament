<?php
require_once("TournamentObject.php");

/**
 * Male, female, etc.
 *
 * Extend person identificaiton to include gender. Could be useful for demographics and housing arrangements.
 *
 * @version 1.0
 * @author steig
 */
class Gender extends TournamentObject
{
  public function __construct($name = null, ?string $label = null)
  {
    parent::__construct(null, $name, $label);
  }

  //public const Male = new Gender("M", "Male");
  //public const Female = new Gender("F", "Female");
}
