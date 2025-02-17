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
  public $_id;
  public $_name;
  public $_label;
  public $_description;

  public function __construct($id, $name = null, $label = null, $description = null)
  {
    $this->_id = $id;
    $this->_name = $name;
    $this->_label = $label;
    $this->_description = $description;
  }
}