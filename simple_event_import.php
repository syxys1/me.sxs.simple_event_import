<?php

require_once 'simple_event_import.civix.php';
// phpcs:disable
use CRM_SimpleEventImport_ExtensionUtil as E;

// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @see https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 *
 * @param mixed $config
 */
function simple_event_import_civicrm_config(&$config): void
{
    _simple_event_import_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @see https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function simple_event_import_civicrm_install(): void
{
    _simple_event_import_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @see https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function simple_event_import_civicrm_enable(): void
{
    _simple_event_import_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_advimport_helpers().
 *
 * @param mixed $helpers
 */
function simple_event_import_civicrm_advimport_helpers(&$helpers)
{
    $helpers[] = [
        'class' => 'CRM_SimpleEventImport_Advimport_ExcelEvents',
        'label' => E::ts("Importation en lot d'événements d'un fichier Excel"),
    ];
}
