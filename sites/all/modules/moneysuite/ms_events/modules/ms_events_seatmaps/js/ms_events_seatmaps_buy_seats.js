var ms_events_selected_seats = {};
function ms_events_seatmaps_attach(eid) {
  var i, ticket_types = Drupal.settings.ms_events_seatmaps[eid].ticket_types,
      prices = Drupal.settings.ms_events_seatmaps[eid].prices;
  var parent_div = jQuery("#ms_events_seatmap_" + eid);
  parent_div.find(".tickets_field").hide();

  jQuery('<div/>', {
    class: 'selected-seats'
  }).appendTo(parent_div.find(".seatmap_image > .form-item"));

  // Load the seats from the settings array
  for (i in Drupal.settings.ms_events_seatmaps[eid].seats) {
    seat_obj = Drupal.settings.ms_events_seatmaps[eid].seats[i];

    var seat = jQuery('<div/>', {
      html: "<div class='seat_name'>" + seat_obj.name + "</div>"
    });

    seat.attr('seat_id', seat_obj.id);
    seat.attr('name', seat_obj.name);
    seat.attr('seats', seat_obj.seats);
    seat.attr('group_id', seat_obj.group_id);
    seat.attr('title', seat_obj.name);

    if(seat_obj.incart != undefined) {
      seat.addClass(seat_obj.incart);
    }


    seat.addClass('seat').css('top', seat_obj.y + "px").css('left', seat_obj.x + "px")
      .css('width', seat_obj.width).css('height', seat_obj.height);

    if (seat_obj.seats > 0) {
      seat.addClass('seat-available').css('background', seat_obj.color);
      make_active(eid, seat);
    }
    else {
      seat.addClass('seat-purchased');
    }

    parent_div.find(".seatmap_image > .form-item").append(seat);
  }

  // Create the dialog and spinner elements
  if (!jQuery('#elemId').length) {
    var dialog = jQuery('<div/>', {
      id: 'seat-dialog',
      title: 'Seat options'
    });
    dialog.html('<form><label for="ticket_type">Type</label><select name="ticket_type" class="dialog_ticket_type"></select><div class="dialog_seats_container"><label for="seats">Number of Seats</label><select name="seats" class="dialog_seats"></select></div></form>');

    parent_div.append(dialog);
  }

  if (Drupal.settings.ms_events_seatmaps_autoadd) {
    parent_div.find('.form-submit').hide();
  }
}

// Stringify the selected seats object and store it in the text field of the form
function updateTicketsField(eid) {
  var ticket_types = Drupal.settings.ms_events_seatmaps[eid].ticket_types,
      prices = Drupal.settings.ms_events_seatmaps[eid].prices;
  var parent_div = jQuery("#ms_events_seatmap_" + eid);
  parent_div.find(".tickets_field textarea").val(JSON.stringify(ms_events_selected_seats));
  parent_div.find(".selected-seats .ticket_button").remove();

  var l;
  for (l in ms_events_selected_seats) {
    var seat = ms_events_selected_seats[l];

    jQuery('<div>')
      .attr('class', 'ticket_button')
      .attr('seat_id', seat.seat_id)
      .text(seat.seat_name + " - " + ticket_types[seat.type] + ": " + seat.price)
      .appendTo(parent_div.find('.selected-seats'));
  }

  parent_div.find(".selected-seats .ticket_button").button({
    icons: {
      secondary: "ui-icon-close"
    }
  });

  parent_div.find(".selected-seats .ticket_button").click(function(e) {
    var seat = jQuery(".seat[seat_id=" + jQuery(this).attr('seat_id') + "]");
    seat.removeClass('seat-selected');
    make_active(eid, seat);
    delete ms_events_selected_seats[seat.attr('seat_id')];
    updateTicketsField();
  });
}

function make_active(eid, element) {
  var ticket_types = Drupal.settings.ms_events_seatmaps[eid].ticket_types,
      prices = Drupal.settings.ms_events_seatmaps[eid].prices;
  var parent_div = jQuery("#ms_events_seatmap_" + eid);
  jQuery(element).click(function(e) {
    var seat = jQuery(e.currentTarget), pos = seat.position(), ticket_type, k;

    jQuery('.dialog_ticket_type option').remove();
    jQuery('.dialog_seats option').remove();
    for (ticket_type in ticket_types) {
      // Make sure the group the seat belongs to uses this type
      try {
        if (prices[seat.attr('group_id')][ticket_type]) {
          jQuery('.dialog_ticket_type').append('<option value="' + ticket_type + '">' + ticket_types[ticket_type] + ' (' + prices[seat.attr('group_id')][ticket_type] + ')' + '</option>');
        }
      }
      catch (error) {}
    }

    for (k = 1; k <= seat.attr('seats'); k++) {
      jQuery('.dialog_seats').append('<option value="' + k + '">' + k + '</option>');
    }
    if (seat.attr('seats') > 1) {
      jQuery(".dialog_seats_container").show();
    }
    else {
      jQuery(".dialog_seats_container").hide();
    }
    jQuery("#seat-dialog").dialog({
      height: 250,
      modal: true,
      buttons: {
        "Confirm": function() {
          // Add the selected seat settings to the array and JSONify it and store it in the textbox
          seat.addClass('seat-selected');
          seat.unbind('click');
          ms_events_selected_seats[seat.attr('seat_id')] = {
            seat_id: seat.attr('seat_id'),
            seat_name: seat.attr('name'),
            group_id: seat.attr('group_id'),
            qty: jQuery(".dialog_seats").val(),
            type: jQuery(".dialog_ticket_type").val(),
            eid: eid,
            price: prices[seat.attr('group_id')][jQuery(".dialog_ticket_type").val()]
          };
          updateTicketsField(eid);
          jQuery(this).dialog("close");

          // Automatic add to cart to save the seats on the server.
          if (Drupal.settings.ms_events_seatmaps_autoadd) {
            parent_div.find('form').submit();
          }
        }
      }
    });
  });
}

