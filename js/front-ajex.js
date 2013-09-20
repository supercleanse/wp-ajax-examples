jQuery(document).ready( function($) {
  var ajex_format_list = function(items) {
    var list = '<h2>' + ajex.title + '</h2>';

    list = '<ol id="ajex-frontend-items">';

    for( var i = 0; i < items.length; i++ ) {
      list += '<li>' + items[i] + '</li>'; 
    }

    list += '</ol>';

    return list;
  }

  var args = { action: 'ajex_items' };

  $.post( ajex.ajaxurl, args,
          function(res) {
            $('#ajex-frontend-items').html(ajex_format_list(res.items));
          },
          'json' ); // Yeah, we prefer to do everything with JSON
});


