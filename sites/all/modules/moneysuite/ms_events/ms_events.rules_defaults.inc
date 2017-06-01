<?php
/**
 * Implements hook_default_rules_configuration().
 */
function ms_events_default_rules_configuration() {
  $configs = array();

  $rules_ticket_purchased = '
  { "rules_ticket_purchased" : {
      "LABEL" : "Ticket Purchased",
      "PLUGIN" : "reaction rule",
      "TAGS" : [ "Events Ticketing Suite" ],
      "REQUIRES" : [ "rules", "ms_events" ],
      "ON" : [ "ms_events_event_ticket_purchased" ],
      "DO" : [
        { "mail" : {
            "to" : [ "ticket:uid:mail" ],
            "subject" : "Ticket Receipt",
            "message" : "Thank you for purchasing a ticket to [ticket:eventTitle]. The ticket details are as follows:\r\n\r\nEvent: [ticket:eventTitle]\r\nDate: [ticket:eventDateTime]\r\nTicket ID: [ticket:ticketId]\r\nTicket Type: [ticket:ticketType]\r\nSeat: [ticket:ticketSeat]\r\nPrice: [ticket:ticketPrice]\r\n\r\nSincerely,\r\nTicket Sales Team"
          }
        }
      ]
    }
  }';

  $configs['rules_ticket_purchased'] = rules_import($rules_ticket_purchased);

  return $configs;
}
