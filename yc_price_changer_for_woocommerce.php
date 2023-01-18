<?php
/**
  * Plugin Name: Price Changer for WooCommerce
  * Version: 1.0.1
  * Description: Change product prices to increase or decrease quickly by specific percentage for all of your WooCommerce products in WooCommerce store, without edit/update original price from admin product page.
  * Author: Yakacj
  * Author URI: https://www.freelancer.com/u/yakacj
  *  
  * Requires at least: 5.1
  * Tested up to: 6.1.1
  * 
  * WC requires at least: 5.0
  * WC tested up to: 7.1.0
  * Requires PHP: 7.0
  * 
  * Text Domain: ycpcw
  * License: GPLv2 or later
  * License URI: https://www.gnu.org/licenses/gpl-2.0.html
  **/

    
    defined( 'ABSPATH' ) or exit;
    
    defined( 'YCPCWF') or define('YCPCWF', plugin_basename( __FILE__ ));
        
        // Check WooCommerce is active or not
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            require_once('includes/admin/yc_wc_filters.php');
        }
    

