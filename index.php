<?php
/*
Plugin Name: WP Ticket Ultra Recaptcha
Plugin URI: https://wpticketultra.com
Description: Add-on for for WP Ticket Ultra.
Version: 1.0.1
Author: WP Ticket Ultra
Text Domain: wp-ticket-ultra-recaptcha
Domain Path: /languages
Author URI: https://wpticketultra.com/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('wptu_recaptcha_url',plugin_dir_url(__FILE__ ));
define('wptu_recaptcha_path',plugin_dir_path(__FILE__ ));

$plugin = plugin_basename(__FILE__);

/* Master Class  */
require_once (wptu_recaptcha_path . 'classes/wptu.recaptcha.class.php');
register_activation_hook( __FILE__, 'wptu_recaptcha');

function  wptu_recaptcha( $network_wide ) 
{
	$plugin = "wp-ticket-ultra-recaptcha/index.php";
	$plugin_path = '';	
	
	if ( is_multisite() && $network_wide ) // See if being activated on the entire network or one blog
	{ 
		activate_plugin($plugin_path,NULL,true);			
		
	} else { // Running on a single blog		   	
			
		activate_plugin($plugin_path,NULL,false);		
		
	}
}
global $wptu_recaptcha;
$wptu_recaptcha = new WPTicketUltraComplementReCaptcha();