<?php
require_once("Entity.php");

/**
 * Mr., Mrs. etc.
 *
 * Extend person identificaiton to include salutation in case of formal communication.
 *
 * @version 1.0
 * @author steig
 */
class Salutation extends Entity
{
  public function __construct($id, ?string $name, ?string $label = null, ?string $description = null)
  {
    parent::__construct($id, $name, $label, $description);
  }

}