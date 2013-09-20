jQuery(document).ready( function($) {
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

  var ajex_load_items = function() {
    var args = { action: 'ajex_items' };

    $.post( ajex.ajaxurl, args,
            function(res) {
              $('#ajex-frontend-items').html(ajex_format_list(res.items));
              $('#ajex-frontend-items-inner').fadeIn('slow');
            },
            'json' ); // Yeah, we prefer to speak JSON
  }

  // ajex_load_items()

  // The setTimeout is purely here so we can see the sweet loading gif a bit longer
  setTimeout( ajex_load_items, 1000 );
});


