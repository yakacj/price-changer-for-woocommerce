<?php
/**
  * Plugin Name: Price Changer For WooCommerce
  * Version: 1.1.0
  * Description: Change product prices to increase or decrease quickly by specific percentage or amount for all products in WooCommerce store, without edit/update original prices from admin product edit page.
  * Author: Yakacj
  * Author URI: https://profiles.wordpress.org/yakacj/
  *  
  * Requires at least: 6.3
  * Tested up to: 6.4.2
  * 
  * WC requires at least: 6.0
  * WC tested up to: 8.4.0
  * Requires PHP: 7.4
  * 
  * License: GPLv3
  * License URI: https://www.gnu.org/licenses/gpl-3.0.html
  **/

    defined( 'ABSPATH' ) or exit;
    
    // Run only, if WooCommerce is active
    if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;
    
    defined( 'YCPPC_BASE' ) or define( 'YCPPC_BASE', plugin_basename( __FILE__ ) );
    
    require_once( 'init/class-plugin-init.php' );
    
    