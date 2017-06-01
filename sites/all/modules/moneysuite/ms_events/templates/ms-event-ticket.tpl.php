<?php

/**
 * @file
 * Template for the Invoice view of an order. This is used both for printing and for display on the site
 *
 * Variables:
 * ----------
 *
 * $ticket
 *   The ticket object, which contains lots of useful info
 * $account
 *   The user account the ticket belongs to
 * $event_name
 *   The name of the entity the event is attached to
 * $event_date
 *   The timestamp of the event date
 * $order
 *   The order object, or FALSE if there is no order
 */
?>

<style>

</style>

<h3>Ticket #<?php print $ticket->ticket_number; ?></h3>

<div>Event: <?php print $event_name; ?></div>

<div>Date: <?php print format_date($event_date); ?></div>

<?php if ($order) { ?>
  <div>Name: <?php print $order->first_name . ' ' . $order->last_name; ?></div>
<?php } ?>

<div>Seat: <?php print $ticket->ticket_seat; ?></div>

<div>Price: <?php print ms_core_format_money($ticket->price); ?></div>
