<?php
/**
 * Visual Composer Testimonials Block
 *
 * @package Uber WPBakery Addons
 * @author WOW Layers
 * @link https://wowlayers.com
 */


/*
=================================================================================================================
uber_wpb_testimonials_func( $atts, $content = null ) - Output the testimonials custom block
=================================================================================================================
*/
add_shortcode( 'uber_wpb_testimonials', 'uber_wpb_testimonials_func' );
function uber_wpb_testimonials_func( $atts, $content = NULL ) {
$custom_css_class = $data_anim = $data_anim_delay = $data_anim_duration = $css_output = $html_output = '';	   

$css_output_array['h'] = array();
$css_output_array['p'] = array();
$css_output_array['w'] = array();

	    //default variables
	    extract( shortcode_atts( array(
		   'testimonials' => '',
		   'name' => '',
		   'website' => '',
		   'text' => '',
		   'image' => '',
		   'style' => 'style1',
		   'name_color' => '',
		   'text_color' => '',
		   'website_color' => '',
		   'bubble_bg' => '',
		   'bullets_color' => '',
		   'el_class' => '',
		   
		   //name typography
	      'h_font'	=> '',
	      'h_font_weight'	=> '',
	      'h_font_weight2'	=> '',
	      'h_font_selector' => '',
	      'h_customfont' => '',
	  
	  	   //testimonial typography
	      'p_font'	=> '',
	      'p_font_weight'	=> '',
	      'p_font_weight2'	=> '',
	      'p_font_selector' => '',
	      'p_customfont' => '',  	  	
	   
	      //website typography
	      'w_font'	=> '',
	      'w_font_weight'	=> '',
	      'w_font_weight2'	=> '',
	      'w_font_selector' => '',
		   'w_customfont' => '',  		   
		   
		   //animation
		   'animate' => '',
		   'animation' =>'fadeIn',	  
		   'animation_duration' => '',
		   'animation_delay' => '',	 

		), $atts ) );
	
		//animations
		if($animate){
			wp_enqueue_script( 'vc_waypoints' );
			wp_enqueue_script('script-animate');
		}
		
		//for style 2 we enqueue the css
		if ($style == 'style2'){
			wp_enqueue_style( 'owl',  UBER_WPB_PLUGIN_URI.'css/owl.css');
			wp_enqueue_script( 'owl', UBER_WPB_PLUGIN_URI. '/js/owl.js', array(), '1.0.0', false );
			wp_enqueue_script( 'owl-init', UBER_WPB_PLUGIN_URI. '/js/owl.init.js', array(), '1.0.0', false );
		}

	    /*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		//ESCAPED ALMOST ALL VARAIBLES HERE AS THERE IS A LARGE NUMBER OF USE //
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		$name_color 		 = esc_attr($name_color);
		$text_color 		 = esc_attr($text_color);
		$website_color  	 = esc_attr($website_color);
		$bubble_bg  	 	 = esc_attr($bubble_bg);
		$bullets_color  	 = esc_attr($bullets_color);
		$animation 			 = esc_attr($animation);
		$animation_duration  = esc_attr($animation_duration);
		$animation_delay 	 = esc_attr($animation_delay);
		
		//dymanic css
		$custom_css_class = 'custom_css_'.uniqid("", true);
		$custom_css_class = str_replace('.','-',$custom_css_class);
		$custom_css_class_w_dot = '.'.esc_attr( $custom_css_class ); //escaped here as there is a large number of use
		
		
		//name typography
		if     ($h_font_selector == 'googlefont') { $css_output_array['h'][]   = esc_attr( uber_wpb_google_fonts($h_font)) ; }
		else 									   { $css_output_array['h'][] = '';}
		
		
		//testimonial typography
		if     ($p_font_selector == 'googlefont') { $css_output_array['p'][]   = esc_attr(uber_wpb_google_fonts($p_font)); }
		else 									  { $css_output_array['p'][] = '';}

		
		//website typography
		if     ($w_font_selector == 'googlefont') { $css_output_array['w'][]   = esc_attr(uber_wpb_google_fonts($w_font)); }
		else 									  { $css_output_array['w'][] = '';}		
		
		$h_array = array_filter($css_output_array['h']);
		$p_array = array_filter($css_output_array['p']);
		$w_array = array_filter($css_output_array['w']);
				
		$css_output.= '<style type="text/css">';
			if ( $style == 'style1' ){
				$css_output.= ($h_array) ? '.testimonials.style1'.esc_attr( $custom_css_class_w_dot )." .testimonial_inner h2{". implode(';', array_filter($h_array)).'}' : ''; //escaped above in $css_output_array
				$css_output.= ($p_array) ? '.testimonials.style1'.esc_attr( $custom_css_class_w_dot )." .testimonial_inner p{". implode(';', array_filter($p_array)).'}' : ''; //escaped above in $css_output_array
				$css_output.= ($w_array) ? '.testimonials.style1'.esc_attr( $custom_css_class_w_dot )." .testimonial_inner span{". implode(';', array_filter($w_array)).'}' : ''; //escaped above in $css_output_array
			}			
			else{
				$css_output.= ($h_array) ? '.testimonials.style2'.esc_attr( $custom_css_class_w_dot )." .name h3{". implode(';', array_filter($h_array)).'}' : ''; //escaped above in $css_output_array
				$css_output.= ($p_array) ? '.testimonials.style2'.esc_attr( $custom_css_class_w_dot )." .quote h3{". implode(';', array_filter($p_array)).'}' : ''; //escaped above in $css_output_array
				$css_output.= ($w_array) ? '.testimonials.style2'.esc_attr( $custom_css_class_w_dot )." .name h6{". implode(';', array_filter($w_array)).'}' : ''; //escaped above in $css_output_array
			}
			$css_output .=  $name_color ? $custom_css_class_w_dot.' h2 { color:'.$name_color.' !important }' : '' ;
			$css_output .=  $text_color ? $custom_css_class_w_dot.' p { color:'.$text_color.' !important }' : '' ;
			$css_output .=  $website_color ? $custom_css_class_w_dot.' span { color:'.$website_color.' !important }' : '' ;
			
			$css_output .=  $text_color ? $custom_css_class_w_dot.' .quote h3 { color:'.$text_color.' !important }' : '' ;
			$css_output .=  $name_color ? $custom_css_class_w_dot.' .name h3 { color:'.$name_color.' !important }' : '' ;
			$css_output .=  $website_color ? $custom_css_class_w_dot.' .name h6 { color:'.$website_color.' !important }' : '' ;
			$css_output .=  $bubble_bg ? $custom_css_class_w_dot.' .quote { background:'.$bubble_bg.' !important }' : '' ;
			$css_output .=  $bubble_bg ? $custom_css_class_w_dot.' .quote:after { border-color:'.$bubble_bg.' transparent transparent transparent !important }' : '' ;
			$css_output .=  $bullets_color ? $custom_css_class_w_dot.' .owl-theme .owl-controls .owl-page span { background:'.$bullets_color.' !important }' : '' ;
		$css_output.= '</style>';
		
		//let's add a space to custom css class
		$custom_css_class =  ' '.$custom_css_class;
		
		//start html output
		$el_class = $el_class ? ' '.$el_class : '';
		
		//animations
		$animate_html = '';		
		if( $animate && $style == 'style2' ){
			$data_anim    		= ' data-animate="'.$animation.'"';
			$data_anim_delay    = ' data-animate-delay="'.$animation_delay.'"';
			$data_anim_duration = ' data-animate-duration="'.$animation_duration.'"';
			$animate_html = $data_anim . ' ' . $data_anim_delay . '' . $data_anim_duration;
		}		
		
		$html_output .= '<div class="testimonials '.esc_attr( $style ).esc_attr( $custom_css_class ). esc_attr( $el_class ) .'" '. $animate_html .'><!-- testimonials -->';
		$html_output .= ( $style == 'style2' ) ? '<div class="owl"><!-- owl -->' : '';
		
		//we parse the group parameter
		$testimonials = vc_param_group_parse_atts( $testimonials );
		
		//calculate animation delay
		if($animate){
			$animation_delay = (empty($animation_delay)) ? 0.3 : $animation_delay;
		}
		
		foreach ($testimonials as $testimonial){			

			//image
			$img = '';
			if (!empty($testimonial['image'])){
				
				$image_id = $testimonial['image'];
				$image_src_arr = wp_get_attachment_image_src( $image_id,'full' );
				$image_src = $image_src_arr[0];
				$img = $style == 'style1' ? aq_resize($image_src,64,64,true) : aq_resize($image_src,150,150,true);
				

			}


			//escapes
			$name 	 = !empty( $testimonial['name'] ) ? esc_attr($testimonial['name']) : '';
			$text 	 = !empty( $testimonial['text'] ) ? esc_attr($testimonial['text']) : '';
			$website 	 = !empty( $testimonial['website'] ) ? esc_attr($testimonial['website']) : '';
			
			//all variables are properly escaped above
			if ($style == 'style1'){

				$animate_html = '';
				//animations
				if( $animate && $style == 'style1' ){
					$data_anim    		= ' data-animate="'.$animation.'"';
					$data_anim_delay    = ' data-animate-delay="'.$animation_delay.'"';
					$data_anim_duration = ' data-animate-duration="'.$animation_duration.'"';
					$animate_html = $data_anim . ' ' . $data_anim_delay . '' . $data_anim_duration;
				}
			
				$image_output = (!empty($img)) ? '<div class="image_wrapper"><img src="'.esc_url ( $img ).'" alt="'.get_the_title().'"/></div>' : '';
				
						
				$html_output .= '<div class="testimonial_inner"' . $animate_html . '><!-- testimonial_inner -->';
					$html_output .= $image_output ;
					$html_output .= '<div class="details_holder">';
						$html_output .= '<h2>'.$name.'</h2>';
						$html_output .= '<p>&quot; '.$text.' &quot;</p>';
						$html_output .= '<span>'.$website.'</span>';
					$html_output .= '</div>';
				$html_output .= '</div><!-- /testimonial_inner -->';
				
				if ( $animate ){ $animation_delay = $animation_delay + $animation_delay; }	
			}
			
			//all variables are properly escaped above
			if ($style == 'style2'){
				
				$image_output = (!empty($img)) ? '<div class="photo-holder"><div class="photo round-image"><img src="'.esc_url ( $img ).'" alt="'.get_the_title().'" /> </div></div>' : '';
							
				$html_output .= '
					<div class="column row"><!-- column -->
					  <div class="large-12 columns testimonial">
						<div class="quote">
						  <h3>&quot; '.$text.' &quot;</h3>
						</div>
						<div class="name">
						 '.$image_output.'
						  <h3>'.$name.'</h3>
						  <h6 class="themecolor">'.$website.'</h6>
						</div>
					  </div>
					</div><!-- /column -->';			
			}

			
		}
		$html_output .= ( $style == 'style2' ) ? '</div><!-- /owl -->' : '';
		$html_output .= '</div><!-- /testimonials -->';

	    return $css_output."\n".$html_output;  //All variables inside $css_output and $html_output are propelry escaped above

}

/*
=================================================================================================================
uber_wpb_testimonials_integrateWithVC() - Adds the testimonials block in VCs
=================================================================================================================
*/
add_action( 'vc_before_init', 'uber_wpb_testimonials_integrateWithVC' );
function uber_wpb_testimonials_integrateWithVC() {

		
		$params =  array(
		
			array(
				'type' 			=> 'vc_links',
				'param_name' 	=> 'caption_url',
				'class'			=>	'ult_param_heading',
				'description' 	=> __( '<span style="Background: #03A9F4;padding: 10px; font-style: normal; display: block;font-weight:500;"><a href="https://wowlayers.com/infinito/?source=uber-plugin" style="color:#fff;text-decoration: none;" target="_blank">46 Ready Websites in One Wordpress Theme. Built with WPBakery.</a></span>', 'uber-wpbakery-addons' ),
			),	

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Style', 'uber-wpbakery-addons' ),
				'param_name' => 'style',
				'description' => esc_html__( 'Select display style of testimonials', 'uber-wpbakery-addons' ),
				'value' => array (
					esc_html__( 'Classic', 'uber-wpbakery-addons' ) => 'style1',
					esc_html__( 'Carousel', 'uber-wpbakery-addons' ) => 'style2',
				),
				'std' =>'style1',
			),		
			array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Testimonials', 'uber-wpbakery-addons' ),
			'param_name' => 'testimonials',
			'description' => esc_html__( 'Click + to add more testimonials', 'uber-wpbakery-addons' ),
			'value' => urlencode( json_encode( array(
				array(
					'name' => esc_html__( 'Josephina Doe', 'uber-wpbakery-addons' ),
					'text' => esc_html__( 'It was an amazing experience with this app. Great work guys!', 'uber-wpbakery-addons' ),
					'website' => esc_html__( 'coolwebsite.com', 'uber-wpbakery-addons' ),
				),
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Name', 'uber-wpbakery-addons' ),
					'param_name' => 'name',
					'description' => esc_html__( 'Enter name of user.', 'uber-wpbakery-addons' ),
					'admin_label' => true,
				),								
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Testimonial', 'uber-wpbakery-addons' ),
					'param_name' => 'text',
					'description' => esc_html__( 'Enter testimonial text.', 'uber-wpbakery-addons' ),
				),	
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Website', 'uber-wpbakery-addons' ),
					'param_name' => 'website',
					'description' => esc_html__( 'Enter website of user.', 'uber-wpbakery-addons' ),
					'admin_label' => true,
				),					
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'uber-wpbakery-addons' ),
					'param_name' => 'image',
					'description' => esc_html__( 'Add user image.', 'uber-wpbakery-addons' ),
				),
			),
		),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'uber-wpbakery-addons' ),
				'param_name' => 'el_class',
				'value' => '',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'description' => esc_html__( 'Add your custom css class for this element.', 'uber-wpbakery-addons' )
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__( "Name Color", "js_composer" ),
				'group' => 'Design Options',
				"param_name" => "name_color",
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),				
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"heading" => esc_html__( "Text Color", "js_composer" ),
				"param_name" => "text_color",
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"heading" => esc_html__( "Website Color", "js_composer" ),
				"param_name" => "website_color",
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"heading" => esc_html__( "Bubble background", "js_composer" ),
				"param_name" => "bubble_bg",
				'dependency' => array(
					'element' => 'style',
					'value' => 'style2',
					),
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"heading" => esc_html__( "Bullets color", "js_composer" ),
				"param_name" => "bullets_color",
				'dependency' => array(
					'element' => 'style',
					'value' => 'style2',
					),
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),

		//typography
		array(
			"type" => "uber_wpb_vc_separator",
			"param_name" => "separator",
			'title' => 'Name',
			'group' => 'Typography',
			'class' => 'fancy-line',
		),	
		array(
			'type' => 'dropdown',
			'group' => 'Typography',
			'heading' => esc_html__( 'Font', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
			),
			'param_name' => 'h_font_selector',
			'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
		),		
		
		array(
			'type' => 'google_fonts',
			'group' => 'Typography',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'h_font',
			'value' => '',// Not recommended, this will override 'settings'. Example:
			'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
						bold italic:900:italic'),
			'settings' => array(
							 
							 'no_font_style'=>true 
					),
			'dependency' => array(
				'element' => 'h_font_selector',
				'value' => 'googlefont',
				),					
			'description' => esc_html__( 'Choose Font', 'uber-wpbakery-addons' ), // Description for field group
		),
		
		array(
			"type" => "uber_wpb_vc_separator",
			"param_name" => "separator2",
			'group' => 'Typography',
			'title' => 'Testimonial',
			'class' => 'fancy-line',
		),	
		array(
			'type' => 'dropdown',
			'group' => 'Typography',
			'heading' => esc_html__( 'Font', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
			),
			'param_name' => 'p_font_selector',
			'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
		),		
		
		array(
			'type' => 'google_fonts',
			'group' => 'Typography',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'p_font',
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
			"type" => "uber_wpb_vc_separator",
			"param_name" => "separator3",
			'group' => 'Typography',
			'title' => 'Website',
			'class' => 'fancy-line',
		),	
		array(
			'type' => 'dropdown',
			'group' => 'Typography',
			'heading' => esc_html__( 'Font', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
			),
			'param_name' => 'w_font_selector',
			'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
		),		
		
		array(
			'type' => 'google_fonts',
			'group' => 'Typography',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'w_font',
			'value' => '',// Not recommended, this will override 'settings'. Example:
			'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
						bold italic:900:italic'),
			'settings' => array(
							 
							 'no_font_style'=>true 
					),
			'dependency' => array(
				'element' => 'w_font_selector',
				'value' => 'googlefont',
				),					
			'description' => esc_html__( 'Choose Font', 'uber-wpbakery-addons' ), // Description for field group
		),
			
			array(
				'type' => 'checkbox',
				'group' => 'Animations',
				'heading' => esc_html__( 'Animate?', 'uber-wpbakery-addons' ),
				'param_name' => 'animate',
			),
			array(
				'type' => 'uber_wpb_vc_animations_in',
				'group' => 'Animations',
				'heading' => esc_html__( 'Animation List', 'uber-wpbakery-addons' ),
				'param_name' => 'animation',
				'value' =>'',
				'dependency' => array(
					'element' => 'animate',
					'value' => 'true',
				),
				'description' => esc_html__( 'Choose list animation', 'uber-wpbakery-addons' ),
				'std' =>'fadeIn',
			),
			array(
				'type' => 'textfield',
				'group' => 'Animations',
				'heading' => esc_html__( 'Animation Duration', 'uber-wpbakery-addons' ),
				'param_name' => 'animation_duration',
				'value' => '',
				'dependency' => array(
					'element' => 'animate',
					'value' => 'true',
					),
				'description' => esc_html__( 'Units are in seconds. Enter without "s", eg: 0.2 or 1.2', 'uber-wpbakery-addons' )
			),
			array(
				'type' => 'textfield',
				'group' => 'Animations',
				'heading' => esc_html__( 'Animation Delay', 'uber-wpbakery-addons' ),
				'param_name' => 'animation_delay',
				'value' => '',
				'dependency' => array(
					'element' => 'animate',
					'value' => 'true',
					),
				'description' => esc_html__( 'Units are in seconds. Enter without "s", eg: 0.2 or 1.2', 'uber-wpbakery-addons' )
			),
	);

		
		
	
		vc_map( array(
			'name' => esc_html__( 'Testimonials', 'uber-wpbakery-addons' ),
			'base' => 'uber_wpb_testimonials',
			'weight' => 999,
			'icon' => 'pe-7f-users',
			'category' => array(esc_html__('Content','uber-wpbakery-addons'),esc_html__('Uber Addons','uber-wpbakery-addons')),
			'admin_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'admin_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'front_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'front_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'description' => esc_html__( 'Add fancy testimonials.', 'uber-wpbakery-addons' ),
			'params' => $params
		) );

  
}

?>