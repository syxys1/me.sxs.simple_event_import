<?php

use Civi\Api4\Event;
use CRM_SimpleEventImport_ExtensionUtil as E;

class CRM_SimpleEventImport_Advimport_ExcelEvents extends CRM_Advimport_Helper_PHPExcel
{
    /**
     * Returns a human-readable name for this helper.
     */
    public function getHelperLabel()
    {
        return E::ts("Importation en lot d'événements");
    }

    /**
     * By default, a field mapping will be shown, but unless you have defined
     * one in getMapping() - example later below - you may want to skip it.
     * Displaying it is useful for debugging at first.
     */
    public function mapfieldMethod()
    {
        return 'skip';
    }

    /**
     * Import an item gotten from the queue.
     *
     * This is where, in custom PHP import scripts, you would program all
     * the logic on how to handle imports the old fashioned way.
     *
     * @param mixed $params
     */
    public function processItem($params)
    {
        if (empty($params['titre'])) {
            throw new Exception('titre is a mandatory field.');
        }
        if (empty($params['type'])) {
            throw new Exception('type is a mandatory field.');
        }
        if (empty($params['date_de_debut'])) {
            throw new Exception('date de début is a mandatory field.');
        }
        if (empty($params['date_de_fin'])) {
            throw new Exception('date de fin is a mandatory field.');
        }

        Civi::log()->debug('ImportEvents.php::$params'.print_r($params, true));

        // Check if this event already exist,
        // so if it's not the case, we create the new event.
        // Exceptions are caught by advimport, and admins can later review.

        $event = Event::get(false)
            ->addWhere('title', '=', $params['titre'])
            ->addWhere('start_date', '=', $params['date_de_debut'])
            ->execute()
            ->first()
        ;

        $event_id = $event['id'] ?? null;

        // If event exist, update it
        if ($event_id) {
            $results = Event::update(true)
                ->addValue('title', $params['titre'])
                ->addValue('summary', $params['resume'])
                ->addValue('description', $params['description'])
                ->addValue('event_type_id', $params['type'])
                ->addValue('start_date', $params['date_de_debut'])
                ->addValue('end_date', $params['date_de_fin'])
                ->addValue('is_online_registration', $params['inscription_en_ligne'])
                ->addValue('registration_start_date', $params['date_de_debut_d_inscription'])
                ->addValue('registration_end_date', $params['date_de_cloture_des_inscriptions'])
                ->addValue('max_participants', $params['nb_maximum_de_participants'])
                ->addValue('loc_block_id', $params['bloc_adresse'])
                ->addValue('intro_text', $params['message_d_introduction'])
                ->addValue('footer_text', $params['message_de_pied_de_page'])
                ->addValue('confirm_email_text', $params['texte_du_couriel_de_confirmation'])
                ->addWhere('id', '=', $event_id)
                ->execute()
            ;
            $event_id = $result['id'];
        } else {
            $results = Event::create(true)
              // ->addValue('id', '')
                ->addValue('title', $params['titre'])
                ->addValue('summary', $params['resume'])
                ->addValue('description', $params['description'])
                ->addValue('event_type_id', $params['type'])
                ->addValue('participant_listing_id', '')
                ->addValue('is_public', true)
                ->addValue('start_date', $params['date_de_debut'])
                ->addValue('end_date', $params['date_de_fin'])
                ->addValue('is_online_registration', $params['inscription_en_ligne'])
                ->addValue('registration_link_text', "S'inscrire maintenant")
                ->addValue('registration_start_date', $params['date_de_debut_d_inscription'])
                ->addValue('registration_end_date', $params['date_de_cloture_des_inscriptions'])
                ->addValue('max_participants', $params['nb_maximum_de_participants'])
                ->addValue('is_map', false)
                ->addValue('event_full_text', 'Cet événement est actuellement complet. Merci de nous contacter au 514-564-3061 poste 105, ou à info@gaso.ca pour manifester votre intérêt.')
                ->addValue('is_monetary', false)
                ->addValue('financial_type_id', '')
                ->addValue('payment_processor', '')
                ->addValue('is_active', true)
                ->addValue('fee_label', '')
                ->addValue('is_show_location', true)
                ->addValue('loc_block_id', $params['bloc_adresse'])
                ->addValue('default_role_id', 1)
                ->addValue('intro_text', $params['message_d_introduction'])
                ->addValue('footer_text', $params['message_de_pied_de_page'])
                ->addValue('confirm_title', 'Confirmer les informations de votre inscription')
                ->addValue('confirm_text', '')
                ->addValue('confirm_footer_text', '')
                ->addValue('is_email_confirm', true)
                ->addValue('confirm_email_text', $params['texte_du_couriel_de_confirmation'])
                ->addValue('confirm_from_name', 'Jeanne Blain')
                ->addValue('confirm_from_email', 'info@gaso.ca')
                ->addValue('cc_confirm', '')
                ->addValue('bcc_confirm', '')
                ->addValue('default_fee_id', '')
                ->addValue('default_discount_fee_id', '')
                ->addValue('thankyou_title', 'Merci pour votre inscription.')
                ->addValue('thankyou_text', '')
                ->addValue('thankyou_footer_text', '')
                ->addValue('is_pay_later', false)
                ->addValue('pay_later_text', '')
                ->addValue('pay_later_receipt', '')
                ->addValue('is_partial_payment', false)
                ->addValue('initial_amount_label', '')
                ->addValue('initial_amount_help_text', '')
                ->addValue('min_initial_amount', '')
                ->addValue('is_multiple_registrations', false)
                ->addValue('max_additional_participants', '')
                ->addValue('allow_same_participant_emails', false)
                ->addValue('has_waitlist', false)
                ->addValue('requires_approval', false)
                ->addValue('expiration_time', '')
                ->addValue('allow_selfcancelxfer', false)
                ->addValue('selfcancelxfer_time', '')
                ->addValue('waitlist_text', '')
                ->addValue('approval_req_text', '')
                ->addValue('is_template', false)
                ->addValue('template_title', '')
                ->addValue('currency', 'CAD')
                ->addValue('is_share', false)
                ->addValue('is_confirm_enabled', '')
                ->addValue('is_billing_required', false)
                ->addValue('is_show_calendar_links', true)
                ->execute()
            ;
            $event_id = $result['id'];
        }
        foreach ($results as $result) {
            Civi::log()->debug('ImportEvents.php::create result '.print_r($result, true));
            // do something
        }

        CRM_Advimport_Utils::setEntityTableAndId($params, 'civicrm_event', $event_id);
    }
}
