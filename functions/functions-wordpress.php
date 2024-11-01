<?php
/*
=================================================================================================================
uber_wpb_excerpt_filter() - get good excerpt even if VC is enabled
=================================================================================================================
*/
if(!function_exists('uber_wpb_excerpt_filter')) {
	function uber_wpb_excerpt_filter( $text , $strip_shortcodes = false) {

		$excerpt_length = apply_filters( 'excerpt_length', 55 );
		
		if( $text){
			
			if( $strip_shortcodes == true  ){
				$content = uber_wpb_get_string_between($text,'[vc_column_text]','[/vc_column_text]');
				$return = wp_trim_words($content,$excerpt_length);
				if($return){
					return $return;
				}
				else{
					
					return wp_trim_words($text,$excerpt_length);
				}					
			}
			
			return wp_trim_words($text,$excerpt_length);
			
		}
		else{
			$uber_wpb_post_content = get_the_content();
			$content = uber_wpb_get_string_between($uber_wpb_post_content,'[vc_column_text]','[/vc_column_text]');
			$return = wp_trim_words($content,$excerpt_length);
			if($return){
				return $return;
			}
			elseif(  strpos($uber_wpb_post_content, "[/vc_row]")  === false ){
				
				return wp_trim_words($uber_wpb_post_content,$excerpt_length);
			}
			else{
				return false;
			}
		}

	}
}
add_filter('get_the_excerpt', 'uber_wpb_excerpt_filter');


/*
=================================================================================================================
uber_wpb_get_the_post_id() - Return the post/page id inside or outside the loop
=================================================================================================================
*/
if(!function_exists('uber_wpb_get_the_post_id')) {
	function uber_wpb_get_the_post_id() {
	  if (in_the_loop()) {
		   $post_id = get_the_ID();
	  } else {
		   global $wp_query;
		   $post_id = $wp_query->get_queried_object_id();
			 }
	  return $post_id;
	}
}