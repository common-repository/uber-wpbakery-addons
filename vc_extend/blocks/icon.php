<?php
/**
 * Visual Composer Custom Heading Block
 *
 * @package Uber WPBakery Addons
 * @author WOW Layers
 * @link https://wowlayers.com
 */


/*
=================================================================================================================
uber_wpb_headings_func( $atts, $content = null ) - Output the heading custom block
=================================================================================================================
*/
add_shortcode( 'uber_wpb_icon', 'uber_wpb_icon_func' );
function uber_wpb_icon_func( $atts, $content = null ) { // New function parameter $content is added!
global $uber_wpb_options;
$output = $html_output = $css_output = $custom_css_class = $data_anim = $data_anim_delay = $data_anim_duration  = '';
$css_output_array = array();

$general_css_box = array();
$css_output_array['global'] = array();
$css_output_array['icon'] = array();

$html_classes = array();
$html_classes['general'] = array();


//in html tags(by default), h1 variable is actually h4, h2 is h2

	//themecolors
	if ( is_array ( $atts ) ){
		foreach ($atts as &$att) {
			$att = str_replace(array('themecolor1','themecolor2','themecolor3'), array($uber_wpb_options['theme-color1'],$uber_wpb_options['theme-color2'],$uber_wpb_options['theme-color3']), $att);
		}
	}
		
   extract( shortcode_atts( array(
	  'icon'	=> 'uberwpb-webapplication-attachment',
	  'color'	=> '',
	  'background_style'	=> '',
	  'size'	=> '48px',
	  'align'	=> '',
	  'link'	=> '',
	  'el_class'	=> '',

	  'css_editor' => '',
	  
	  //animation
	  'animate' => '',
	  'animation' =>'fadeIn',	  
	  'animation_duration' => '',
	  'animation_delay' => '',	 
	 
   ), $atts ) );

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
		
		uber_wpb_vc_font_icons_enqueue($icon);

		$custom_css_class = 'custom_css_'.uniqid("", true);				
		$custom_css_class = str_replace('.','-',$custom_css_class);				
		$custom_css_class_w_dot = '.'.esc_attr( $custom_css_class );  //escaped here as there is a large number of use
				
		//animations
		if($animate){
			wp_enqueue_script( 'vc_waypoints' );
			wp_enqueue_script('script-animate');
		}	

		/*=====  CSS OUTPUT BEGIN ======*/
		if( $css_editor ){
			$general_css_box = uber_wpb_css_box($css_editor);
			$css_output_array['global'][]= $custom_css_class_w_dot." .icon_holder i{".implode(";",$general_css_box)."}";							
		}		

		$css_output_array['global'][]= ($align) ? $custom_css_class_w_dot.'{text-align:'.esc_attr($align).'}' : ''; 
		$css_output_array['icon'][]= ($color)       ? 'color:'.esc_attr($color) : '';
		$css_output_array['icon'][]= ($size)   ? 'font-size:'.esc_attr($size) : '';
		
		//delete empty array values so we don't get ';' when there is no css
		$global_array = array_filter($css_output_array['global']);
		$icon_array = array_filter($css_output_array['icon']);
	
		if( $global_array || $icon_array ){ //check if there are any custom css

				$css_output.= '<style type="text/css">';
		
				$css_output.= ($global_array) ? implode(array_filter($global_array)) : '';	
				
				$css_output.= $custom_css_class_w_dot.' i{'.esc_attr( implode(';', array_filter($icon_array))).'}';
				$css_output.= '</style>';
		}
	    /*=====  CSS OUTPUT END ======*/
	
	
		/*=====  HTML OUTPUT BEGIN ======*/
		$html_classes['general'][] = esc_attr( $custom_css_class );
		//$html_classes['general'][] = 'uber_wpb_vc_icon';
		$html_classes['general'][] =  isset( $el_class  ) ? esc_attr($el_class) : '';
		$general_custom_css_class = (array_filter($html_classes['general'])) ? ' '.esc_attr(implode(' ', array_filter($html_classes['general']))) : "";
		
		//animation output
	    if($animate){
			$data_anim    		= 'data-animate="'.esc_attr($animation).'" ';
			$data_anim_delay    = 'data-animate-delay="'.esc_attr($animation_delay).'" ';
			$data_anim_duration = 'data-animate-duration="'.esc_attr($animation_duration).'" ';
	    }
		
		$url = vc_build_link( $link );
		$rel = '';
		if ( ! empty( $url['rel'] ) ) {
			$rel = ' rel="' . esc_attr( $url['rel'] ) . '"';
		}
		
		//all variables are properly escaped above
		$html_output.= '<div class="uber_wpb_icon'.$general_custom_css_class.$el_class.'" '.$data_anim.''.$data_anim_delay.''.$data_anim_duration.'>';
			$html_output.='<div class="icon_holder">';		
				if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) {
					$html_output.= '<a href="' . esc_url( $url['url'] ) . '" ' . $rel . ' title="' . esc_attr( $url['title'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '"><i class="'.esc_attr( $icon ).'"></i></a>';
				}
				else {
					$html_output.= '<i class="'.esc_attr( $icon ).'"></i>';
				}
			$html_output.='</div>';			
		$html_output.='</div>';
		/*=====  HTML OUTPUT END ======*/
		
		$output=$css_output."\n".$html_output;  //All variables inside $css_output and $html_output are propelry escaped above
		return $output;	
}


add_action( 'vc_before_init', 'uber_wpb_icon_integrateWithVC' );
function uber_wpb_icon_integrateWithVC() {

	$params = array(
	
			array(
				'type' 			=> 'vc_links',
				'param_name' 	=> 'caption_url',
				'class'			=>	'ult_param_heading',
				'description' 	=> __( '<span style="Background: #03A9F4;padding: 10px; font-style: normal; display: block;font-weight:500;"><a href="https://wowlayers.com/infinito/?source=uber-plugin" style="color:#fff;text-decoration: none;" target="_blank">46 Ready Websites in One Wordpress Theme. Built with WPBakery.</a></span>', 'uber-wpbakery-addons' ),
			),	
	
			array(
				'type' => 'uber_wpb_vc_fonts_select',
				'heading' => esc_html__("Select Icon", "js_composer"),
				'param_name' => "icon",
				'value' => '',
				'std' => 'uberwpb-webapplication-attachment',
				'admin_label' => true
            ),		
			array(
				"type" => "colorpicker",
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				"class" => "",
				"heading" => esc_html__( "Color", "js_composer" ),
				"param_name" => "color",
				"value" => '', //Default color
			),
			array(
				'type' => 'textfield',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Size', 'uber-wpbakery-addons' ),
				'param_name' => 'size',
				'value' => '',
				'description' => esc_html__( 'Size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' ),
				"std" => '48px'
			),	
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon alignment', 'uber-wpbakery-addons' ),
				'param_name' => 'align',
				'value' => array(
					esc_html__( 'Left', 'uber-wpbakery-addons' ) => 'left',
					esc_html__( 'Right', 'uber-wpbakery-addons' ) => 'right',
					esc_html__( 'Center', 'uber-wpbakery-addons' ) => 'center',
				),
				'description' => esc_html__( 'Select icon alignment.', 'uber-wpbakery-addons' ),
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'URL (Link)', 'uber-wpbakery-addons' ),
				'param_name' => 'link',
				'description' => esc_html__( 'Add link to icon.', 'uber-wpbakery-addons' ),
			),			
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'uber-wpbakery-addons' ),
				'param_name' => 'el_class',
				'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'uber-wpbakery-addons' ),
			),
			array(
				'type' => 'css_editor',
				'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
				'param_name' => 'css_editor',
				'group' => esc_html__( 'Design Options', 'uber-wpbakery-addons' ),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Animate?', 'uber-wpbakery-addons' ),
				'param_name' => 'animate',
				'std' => 'false',
				'group' => esc_html__( 'Animations', 'uber-wpbakery-addons' ),
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
				'description' => esc_html__( 'Choose animation', 'uber-wpbakery-addons' ),
				'std' => 'fadeIn',
				'group' => esc_html__( 'Animations', 'uber-wpbakery-addons' ),
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
				'group' => esc_html__( 'Animations', 'uber-wpbakery-addons' ),
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
				'group' => esc_html__( 'Animations', 'uber-wpbakery-addons' ),
			),	
		
	);
		
	vc_map( array(
			'name' => esc_html__( 'Icon', 'uber-wpbakery-addons' ),
			'base' => 'uber_wpb_icon',
			'weight' => 999,
			'icon' => 'uberwpb-webapplication-paper-plane',
			'category' => array(esc_html__('Content','uber-wpbakery-addons'),esc_html__('Uber Addons','uber-wpbakery-addons')),
			'admin_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'admin_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'front_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'front_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'description' => esc_html__( 'Add icon to content', 'uber-wpbakery-addons' ),
			'params' => $params
	) );
	
  
}

?>