<?php

/**
 * CiviTournament System wide utilities.
 *
 * Provides a collection of CiviTournament utilities.
 *
 * @version 1.0
 * @author msteigerwald
 */
class CiviTournament_Utils_System
{
  /**
   * Get the URL for the tournament person form.
   *
   * @param int $contactId The ID of the contact (person).
   *
   * @return string The URL to the tournament person form.
   */
  public static function civi_tournament_get_person_url($contactId)
  {
    $url = CRM_Utils_System::url(CiviTournament_Utils_System::civi_tournament_get_path('person'), "cid={$contactId}");
    return $url;
  }

  /**
   * Get the URL for the tournament person form.
   *
   * @param int $contactId The ID of the contact (person).
   *
   * @return string The URL to the tournament person form.
   */
  public static function civi_tournament_get_path($relativePath)
  {
    $url = "civicrm/tournament/{$relativePath}";
    return $url;
  }
}