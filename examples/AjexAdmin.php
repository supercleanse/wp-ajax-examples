<?php
if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

/** This example shows how you'd implement a simple AJAX style list in the
  * WordPress admin. It covers adding a page to the admin, enqueuing scripts
  * and styles, adding html to your page, and defining 2 AJAX endpoints for
  * dynamically modifying the data.
  *
  * To work properly, this script utilizes the JS code in ../js/admin-ajex.js
  * and the CSS styles in ../css/admin-ajex.css ...
  */
class AjexAdmin {
  // Loads up all the hooks we're using in this example
  public function __construct() {
    // Setup menus
    add_action('admin_menu', array($this,'menu'));

    // Enqueue JS scripts and CSS styles
    add_action('admin_enqueue_scripts', array($this,'enqueue'));

    // Define a logged in ajax endpoint for ajex_save and ajex_remove
    add_action('wp_ajax_ajex_save', array($this,'save'));
    add_action('wp_ajax_ajex_remove', array($this,'remove'));
  }

  // Add the option page to the WordPress menu for our example
  public function menu() {
    add_options_page( __('AJAX Example'), __('AJAX Example'),
                      'manage_options', 'wp-ajax-example',
                      array($this,'view') );
  }

  // Instead of loading scripts and styles directly using 'wp_head'
  // we want to always use WordPress' built-in enqueue system
  public function enqueue($hook) {
    // Be a good neighbor and only load scripts on the actual page we need them
    if($hook=='settings_page_wp-ajax-example') {
      wp_enqueue_style('admin-ajex-css', AJEX_URL.'/css/admin-ajex.css', array());
      wp_enqueue_script('admin-ajex-js', AJEX_URL.'/js/admin-ajex.js', array('jquery'));

      // We need this to pass the nonce to the javascript
      wp_localize_script('admin-ajex-js', 'ajex', array('wpnonce' => wp_create_nonce(AJEX_PLUGIN_SLUG)));
    }
  }

  // This is the view of the form in the wp admin
  // There's no real reason to load this with AJAX but you could if you wanted to
  public function view() {
    // Get items and initialize if necessary
    $items = get_option('ajex-items');
    if( !is_array($items) ) { $items = array(); }

    $hidden_class = ( ( empty( $items ) ) ? ' class="ajex-hidden"' : '' );

    ?>
    <h2><?php _e('AJAX WordPress Example'); ?></h2>

    <div id="ajex-error" class="error ajex-hidden"></div>

    <ol id="ajex-items">
      <?php foreach( $items as $item ): ?>
        <li><input type="text" value="<?php echo $item; ?>" /></li>
      <?php endforeach; ?>
    </ol>

    <div id="ajex-actions">
      <button id="ajex-add-item">+</button>
      <button id="ajex-remove-item"<?php echo $hidden_class; ?>>-</button>
    </div>

    <?php
  }

  // An AJAX Endpoint must end with a die or exit ... to ensure that what's output is final
  public function save() {
    // Validate nonce
    if( !isset($_POST['wpnonce']) or !wp_verify_nonce( $_POST['wpnonce'], AJEX_PLUGIN_SLUG ) )
      die( json_encode( array( 'error' => __('Hey yo, why you creepin\'?') ) ) );

    // Validate inputs
    if( !isset( $_POST['index'] ) ) 
      die( json_encode( array( 'error' => __('Sorry, don\'t know what to save.') ) ) );
    
    // Get items and initialize if necessary
    $items = get_option('ajex-items');
    if( !is_array($items) ) { $items = array(); }

    // Set the item index we want
    $items[ $_POST['index'] ] = $_POST['item'];

    // Update the option
    update_option('ajex-items', $items);

    // Return success message
    die(json_encode(array('message'=>__('The item was successfully saved')))); 
  }

  // An AJAX Endpoint must end with a die or exit ... to ensure that what's output is final
  public function remove() {
    // Validate nonce
    if( !isset($_POST['wpnonce']) or !wp_verify_nonce( $_POST['wpnonce'], AJEX_PLUGIN_SLUG ) )
      die( json_encode( array( 'error' => __('Hey yo, why you creepin\'?') ) ) );

    // Get items and validate there's something to remove ... if not output a message
    $items = get_option('ajex-items');
    if( !is_array($items) ) { die(json_encode(array('message'=>__('Hey, there\'s nothing here to remove')))); }

    // In this example we just pop the last item off the array
    array_pop($items);

    // Update the option
    update_option('ajex-items', $items);

    // Return a success message
    die(json_encode(array('message'=>__('The item was successfully removed')))); 
  }
}

