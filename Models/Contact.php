<?php
require_once("Entity.php");

/**
 * Base class for Person and Organization.
 *
 * Base class for Person and Organization.
 *
 * @version 1.0
 * @author steig
 */
class Contact extends Entity
{
  public function __construct(?int $id, ?string $name = null, ?string $label = null, ?string $description = null)
  {
    parent::__construct($id, $name, $label, $description);
  }
}