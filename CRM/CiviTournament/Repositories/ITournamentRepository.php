<?php

/**
 * ITournamentRepository short summary.
 *
 * ITournamentRepository description.
 *
 * @version 1.0
 * @author steig
 */
interface ITournamentRepository
{
  public static function GetPerson($personId): array;
  public static function GetBillingOrganizations(int $personId): array;
}
