<?php
require_once("FormElement.php");
/**
 * i.e., dropdpwn element
 * 
 * Wrapper around html select element.
 *
 * @version 1.0
 * @author steig
 */
class SelectFormElement extends FormElement
{
  public function __construct($name, ?string $label, ?bool $required, array $options, ?bool $addDefaultOption = false, ?string $defaultOption = "-- Select One --")
  {
    if ($addDefaultOption) $options = ["" => ts($defaultOption)] + $options;
    parent::__construct('Select', $name, $label, $required ?? self::OPTIONAL, $options);
  }
}