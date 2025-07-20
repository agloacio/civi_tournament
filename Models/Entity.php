<?php

/**
 * Common properties for every class in the project
 *
 * base class that contains an id, name, label and description for objects that will build a tournament management application.
 *
 * @version 1.0
 * @author msteigerwald
 */
abstract class Entity
{
  public ?int $_id;
  public ?string $_name;
  public ?string $_label;
  public ?string $_description;

  public function __construct(?int $id = null, ?string $name = null, ?string $label = null, ?string $description = null)
  {
    $this->_id = $id;
    $this->_name = $name;
    $this->_label = $label ?? $name;
    $this->_description = $description;
  }

  public function __get($name)
  {
    if ($name === 'id') {
      return $this->_id;
    }
    if ($name === 'name') {
      return $this->_name;
    }
    if ($name === 'label') {
      return $this->_label;
    }
    if ($name === 'description') {
      return $this->_description;
    }
    return null;
  }

  // The magic __toString() method
  public function __toString() : string
  {
    return $this->_label ??  $this->_name;
  }
}