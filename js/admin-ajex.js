jQuery(document).ready( function($) {
  // HTML Snippet for each input box
  var ajex_item_input = function() {
    return '<li><input type="text" /></li>';
  }

  // HTML Snippet for each input box
  $('#ajex-add-item').click( function(e) {
    e.preventDefault();
    $('ol#ajex-items').append( ajex_item_input );
    $('#ajex-remove-item').show();
  });

  // We use $.on here because inputs can be placed dynamically
  // so we need to bind the event to the list itself
  $('ol#ajex-items').on('keyup', 'input', function(e) {
    e.preventDefault();

    var args = {
      action: 'ajex_save',
      index: $(this).parent().prevAll().length,
      wpnonce: ajex.wpnonce
    };

    // Yeah, we prefer to do everything with JSON
    $.post( ajaxurl, args );
  });

  $('#ajex-remove-item').click( function(e) {
    e.preventDefault();

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
                // Remove the last item from the list
                $('#ajex-items li:last').slideUp({ complete: function(e) { $(this).remove(); } });
              }
            },
            'json' ); // Yeah, we prefer to do everything with JSON
  });
});

