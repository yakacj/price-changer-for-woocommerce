<?php

/**
 * Plugin price filter class
 */
 
namespace YCPlugins\PriceChanger\Price;
use YCPlugins\PriceChanger\Init\Utils\Plugin_Utils as Utils;

defined( 'ABSPATH' ) or exit;

class Price_Filter{
    
    protected static $_instance = null;
    
    protected static $_filter_prefix = 'woocommerce_';
    
    public function __construct(){
        $this->apply_filters();
    }
    
    private function apply_filters(){
        foreach( Utils::get_filters( $this ) as $filter => $property ){
            \add_filter( self::$_filter_prefix . $filter, $property[0], $property[1], $property[2] );
        }
    }
    
    public function applicable_price( $price, $product ) {
        return $this->maybe_apply_price( $price, $product );
    }
                
    public function applicable_price_variable( $price, $variation, $product ) {
        return $this->maybe_apply_price( $price, $product );
    }

    public function get_price_hash( $hash_value ) {
        $hash_value[] = $this->get_price_change_param();
        return $hash_value;
    }
    
    private static function get_value( $option ){
        return Utils::get_value( '', $option );
    }
    
    private function maybe_apply_price( $price, $product = null ){
 
        if( ! $price ) return;
        
        $type   = self::get_value( 'type' );
        $value  = self::get_value( 'value');
        
        if( empty( $type ) || empty( $value ) ) return $price;
        
        if( $product && $this->maybe_products_exclude( $product->get_id() ) ) return $price;
        
        wc_delete_product_transients();
    
        if( $type == 'amount' ){
            return ( float ) $this->maybe_price_rounded( $this->price_by_amount( $price ) );
        } else {
            return ( float ) $this->maybe_price_rounded( $price * $this->get_price_change_param() );
        }
    }
    
    private function maybe_products_exclude( $product_id ){
        
        $products =  ( array ) self::get_value( 'exclude' );
        
        if( empty( $products ) ) return;
        
        if( in_array( $product_id, $products ) ) return true;
        
    }
    
    private function get_price_change_param() {
 
        $price = 1;

        $perc =  ( float ) self::get_value( 'value' );
        
        $action = self::get_value( 'action' );
        
        if( $perc > 0 && $action ){
            $price = Utils::get_ratio( $perc, $action );
        }
        
        return $price; 
    }
    
    private function price_by_amount( $price ){
    
        $action = self::get_value( 'action' );
        $value  = ( float ) self::get_value( 'value' );
        
        if( empty( $value ) || ! $action ) return $price;
        
            if( $action == 'pricedown' ){
                if( $value >= $price ) return $price;
                $price = $price - $value;
            } else {
                $price = $price + $value;
            }
        
        return $price;
    }
    
    private function maybe_price_rounded( $price ){

        if( self::get_value( 'rounded' )  && ! empty( self::get_value( 'value' ) ) ){
            $price = round( $price );
        }
        
        return $price;
    }
    
    public static function instance() {
		
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
}

Price_Filter::instance();
