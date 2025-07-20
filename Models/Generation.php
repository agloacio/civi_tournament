<?php
require_once("Entity.php");

/**
 * Jr., Sr., etc.
 *
 * Extend person identificaiton to include generation.
 *
 * @version 1.0
 * @author steig
 */
class Generation extends Entity
{
  public function __construct($id, ?string $name, ?string $label = null, ?string $description = null)
  {
    parent::__construct($id, $name, $label, $description);
  }
}