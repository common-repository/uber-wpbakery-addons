<?php
/**
 * Visual Composer Simple Heading Block
 *
 * @package Uber WPBakery Addons
 * @author WOW Layers
 * @link https://wowlayers.com
 */


/*
=================================================================================================================
uber_wpb_simple_heading_func( $atts, $content = null ) - Output the simple heading custom block
=================================================================================================================
*/
add_shortcode( 'uber_wpb_simple_heading', 'uber_wpb_simple_heading_func' );
function uber_wpb_simple_heading_func( $atts, $content = null ) { // New function parameter $content is added!

$output = $html_output = $css_output = $custom_css_class = $data_anim = $data_anim_delay = $data_anim_duration =  '';


$css_output_array = array();
$css_output_array['content'] = array();
$css_output_array['responsive'] = array();
$css_output_array['general'] = array();
$general_css_box = array();

		
   extract( shortcode_atts( array(
	  'inline' => '',
	  'css_editor' => '',
	  'uber_wpb_button'	=> '',
	  'uber_wpb_link' => '',
	  'el_class'	=> '',
	  
	  'color'	=> '',
	  'text_transform'	=> '',
	  'content_font'	=> '',
	  'content_line_height'	=> '',
	  'content_font_weight'	=> '',
	  'content_font_weight2'	=> '',
	  'content_font_selector' => '',
	  'content_customfont' => '',
	  'content_font_size' => '',
	  'content_letterspacing' => '',
	  'content_high' => '',
	  'content_css_editor' => '',
 
	  
	  //animation
	  'animate' => '',
	  'animation' =>'fadeIn',	  
	  'animation_duration' => '',
	  'animation_delay' => '',	 
	 
   ), $atts ) );

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
		
		$custom_css_class = 'custom_css_'.uniqid("", true);
		$custom_css_class = str_replace('.','-',$custom_css_class);
		$custom_css_class_w_dot = '.'.$custom_css_class;	

		//animations
		if($animate){
			wp_enqueue_script( 'vc_waypoints' );
			wp_enqueue_script('script-animate');
		}	

		/*=====  CSS OUTPUT BEGIN ======*/
		
		//general
		if( $css_editor ){
			$general_css_box = uber_wpb_css_box($css_editor);
			$css_output_array['general'][]= implode(";",$general_css_box);			
		}

		//heading styles
		if     ($content_font_selector == 'googlefont') { $css_output_array['content'][]   = esc_attr( uber_wpb_google_fonts($content_font)) ; }
		else 									   { $css_output_array['content'][] = '';}
		//$css_output_array['content'][]= 'display:inline-block';
		$css_output_array['content'][]= ($content_font_size)   ? 'font-size:'.esc_attr($content_font_size) : '';
		$css_output_array['content'][]= ($content_line_height || strlen($content_line_height) >= 1 ) ? 'line-height:'.esc_attr($content_line_height) : '';
		$css_output_array['content'][]= ($content_letterspacing) ? 'letter-spacing:'.esc_attr($content_letterspacing) : '';
		
		$css_output_array['content'][]= $color ? 'color:'.esc_attr( $color ) : '';
		$css_output_array['content'][]= $text_transform ? 'text-transform:'.esc_attr( $text_transform ) : '';
		
		//responsive			
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot ." .simple-headings-holder",  "css_atts" =>$general_css_box ,"default_font_size" => '');		
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot ." .simple-headings-holder > *",  "css_atts" =>$css_output_array['content'] ,"default_font_size" => '');		
		
		//delete empty array values so we don't get ';' when there is no css
		$general_array = array_filter($css_output_array['general']);
		$content_array = array_filter($css_output_array['content']);
		$responsive_array = array_filter($css_output_array['responsive']);
		
	
		if( $general_array || $content_array || $responsive_array ){ //check if there are any custom css

				$css_output.= '<style type="text/css">';
					$css_output.= ($general_array) ? esc_attr( $custom_css_class_w_dot )." .simple-headings-holder{". implode(';', array_filter($general_array)).'}' : ''; //escaped above in 
					
					$css_output.= ($content_array) ? esc_attr( $custom_css_class_w_dot )." .simple-headings-holder > *," . esc_attr( $custom_css_class_w_dot )." .simple-headings-holder > * > a{". implode(';', array_filter($content_array)).'}' : ''; //escaped above in $css_output_array
					
					$css_output.= ($responsive_array)  ? uber_wpb_responsive( $responsive_array) : '';
				$css_output.= '</style>';
		}
	    /*=====  CSS OUTPUT END ======*/
	
	
		/*=====  HTML OUTPUT BEGIN ======*/
	    
		//animation output
	    if($animate){
			$data_anim    		= 'data-animate="'.esc_attr( $animation ).'"';
			$data_anim_delay    = 'data-animate-delay="'.esc_attr( $animation_delay ).'"';
			$data_anim_duration = 'data-animate-duration="'.esc_attr( $animation_duration ).'"';
	    }
		
		//escape
		$custom_css_class = ' '.esc_attr($custom_css_class);
		$el_class 		  = ' '.esc_attr($el_class);
		
		//all variables are properly escaped above
		$html_output.= '<div class="simple-headings'.$custom_css_class.$el_class.'" '.$data_anim.''.$data_anim_delay.''.$data_anim_duration.'>';
		
		if($content){
			$html_output.= '<div class="simple-headings-holder">';
			$html_output.= wp_kses_post( $content );
			$html_output.= '</div>';
		}



		$html_output.='</div>'; //headings div end
		/*=====  HTML OUTPUT END ======*/
		
		$output=$css_output."\n".$html_output; //All variables inside $css_output and $html_output are propelry escaped above
		return $output;	
}


add_action( 'vc_before_init', 'uber_wpb_simple_heading_integrateWithVC' );
function uber_wpb_simple_heading_integrateWithVC() {

	
	$params = array(
	
			array(
				'type' 			=> 'vc_links',
				'param_name' 	=> 'caption_url',
				'class'			=>	'ult_param_heading',
				'description' 	=> __( '<span style="Background: #03A9F4;padding: 10px; font-style: normal; display: block;font-weight:500;"><a href="https://wowlayers.com/infinito/?source=uber-plugin" style="color:#fff;text-decoration: none;" target="_blank">46 Ready Websites in One Wordpress Theme. Built with WPBakery.</a></span>', 'uber-wpbakery-addons' ),
			),	

		//general tab
        array(
            'type' => 'textarea_html',
            'heading' => esc_html__( 'Heading 1', 'uber-wpbakery-addons' ),
            'param_name' => 'content',
            'value' => '',
			'admin_label' => true,
            'description' => esc_html__( 'Enter Heading text.', 'uber-wpbakery-addons' ),
			'std' => 'Add a text here and select the heading tag from the editor',
        ),
			

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'uber-wpbakery-addons' ),
            'param_name' => 'el_class',
            'value' => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'description' => esc_html__( 'Add your custom css class for this element.', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'css_editor',
			//'edit_field_class' => 'vc_col-sm-6 vc_column',
			'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
			'param_name' => 'css_editor',
			// 'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'uber-wpbakery-addons' ),
		),	
		
		//Heading Options tab
        array(
            "type" => "colorpicker",
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading Options',
            "heading" => esc_html__( "Text color", "js_composer" ),
            "param_name" => "color",
        ),
		array(
            'type' => 'dropdown',
			'group' => 'Heading Options',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'Text Transform', 'uber-wpbakery-addons' ),
			'param_name' => 'text_transform',
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Uppercase', 'uber-wpbakery-addons' ) => 'uppercase',
				esc_html__( 'Lowercase', 'uber-wpbakery-addons' ) => 'lowercase',
				esc_html__( 'Capitalize', 'uber-wpbakery-addons' ) => 'capitalize',
			),           
        ),		
		array(
			'type' => 'dropdown',
			'group' => 'Heading Options',
			'heading' => esc_html__( 'Font', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
			),
			'param_name' => 'content_font_selector',
			'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
		),		
		
		array(
			'type' => 'google_fonts',
			'group' => 'Heading Options',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'content_font',
			'value' => '',// Not recommended, this will override 'settings'. Example:
			'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
						bold italic:900:italic'),
			'settings' => array(
							 
							 'no_font_style'=>true 
					),
			'dependency' => array(
				'element' => 'content_font_selector',
				'value' => 'googlefont',
				),					
			'description' => esc_html__( 'Choose Font', 'uber-wpbakery-addons' ), // Description for field group
		),
        array(
            'type' => 'textfield',
			'group' => 'Heading Options',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'Font Size', 'uber-wpbakery-addons' ),
            'param_name' => 'content_font_size',
            'value' => '',
            'description' => esc_html__( 'Font size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
        ),	
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading Options',
			'heading' => esc_html__( 'Line height', 'uber-wpbakery-addons' ),
			'param_name' => 'content_line_height',
			'value' => '',
			'description' => esc_html__( 'Enter line height. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
		),	
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading Options',
			'heading' => esc_html__( 'Letter Spacing', 'uber-wpbakery-addons' ),
			'param_name' => 'content_letterspacing',
			'value' => '',
			'description' => esc_html__( 'All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
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
			'name' => esc_html__( 'Simple heading', 'uber-wpbakery-addons' ),
			'base' => 'uber_wpb_simple_heading',
			'weight' => 999,
			'icon' => 'uberwpb-texteditor-font',
			'category' => array(esc_html__('Content','uber-wpbakery-addons'),esc_html__('Uber Addons','uber-wpbakery-addons')),
			'admin_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'admin_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'front_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'front_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'description' => esc_html__( 'Simple heading text', 'uber-wpbakery-addons' ),
			'params' => $params
	) );
	
  
}

?>