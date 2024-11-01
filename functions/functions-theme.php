<?php
/*
=================================================================================================================
uber_wpb_responsive() - calculate responsive
=================================================================================================================
*/
if ( !function_exists('uber_wpb_responsive') ) {
function uber_wpb_responsive( $args = array() ){
$responsive_fonts = $css_output = '';	
$factor = 1;
	
	if( empty( $args ) ) return false;

	if( isset( $args[0]['responsive_typography_factor'] ) ){
		$factor = (float) $args[0]['responsive_typography_factor'];
		unset( $args[0] );
	}

	foreach( $args as $val ){
			
		if( is_array( $val['css_atts'] ) ){
			$css_atts_array = array_filter( $val['css_atts'] ); //delete empty values if any
		}
		if( isset( $css_atts_array ) && is_array( $css_atts_array ) ){
			
			foreach($css_atts_array as $value){
				$x = explode(":",$value);
				
				if( strpos($x[0], "margin-") !== false ){
					
					if( intval( $x[1] ) ){
						$key= str_replace("margin-","",$x[0]);
						$new_array['margins'][trim($key)] = trim($x[1]);
					}

				}
				elseif( strpos($x[0], "padding-") !== false ){
					
					if( intval( $x[1] ) ){
						$key= str_replace("padding-","",$x[0]);
						$new_array['paddings'][trim($key)] = trim($x[1]);	
					}
				}
				else{
					$new_array[$x[0]] = trim($x[1]);
				}
			}				
		}
		
		if( isset( $new_array["font-size"] ) ){
			
			$font_size_numeric =  uber_wpb_px_em_rem( $new_array['font-size'] , uber_wpb_calc_default_font_size( $val['default_font_size'] ) );
			
		}
		elseif( isset( $val['default_font_size'] ) ){
			$font_size_numeric =   uber_wpb_calc_default_font_size( $val['default_font_size']  );
		}
		else{
			$font_size_numeric = 0;
		}
		
		if( $font_size_numeric > 32 ){  //letter spacing and line height goes together with font size so don't do without it

			if( $font_size_numeric < 45 ){
				$min_font_size = intval( $font_size_numeric / 1.6 );
			}
			elseif( $font_size_numeric < 65 ){
				$min_font_size = intval( $font_size_numeric / 1.8 );
			}
			elseif( $font_size_numeric < 85 ){
				$min_font_size = intval( $font_size_numeric / 2 );
			}
			elseif( $font_size_numeric < 100 ){
				$min_font_size = intval( $font_size_numeric / 2.2 );
			}
			elseif( $font_size_numeric < 120 ){
				$min_font_size = intval( $font_size_numeric / 2.4 );
			}
			elseif( $font_size_numeric < 200 ){
				$min_font_size = intval( $font_size_numeric / 2.6 );
			}
			else{
				$min_font_size = intval( $font_size_numeric / 3.5 );
			}
			
			$responsive_fonts .= "font-size: calc(".esc_attr($min_font_size)."px + (".esc_attr( round( $font_size_numeric / $factor ) )." - ".esc_attr($min_font_size).") * ((100vw - 300px) / (1890 - 300)));"; 

			if( isset( $new_array["letter-spacing"] )  ){
				
				$ls_numeric =  uber_wpb_px_em_rem( $new_array['letter-spacing'] , $font_size_numeric );
				
				$ls_ratio =  $ls_numeric / $font_size_numeric;
				$responsive_fonts .= "letter-spacing: calc((".esc_attr($min_font_size)."px + (".esc_attr(  round( $font_size_numeric / $factor ) )." - ".esc_attr($min_font_size).") * ((100vw - 300px) / (1890 - 300))) *  ".esc_attr($ls_ratio).");";
			}
			if( isset( $new_array["line-height"] )  ){

				$lh_numeric = uber_wpb_px_em_rem( $new_array['line-height'] , $font_size_numeric );
				$lh_ratio =  $lh_numeric / $font_size_numeric;
				$responsive_fonts .= "line-height: calc((".esc_attr($min_font_size)."px + (".esc_attr( round( $font_size_numeric / $factor ) )." - ".esc_attr($min_font_size).") * ((100vw - 300px) / (1890 - 300))) *  ".esc_attr($lh_ratio).");";
			}
		}
		if( $responsive_fonts ){
			
			//we can't escape ">" sign, so if we have it, we won't escape
			if ( strpos($val['selector'], ">") !== false) {
				$css_output.= $val['selector'] . "{" . $responsive_fonts . "}";
			} else {
				 
				 $css_output.= esc_attr( $val['selector'] ) . "{" . $responsive_fonts . "}" ; 
			}
		}
		unset($new_array);
		$responsive_fonts = '';
	}
	
	$css_output = "\n\n\n".'@media only screen and (max-width : 1890px) {
						'. $css_output  . 
					'}'."\n\n\n";

	return $css_output;

}
}
/*
=================================================================================================================
uber_wpb_calc_default_font_size() - if no font size is enter determine the default size for responsive
=================================================================================================================
*/
if ( !function_exists('uber_wpb_calc_default_font_size') ) {
	function uber_wpb_calc_default_font_size( $font ){
		if( !$font ) return false;
		global $uber_wpb_options;
		$h1 = !empty( $uber_wpb_options['h1-font']['font-size'] ) ? $uber_wpb_options['h1-font']['font-size'] : 42;
		$h2 = !empty( $uber_wpb_options['h2-font']['font-size'] ) ? $uber_wpb_options['h2-font']['font-size'] : 32;
		$h3 = !empty( $uber_wpb_options['h3-font']['font-size'] ) ? $uber_wpb_options['h3-font']['font-size'] : 22;
		$h4 = !empty( $uber_wpb_options['h4-font']['font-size'] ) ? $uber_wpb_options['h4-font']['font-size'] : 19;
		$h5 = !empty( $uber_wpb_options['h5-font']['font-size'] ) ? $uber_wpb_options['h5-font']['font-size'] : 18;
		$h6 = !empty( $uber_wpb_options['h6-font']['font-size'] ) ? $uber_wpb_options['h6-font']['font-size'] : 16;
		$p = !empty( $uber_wpb_options['p-font']['font-size'] ) ? $uber_wpb_options['p-font']['font-size'] : 15;

		$needs_processing = in_array($font,array('h1','h2','h3','h4','h5','h6','p'));	
		if( $needs_processing ){
			
			switch ($font) {
				case 'p':
					return intval( $p );			
				case 'h1':
					return intval( $h1 );
				case 'h2':
					return intval( $h2 );
				case 'h3':
					return intval( $h3 );
				case 'h4':
					return intval( $h4 );
				case 'h5':
					return intval( $h5 );
				case 'h6':
					return intval( $h6 );
			}
			
		}
		else return intval( $font );

	}
}
/*
=================================================================================================================
uber_wpb_px_em_rem() - calculate sizes in px even if em or rem is entered for responsive
=================================================================================================================
*/
if ( !function_exists('uber_wpb_px_em_rem') ) {
	function uber_wpb_px_em_rem( $font_size , $default_font_size ){
		$font_size_numeric='';	
		if( !$font_size ) return false;

		if( strpos($font_size, "px") !== false ){
			$font_size_numeric =  intval( $font_size);
		}
		elseif( strpos($font_size, "rem") !== false ){
				$font_size_numeric = 16;
		}
		elseif( strpos($font_size, "em") !== false ){
			$default_font_size =  intval( $default_font_size);
			$font_size_numeric =  $default_font_size * floatval( $font_size);
		}	
		return $font_size_numeric;
		
	}
}

/*
=================================================================================================================
Function uber_wpb_buildTree() - used for One Page
=================================================================================================================
*/
if ( !function_exists('uber_wpb_buildTree') ) {
	function uber_wpb_buildTree( array &$elements, $parentId = 0)
	{
		$branch = array();
		foreach ( $elements as &$element ){
			
			
			
			if ( $element->menu_item_parent == $parentId ){
				$children = uber_wpb_buildTree( $elements, $element->ID );
				if ( $children ){
					$element->wpse_children = $children;
				}
				
				$branch[$element->ID] = $element;
				unset( $element );
			}

		}

		return $branch;
	}
}
/*
=================================================================================================================
Function uber_wpb_oneclick_menu_parse_array() - used for One Page
=================================================================================================================
*/
if ( !function_exists('uber_wpb_oneclick_menu_parse_array') ) {
	function uber_wpb_oneclick_menu_parse_array($array , $selected_id = '') {

	$level1_line = '';
	$level2_line = '--';
	$level3_line = '-----';
		
	  //$return[esc_html__( 'None', 'uber-wpbakery-addons' )]= '';
	$i=0;
	  foreach($array as $values) {
			
		$return[] ='<ul class="first_level_ul vc_col-xs-12 vc_col-sm-6 vc_col-md-3 vc_col-lg-2">';

			$selected = $selected_id == $values->ID ? ' selected' : '';
			$return[] = '<li class="first-level'.esc_attr($selected).'"><a data-id="'.esc_attr( $values->ID ).'" href="#">'.esc_attr( $values->title ). '</a></li>';
		 
			if (!empty($values->wpse_children) ) {

			   foreach($values->wpse_children as $level2  ){
				  $selected = $selected_id == $level2->ID ? ' selected' : '';
				  $return[] = '<li class="second-level'.esc_attr($selected).'"><a data-id="'.esc_attr( $level2->ID ).'" href="#">'.esc_attr($level2->title). '</a></li>';
					
					if (!empty($level2->wpse_children) ) {
						foreach($level2->wpse_children as $level3  ){
							$selected = $selected_id == $level3->ID ? ' selected' : '';
							$return[] = '<li class="third-level'.esc_attr($selected).'"><a data-id="'.esc_attr( $level3->ID ).'" href="#">'.esc_attr($level3->title). '</a></li>';
						}
						
					}
					
			   }  
			   
			}
		

		$return[] ='</ul>';

	  }
	  return $return;

	}
}
/*
=================================================================================================================
Function uber_wpb_nav_menu_2_tree() - used for One Page
=================================================================================================================
*/
if ( !function_exists('uber_wpb_nav_menu_2_tree') ) {
	function uber_wpb_nav_menu_2_tree( $post_id = '' , $menu_id = ''){
		
		if( !$menu_id ){
			if(!$post_id) { return false; };
			
			$other_menu = get_post_meta( (int) $post_id, "uberwpb-different-menu" );
			
			if( empty( $other_menu[0] )  ){

				$locations = get_nav_menu_locations();
				
				if( !empty( $locations[ 'main_nav' ] ) ){
					$menu_id = $locations[ 'main_nav' ] ;
				}
				else return false;
			
			}
			else{
				 $menu_id = (int) $other_menu[0];
			}		
		}

		$items = wp_get_nav_menu_items( $menu_id );

		if( is_array($items) ){
			$items_tree = uber_wpb_buildTree( $items, 0 );
		}

		if( is_array($items_tree) ){

			$return= uber_wpb_oneclick_menu_parse_array( $items_tree ,$post_id );
			
			$return = '<div class="current-menu" data-menu_id="'.esc_attr($menu_id).'">'.implode($return).'</div>';
		}

		return  $return ? $return : false;
	}
}
/*
=================================================================================================================
uber_wpb_theme_options_font_weights() - VC fonts family and weights
=================================================================================================================
*/
if ( !function_exists('uber_wpb_theme_options_font_weights') ) {
	function uber_wpb_theme_options_font_weights( $font , $google ) {

		require( UBER_WPB_PLUGIN_DIR .'/functions/google-fonts.php' );

		//define defaults, just in case the font is not found
		$nonGStyles = array(	
						'400 regular' => '400:normal',
						'700 bold regular' => '700:normal',
						'400 italic' => '400:italic',
						'700 bold italic' => '700:italic',
					);
		if ( !empty( $font ) && ( $google == '1' ||  $google === true ||  $google === 'true' ) ){
			if ( !empty( $fonts_list[0][$font]['font_types'] ) ){
				$get_all_font_weights = explode( ',' , $fonts_list[0][$font]['font_types'] );
				foreach ( $get_all_font_weights as $font_weight ){
					$font_weight_xplode = explode( ':' , $font_weight );
					$weights[$font_weight_xplode[0]] = $font_weight_xplode[1] . ':' . $font_weight_xplode[2];
				}
				return $weights;	
			}
			else return $nonGStyles;
		}
		
		elseif( !empty( $font ) &&  ( $google == 'false' ||  $google == false ) ){
				return 	$nonGStyles;			
		}
		else return array(esc_html__( 'No Font defined.', 'uber-wpbakery-addons' ) => '');
	}
}