<?php

require_once 'tournament.civix.php';

use CRM_Tournament_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function tournament_civicrm_config(&$config): void {
  _tournament_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function tournament_civicrm_install(): void {
  _tournament_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function tournament_civicrm_enable(): void {
  _tournament_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function tournament_civicrm_navigationMenu(&$menu) {
  _tournament_civix_insert_navigation_menu($menu, '', array(
    'label' => E::ts('Tournaments'),
    'name' => 'tournament',
    'permission' => 'access CiviEvent',
    'operator' => 'OR',
    'separator' => 0,
    'icon' => 'crm-i fa-calendar',
  ));

  _tournament_civix_insert_navigation_menu($menu, 'tournament', array(
    'label' => E::ts('Dashboard'),
    'name' => 'extensions',
    'url' => 'civicrm/tournament',
    'permission' => 'access CiviEvent',
    'operator' => 'OR',
    'separator' => 0
  ));

  _tournament_civix_insert_navigation_menu($menu, 'tournament', array(
    'label' => E::ts('Person'),
    'name' => 'person',
    'url' => 'civicrm/person',
    'permission' => 'access CiviCRM',
    'operator' => 'OR',
    'separator' => 0,
  ));
}
