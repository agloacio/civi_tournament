<?php

/**
 * Form Field
 *
 * Binds entity properties to form elements.
 *
 * @version 1.0
 * @author msteigerwald
 */
class FormElement
{
  public const REQUIRED = TRUE;
  public const OPTIONAL = FALSE;

  private ?string $_type;
  private ?string $_name;
  private ?string $_label;
  private $_attributes;
  private bool $_required;
  private $_extra;

  public function __construct($type, ?string $name, ?string $label = null, bool $required = FALSE, $attributes = array(), $extra = array())
  {
    $this->_type = $type;
    $this->_name = $name;
    $this->_label = ts($label ?? $this->defaultLabel());
    $this->_required = $required;
    $this->_attributes = $attributes;
    $this->_extra = $extra;
  }

  public function __get(string $name)
  {
    if ($name === 'type') {
      return $this->_type;
    }
    if ($name === 'name') {
      return $this->_name;
    }
    if ($name === 'label') {
      return $this->_label;
    }
    if ($name === 'required') {
      return $this->_required;
    }
    if ($name === 'attributes') {
      return $this->_attributes;
    }
    if ($name === 'extra') {
      return $this->_extra;
    }
  }

  public function GetEntityValue($entity)
  {
    $property = $this->name;
    $value = $entity->$property;
    return $value;
  }

  private function defaultLabel()
  {
    $token = str_contains($this->_name, '_id') ? str_replace('_id', '', $this->_name) : $this->_name;
    return self::capitalizeWords($token);
  }

  private static function capitalizeWords($string)
  {
    $words = explode('_', $string);
    $capitalizedWords = array_map('ucfirst', $words);
    return implode(' ', $capitalizedWords);
  }
}