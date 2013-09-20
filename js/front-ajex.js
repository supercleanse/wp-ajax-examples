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

      list += '</ol></div>';
    }

    return list;
  }

  // Loads the list of items from our ajax, nopriv endpoint 'ajex_items'
  var ajex_load_items = function() {
    var args = { action: 'ajex_items' }; // Setup arguments ... in this case all we need is the action

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

  // ajex_load_items()

  // The setTimeout is purely here so we can see the sweet loading gif a bit longer
  setTimeout( ajex_load_items, 1000 );
});


