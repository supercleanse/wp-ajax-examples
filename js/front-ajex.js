jQuery(document).ready( function($) {
  // Template for the html of our front-end list
  // If there aren't any items then it will just display the 'empty' message
  var ajex_format_list = function(items) {
    var list = '<div id="ajex-frontend-items-inner" class="ajex-hidden"><h2>' + ajex.title + '</h2>';

    if( items.length <= 0 ) {
      list += '<div>' + ajex.empty + '</div>';
    }
    else {
      list += '<ol>';

      for( var i = 0; i < items.length; i++ ) {
        list += '<li>' + items[i] + '</li>'; 
      }

      list += '</ol>';
    }

    //list += '<div id="ajex-refresh"><button>' + ajex.refresh + '</button></div>';

    list += '</div>';

    return list;
  }

  // Returns HTML for the spinner
  var ajex_spinner = function() {
    return '<img src="' + ajex.spinner + '" width="32px" height="32px" />';
  }

  // Loads the list of items from our ajax, nopriv endpoint 'ajex_items'
  var ajex_load_items = function() {
    // Replace content with the spinner before loading
    $('#ajex-frontend-items').html(ajex_spinner());

    // Setup arguments ... in this case all we need is the action
    var args = { action: 'ajex_items' };

    // Call our WordPress AJAX endpoint
    $.post( ajex.ajaxurl, args,
            function(res) {
              // Replace the inner html for ajex-frontend-items wrapper div
              // Since we get JSON back from our endpoint, we use the template
              // above to format the data as an HTML list
              $('#ajex-frontend-items').html(ajex_format_list(res.items));
              $('#ajex-frontend-items-inner').fadeIn('slow');
            },
            'json' ); // Yeah, we prefer to speak JSON
  }

  // Initially load this thing (since setInterval waits before execution)
  ajex_load_items();

  // Refreshes the data from the database at 10 second intervals
  setInterval( ajex_load_items, 10000 );
});


