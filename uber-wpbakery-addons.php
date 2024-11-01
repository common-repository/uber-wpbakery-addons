<?php
/**
* Plugin Name: Uber WPBakery Addons
* Plugin URI: https://wordpress.org/plugins/uber-wpbakery-addons/
* Description: Boost your WPBakery Page Builder with nicely crafted extra elements ( Requires WPBakery Page Builder )
* Version: 1.0.2
* Author: WOW Layers
* Author URI: https://wowlayers.com
* Text Domain: uber-wpbakery-addons
**/

#exit if accessed directly
defined( 'ABSPATH' ) or exit;

#constants
if ( !defined ( 'UBER_WPB_PLUGIN_DIR' ) ){
	define( 'UBER_WPB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( !defined ( 'UBER_WPB_PLUGIN_URI' ) ){
	define( 'UBER_WPB_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
}

#dummy images
if ( !defined ( 'UBER_WPB_PLUGIN_SQ_IMG' ) ){
	define( 'UBER_WPB_PLUGIN_SQ_IMG', UBER_WPB_PLUGIN_URI. '/images/dummy/dummy-square.png' );
}
if ( !defined ( 'UBER_WPB_PLUGIN_LS_IMG' ) ){
	define( 'UBER_WPB_PLUGIN_LS_IMG', UBER_WPB_PLUGIN_URI. '/images/dummy/dummy-landscape.png' );
}
if ( !defined ( 'UBER_WPB_PLUGIN_PT_IMG' ) ){
	define( 'UBER_WPB_PLUGIN_PT_IMG', UBER_WPB_PLUGIN_URI. '/images/dummy/dummy-portrait.png' );
}

#
# Uber_WPBakery_Addons_Main - Main plugin class
#

if ( !class_exists ( 'Uber_WPBakery_Addons_Main' ) ){

class Uber_WPBakery_Addons_Main{
	
	private static $_instance = null;
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}	

	
	public function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
	}
	
	public function i18n() {
		load_plugin_textdomain( 'uber-wpbakery-addons' );
	}	
	
	
	private static function is_premium(){
		return false;
	}
	
	public function init() {
		
		#return early if WPBakery plugin does not exist, and print an error
		if ( current_user_can( 'activate_plugins' ) && ! class_exists( 'Vc_Manager' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_error' ] );
				return;
		}		
		
		#include stuff
		if ( class_exists ( 'Vc_Manager' ) ){
			#core functions
			require_once ( UBER_WPB_PLUGIN_DIR .'/functions/functions-vc.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/functions/functions-ajax.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/functions/functions-vc-icons.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/functions/functions-others.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/functions/functions-wordpress.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/functions/functions-theme.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/misc/google-fonts.php' );
			
			#free blocks
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/headings.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/simple-heading.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/facts.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/social.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/button.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/simple-list.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/testimonials.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/icon.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/toggle.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/countdown.php' );
			require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/simple-banner.php' );		
			
			#premium blocks
			if ( $this->is_premium() ){
				require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/list.php' );
				require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/team.php' );
				require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/posts.php' );
				require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/maps.php' );
				require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/pricing-table.php' );
				require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/gallery.php' );	
				require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/banners.php' );				
				if ( post_type_exists( 'portfolio' ) ){
					require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/portfolio.php' );
				}
				require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/masonry.php' );
				if ( class_exists( 'WooCommerce' ) ){
					require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/woo-tabbed-products.php' );
					require_once ( UBER_WPB_PLUGIN_DIR .'/functions/functions-woo.php' );
				}
				if ( class_exists( 'WPCF7' ) ){
					require_once ( UBER_WPB_PLUGIN_DIR .'/vc_extend/blocks/contact-form-7.php' );
				}
			
			}		
		
		}
					

	}
	
	#plugin styles
	function styles(){
		wp_enqueue_style( 'uberwpb-elements_main', 	UBER_WPB_PLUGIN_URI.'css/main.css');
		wp_enqueue_style( 'uberwpb-animate', 		UBER_WPB_PLUGIN_URI.'css/animate.css');
		if (  class_exists( 'WooCommerce' ) && $this->is_premium() ){
			wp_enqueue_style( 'skeletabs', 			UBER_WPB_PLUGIN_URI.'css/skeletabs.css', false );

		}
	}
	
	#plugin scripts
	function scripts(){
		wp_enqueue_script ( 'vc_waypoints', 		UBER_WPB_PLUGIN_URI."/js/vc-waypoints.min.js", array('jquery'), '1.0.0', true );
		wp_register_script( 'script-facts', 		UBER_WPB_PLUGIN_URI."/js/facts.js", array( 'vc_waypoints' ), '1.0.0', true );
		wp_register_script( 'script-animate', 		UBER_WPB_PLUGIN_URI."/js/script-animate.js", array( 'vc_waypoints' ), '1.0.0', true );
	}
	
	#plugin admin styles
	function admin_styles(){
		wp_enqueue_style( 'uberwpb-admin-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700', false );	
		$icons_nice_names = array('business' => 'Business','chart' => 'Chart','construction' => 'Construction','device' => 'Device','directional' => 'Directional','education' => 'Education','food' => 'Food','mathematical' => 'Mathematical','medical' => 'Medical','mobileui' => 'Mobile UI','multimedia' => 'Multimedia','person' => 'Person','search' => 'Search','social' => 'Social','sport' => 'Sport','texteditor' => 'Text Editor','transport' => 'Transport','travel' => 'Travel','webapplication' => 'Web Application','icons_7f'=>'Pe-7 Fill','icons_7s'=>'Pe-7 Stroke');

			foreach( $icons_nice_names as $key => $val ){
				if( $key == 'icons_7f'){
					$url = UBER_WPB_PLUGIN_URI . '/fonts/icons/pe-7f/style.css';
					wp_enqueue_style( 'pe-7f', $url );
				}
				elseif( $key == 'icons_7s' ){
					$url = UBER_WPB_PLUGIN_URI . '/fonts/icons/pe-7s/style.css';
					wp_enqueue_style( 'pe-7s', $url );			
				}
				else{
					$url = UBER_WPB_PLUGIN_URI . '/fonts/icons/' . $key . '/style.css';
					wp_enqueue_style( 'uberwpb-'.$key, $url );
				}
			}
	}

	#plugin admin scripts
	function admin_scripts() {
		wp_enqueue_script( 'uberwpb-addons-admin-scripts', UBER_WPB_PLUGIN_URI . '/js/admin_script.js', array('jquery') , true);
		wp_register_script( 'uber_wpb_vc_presets', UBER_WPB_PLUGIN_URI . '/vc_extend/js/uber_wpb_vc_presets.js', array('jquery') , true);
		wp_localize_script( 'uber_wpb_vc_presets', 'uber_wpb_vc_presets_params', array('ajaxurl' => esc_url( site_url() ) . '/wp-admin/admin-ajax.php') );	
		wp_enqueue_script( 'uber_wpb_vc_presets' );			
		
	}	

	#print an error
	function admin_notice_error() {
		$class = 'notice notice-info is-dismissible';
		$message =  esc_html__( 'Uber WPBakery Addons requires <a href="https://1.envato.market/WrXRJ">WPBakery Page Builder</a> to be installed.','uber-wpbakery-addons' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
	}
	

} # end class

#Start your engines! :)
Uber_WPBakery_Addons_Main::instance();

}  # end if class exists