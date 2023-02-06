<?php 
/* 
Plugin Name: IIS Pro V2 
Version: 2.7.84
Plugin URI: http://www.u-r-g.com
Author: Briscoweb 
Author URI: http://www.briscoweb.com 
Description: Auto parts search and Ecommerce plugin for the automotive recycling industry 
*/ 
register_activation_hook(__FILE__, 'iis_sitemap_gen_activation');
function iis_sitemap_gen_activation() {
    if (! wp_next_scheduled ( 'iis_sitemap_gen' )) {
	//wp_schedule_event(current_time( 'timestamp' ), 'daily', 'iis_sitemap_gen');
		
	wp_schedule_event( strtotime('21:00:00'), 'twicedaily', 'iis_sitemap_gen' );	
		
    }
}
add_action('iis_sitemap_gen', 'iis_sitemap_func');
function iis_sitemap_func() {
	iissitemap();
    iiscleanoldprod();
}
register_deactivation_hook(__FILE__, 'iis_sitemap_gen_deactivation');

function iis_sitemap_gen_deactivation() {
	wp_clear_scheduled_hook('iis_sitemap_gen');
}

require_once( 'class-wp-license-manager-client.php' ); 
if ( is_admin() ) {
      $license_manager = new Wp_License_Manager_Client(
        'iis-pro-v2',
        'IIS Pro V2',
        'iis-pro-v2',
        'https://iisprolm.briscoweb.net/api/license-manager/v1',
        'plugin',
    __FILE__
    );
}
if(!isset($_SESSION)){ 
    session_start(); 
}
define('WP_CART_VERSION', '2.7.84'); 
define('WP_CART_FOLDER', dirname(plugin_basename(__FILE__))); 
define('WP_CART_PATH',plugin_dir_path( __FILE__ )); 
define('WP_CART_URL', plugins_url('',__FILE__)); 
require_once( 'wp_shopping_cart.php' );