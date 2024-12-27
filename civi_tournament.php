<?php

require_once 'civi_tournament.civix.php';

use CRM_CiviTournament_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function civi_tournament_civicrm_config(&$config): void {
  _civi_tournament_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function civi_tournament_civicrm_install(): void {
  _civi_tournament_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function civi_tournament_civicrm_enable(): void {
  _civi_tournament_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function civi_tournament_civicrm_navigationMenu(&$menu)
{
  _civi_tournament_civix_insert_navigation_menu($menu, '', array(
    'label' => E::ts('Tournaments'),
    'name' => 'tournament',
    'permission' => 'access CiviEvent',
    'operator' => 'OR',
    'separator' => 0,
    'icon' => 'crm-i fa-calendar',
  ));

  _civi_tournament_civix_insert_navigation_menu($menu, 'tournament', array(
    'label' => E::ts('Dashboard'),
    'name' => 'extensions',
    'url' => 'civicrm/tournament',
    'permission' => 'access CiviEvent',
    'operator' => 'OR',
    'separator' => 0
  ));

  _civi_tournament_civix_insert_navigation_menu($menu, 'tournament', array(
    'label' => E::ts('Person'),
    'name' => 'person',
    'url' => 'civicrm/tournament/person',
    'permission' => 'access CiviCRM',
    'operator' => 'OR',
    'separator' => 0,
  ));
}