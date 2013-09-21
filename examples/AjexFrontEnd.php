<?php
if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

/** An example of some sweet ajax happening on the front end of WordPress.
  * This example would potentially be relevant if you had some dyanmic data
  * that you wanted to load outside of the normal page load ... potentially
  * to bypass caching.
  */
class AjexFrontEnd {
  public function __construct() {
    // Enqueue JS & CSS
    add_action('wp_enqueue_scripts', array($this,'enqueue'));

    // Setup a front-end shortcode
    add_shortcode('ajex-items', array($this,'shortcode'));

    // Add a logged in and a nopriv endpoint
    add_action('wp_ajax_ajex_items', array($this,'items'));
    add_action('wp_ajax_nopriv_ajex_items', array($this,'items'));
  }

  /** Enqueue scripts and styles */
  public function enqueue() {
    global $post;

    // Be a good neighbor ... only enqueue if the post has the shortcode on it
    if( isset($post) and $post instanceof WP_Post and
        preg_match( '~\[ajex-items~', $post->post_content ) )
    {
      wp_enqueue_style('front-ajex-css', AJEX_URL.'/css/front-ajex.css', array());
      wp_enqueue_script('front-ajex-js', AJEX_URL.'/js/front-ajex.js', array('jquery'));

      // So we can figure out the ajax url from the front end
      // and so we can utilize some i18n strings in the JS
      wp_localize_script( 'front-ajex-js',
                          'ajex',
                          array( 'ajaxurl' => admin_url('admin-ajax.php'), 
                                 'title' => __('Cool List'),
                                 'refresh' => __('Refresh'),
                                 'spinner' => site_url(WPINC . '/images/wpspin-2x.gif'),
                                 'empty' => __('There aren\'t any items to display') ) );
    }
  }

  /** This is the AJAX endpoint to fetch items from WordPress */
  public function items() {
    $items = get_option('ajex-items');
    if( !is_array($items) ) { $items = array(); }
    die(json_encode(compact('items'))); 
  }

  /** Displays a very simple div that the JS will use to display the items
    * Also shows a simple loading gif.
    */
  public function shortcode($atts, $content='') {
    // Start getting ready to capture output with ob_start & ob_get_clean
    ob_start();

    ?>
    <div id="ajex-frontend-items"></div>
    <?php

    return ob_get_clean();
  }
}

