<?php

/**
 * Plugin utility class
 */
 
namespace YCPlugins\PriceChanger\Init\Utils;

defined( 'ABSPATH' ) or exit;

class Plugin_Utils{

    protected static $_instance = null;
    
    public function __constuctor(){}
    
    public static function get_fields(){
        return array(
            'yc_price_action'       => 'Price action',
            'yc_price_change_type'  => 'Price change by',
            'yc_price_change_value' => 'Price change value (% or $)'  ,
            'yc_price_rounded'      => 'Price rounded?' ,
            'yc_exclude_products'   => 'Exclude products?',
            );
    }
    
    private static function init_keys(){
        return array( 
            'action' ,
            'type'   ,
            'value'  ,
            'rounded',
            'exclude',
        );
    }
    
    public static function get_filters( $object ){
        return array(
            'product_get_price'                     => array( 
                array( $object, 'applicable_price' ), 
                99, 2 
            ),
            'product_get_regular_price'             => array( 
                array( $object, 'applicable_price' ), 
                99, 2 
            ),
            'product_variation_get_regular_price'   => array( 
                array( $object, 'applicable_price' ),
                99, 2 
            ),
            'product_variation_get_price'           => array( 
                array( $object, 'applicable_price' ), 
                99, 2 
            ),
            'variation_prices_price'                => array( 
                array( $object, 'applicable_price_variable' ), 
                99, 3 
            ),
            'variation_prices_regular_price'        => array( 
                array( $object, 'applicable_price_variable' ), 
                99, 3 
            ),
            'get_variation_prices_hash'             => array( 
                array( $object, 'get_price_hash' ), 
                99, 1 
            ),
        );
    }
    
    public static function settings_keys(){
        return array_combine( array_values( self::init_keys() ), array_keys( self::get_fields() ) );
    }
    
    private static function short_keys(){
        return array_combine(  array_keys( self::get_fields() ), array_values( self::init_keys() ) );
    }
    
    public static function get_value( $function = '', $key = '' ){

       if( $key ) { 
           $get = array_search( $key, self::short_keys() );
           return get_option( $get );
       }
       
       return get_option( str_replace('_callback','', $function ) );

    }
    
    public static function get_ratio( $perc, $action ){
        
        $ratio = array( 
            'pricedown' => ( 100 - $perc ) / 100, 
            'priceup'   => 1 + ( $perc / 100 ) 
            );
            
        return $ratio[ $action ];
    }
    
    private static function get_product_args(){
        return array(
            'post_type'     => 'product',
            'post_status'   => 'publish',
            'posts_per_page'=> -1,
            'tax_query'     => [ 
                'relation'  => 'AND',
            [ 
            'taxonomy'  => 'product_type',
            'field'     => 'slug',
            'terms'     => ['simple', 'variable'],
            ]
        ],
            
        );
    }
    
    public static function get_products(){
        $query = new \WP_Query( self::get_product_args() );
        wp_reset_postdata();
        if( empty( $query ->found_posts ) ) return new \stdClass();
        return $query->posts;
    }

    public static function instance() {
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    
}

Plugin_Utils::instance();
