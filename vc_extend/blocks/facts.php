<?php
/**
 * Visual Composer Custom Facts Block
 *
 * @package Uber WPBakery Addons
 * @author WOW Layers
 * @link https://wowlayers.com
 */


/*
=================================================================================================================
uber_wpb_facts_func( $atts, $content = null ) - Output the facts custom block
=================================================================================================================
*/
add_shortcode( 'uber_wpb_facts', 'uber_wpb_facts_func' );
function uber_wpb_facts_func( $atts, $content = NULL ) {
$html_output = $css_output = $custom_css_class = $data_anim = $data_anim_delay = $data_anim_duration = '';

$css_output_array = array();

$general_css_box = $h1_css_box = $h2_css_box = $p_css_box = array();

$css_output_array['general'] = array();
$css_output_array['icon'] = array();
$css_output_array['h1'] = array();
$css_output_array['h2'] = array();
$css_output_array['p'] = array();
$css_output_array['responsive'] = array();

	
	   //default variables
	    extract( shortcode_atts( array(
	    'icon_image'	=> 'icon',
		'icon' => 'uberwpb-webapplication-earth',
		'image'	=> '',
		'image_source'	=> 'media_library',
		'img_src' => '',
		'image_size' => '136x136-medium',
		'img_title' => 'Image Title',
	    'h1' => '1275',
	    'h2' => 'Projects Completed',
	    'p' =>  'Wayfarers mustache pork belly, next level green',
	    'speed' =>  '',
	    'icon_font_size' =>  '',
	    'icon_color' =>  '',
	    'text_alignment' =>  'center',
	    'dot' =>  '',
	    'general_css_editor' =>  '',
			
	    'h1_font'	=> '',
	    'h1_line_height'	=> '',
		'h1_font_weight'	=> '',
		'h1_font_weight2'	=> '',
	    'h1_font_selector' => '',
	    'h1_customfont' => '',
	    'h1_font_size' => '',
	    'h1_color' => '',
	    'h1_css_editor' => '',

		'h2_font'	=> '',
		'h2_line_height'	=> '',
	    'h2_font_weight'	=> '',
	    'h2_font_weight2'	=> '',
	    'h2_font_selector' => '',
	    'h2_customfont' => '',
	    'h2_font_size' => '',
	    'h2_color' => '',
		'h2_css_editor' => '',		
		
		'p_font'	=> '',
		'p_line_height'	=> '',
	    'p_font_weight'	=> '',
	    'p_font_weight2'	=> '',
	    'p_font_selector' => '',
	    'p_customfont' => '',
	    'p_font_size' => '',
	    'p_color' => '',
		'p_css_editor' => '',
		
	    //animation
	    'animate' => '',
	    'animation' =>'fadeIn', 
	    'animation_duration' => '',
	    'animation_delay' => '',

	    ), $atts ) );

		$custom_css_class = 'custom_css_'.uniqid("", true);
		$custom_css_class = str_replace('.','-',$custom_css_class);
		$custom_css_class_w_dot = '.'. esc_attr( $custom_css_class ); //we escape it here as we use it in many places
		
	    /*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		//ESCAPED ALMOST ALL VARAIBLES HERE AS THERE IS A LARGE NUMBER OF USE //
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
	    $icon 	  		      = esc_attr($icon);
	    $image 	  		      = esc_attr($image);
	    $image_source 	  	  = esc_attr($image_source);
	    $img_src 	  	  	  = esc_url($img_src);	
	    $image_size 	  	  = esc_attr($image_size);
	    $img_title 	  	  	  = esc_attr($img_title);
	    $h1 	  	  		  = esc_attr($h1);
	    $h2 	   	  		  = esc_attr($h2);
	    $p 	   	 		      = esc_attr($p);
	    $speed 	  		      = esc_attr($speed);
	    $icon_font_size 	  = esc_attr($icon_font_size);
	    $icon_color 	  	  = esc_attr($icon_color);
	    $text_alignment 	  = esc_attr($text_alignment);
	    $dot 	  			  = esc_attr($dot);
	    $h1_font_size 		  = esc_attr($h1_font_size);
	    $h1_color 	  		  = esc_attr($h1_color);
	    $h2_font_size 	  	  = esc_attr($h2_font_size);
	    $h2_color 	  		  = esc_attr($h2_color);	    
		$p_font_size 	  	  = esc_attr($p_font_size);
	    $p_color 	  		  = esc_attr($p_color);
	 
		
	   //enqueue stuff
	    wp_enqueue_script( 'script-facts', UBER_WPB_PLUGIN_URI."/js/facts.js", array( 'vc_waypoints' ), '1.0.0', true );
	    uber_wpb_vc_font_icons_enqueue($icon);

		//animations
		if($animate){
			wp_enqueue_script( 'vc_waypoints' );
			wp_enqueue_script('script-animate');
		}	
		
		//general
		$general_css_box = uber_wpb_css_box($general_css_editor);
		$css_output_array['general'] = $general_css_box;			
		
		//text alignment
		$global_align = esc_attr( $text_alignment );
		$text_alignment = $text_alignment ? 'text-align:'.$text_alignment : '';
		
		//icon styles
		$css_output_array['icon'][]= ($icon_font_size) ? 'font-size:'.$icon_font_size : '';
		$css_output_array['icon'][]= ($icon_color) ? 'color:'.$icon_color : '';
	
		//number styles
		$h1_css_box = uber_wpb_css_box($h1_css_editor);
		$css_output_array['h1'] = $h1_css_box;		
		if     ($h1_font_selector == 'googlefont') { $css_output_array['h1'][]   = esc_attr( uber_wpb_google_fonts($h1_font) ); }
		elseif ($h1_font_selector == 'customfont' && !empty($h1_customfont)) { $css_output_array['h1'][] = "font-family:'". esc_attr( $h1_customfont )."'"; }
		else { $css_output_array['h1'][] = '';}
		$css_output_array['h1'][]= ($h1_font_size) ? 'font-size:'.$h1_font_size : '';
		$css_output_array['h1'][]= ($h1_color) ? 'color:'.$h1_color : '';		
		$css_output_array['h1'][]= ($h1_line_height) ? 'line-height:'.$h1_line_height : '';
		
		//heading styles
		$h2_css_box = uber_wpb_css_box($h2_css_editor);
		$css_output_array['h2'] = $h2_css_box;	
		if     ($h2_font_selector == 'googlefont') { $css_output_array['h2'][]   =  esc_attr( uber_wpb_google_fonts($h2_font) ); }
		elseif ($h2_font_selector == 'customfont' && !empty($h2_customfont)) { $css_output_array['h2'][] = "font-family:'". esc_attr( $h2_customfont )."'"; }
		else { $css_output_array['h2'][] = '';}
		$css_output_array['h2'][]= ($h2_font_size) ? 'font-size:'.$h2_font_size : '';
		$css_output_array['h2'][]= ($h2_color) ? 'color:'.$h2_color : '';
		$css_output_array['h2'][]= ($h2_line_height) ? 'line-height:'.$h2_line_height : '';	
		
		//paragraph styles
		$p_css_box = uber_wpb_css_box($p_css_editor);
		$css_output_array['p'] = $p_css_box;	
		if     ($p_font_selector == 'googlefont') { $css_output_array['p'][]   =  esc_attr( uber_wpb_google_fonts($p_font) ); }
		elseif ($p_font_selector == 'customfont' && !empty($p_customfont)) { $css_output_array['p'][] = "font-family:'". esc_attr( $p_customfont )."'"; }
		else { $css_output_array['p'][] = '';}
		$css_output_array['p'][]= ($p_font_size) ? 'font-size:'.$p_font_size : '';
		$css_output_array['p'][]= ($p_color) ? 'color:'.$p_color : '';
		$css_output_array['p'][]= ($p_line_height) ? 'line-height:'.$p_line_height : '';	

		//responsive
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot,  "css_atts" =>$general_css_box);
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' .icon i',  "css_atts" =>$css_output_array['icon'] ,"default_font_size" => 62);
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' h1',  "css_atts" =>$css_output_array['h1'] ,"default_font_size" => 'h1');
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' h2',  "css_atts" =>$css_output_array['h2'] ,"default_font_size" => 'h2');
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' p',  "css_atts" =>$css_output_array['p'] ,"default_font_size" => 'p');
		
		//delete empty array values so we don't get ';' when there is no css
		$general_array = (is_array($css_output_array['general'])) ? array_filter($css_output_array['general']) : '';
		$icon_array = (is_array($css_output_array['icon'])) ? array_filter($css_output_array['icon']) : '';
		$h1_array = (is_array($css_output_array['h1'])) ? array_filter($css_output_array['h1']) : '';
		$h2_array = (is_array($css_output_array['h2'])) ? array_filter($css_output_array['h2']) : '';
		$p_array = (is_array($css_output_array['p'])) ? array_filter($css_output_array['p']) : '';
		$responsive_array = (is_array($css_output_array['responsive'])) ? array_filter($css_output_array['responsive']) : '';

		//generate the dymanic css
		if ( $general_array || $icon_array || $text_alignment || $h1_array || $h2_array || $text_alignment || $h1_css_editor || $h2_css_editor || $p_css_editor){
			$css_output.= '<style type="text/css">';
				$css_output.= ($general_array) 	? $custom_css_class_w_dot.'{'.implode(';', array_filter($general_array)).'}' : ''; //escaped above in $css_output_array
				$css_output.= ($icon_array) 	? $custom_css_class_w_dot.' .icon i{'.implode(';', array_filter($icon_array)).'}' : ''; //escaped above in $css_output_array
				$css_output.= ($h1_array)   	? $custom_css_class_w_dot.' h1{'.implode(';', array_filter($h1_array)).'}' : ''; //escaped above in $css_output_array
				$css_output.= ($h2_array)   	? $custom_css_class_w_dot.' h2{'.implode(';', array_filter($h2_array)).'}' : ''; //escaped above in $css_output_array
				$css_output.= ($p_array)   		? $custom_css_class_w_dot.' p{'.implode(';', array_filter($p_array)).'}' : ''; //escaped above in $css_output_array
				$css_output.= ($text_alignment) ? $custom_css_class_w_dot.'{'.$text_alignment.'}' : '';
				$css_output.= ($h1_css_editor)  ? 'h1'.$h1_css_editor : '';
				$css_output.= ($h2_css_editor)  ? 'h2'.$h2_css_editor : '';
				$css_output.= ($p_css_editor)   ?  'p'.$p_css_editor : '';
				$css_output.= ($responsive_array)  ? uber_wpb_responsive( $responsive_array) : '';
			$css_output.= '</style>';
		}
		
	    //we add a space to $custom_css_class
	    $custom_css_class = ($custom_css_class) ? ' '.esc_attr($custom_css_class) : '';
	   
	    //show/hide theme color dot at the end of heading
		$span_dot = ($dot == 'yes') ? '<span class="themecolor1">.</span>' : '';
	   
	    //animation output
	    if($animate){
			$data_anim    		= 'data-animate="'.$animation.'"';
			$data_anim_delay    = 'data-animate-delay="'.$animation_delay.'"';
			$data_anim_duration = 'data-animate-duration="'.$animation_duration.'"';
	    }
		
		if($icon_image == 'icon' and $icon){
			$icon_output = '<div class="icon"><i class="'.$icon.' themecolor1"></i></div>';
		}		
		elseif($icon_image == 'icon' and !$icon){
			$icon_output = '';
		}

	
		//if it is an image icon
		if($icon_image == 'image'){
			
			if ( $image_size != 'full' ){
				$xplode = explode( '-' , $image_size);
				$get_width_height = explode('x',$xplode[0]);
				$img_width = esc_attr($get_width_height[0]);
				$img_height = esc_attr($get_width_height[1]);	
			}
			
			if ( $image_source == 'media_library' ){
				if ( $image_size != 'full' ){
					
					//image is local or external - if external skip aq_resize
					$is_local = stripos($image, get_site_url() );
					
					if ($is_local !== false) {			
						$img = aq_resize($image, $img_width, $img_height, true, true, true);
					}
					else{
						$img = $image;
					}
	
					$icon_output = '<div class="icon"><img class="'.$global_align.'" src="'. esc_url( $img ) .'" title="' .  esc_attr( $img_title ) . '" /></div>';
				}
				else{
					$icon_output = '<div class="icon"><img class="'.$global_align.'" src="'. esc_url( $image ) .'" title="' .  esc_attr( $img_title ) . '" /></div>';
				}
			}
			elseif( $image_source == 'external_link' && !empty ( $img_src ) ){
				$icon_output = '<div class="icon"><img class="'.$global_align.'" src="'. esc_url( $img_src ) .'" title="' . esc_attr( $img_title ) . '" /></div>';
			}
			if ( empty ( $icon_output ) ){
				$icon_output = '<div class="icon"><img class="'.$global_align.'" src="'. esc_url( aq_resize( UBER_WPB_PLUGIN_SQ_IMG , $img_width, $img_height, true, true, true) ) .'" alt="dummy image" title="dummy-image" /></div>';
			}
		}


		//generate the html output
			$html_output .= '
			<div class="facts'.$custom_css_class.'" '.$data_anim.''.$data_anim_delay.''.$data_anim_duration.'><!-- facts -->
				<div class="facts_inner"><!-- facts_inner -->
					 '.$icon_output.'
						<div class="facts-heading-details"><!-- facts-heading-details -->
							<div class="facts-heading-details-inner '.$global_align.'"><!-- facts-heading-details-inner -->
								<div class="facts-heading"><!-- facts-heading -->
									<h1><span class="count" data-counter-speed="'.$speed.'">'.$h1.'</span></h1>
								 </div><!-- /facts-heading -->
								 <div class="facts-details"><!-- facts-details -->
									 <h2>'.$h2.$span_dot.'</h2>
									 <p>'.$p.'</p>
								 </div><!-- /facts-details -->
							</div><!-- /facts-heading-details-inner -->
						</div><!-- /facts-heading-details -->
				</div><!--/ facts_inner -->
			</div><!--/ facts -->';
		
	   
	   return $css_output.$html_output; //All variables inside $css_output and $html_output are propelry escaped above


}

/*
=================================================================================================================
uber_wpb_facts_integrateWithVC() - Adds the facts block in VCs
=================================================================================================================
*/
add_action( 'vc_before_init', 'uber_wpb_facts_integrateWithVC' );
function uber_wpb_facts_integrateWithVC() {

		$params = array(
		
			array(
				'type' 			=> 'vc_links',
				'param_name' 	=> 'caption_url',
				'class'			=>	'ult_param_heading',
				'description' 	=> __( '<span style="Background: #03A9F4;padding: 10px; font-style: normal; display: block;font-weight:500;"><a href="https://wowlayers.com/infinito/?source=uber-plugin" style="color:#fff;text-decoration: none;" target="_blank">46 Ready Websites in One Wordpress Theme. Built with WPBakery.</a></span>', 'uber-wpbakery-addons' ),
			),
			
			//General tab
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Font Icon / Image', 'uber-wpbakery-addons' ),
				'value' => array(
					esc_html__( 'Font Icon', 'uber-wpbakery-addons' ) => 'icon',
					esc_html__( 'Image', 'uber-wpbakery-addons' ) => 'image',
				),
				'std' => 'icon',
				'param_name' => 'icon_image',
			),			
			array(
				'type' => 'uber_wpb_vc_fonts_select',
				'heading' => esc_html__("Select Icon", "js_composer"),
				'param_name' => "icon",
				'value' => '',
				'std' => 'uberwpb-webapplication-earth',
				'dependency' => array(
					'element' => 'icon_image',
					'value' => 'icon',
				),				
            ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Image source', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'Media library', 'uber-wpbakery-addons' ) => 'media_library',
				esc_html__( 'External link', 'uber-wpbakery-addons' ) => 'external_link',
			),
			'std' => 'media_library',
			'dependency' => array(
				'element' => 'icon_image',
				'value' => 'image',
				),				
			'param_name' => 'image_source',
		),
		
		array(
			'type' => 'uber_wpb_attach_image',
			'heading' => esc_html__( 'Image', 'uber-wpbakery-addons' ),
			'param_name' => 'image',
			'value' => '',
			'dependency' => array(
				'element' => 'image_source',
				'value' => 'media_library',
			),			
			'description' => esc_html__( 'Add Image or Icon to this block. If image is added, icon will be overriden', 'uber-wpbakery-addons' )
		),
        array(
            'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'External link', 'uber-wpbakery-addons' ),
            'param_name' => 'img_src',
            'value' => '',
			'dependency' => array(
				'element' => 'image_source',
				'value' => 'external_link',
			),					
            'description' => esc_html__( 'Select image external link.', 'uber-wpbakery-addons' )
        ),			
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Number', 'uber-wpbakery-addons' ),
				'param_name' => 'h1',
				'value' => "",
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__( 'Enter a number or simple text. If you enter numbers only they are animated.', 'uber-wpbakery-addons' ),
				"std" => '1275'
			),				
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Heading', 'uber-wpbakery-addons' ),
				'param_name' => 'h2',
				'value' => "",
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__( 'Enter heading text', 'uber-wpbakery-addons' ),
				'admin_label' => true,
				"std" => 'Projects Completed'
			),			
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Description', 'uber-wpbakery-addons' ),
				'param_name' => 'p',
				'value' => "",
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__( 'Enter description', 'uber-wpbakery-addons' ),
				"std" => 'Wayfarers mustache pork belly, next level green'
			),					
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Counter speed', 'uber-wpbakery-addons' ),
				'param_name' => 'speed',
				'value' => "",
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__( 'Enter the speed in miliseconds. 1000 = 1 second. Only numbers.', 'uber-wpbakery-addons' )
			),	
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text Alignment', 'uber-wpbakery-addons' ),
				'param_name' => 'text_alignment',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'value' => array(
					esc_html__( 'Left', 'uber-wpbakery-addons' ) => 'left',
					esc_html__( 'Center', 'uber-wpbakery-addons' ) => 'center',
					esc_html__( 'Right', 'uber-wpbakery-addons' ) => 'right',
				),
				'description' => esc_html__( 'Select text alignment.', 'uber-wpbakery-addons' ),
				'std' => 'center',
			),				
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Show theme color dot?', 'uber-wpbakery-addons' ),
				'param_name' => 'dot',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'value' => array( esc_html__( 'Yes', 'uber-wpbakery-addons' ) => 'yes' ),
				'description' => esc_html__( 'If checked it will show a theme color dot at the end of heading.', 'uber-wpbakery-addons' ),
			),
			array(
				'type' => 'css_editor',
				'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
				'param_name' => 'general_css_editor',
			),	
			
			//Icon tab
			
			array(
				'type' => 'textfield',
				'group' => 'Icon',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Font Size', 'uber-wpbakery-addons' ),
				'param_name' => 'icon_font_size',
				'value' => '',
				'description' => esc_html__( 'Icon font size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' ),
				'dependency' => array(
					'element' => 'icon_image',
					'value' => 'icon',
				),	
			),
			array(
				"type" => "colorpicker",
				'group' => 'Icon',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				"heading" => esc_html__( "Color", "js_composer" ),
				"param_name" => "icon_color",
				"description" => esc_html__( "Icon color. Leave blank for theme deafult color.", "js_composer" ),
				'dependency' => array(
					'element' => 'icon_image',
					'value' => 'icon',
				),
				"std" => '#ff4949'
			),
			
			//Icon image tab
			
			array(
				'type' => 'dropdown',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'group' => esc_html__( 'Image', 'uber-wpbakery-addons' ),
				'heading' => esc_html__( 'Image Size', 'uber-wpbakery-addons' ),
				'param_name' => 'image_size',
				'value' => array(
					esc_html__( 'Xtra Small - 64x64', 'uber-wpbakery-addons' ) => '64x64-xsmall',
					esc_html__( 'Small - 100x100', 'uber-wpbakery-addons' ) => '100x100-small',
					esc_html__( 'Medium - 136x136', 'uber-wpbakery-addons' ) => '136x136-medium',
					esc_html__( 'Large - 180x180', 'uber-wpbakery-addons' ) => '180x180-large',
					esc_html__( 'Xtra Large - 220x220', 'uber-wpbakery-addons' ) => '220x220-xlarge',
					esc_html__( 'Actual size', 'uber-wpbakery-addons' ) => 'full',

				),
				'dependency' => array(
					'element' => 'image_source',
					'value' => 'media_library',
				),
				'std' => '136x136-medium',
				'description' => esc_html__( 'Choose image size. ', 'uber-wpbakery-addons' )
			),
			
			//Number tab					
			array(
				'type' => 'dropdown',
				'group' => 'Number',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Font', 'uber-wpbakery-addons' ),
				'value' => array(
					esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
					esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
				),
				'param_name' => 'h1_font_selector',
				'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
			),		
			
			array(
				'type' => 'google_fonts',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group' => 'Number',
				'param_name' => 'h1_font',
				'value' => '',// Not recommended, this will override 'settings'. Example:
				'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
							bold italic:900:italic'),
				'settings' => array(
								 
								 'no_font_style'=>true 
						),
				'dependency' => array(
					'element' => 'h1_font_selector',
					'value' => 'googlefont',
					),					
				'description' => esc_html__( 'Choose Font', 'uber-wpbakery-addons' ),
			),
			array(
				'type' => 'textfield',
				'group' => 'Number',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Font Size', 'uber-wpbakery-addons' ),
				'param_name' => 'h1_font_size',
				'value' => '',
				'description' => esc_html__( 'Font Size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
			),			
			array(
				'type' => 'textfield',
				'group' => 'Number',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Line height', 'uber-wpbakery-addons' ),
				'param_name' => 'h1_line_height',
				'value' => '',
				'description' => esc_html__( 'Enter line height. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
			),		
			
			array(
				"type" => "colorpicker",
				'group' => 'Number',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				"class" => "",
				"heading" => esc_html__( "Color", "js_composer" ),
				"param_name" => "h1_color",
				"value" => '', //Default color
				"description" => esc_html__( "Choose text color", "js_composer" ),
				"std" => '#000000'
			),
			array(
				'type' => 'css_editor',
				'group' => 'Number',
				'heading' => esc_html__( 'Number CSS box', 'uber-wpbakery-addons' ),
				'param_name' => 'h1_css_editor',
			),				
			
			//Heading tab
			
			array(
				'type' => 'dropdown',
				'group' => 'Heading',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Font', 'uber-wpbakery-addons' ),
				'value' => array(
					esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
					esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
				),
				'param_name' => 'h2_font_selector',
				'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
			),		
			
			array(
				'type' => 'google_fonts',
				'group' => 'Heading',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'param_name' => 'h2_font',
				'value' => '',// Not recommended, this will override 'settings'. Example:
				'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
							bold italic:900:italic'),
				'settings' => array(
								 'no_font_style'=>true 
						),
				'dependency' => array(
					'element' => 'h2_font_selector',
					'value' => 'googlefont',
					),					
				'description' => esc_html__( 'Choose Font', 'uber-wpbakery-addons' ), // Description for field group
			),
			array(
				'type' => 'textfield',
				'group' => 'Heading',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Font Size', 'uber-wpbakery-addons' ),
				'param_name' => 'h2_font_size',
				'value' => '',
				'description' => esc_html__( 'Font Size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
			),
			array(
				'type' => 'textfield',
				'group' => 'Heading',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Line height', 'uber-wpbakery-addons' ),
				'param_name' => 'h2_line_height',
				'value' => '',
				'description' => esc_html__( 'Enter line height. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
			),							
			array(
				"type" => "colorpicker",
				'group' => 'Heading',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				"class" => "",
				"heading" => esc_html__( "Color", "js_composer" ),
				"param_name" => "h2_color",
				"value" => '', //Default color
				"description" => esc_html__( "Choose text color", "js_composer" ),
				"std" => '#212121'
			),
			array(
				'type' => 'css_editor',
				'group' => 'Heading',
				'heading' => esc_html__( 'Heading CSS box', 'uber-wpbakery-addons' ),
				'param_name' => 'h2_css_editor',
			),				
			
			//Description tab
			
			array(
				'type' => 'dropdown',
				'group' => 'Description',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Font', 'uber-wpbakery-addons' ),
				'value' => array(
					esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
					esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
				),
				'param_name' => 'p_font_selector',
				'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
			),		
			
			array(
				'type' => 'google_fonts',
				'group' => 'Description',
				'param_name' => 'p_font',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'value' => '',// Not recommended, this will override 'settings'. Example:
				'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
							bold italic:900:italic'),
				'settings' => array(
								 'no_font_style'=>true 
						),
				'dependency' => array(
					'element' => 'p_font_selector',
					'value' => 'googlefont',
					),					
				'description' => esc_html__( 'Choose Font', 'uber-wpbakery-addons' ), // Description for field group
			),
			array(
				'type' => 'textfield',
				'group' => 'Description',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Font Size', 'uber-wpbakery-addons' ),
				'param_name' => 'p_font_size',
				'value' => '',
				'description' => esc_html__( 'Font Size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
			),
			array(
				'type' => 'textfield',
				'group' => 'Description',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Line height', 'uber-wpbakery-addons' ),
				'param_name' => 'p_line_height',
				'value' => '',
				'description' => esc_html__( 'Enter line height. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
			),					
			array(
				"type" => "colorpicker",
				'group' => 'Description',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				"class" => "",
				"heading" => esc_html__( "Color", "js_composer" ),
				"param_name" => "p_color",
				"value" => '', //Default color
				"description" => esc_html__( "Choose text color", "js_composer" ),
				"std" => '#505050'
			),
			array(
				'type' => 'css_editor',
				'group' => 'Description',
				'heading' => esc_html__( 'Description CSS box', 'uber-wpbakery-addons' ),
				'param_name' => 'p_css_editor',
			),

			//Animations tab
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Animate?', 'uber-wpbakery-addons' ),
				'param_name' => 'animate',
				"group" => 'Animations',
			),
			array(
				'type' => 'uber_wpb_vc_animations_in',
				'heading' => esc_html__( 'Animation List', 'uber-wpbakery-addons' ),
				'param_name' => 'animation',
				'value' =>'',
				'dependency' => array(
					'element' => 'animate',
					'value' => 'true',
				),
				'description' => esc_html__( 'Choose list animation', 'uber-wpbakery-addons' ),
				'std' =>'fadeIn',
				"group" => 'Animations',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Animation Duration', 'uber-wpbakery-addons' ),
				'param_name' => 'animation_duration',
				'value' => '',
				'dependency' => array(
					'element' => 'animate',
					'value' => 'true',
					),
				'description' => esc_html__( 'Units are in seconds. Enter without "s", eg: 0.2 or 1.2', 'uber-wpbakery-addons' ),
				"group" => 'Animations',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Animation Delay', 'uber-wpbakery-addons' ),
				'param_name' => 'animation_delay',
				'value' => '',
				'dependency' => array(
					'element' => 'animate',
					'value' => 'true',
					),
				'description' => esc_html__( 'Units are in seconds. Enter without "s", eg: 0.2 or 1.2', 'uber-wpbakery-addons' ),
				"group" => 'Animations',
			),
				
		);
	

		vc_map( array(
			'name' => esc_html__( 'Facts', 'uber-wpbakery-addons' ),
			'base' => 'uber_wpb_facts',
			'weight' => 999,
			'icon' => 'uberwpb-webapplication-numbered',
			'category' => array(esc_html__('Content','uber-wpbakery-addons'),esc_html__('Uber Addons','uber-wpbakery-addons')),
			'admin_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'admin_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'description' => esc_html__( 'Add facts with numbers', 'uber-wpbakery-addons' ),
			'params' => $params
		) );
		
}

?>