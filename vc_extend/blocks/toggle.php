<?php
/**
 * Visual Composer Custom Toggle Block
 *
 * @package Uber WPBakery Addons
 * @author WOW Layers
 * @link https://wowlayers.com
 */


/*
=================================================================================================================
uber_wpb_toggle_func( $atts, $content = null ) - Output the toggle custom block
=================================================================================================================
*/
add_shortcode( 'uber_wpb_toggle', 'uber_wpb_toggle_func' );
function uber_wpb_toggle_func( $atts, $content = NULL ) {
$custom_css_class = $data_anim = $data_anim_delay = $data_anim_duration = $css_output = $html_output = '';	   
$css_output_array['accordion_head'] = array();
$css_output_array['accordion_body'] = array();
$css_output_array['plus_minus'] = array();
$css_output_array['responsive'] = array();
$css_output_array['h'] = array();
$css_output_array['p'] = array();

		
	    //default variables
	    extract( shortcode_atts( array(
		'accordions' => '',
		'title' => '',
		'content' => '',
		'title_size' => '',
		'content_size' => '',
		'content_line_height' => '',
		'title_color' => '',
		'content_color' => '',
		'heading_bg' => '',
		'heading_border' => '',
		'icon_bg' => '',
		'icon_color' => '',
		'icon_bg_width' => '',		
		'el_class' => '',
	
		//title typography
	   'h_font'	=> '',
	   'h_font_weight'	=> '',
	   'h_font_weight2'	=> '',
	   'h_font_selector' => '',
	   'h_customfont' => '',
	  
	  	//content typography
	   'p_font'	=> '',
	   'p_font_weight'	=> '',
	   'p_font_weight2'	=> '',
	   'p_font_selector' => '',
	   'p_customfont' => '',  	
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
		
		wp_enqueue_script( 'toggle', UBER_WPB_PLUGIN_URI."/js/toggle.js", false, NULL, true );
		wp_enqueue_style( 'lato-accordion-icon', 'https://fonts.googleapis.com/css?family=Lato:100');

	    /*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		//ESCAPED ALMOST ALL VARAIBLES HERE AS THERE IS A LARGE NUMBER OF USE //
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		$title					= esc_attr($title);
		$content				= esc_attr($content);
		
		$title_size				= esc_attr($title_size);
		$content_size			= esc_attr($content_size);
		$content_line_height	= esc_attr($content_line_height);
		
		$title_color			= esc_attr($title_color);
		$content_color			= esc_attr($content_color);
		$heading_bg				= esc_attr($heading_bg);
		$heading_border			= esc_attr($heading_border);
		$icon_bg				= esc_attr($icon_bg);
		$icon_color				= esc_attr($icon_color);
		
		$icon_bg_width			= esc_attr($icon_bg_width);
		
		
		//custom css class
		$custom_css_class = 'custom_css_'.uniqid("", true);
		$custom_css_class = str_replace('.','-',$custom_css_class);
		$custom_css_class_w_dot = '.'.esc_attr( $custom_css_class ); //escaped here as there is a large number of use	

		//title typography
		if     ($h_font_selector == 'googlefont') { $css_output_array['h'][]   = esc_attr( uber_wpb_google_fonts($h_font)) ; }
		else 									   { $css_output_array['h'][] = '';}
		
		
		//content typography
		if     ($p_font_selector == 'googlefont') { $css_output_array['p'][]   = esc_attr(uber_wpb_google_fonts($p_font)); }
		else 									  { $css_output_array['p'][] = '';}
		
		$h_array = array_filter($css_output_array['h']);
		$p_array = array_filter($css_output_array['p']);
		
		//dymanic css - all variables are properly escaped above	

			$css_output.= ($h_array) ? esc_attr( $custom_css_class_w_dot )." .accordion_head{". implode(';', array_filter($h_array)).'}' : ''; //escaped above in $css_output_array
			$css_output.= ($p_array) ? esc_attr( $custom_css_class_w_dot )." .accordion_body p{". implode(';', array_filter($p_array)).'}' : ''; //escaped above in $css_output_array
			$css_output_array['accordion_head'][] = $title_size ? "font-size:". $title_size : "";
			$css_output_array['accordion_head'][] = $title_color ? "color:". $title_color : "";
			$css_output_array['accordion_head'][] = $heading_bg ? 'background:'.$heading_bg : "";
			$css_output_array['accordion_head'][] = $heading_border ? 'border: solid 1px '.$heading_border : "";

			$css_output_array['accordion_body'][] = $content_size ? "font-size:". $content_size : "";
			$css_output_array['accordion_body'][] = $content_size ? 'line-height:'.$content_line_height : "";
			$css_output_array['accordion_body'][] = $content_color ? 'color:'.$content_color : "";
			
			$css_output_array['plus_minus'][] = $icon_bg ? 'background:'.$icon_bg : "";
			$css_output_array['plus_minus'][] = $icon_color ? 'color:'.$icon_color : "";
			$css_output_array['plus_minus'][] = $icon_bg_width ? 'width:'.$icon_bg_width : "";
			
			$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' .accordion_head',  "css_atts" =>$css_output_array['accordion_head'] ,"default_font_size" => 18);
			$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' .accordion_body p',  "css_atts" =>$css_output_array['accordion_body'] ,"default_font_size" => 'p');
			
			$accordion_head_array = array_filter($css_output_array['accordion_head']);	
			$accordion_body_array = array_filter($css_output_array['accordion_body']);	
			$plus_minus_array = array_filter($css_output_array['plus_minus']);
			$responsive_array = array_filter($css_output_array['responsive']);

			$css_output .=  $accordion_head_array ? $custom_css_class_w_dot.' .accordion_head { ' .esc_attr( implode(';', array_filter($accordion_head_array))). '}' : '' ;
			$css_output .=  $accordion_body_array ? $custom_css_class_w_dot.' .accordion_body p { ' .esc_attr( implode(';', array_filter($accordion_body_array))). '}' : '' ;
			$css_output .=  $plus_minus_array ? $custom_css_class_w_dot.' .plusminus { ' .esc_attr( implode(';', array_filter($plus_minus_array))). '}' : '' ;
			$css_output.= ($responsive_array)  ? uber_wpb_responsive( $responsive_array) : '';
		
		//let's add a space to custom css class
		$custom_css_class =  ' '.$custom_css_class;
		
		//custom css class
		$el_class = $el_class ? ' '.$el_class : '';
		
		//start html output
		$html_output .= '<div class="accordion_container '.esc_attr( $custom_css_class ). esc_attr($el_class) .'"><!-- accordion_container -->';
		
		//we parse the group parameter
		$accordions = vc_param_group_parse_atts( $accordions );
		
		//calculate animation delay
		if($animate){
			$animation_delay = (empty($animation_delay)) ? 0.3 : $animation_delay;
		}
		
		//counter used to open the first accordion content
		$first = 0;
		
		foreach ($accordions as $accordion){

			$open_first_accordion = ($first == 0) ? ' style="display: block;"' : ' style="display: none;"';
			$first_minus = ($first == 0) ? '-' : '+';
			//animations
			if($animate){
				$data_anim    		= ' data-animate="'.esc_attr( $animation ).'"';
				$data_anim_delay    = ' data-animate-delay="'.esc_attr( $animation_delay ).'"';
				$data_anim_duration = ' data-animate-duration="'.esc_attr( $animation_duration ).'"';
			}			
		
			//escapes
			$title 	 = !empty( $accordion['title'] ) ? esc_attr($accordion['title']) : '';
			$content =  !empty( $accordion['content'] ) ? esc_attr($accordion['content']) : '';
			
			//all variables are properly escaped above
			$html_output .=' 
			<div class="accordion_head"'.$data_anim.$data_anim_delay.$data_anim_duration.'>'.$title.'<span class="plusminus">'.esc_attr( $first_minus ).'</span></div>
			<div class="accordion_body"'.$open_first_accordion.'>
				<p>'.$content.'</p>
			</div>
			';

			if ( $animate ){ $animation_delay = $animation_delay + $animation_delay; }	
			
			$first++;
			
			
		}
		$html_output .= '</div><!-- /accordion_container -->';
		
		if( $css_output ){
			$css_output = '<style type="text/css">'.$css_output.'</style>';
		}
		
	    return $css_output."\n".$html_output;  //All variables inside $css_output and $html_output are propelry escaped above

}

/*
=================================================================================================================
uber_wpb_toggle_integrateWithVC() - Adds the toggle block in VCs
=================================================================================================================
*/
add_action( 'vc_before_init', 'uber_wpb_toggle_integrateWithVC' );
function uber_wpb_toggle_integrateWithVC() {
		
		$params =  array(	

			array(
				'type' 			=> 'vc_links',
				'param_name' 	=> 'caption_url',
				'class'			=>	'ult_param_heading',
				'description' 	=> __( '<span style="Background: #03A9F4;padding: 10px; font-style: normal; display: block;font-weight:500;"><a href="https://wowlayers.com/infinito/?source=uber-plugin" style="color:#fff;text-decoration: none;" target="_blank">46 Ready Websites in One Wordpress Theme. Built with WPBakery.</a></span>', 'uber-wpbakery-addons' ),
			),
		
			array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Accordions', 'uber-wpbakery-addons' ),
			'param_name' => 'accordions',
			'description' => esc_html__( 'Click + to add more accordions', 'uber-wpbakery-addons' ),
			'value' => urlencode( json_encode( array(
				array(
					'title' => esc_html__( 'We trully rock at this', 'uber-wpbakery-addons' ),
					'content' => esc_html__( 'Flannel plaid locavore brunch chartreuse distillery. Distillery kale chips freegan, post-ironic trust fund thundercats wayfarers kogi venmo leggings dreamcatcher authentic synth lumbersexual. Authentic crucifix mixtape art party. Seitan meggings tote bag put a bird on it. Gastropub sriracha kitsch banjo food truck wayfarers.', 'uber-wpbakery-addons' ),
				),
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'uber-wpbakery-addons' ),
					'param_name' => 'title',
					
					'admin_label' => true,
				),								
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Content', 'uber-wpbakery-addons' ),
					'param_name' => 'content',
					
				),					
			),
			),		
			//typography
			array(
				"type" => "uber_wpb_vc_separator",
				"param_name" => "separator",
				'title' => 'Title',
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
				'type' => 'textfield',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Title size', 'uber-wpbakery-addons' ),
				'param_name' => 'title_size',
				'group' => 'Typography',
				'value' => '',
				'description' => esc_html__( 'All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
			),
			array(
				"type" => "uber_wpb_vc_separator",
				"param_name" => "separator2",
				'group' => 'Typography',
				'title' => 'Content',
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
				'type' => 'textfield',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Content size', 'uber-wpbakery-addons' ),
				'param_name' => 'content_size',
				'group' => 'Typography',
				'value' => '',
				'description' => esc_html__( 'All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
			),		
			array(
				'type' => 'textfield',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Content line height', 'uber-wpbakery-addons' ),
				'param_name' => 'content_line_height',
				'group' => 'Typography',
				'value' => '',
				'description' => esc_html__( 'All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
			),
			array(
				"type" => "colorpicker",
				"heading" => esc_html__( "Title color", "uber-wpbakery-addons" ),
				"param_name" => "title_color",
				"edit_field_class" => "vc_col-sm-3 vc_column",
				"group" => 'Styling',
				"description" => esc_html__( "", "uber-wpbakery-addons" )
			),			
			array(
				"type" => "colorpicker",
				"heading" => esc_html__( "Content color", "uber-wpbakery-addons" ),
				"param_name" => "content_color",
				"edit_field_class" => "vc_col-sm-3 vc_column",
				"group" => 'Styling',
				"description" => esc_html__( "", "uber-wpbakery-addons" )
			),					
			array(
				"type" => "colorpicker",
				"heading" => esc_html__( "Heading background", "uber-wpbakery-addons" ),
				"param_name" => "heading_bg",
				"edit_field_class" => "vc_col-sm-3 vc_column",
				"group" => 'Styling',
				"description" => esc_html__( "", "uber-wpbakery-addons" )
			),				
			array(
				"type" => "colorpicker",
				"heading" => esc_html__( "Heading border", "uber-wpbakery-addons" ),
				"param_name" => "heading_border",
				"edit_field_class" => "vc_col-sm-3 vc_column",
				"group" => 'Styling',
				"description" => esc_html__( "", "uber-wpbakery-addons" )
			),			
			array(
				"type" => "colorpicker",
				"heading" => esc_html__( "Icon color", "uber-wpbakery-addons" ),
				"param_name" => "icon_color",
				"edit_field_class" => "vc_col-sm-3 vc_column",
				"group" => 'Styling',
				"description" => esc_html__( "", "uber-wpbakery-addons" )
			),			
			array(
				"type" => "colorpicker",
				"heading" => esc_html__( "Icon background", "uber-wpbakery-addons" ),
				"param_name" => "icon_bg",
				"edit_field_class" => "vc_col-sm-3 vc_column",
				"group" => 'Styling',
				"description" => esc_html__( "", "uber-wpbakery-addons" )
			),
			array(
				'type' => 'textfield',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Icon background width', 'uber-wpbakery-addons' ),
				'param_name' => 'icon_bg_width',
				"group" => 'Styling',
				'value' => '',
				'description' => esc_html__( 'Pixel (px.) units are allowed', 'uber-wpbakery-addons' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'uber-wpbakery-addons' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'Add your custom css class for this element.', 'uber-wpbakery-addons' )
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
			'name' => esc_html__( 'Toggle plus/minus', 'uber-wpbakery-addons' ),
			'base' => 'uber_wpb_toggle',
			'weight' => 999,
			'icon' => 'pe-7f-plus',
			'category' => array(esc_html__('Content','uber-wpbakery-addons'),esc_html__('Uber Addons','uber-wpbakery-addons')),
			'admin_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'admin_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'front_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'front_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'description' => esc_html__( 'Add toggle with +/-', 'uber-wpbakery-addons' ),
			'params' => $params
		) );

  
}

?>