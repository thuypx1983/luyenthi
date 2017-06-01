<?php

// ======================================
// CONDITIONS
// ======================================
/*
 * Conditions:
 */

// ======================================
// ACTIONS
// ======================================

/*
 * Actions:
 */

// ======================================
// TRIGGERS
// ======================================

/*
 * Triggers:
 * + A ticket has been purchased
 */

/**
 * Implements hook_rules_event_info()
 */
function ms_events_rules_event_info() {
  $items = array(
    'ms_events_event_ticket_purchased' => array(
      'label' => t('Ticket(s) Purchased'),
      'group' => 'Events Ticketing Suite',
      'help' => t("Act when ticket(s) are purchased"),
      'variables' => array(
        'payment' => array('type' => 'ms_payment', 'label' => t('Payment')),
        'ticket' => array('type' => 'ms_events_ticket', 'label' => t('Ticket')),
        'order' => array('type' => 'ms_order', 'label' => t('Order', array(), array('context' => 'ms_core'))),
        'account' => array('type' => 'user', 'label' => t('Seller')),
      ),
    ),
  );

  return $items;
}


// ======================================
// DATA TYPES
// ======================================

/**
 * Implements hook_rules_data_info()
 */
function ms_events_rules_data_info() {
  return array(
    'ms_events_ticket' => array(
      'label' => t('Event Ticket'),
      'wrap' => TRUE,
      'group' => t('Events Ticketing Suite'),
    ),
  );
}
