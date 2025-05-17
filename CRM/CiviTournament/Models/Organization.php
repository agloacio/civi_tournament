<?php

/**
 * School, District, Company, etc.
 *
 * Non-person Contact.
 *
 * @version 1.0
 * @author steig
 */
class Organization extends Contact
{
  public function __construct(?int $id, ?string $name = null)
  {
    parent::__construct($id, $name);
  }
}