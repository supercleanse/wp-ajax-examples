<?php
/*
Plugin Name: AJAX Examples
Plugin URI: http://blairwilliams.com
Description: Some sweet AJAX examples for WordPress
Version: 1.0
Author: Blair Williams
Author URI: http://blairwilliams.com
Text Domain: wp-ajax-examples

GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

define('AJEX_PLUGIN_SLUG',plugin_basename(__FILE__));
define('AJEX_PLUGIN_NAME',dirname(AJEX_PLUGIN_SLUG));
define('AJEX_PATH',WP_PLUGIN_DIR.'/'.AJEX_PLUGIN_NAME);
define('AJEX_URL',plugins_url($path = '/'.AJEX_PLUGIN_NAME));

include_once( AJEX_PATH . "/examples/AjexAdmin.php" );
include_once( AJEX_PATH . "/examples/AjexFrontEnd.php" );

new AjexAdmin();
new AjexFrontEnd();

