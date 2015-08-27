<?php
ini_set('display_errors','1');
/**
 * Plugin Name: Goozmo Concierge
 * Plugin URI: http://www.goozmo.com
 * Description: No words can describe this plugin
 * Version: Goozmo 1.infinity
 * Author: Goozmo, inc.
 * Author URI: http://www.goozmo.com
 * License: private
 */
 
 /*
 *
 *	initialize
 *
 */
//require_once('data_access_object/Client.MySQL.php');
require('inc/goozmo_concierge.php');
include('PHPMailer/PHPMailerAutoload.php');

add_action( 'admin_menu', 'go_goozmo_concierge' );

/*
*
*	register with Wordpress
*/
function go_goozmo_concierge() {
	add_menu_page(__(
		'Goozmo Concierge',
		'Goozmo Concierge'),
		__('Goozmo Concierge','Goozmo Concierge'), 
		'manage_options',
		'goozmo_concierge',
		'goozmo_concierge_index',
		'/wp-content/plugins/goozmo_concierge/img/goozmo_icon.png');
}

/*
*
*	instantiate
*
*/
function goozmo_concierge_index() {
	$goozmo_inst=new Goozmo_concierge();
}

/*
*
*
*	admin header hook
*
*/

function go_go_goozmo_js() {
    echo '<script type="text/javascript" src="/wp-content/plugins/goozmo_concierge/js/goozmo.js"></script>';
}
// Add hook for admin <head></head>
add_action('admin_head', 'go_go_goozmo_js');

?>