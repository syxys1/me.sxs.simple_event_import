<?php

require_once 'gaso_event.civix.php';
// phpcs:disable
use CRM_GasoEvent_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function gaso_event_civicrm_config(&$config): void {
  _gaso_event_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function gaso_event_civicrm_install(): void {
  _gaso_event_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function gaso_event_civicrm_enable(): void {
  _gaso_event_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_advimport_helpers()
 */
function gaso_event_civicrm_advimport_helpers(&$helpers) {
  $helpers[] = [
    'class' => 'CRM_GasoEvent_Advimport_ExcelEvents',
    'label' => E::ts("Importation en lot Événements GASO d'un fichier Excel"),
  ];
  
}