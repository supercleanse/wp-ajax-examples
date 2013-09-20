<?php
if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

class AjexAdmin {
  public function __construct() {
    add_action('admin_menu', array($this,'menu'));
    add_action('admin_enqueue_scripts', array($this,'enqueue'));
    add_action('wp_ajax_ajex_add', array($this,'add'));
    add_action('wp_ajax_ajex_remove', array($this,'remove'));
  }

  public function menu() {
    add_options_page( __('AJAX Example'), __('AJAX Example'),
                      'manage_options', 'wp-ajax-example',
                      array($this,'view') );
  }

  public function enqueue($hook) {
    // Be a good neighbor and only load scripts on the actual page we need them
    if($hook=='settings_page_wp-ajax-example') {
      wp_enqueue_style('admin-ajex-css', AJEX_URL.'/css/admin-ajex.css', array());
      wp_enqueue_script('admin-ajex-js', AJEX_URL.'/js/admin-ajex.js', array('jquery'));
    }
  }

  public function view() {
    $items = get_option('ajex-items');

    if( !is_array($items) ) { $items = array(); }

    ?>
    <h2><?php _e('AJAX WordPress Example'); ?></h2>

    <ol id="ajex-items">
      <?php foreach( $items as $item ): ?>
        <li><input type="text" value="<?php echo $item; ?>" /></li>
      <?php endforeach; ?>
    </ol>

    <div id="ajex-actions">
      <a href="#" id="ajex-add-item"><?php _e('Add'); ?></a>
      <?php if( !empty($items) ): ?>
        | <a href="#" id="ajex-remove-item"><?php _e('Remove'); ?></a>
      <?php endif; ?>
    </div>

    <?php
  }

  public function add() {
    
    die(json_encode($response)); 
  }

  public function remove() {
    
    die(json_encode($response)); 
  }
}

