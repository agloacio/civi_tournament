<?php
require_once("SelectFormElement.php");

/**
 * Dropdown: Male, Female, etc.
 *
 * GendersFormElement description.
 *
 * @version 1.0
 * @author steig
 */
class GenderFormElement extends SelectFormElement
{
  public function __construct(string $name, ?string $label = null, ?bool $required = FALSE)
  {
    $genders = ContactService::GetGenders();
    $addDefaultOption = true;
    parent::__construct($name, $label, $required, $genders, $addDefaultOption);
  }

  public function GetEntityValue($person)
  {
    $value = $person->gender->id;
    return $value;
  }
}