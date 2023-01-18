<?php

    defined('ABSPATH') or exit;
    
    function yc_get_price_change_param() {
        
        //Set default
        $price = 1;
    
        //Price ex.1 means normal
        $perc =  get_option('yc_product_price_per_global')?get_option('yc_product_price_per_global'):'';

        if(!empty($perc)){
            
            if(get_option('yc_product_price_per_global_action') == 'yc-dec'){
                $price = (100-$perc)/100;
            } elseif(get_option('yc_product_price_per_global_action') == 'yc-inc'){
                $price = (1+($perc/100));
            }
            
        }
        return $price; 
    }
    
    // Rounded prices
    function yc_get_prices_rounded($price){
        $re = get_option('_y_enable_rnded_prices_global');
        $pr = get_option('yc_product_price_per_global');
            if($re == 'yes' && !empty($pr)){
                $price = round($price);
            }
        return $price;
    }