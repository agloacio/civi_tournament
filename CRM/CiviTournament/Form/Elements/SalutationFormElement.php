<?php
require_once("SelectFormElement.php");

/**
 * Mr., Ms. etc.
 *
 * GendersFormElement description.
 *
 * @version 1.0
 * @author steig
 */
class SalutationFormElement extends SelectFormElement
{
  public function __construct(string $name, ?string $label = null, ?bool $required = FALSE)
  {
    $salutations = ContactService::GetSalutations();
    $addDefaultOption = true;
    parent::__construct($name, $label, $required, $salutations, $addDefaultOption);
  }

  public function GetEntityValue($person)
  {
    $value = $person->salutation->id;
    return $value;
  }
}