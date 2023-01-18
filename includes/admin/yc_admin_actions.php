<?php

    defined('ABSPATH') or exit;
    
    // Add sub menu under woocommerce menu
    add_action('admin_menu', 'yc_price_changer_submenu_page',99);
    function yc_price_changer_submenu_page() {
        add_submenu_page( 'woocommerce', 'Price Changer', 'Price Changer', 'manage_woocommerce', 'wc-settings&tab=products&section=yc-price-changer', 'yc_price_changer_callback','', 20 ); 
    }
    
    // WP Plugin settings link
    add_filter( 'plugin_action_links_' . YCPCWF, 'yc_price_changer_links' );
    function yc_price_changer_links( $links ) {
	
	    $settings_links = array(
		    '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=products&section=yc-price-changer' ) . '">' . __( 'Changer', 'woocommerce' ) . '</a>'
	    );

	        return array_merge( $settings_links, $links );
    }
    
    // WC Settings api
    function yc_product_prices_section_tab( $section ){
            $section['yc-price-changer'] = __('Price Changer', 'woocommerce');;
            return $section;
    }
	
    function yc_product_prices_settings( $settings, $current_section ) {
	        
	        if ( $current_section == 'yc-price-changer' ) {
    	    
		    $settings_yc = array();

            $settings_yc['wc_yc_product_prices_t'] = array(
				 'title'    => __( 'Global Prices', 'woocommerce' ),
				 'type'     => 'title',
				 'desc'     => '',
				 'id'       => 'general_options_product_section_prices',
			);


			$settings_yc['yc_price_box_action'] = array(
			     'title'    => __( 'Price action', 'woocommerce' ),
			     'id'       => 'yc_product_price_per_global_action',
			     'type'     => 'radio',
			     'options'  => array('yc-inc'=> '▲ Increase','yc-dec'=>'▼ Decrease'),
			     'default'  => 'yc-inc',
		    );
		    
			$settings_yc['yc_price_box'] = array(
			     'title'    => __( 'Price percentage (%)', 'woocommerce' ),
			     'id'       => 'yc_product_price_per_global',
			     'type'     => 'number',
			     'desc'     => __( 'Enter price percentage for increase or decrease prices by percentage or leave blank for normal', 'woocommerce' ),
			     'custom_attributes' => array('min'=> 0,'step'=>'0.001'),
			     'desc_tip' => true
		    );
			 
			$settings_yc['_y_price_rnd_settings'] = array(
			     'title'    => __('Rounded prices ','woocommerce'),
			     'id'       => '_y_enable_rnded_prices_global',
			     'type'     => 'checkbox',
			     'desc_tip' =>  true,
                 'desc'     => __('Enable this to all new prices will be rounded (Ex.1.49=1.00, 1.50=2.00)','woocommerce'),
            );
		     
	        $settings_yc['wc_product_price_section_end'] =	array(
				 'type'     => 'sectionend',
				 'id'       => 'yc_general_options_produts_price_section_end',
			);
	
		return $settings_yc;
		
	    } else {
	         
		return $settings;
	    }
    }
    
    
    