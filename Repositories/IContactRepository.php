<?php

/**
 * Contact repository interface.
 *
 * Required function signatures for any Contact repository.
 *
 * @version 1.0
 * @author steig
 */
interface IContactRepository
{
  public static function GetPerson($personId) : array;
  public static function GetBillingOrganizations($personId) : array;
  public static function GetGenders(): array;
  public static function GetSalutations(): array;
  public static function GetGenerations(): array;

  public static function GetContactEmail($contactId): array;
  public static function GetContactPhone($contactId): array;
  public static function GetContactAddress($contactId): array;
  public static function GetContactMobilePhone($contactId): array;
}
