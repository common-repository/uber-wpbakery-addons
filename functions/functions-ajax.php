<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/*
=================================================================================================================
Function uber_wpb_load_more_scripts() - for ajax VC posts, portfolio, masonry
=================================================================================================================
*/
function uber_wpb_load_more_scripts( $action) {
	
	
	wp_enqueue_script( 'waypoints' );

	//masonry
		if( $action == 'masonry_more' ){

			wp_register_script( 'masonry_more', UBER_WPB_PLUGIN_URI . '/js/masonry/masonry_more.js', array('jquery') , true);
			wp_localize_script( 'masonry_more', 'uber_wpb_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
				'loading_text' => esc_html__( 'Loading...', 'uber-wpbakery-addons' ),
				'button_text' => esc_html__( 'More', 'uber-wpbakery-addons' ),
			) );
			wp_enqueue_script( 'masonry_more' );			
		}
		
		if( $action == 'masonry_lazy' ){
			wp_register_script( 'masonry_lazy', UBER_WPB_PLUGIN_URI . '/js/masonry/masonry_lazy.js', array('jquery') , true);
			wp_localize_script( 'masonry_lazy', 'uber_wpb_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
			) );
			wp_enqueue_script( 'masonry_lazy' );	
		}
		
		if( $action == 'masonry_pagination' ){
			wp_register_script( 'masonry_pagination', UBER_WPB_PLUGIN_URI . '/js/masonry/masonry_pagination.js', array('jquery') , true);
			wp_localize_script( 'masonry_pagination', 'uber_wpb_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
			) );
			wp_enqueue_script( 'masonry_pagination' );				
		}
		
	//posts
		if( $action == 'posts_more' ){
			wp_register_script( 'posts_more', UBER_WPB_PLUGIN_URI . '/js/posts/posts_more.js', array('jquery') , true);
			wp_localize_script( 'posts_more', 'uber_wpb_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
				'loading_text' => esc_html__( 'Loading...', 'uber-wpbakery-addons' ),
				'button_text' => esc_html__( 'More posts', 'uber-wpbakery-addons' ),
			) );
			wp_enqueue_script( 'posts_more' );	
		}
		
		if( $action == 'posts_lazy' ){
			wp_register_script( 'posts_lazy', UBER_WPB_PLUGIN_URI . '/js/posts/posts_lazy.js', array('jquery') , true);
			wp_localize_script( 'posts_lazy', 'uber_wpb_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
			) );
			wp_enqueue_script( 'posts_lazy' );	
		
		}
		
		if( $action == 'posts_pagination' ){
			wp_register_script( 'posts_pagination', UBER_WPB_PLUGIN_URI . '/js/posts/posts_pagination.js', array('jquery') , true);
			wp_localize_script( 'posts_pagination', 'uber_wpb_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
			) );
			wp_enqueue_script( 'posts_pagination' );		
		
		}

	//portfolio		
		if($action == 'portfolio_more' ){
			wp_register_script( 'portfolio_more', UBER_WPB_PLUGIN_URI . '/js/portfolio/portfolio_more.js', array('jquery') , true);
			wp_localize_script( 'portfolio_more', 'uber_wpb_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
				'loading_text' => esc_html__( 'Loading...', 'uber-wpbakery-addons' ),
				'button_text' => esc_html__( 'More', 'uber-wpbakery-addons' ),
			) );
			wp_enqueue_script( 'portfolio_more' );			
		}

		if($action == 'portfolio_pagination' ){
			wp_register_script( 'portfolio_pagination', UBER_WPB_PLUGIN_URI . '/js/portfolio/portfolio_pagination.js', array('jquery') , true);
			wp_localize_script( 'portfolio_pagination', 'uber_wpb_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
			) );
			wp_enqueue_script( 'portfolio_pagination' );				
		}
		
		if($action == 'portfolio_lazy' ){
			wp_register_script( 'portfolio_lazy', UBER_WPB_PLUGIN_URI . '/js/portfolio/portfolio_lazy.js', array('jquery') , true);
			wp_localize_script( 'portfolio_lazy', 'uber_wpb_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
			) );
			wp_enqueue_script( 'portfolio_lazy' );			
		}	
}

/*
=================================================================================================================
Function uber_wpb_posts_loadmore_ajax_handler() - Ajax VC posts more
=================================================================================================================
*/
function uber_wpb_posts_loadmore_ajax_handler(){

	if( $_POST['query'] ){
		
		$data = json_decode( stripslashes( wp_filter_kses( $_POST['query'] ) )  , true);

		$current_page = wp_filter_kses ( $_POST['current_page'] );
			
			if( !is_numeric ( $current_page ) ){
				die();
			}

			$data['atts']['page'] = $current_page;
			$data['atts']['ajax'] = true;		

			echo uber_wpb_posts_func(  $data['atts'], $content = null );
			
		die(); // here we exit the script 
	}	
	
}
add_action('wp_ajax_posts_loadmore', 'uber_wpb_posts_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_posts_loadmore', 'uber_wpb_posts_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}


/*
=================================================================================================================
Function uber_wpb_portfolio_loadmore_ajax_handler() - Ajax VC portfolio more
=================================================================================================================
*/
function uber_wpb_portfolio_loadmore_ajax_handler(){

	if( $_POST['query'] ){
		
		$data = json_decode( stripslashes( wp_filter_kses( $_POST['query'] ) )  , true);

		$current_page = wp_filter_kses ( $_POST['current_page'] );
			
			if( !is_numeric ( $current_page ) ){
				die();
			}

			$data['atts']['page'] = $current_page;
			$data['atts']['ajax'] = true;		

			echo uber_wpb_portfolio_func(  $data['atts'], $content = null );
			
		die(); // here we exit the script 
	}	
	
}
add_action('wp_ajax_portfolio_loadmore', 'uber_wpb_portfolio_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_portfolio_loadmore', 'uber_wpb_portfolio_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}

/*
=================================================================================================================
Function uber_wpb_masonry_loadmore_ajax_handler() - Ajax VC masonry more
=================================================================================================================
*/
function uber_wpb_masonry_loadmore_ajax_handler(){
	if( $_POST['query'] ){
		
		$data = json_decode( stripslashes( wp_filter_kses( $_POST['query'] ) )  , true);

		$current_page = wp_filter_kses ( $_POST['current_page'] );
			
			if( !is_numeric ( $current_page ) ){
				die();
			}

			$data['atts']['page'] = $current_page;
			$data['atts']['ajax'] = true;		

			echo uber_wpb_masonry_func(  $data['atts'], $content = null );
			
		die(); // here we exit the script 
	}	
	
}
add_action('wp_ajax_masonry_loadmore', 'uber_wpb_masonry_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_masonry_loadmore', 'uber_wpb_masonry_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}

/*
=================================================================================================================
Function uber_wpb_loadmore_ajax_handler() - Ajax VC posts, portfolio, masonry
=================================================================================================================
*/
function uber_wpb_loadmore_ajax_handler(){

	if( $_POST['query'] ){
		
		$data = json_decode( stripslashes( wp_filter_kses( $_POST['query'] ) )  , true);
		
		
		$current_page = wp_filter_kses ( $_POST['current_page'] );
		//var_dump( $_POST['current_page']);
		if ( $data['atts']['do_action'] == 'masonry'){
			
			$data['atts']['page'] = $current_page;
			$data['atts']['ajax'] = true;	
			echo uber_wpb_masonry_func(  $data['atts'], $content = null );
		}	
		
		elseif ( $data['atts']['do_action'] == 'portfolio'){
			
			$data['atts']['page'] = $current_page;
			$data['atts']['ajax'] = true;	
			echo uber_wpb_portfolio_func(  $data['atts'], $content = null );
		}
		elseif ( $data['atts']['do_action'] == 'posts'){
			$data['atts']['page'] = $current_page;
			$data['atts']['ajax'] = true;	
			echo uber_wpb_posts_func(  $data['atts'], $content = null );
		}
			
		die(); // here we exit the script 
	}	
	
}
add_action('wp_ajax_loadmore', 'uber_wpb_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'uber_wpb_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}

/*
=================================================================================================================
Function uber_wpb_uber_wpb_vc_presets_ajax_handler() - Ajax for Visual composer (WPBakery) elements presets
=================================================================================================================
*/
function uber_wpb_uber_wpb_vc_presets_ajax_handler(){
	if( $_POST['query'] && $_POST['action']){
		
		$query = stripslashes( wp_filter_kses( $_POST['query'] ));
		$action = stripslashes( wp_filter_kses( $_POST['action'] ));
		if( $query && $action == 'uber_wpb_vc_presets' ){
			
		
			$data  = json_decode($query ,true);
			$preset = uber_wpb_vc_presets( $data['base_name'] , $data['preset_id']);
			die(json_encode($preset)); // here we exit the script 
		}
		
	}	

}
 
add_action('wp_ajax_uber_wpb_vc_presets', 'uber_wpb_uber_wpb_vc_presets_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_uber_wpb_vc_presets', 'uber_wpb_uber_wpb_vc_presets_ajax_handler'); // wp_ajax_nopriv_{action}