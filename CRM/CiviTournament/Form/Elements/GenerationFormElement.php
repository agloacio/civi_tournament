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
class GenerationFormElement extends SelectFormElement
{
  public function __construct(string $name, ?string $label = null, ?bool $required = FALSE)
  {
    $generations = ContactService::GetGenerations();
    $addDefaultOption = true;
    parent::__construct($name, $label, $required, $generations, $addDefaultOption);
  }

  public function GetEntityValue($person)
  {
    $value = $person->generation->id;
    return $value;
  }
}