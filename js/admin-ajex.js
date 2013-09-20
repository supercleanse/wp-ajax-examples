jQuery(document).ready( function($) {
  // HTML Snippet for each input box
  var ajex_item_input = function() {
    return '<li class="ajex-hidden"><input type="text" /></li>';
  }

  // Add an item to the list
  $('#ajex-add-item').click( function(e) {
    // Append an new "hidden" list item
    $('#ajex-items').append( ajex_item_input );
   
    // Animate the list item appearing
    $('#ajex-items li:last').slideDown();

    // Ensure the new item has the focus
    $('#ajex-items li:last input').focus();

    // We can now assume that there's an item that could be removed 
    $('#ajex-remove-item').show();
  });

  // Button used to remove an item from the list
  $('#ajex-remove-item').click( function(e) {
    // Setup the arguments to be sent to our endpoint handler in AjexAdmin
    var args = {
      action: 'ajex_remove',
      wpnonce: ajex.wpnonce
    };

    $.post( ajaxurl, args,
            function(res) {
              // Check to see if the action returned an error
              if( 'error' in res ) {
                // Display an error message
                $('#ajex-error').html( res.error );
                $('#ajex-error').fadeIn();
              }
              else {
                // Remove the last item from the list and hide the remove button if we're down to zero items
                $('#ajex-items li:last').slideUp({
                  complete: function(e) {
                              $(this).remove();
                              if( $('#ajex-items li').length <= 0 ) {
                                $('#ajex-remove-item').hide();
                              }
                            }
                });

              }
            },
            'json' ); // Yeah, we prefer to do everything with JSON
  });

  // We use $.on here because inputs can be placed dynamically
  // so we need to bind the event to the list itself
  $('ol#ajex-items').on('blur', 'input', function(e) {
    // Setup the arguments to be sent to our endpoint handler in AjexAdmin
    var args = {
      action: 'ajex_save', // Name of the WordPress action
      index: $(this).parent().prevAll().length, // Calculate the index of the item we're editing
      item: $(this).val(), // New value
      wpnonce: ajex.wpnonce // Nonce
    };

    // Issue the post and in this case ignore the endpoint's output
    $.post( ajaxurl, args );
  });
});

