<?php

/**
 * common properties for any tournament object
 *
 * base class that contains an id, name, label and description for objects that will build a tournament management application.
 *
 * @version 1.0
 * @author msteigerwald
 */
abstract class TournamentObject
{
  public ?int $_id;
  public ?string $_name;
  public ?string $_label;
  public ?string $_description;

  public function __construct(?int$id, ?string $name = null, ?string $label = null, ?string $description = null)
  {
    $this->_id = $id;
    $this->_name = $name;
    $this->_label = $label;
    $this->_description = $description;
  }
}