<?php

require_once("Entity.php");

/**
 * Tournament short summary.
 *
 * Tournament description.
 *
 * @version 1.0
 * @author steig
 */
class Tournament extends Entity
{
  private ?DateTimeImmutable $_registrationEndDateTime;
  public function __construct(?int $id, ?string $name = null, ?string $label = null, ?string $description = null, ?DateTimeImmutable $registrationEndDateTime = null)
  {
    $this->_registrationEndDateTime = $registrationEndDateTime;
    parent::__construct($id, $name, $label, $description);
  }

  public function __get($name)
  {
    if ($name === 'registrationEndDateTime') {
      return $this->_registrationEndDateTime;
    }
  }
}