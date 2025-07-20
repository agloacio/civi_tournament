<?php

/**
 * DateTimeFormElement short summary.
 *
 * DateTimeFormElement description.
 *
 * @version 1.0
 * @author steig
 */
class DateTimeFormElement extends FormElement {

  public function __construct($name, ?string $label = null, ?bool $required = FALSE)
  {
    parent::__construct('datepicker', $name, $label, $required);
  }

  public function GetEntityValue($entity)
  {
    $propertyName = $this->name;
    $property = $entity->$propertyName;
    if (isset($property)) {
      $value = $property->format('Y-m-d');
      return $value;
    }
  }
}