<?php

    defined('ABSPATH') or exit;
    
    require_once('yc_admin_actions.php');
    require_once('yc_functions.php');
    
    if(!class_exists('YC_WC_Filters')){
        
        class YC_WC_Filters {
	    
	        function __construct() {
            
            //price section to products
            add_filter('woocommerce_get_sections_products','yc_product_prices_section_tab');
            
    	    //Apply settings field by selected section
	        add_filter( 'woocommerce_get_settings_products', 'yc_product_prices_settings', 10, 2 );
	        
            // Simple, grouped and external products
            add_filter('woocommerce_product_get_price', 'yc_custom_price', 99, 2 );
            add_filter('woocommerce_product_get_regular_price', 'yc_custom_price', 99, 2 );
    
            // Variations
            add_filter('woocommerce_product_variation_get_regular_price', 'yc_custom_price', 99, 2 );
            add_filter('woocommerce_product_variation_get_price', 'yc_custom_price', 99, 2 );
            
            // Variable (price range)
            add_filter('woocommerce_variation_prices_price', 'yc_custom_variable_price', 99, 3 );
            add_filter('woocommerce_variation_prices_regular_price', 'yc_custom_variable_price', 99, 3 );
            
            // Handling price cache
            add_filter( 'woocommerce_get_variation_prices_hash', 'yc_add_price_multiplier_to_variation_prices_hash', 99, 1 );
            
            
            function yc_custom_price( $price, $product ) {
                return (float) yc_get_prices_rounded(floatval($price) * yc_get_price_change_param());
            }

            function yc_custom_variable_price( $price, $variation, $product ) {
                
                // Delete product cached price
                wc_delete_product_transients();
                return (float) yc_get_prices_rounded($price * yc_get_price_change_param());
            }

            function yc_add_price_multiplier_to_variation_prices_hash( $hash_value ) {
                $hash_value[] = yc_get_price_change_param();
                return $hash_value;
            }
	        
	        
	        }
        }
    }
    
    new YC_WC_Filters();
    