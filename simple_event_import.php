<?php

require_once 'simple_event_import.civix.php';
// phpcs:disable
use CRM_SimpleEventImport_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function simple_event_import_civicrm_config(&$config): void {
  _simple_event_import_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function simple_event_import_civicrm_install(): void {
  _simple_event_import_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function simple_event_import_civicrm_enable(): void {
  _simple_event_import_civix_civicrm_enable();
}
