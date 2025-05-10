<?php

/**
 * Mr., Mrs. etc.
 *
 * Extend person identificaiton to include salutation in case of formal communication.
 *
 * @version 1.0
 * @author steig
 */
class Salutation extends TournamentObject
{
  public function __construct($name, ?string $label = null, ?string $description = null)
  {
    parent::__construct(null, $name, $label, $description);
  }

  public const Mr = new Salutation("Mr", "Mr.", "Mister");
  public const Mrs = new Salutation("Mrs", "Mrs.", "Mrs.");
  public const Ms = new Salutation("Ms", "Ms.", "Ms.");
  public const Miss = new Salutation("Miss", "Miss", "Miss");
  public const Dr = new Salutation("Dr", "Dr.", "Doctor");
  public const Br = new Salutation("Br", "Br.", "Brother");
}