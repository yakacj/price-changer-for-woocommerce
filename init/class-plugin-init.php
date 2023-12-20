<?php 

/**
 * Plugin initializer class
 */
 
namespace YCPlugins\PriceChanger\Init;

defined( 'ABSPATH' ) or exit;

class Plugin_Init{

    protected static $_instance = null;
    
    protected static $_prefix   = 'class-plugin-';
    
    public function __construct(){
        self::load_dependencies();
    }
    
    private static function load_dependencies(){

        $files = array( 
            'admin/' . self::$_prefix . 'admin-setup.php',
            'init/utils/' . self::$_prefix . 'utils.php',
            'price/' . self::$_prefix . 'price-filter.php',
        );

        foreach( $files as $file ){
            $located_file = realpath( plugin_dir_path( dirname( __FILE__ ) ) . $file );
            if( $located_file  ) require_once $located_file;
        }

    }
	
    public static function instance() {
		if( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

Plugin_Init::instance();
