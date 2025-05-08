<?php

/**
 * Jr., Sr., etc.
 *
 * Extend person identificaiton to include generation.
 *
 * @version 1.0
 * @author steig
 */
class Generation extends TournamentObject
{
  public function __construct($name, ?string $label = null, ?string $description = null)
  {
    parent::__construct(null, $name, $label, $description);
  }

  public const Jr = new Generation("Jr", "Jr.", "Junior");
  public const Sr = new Generation("Sr", "Sr.", "Senior");
  public const II = new Generation("II", "II", "The Second");
  public const III = new Generation("III", "III", "The Third");
}