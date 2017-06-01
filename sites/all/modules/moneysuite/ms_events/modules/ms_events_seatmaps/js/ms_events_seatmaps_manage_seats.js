(function ($) {
  $(document).ready(function() {
    var seat_default_width = 20, seat_default_height = 20;

    // Load the seats from the settings array
    var i;
    for (i in Drupal.settings.ms_events_seatmaps.seats) {
      seat_obj = Drupal.settings.ms_events_seatmaps.seats[i];

      var seat = $('<div/>', {
        html: "<div class='seat_name'>" + seat_obj.name + "</div>"
      });

      seat.attr('seat_id', seat_obj.id);
      seat.attr('name', seat_obj.name);
      seat.attr('seats', seat_obj.seats);
      seat.attr('group_id', seat_obj.group_id);
      seat.attr('title', seat_obj.name);

      seat.addClass('seat').addClass('make_seat_work').css('top', seat_obj.y + "px").css('left', seat_obj.x + "px")
        .css('width', seat_obj.width).css('height', seat_obj.height)
        .css('background', seat_obj.color);

      $("#edit-image-pic").append(seat);
      activate_seat(seat);
    }

    $("#edit-image-pic").selectable({
      filter: ".seat",
      distance: 5
    });

    $( ".make_seat_work" ).live('mouseover', function(e){
      activate_seat(this);
      $(this).removeClass('make_seat_work');
      return false;
    });


    // Keyboard control
    $(document).keydown(function(e) {
      switch (e.keyCode) {
        case 37: // Left
          move_seat_keyboard(-1, 0, e.shiftKey);
          return false;
        case 38: // Up
          move_seat_keyboard(0, -1, e.shiftKey);
          return false;
        case 39: // Right
          move_seat_keyboard(1, 0, e.shiftKey);
          return false;
        case 40: // Down
          move_seat_keyboard(0, 1, e.shiftKey);
          return false;
        case 46: // Delete
          $(".ui-selected").attr('remove', 1).hide();
          mark_changed();
          return false;
      }
    });

    // Create the dialog and spinner elements
    var dialog = $('<div/>', {
      id: 'seat-dialog',
      title: 'Seat settings'
    });
    dialog.html('<form><label for="name">Name</label><input type="text" name="name" id="dialog_name" /><label for="seats">Number of Seats</label><input type="text" name="seats" id="dialog_seats" /></form>');

    $("#edit-image-pic").append(dialog);
    $("#edit-image-pic").append("<div id='seats_throbber'></div>");

    // Make seats join a group
    $(".group_button").click(function(event) {
      var button = this;
      $(".ui-selected").each(function(index, element) {
        var seat = $(element);
        seat.attr('group_id', $(button).attr('group_id'));
        seat.css('background', $(button).attr('color'));
      });

      return false;
    });

    // Save the seats
    $("#edit-submit").click(function(event) {
      event.preventDefault();
      // Show the ajax spinner and disable button
      $("#seats_throbber").show();
      $("#edit-submit").val(Drupal.t('Saving...'));
      $("#edit-submit").attr("disabled", "disabled");

      var seats = new Array();
      $('.seat').each(function(index, element) {
        var pos = $(element).position();
        seats.push({
          seat_id: $(element).attr('seat_id'),
          height: $(element).height(),
          width: $(element).width(),
          x: pos.left,
          y: pos.top,
          seats: $(element).attr('seats'),
          remove: $(element).attr('remove') == 1 ? 1 : 0,
          group_id: $(element).attr('group_id'),
          name: $(element).attr('name')
        });
      });

      var seats_data = {"seat_data": seats};

      // Post this to the server
      $.post(Drupal.settings.basePath + 'ms_events_seatmaps/save/' + Drupal.settings.ms_events_seatmaps.map_id, seats_data,
        function(data, textStatus, jqXHR){
          // Remove the ajax spinner and show saved text
          $("#seats_throbber").hide();
          $("#edit-submit").val(Drupal.t('Saved'));
          $("#edit-submit").removeAttr("disabled");
        }, 'json');
    });

    $("#edit-image-pic img").click(function(e) {
      $(".seat").removeClass('ui-selected');
    });

    // Create a new seat
    $("#edit-image-pic img").dblclick(function(e) {
      var posX = $(this).offset().left,
          posY = $(this).offset().top,
          clickY = Math.round(e.pageY - posY),
          clickX = Math.round(e.pageX - posX);

      $("#dialog_name").val('');
      $("#dialog_seats").val(1);

      $("#seat-dialog").dialog({
        height: 200,
        modal: true,
        buttons: {
          "Create": function() {
            // If there is a range entered, create many seats
            var regex = /range\((.+),(\d+),(\d+)\)/i, input = $("#dialog_name").val();
            if(regex.test(input)) {
              var matches = input.match(regex), start = parseInt(matches[2]), end = parseInt(matches[3]), namestring = matches[1], n;
              for (n = start; n <= end; n++) {
                // Create the seat
                var seat = $('<div>', {
                  html: "<div class='seat_name'>" + namestring + n + "</div>"
                });

                seat.attr('name', namestring + n);
                seat.attr('title', namestring + n);
                seat.attr('seats', $("#dialog_seats").val());

                make_active(seat);

                seat.addClass('seat').addClass('make_seat_work').css('top', clickY)
                  .css('left', clickX + (seat_default_width * (n - start)))
                  .css('width', seat_default_width).css('height', seat_default_height);

                $("#edit-image-pic").append(seat);
              }
            }
            else {
              // Create the seat
              var seat = $('<div/>', {
                html: "<div class='seat_name'>" + $("#dialog_name").val() + "</div>"
              });

              seat.attr('name', $("#dialog_name").val());
              seat.attr('title', $("#dialog_name").val());
              seat.attr('seats', $("#dialog_seats").val());

              make_active(seat, true);

              seat.addClass('seat').addClass('make_seat_work').css('top', clickY).css('left', clickX)
                .css('width', seat_default_width).css('height', seat_default_height);

              $("#edit-image-pic").append(seat);
            }

            mark_changed();
            $(this).dialog("close");
          },
        }
      });
    });

    // Mark the seat as active
    function make_active(element, clear) {
      if (clear) {
        $(".seat").removeClass('ui-selected');
      }
      $(element).addClass('ui-selected');
    }

    // Move the seat with the keys
    function move_seat_keyboard(dx, dy, shiftkey) {
      $(".ui-selected").each(function(index, element) {
        var seat = $(element), pos = seat.position(), container = $("#edit-image-pic img");
        if (shiftkey) {
          seat.css('width', seat.width() + dx).css('height', seat.height() + dy);
          mark_changed();
          seat_default_width = seat.width() + dx;
          seat_default_height = seat.height() + dy;
        }
        else {
          if (pos.left + dx >= 0 && (seat.width() + pos.left + dx < container.width() - 1)
           && pos.top + dy >= 0 && (seat.height() + pos.top + dy < container.height() - 1)) {
            seat.css('left', pos.left + dx).css('top', pos.top + dy);
            mark_changed();
          }
        }
      });
    }

    // Mark the submit button as changed
    function mark_changed() {
      $("#edit-submit").val(Drupal.t('Save') + "*");
      $("#edit-image-pic").selectable({
        filter: ".seat",
        distance: 5
      });
    }

    // Activates the seat
    function activate_seat(element) {
      $(element).bind("dblclick", function(e) {
        var seat = $(e.currentTarget);
        var pos = seat.position();
        $("#dialog_name").val(seat.attr('name'));
        $("#dialog_seats").val(seat.attr('seats'));
        $("#seat-dialog").dialog({
          height: 200,
          modal: true,
          buttons: {
            "Save": function() {
              // Update the seat
              seat.attr('name', $("#dialog_name").val());
              seat.attr('title', $("#dialog_name").val());
              seat.children('.seat_name').text($("#dialog_name").val());
              seat.attr('seats', $("#dialog_seats").val());

              mark_changed();

              $(this).dialog("close");
            },
            "Delete": function() {
              // Remove the seat
              seat.attr('remove', 1);
              seat.hide();
              mark_changed();

              $(this).dialog("close");
            },
          }
        });
      });
      $(element).draggable({
        containment: "#edit-image-pic img",
        snap: true,
        snapTolerance: 5,
        stop: function(event, ui) {
          mark_changed();
          make_active(ui.helper, !event.shiftKey);
        }
      });
      $(element).addClass('draggable');
      $(element).resizable({
        stop: function(event, ui) {
          seat_default_width = ui.size.width;
          seat_default_height = ui.size.height;
          make_active(this, !event.shiftKey);
          mark_changed();
        }
      });
      $(element).click(function(e){
        make_active(this, !e.shiftKey);
      });
      $(element).addClass('resizable');
    }
  });
})(jQuery);
