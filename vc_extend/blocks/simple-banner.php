<?php
/**
 * Visual Composer Countdown Block
 *
 * @package Uber WPBakery Addons
 * @author WOW Layers
 * @link https://wowlayers.com
 */


/*
=================================================================================================================
uber_wpb_simple_banner_func( $atts, $content = null ) - Output the simple banner block
=================================================================================================================
*/
add_shortcode( 'uber_wpb_simple_banner', 'uber_wpb_simple_banner_func' );
function uber_wpb_simple_banner_func( $atts, $content = null ) { 

$html_output = $css_output = $js_html_output = $custom_css_class = $data_anim = $data_anim_delay = $data_anim_duration = '';

$css_output_array['global'] = array();
$css_output_array['h1'] = array();
$css_output_array['responsive'] = array();

$general_css_box = array();

	
   extract( shortcode_atts( array(
	  'heading' => 'STAY IN SHAPE!',
	  'paragraph' => 'Brunch subway tile viral meh kale chips',
	  'second_paragraph' => '',
	  
	  //image start
	  'image' => '',
	  'image_source' => 'media_library',
	  'img_src' => '',
	  'img_title' => '',
	  
	  //image end
	  'hover_effect'=>'roxy',
	  'alignment' => 'left',
	  'url' => '',
	  'target' => '_self',
	  'hide_heading' => '',
	  
	  //icon
	  'icon'	=> 'uberwpb-sport-boot-alt-1',	  
	  'icon_color'	=> '#ffffff',
	  'icon_size'	=> '96px',
	  'icon_css_editor'	=> '',
	  
	  //fonts
	  'h1_font'	=> 'font_family:Oswald%3A200%2C300%2Cregular%2C500%2C600%2C700|font_style:700%20bold%20regular%3A700%3Anormal',
	  'h1_line_height'	=> '1em',
	  'h1_font_weight'	=> '700',
	  'h1_font_weight2'	=> '',
	  'h1_font_selector' => 'googlefont',
	  'h1_font_size' => '56px',
	  'h1_color' => '#fff',
	  'h1_letterspacing' => '',	 
	  'h1_css_editor' => '',	 
	  
	  'p_font' => '',
	  'p_line_height'	=> '',
	  'p_font_weight'	=> '',
	  'p_font_weight2'	=> '',
	  'p_font_selector' => '',
	  'p_font_size'	=> '',
	  'p_color' => '#ffffff',
	  'p_letterspacing'	=> '',
	  'p_css_editor' => '',
	  
	  //background and hover image
	  'bg_bnr'	=> '#000000',
	  'overlay_color'	=> '',
	  'img_opacity'	=> '.3',
	  'img_hover_opacity'	=> '.6',
	  'effect'	=> 'rgba(255,255,255,0.27)',
	  
	//animation
	'animate' => '',
	'animation' =>'fadeIn',	  
	'animation_duration' => '',
	'animation_delay' => '',	  
	  
   ), $atts ) );

   //css
	wp_enqueue_style( 'pe-7f', UBER_WPB_PLUGIN_URI.'fonts/icons/pe-7f/style.css' );
	wp_enqueue_style( 'global-portfolio-hovers',  UBER_WPB_PLUGIN_URI.'css/portfolio-hovers/global.css' );
	wp_enqueue_style( 'effect-'.$hover_effect.'', UBER_WPB_PLUGIN_URI.'css/portfolio-hovers/'.$hover_effect.'.css' );  
   
	//custom css class
   	$custom_css_class = 'custom_css_'.uniqid("", true);
	$custom_css_class = str_replace('.','-',$custom_css_class);
	$custom_css_class_w_dot = '.'.esc_attr( $custom_css_class ); //we escape it here as we use it in many places

	//animations
	if( $animate ){
		wp_enqueue_script( 'vc_waypoints' );
		wp_enqueue_script('script-animate');
	}

	//animation output
	if($animate){
		$data_anim    		= 'data-animate="'.esc_attr($animation).'"';
		$data_anim_delay    = 'data-animate-delay="'.esc_attr($animation_delay).'"';
		$data_anim_duration = 'data-animate-duration="'.esc_attr($animation_duration).'"';
	}
	
	//enqueue font icon
	uber_wpb_vc_font_icons_enqueue($icon);
	
		
	//heading styles
	if     ($h1_font_selector == 'googlefont') { $css_output_array['h1'][]   = esc_attr( uber_wpb_google_fonts($h1_font) ); }
	else 									   { $css_output_array['h1'][] = '';}
	$css_output_array['h1'][]= ($h1_font_size)   ? 'font-size:'.esc_attr($h1_font_size) : '';
	$css_output_array['h1'][]= ($h1_color)       ? 'color:'.esc_attr($h1_color) : '';
	$css_output_array['h1'][]= ($h1_line_height || strlen($h1_line_height) >= 1 ) ? 'line-height:'.esc_attr($h1_line_height) : '';
	$css_output_array['h1'][]= ($h1_letterspacing) ? 'letter-spacing:'.esc_attr($h1_letterspacing) : '';
	
	//paragraph styles
	if     ($p_font_selector == 'googlefont') { $css_output_array['p'][]   = esc_attr( uber_wpb_google_fonts($p_font) ); }
	else 									   { $css_output_array['p'][] = '';}
	$css_output_array['p'][]= ($p_font_size)   ? 'font-size:'.esc_attr($p_font_size) : '';
	$css_output_array['p'][]= ($p_color)       ? 'color:'.esc_attr($p_color).'!important' : '';
	$css_output_array['p'][]= ($p_line_height || strlen($p_line_height) >= 1 ) ? 'line-height:'.esc_attr($p_line_height) : '';
	$css_output_array['p'][]= ($p_letterspacing) ? 'letter-spacing:'.esc_attr($p_letterspacing) : '';

	
	//icon styles
	$css_output_array['icon'][]= ( $icon_color )       ? 'color:'.esc_attr($icon_color) : '';
	$css_output_array['icon'][]= ( $icon_size )   ? 'font-size:'.esc_attr($icon_size) : '';
	
	//responsive	
	$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' .grid figure h2',  "css_atts" =>$css_output_array['h1'] ,"default_font_size" => 72 );
	$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' .grid figure p',  "css_atts" =>$css_output_array['p'] ,"default_font_size" => 24 );

	//icon css box
	$icon_css_box = uber_wpb_css_box( $icon_css_editor );
	$css_output_array['icon_css'] = $icon_css_box;		
	
	//heading css box
	$h1_css_box = uber_wpb_css_box( $h1_css_editor );
	$css_output_array['h1_css'] = $h1_css_box;			
	
	//paragraph css box
	$p_css_box = uber_wpb_css_box( $p_css_editor );
	$css_output_array['p_css'] = $p_css_box;		
	
	$icon_css_array = ( is_array( $css_output_array['icon_css'] ) ) ? array_filter( $css_output_array['icon_css'] ) : '';
	$h1_css_array = ( is_array( $css_output_array['h1_css'] ) ) ? array_filter( $css_output_array['h1_css'] ) : '';
	$p_css_array = ( is_array( $css_output_array['p_css'] ) ) ? array_filter( $css_output_array['p_css'] ) : '';
	$h1_array = array_filter($css_output_array['h1']);
	$p_array = array_filter($css_output_array['p']);
	$icon_array = array_filter($css_output_array['icon']);
	$responsive_array  = (is_array($css_output_array['responsive'])) ? array_filter($css_output_array['responsive']) : '';

if( $icon_css_array || $h1_css_array || $p_css_array ||  $h1_array || $p_array || $alignment || $icon_array || $bg_bnr || $overlay_color || $img_opacity || $img_hover_opacity || $effect || $hide_heading ){
		$css_output.= '<style type="text/css">';
			
			$css_output.= ( $icon_css_array ) ? $custom_css_class_w_dot." .grid figure p.second i{".implode(';', array_filter( $icon_css_array )).'}' : ''; //escaped above in $css_output_array
			$css_output.= ( $h1_css_array ) ? $custom_css_class_w_dot." .grid figure h2{".implode(';', array_filter( $h1_css_array ) ).'}' : ''; //escaped above in $css_output_array
			$css_output.= ( $p_css_array ) ? $custom_css_class_w_dot." .grid figure p{".implode(';', array_filter( $p_css_array ) ).'}' : ''; //escaped above in $css_output_array
			$css_output.= ( $alignment ) ? $custom_css_class_w_dot.' .grid figure h2,'.$custom_css_class_w_dot.' .grid figure p,'.$custom_css_class_w_dot.' .grid figure p.second{text-align:'.esc_attr( $alignment ).' !important}' : '';
			$css_output.= ( $h1_array ) ? $custom_css_class_w_dot." .grid figure h2{".implode(';', array_filter( $h1_array ) ).'}' : ''; //escaped above in $css_output_array
			$css_output.= ( $icon_array ) ? $custom_css_class_w_dot." .grid figure p.second i{".implode(';', array_filter( $icon_array ) ).'}' : ''; //escaped above in $css_output_array
			$css_output.= ( $p_array ) ? $custom_css_class_w_dot." p{".implode(';', array_filter( $p_array ) ).'}' : ''; //escaped above in $css_output_array
			$css_output.= ( $responsive_array )  ? uber_wpb_responsive( $responsive_array) : '';
			$css_output.= ( $hide_heading )  ? $custom_css_class_w_dot.' .grid figure h2 { opacity:0 } '.$custom_css_class_w_dot.' .grid figure:hover h2 { opacity:1 !important }' : '';
			$css_output.= $bg_bnr ? '.uber_wpb_simple_banner'.$custom_css_class_w_dot.' figure {background:'.esc_attr( $bg_bnr ).'}' : '';
			$css_output.= $overlay_color ? '.uber_wpb_simple_banner'.$custom_css_class_w_dot.' figure:hover {background:'.esc_attr( $overlay_color ).'}' : '';
			$css_output.= $img_opacity ? '.uber_wpb_simple_banner'.$custom_css_class_w_dot.' figure img {opacity:'.esc_attr( $img_opacity ).'}' : '';
			$css_output.= $img_hover_opacity ? '.uber_wpb_simple_banner'.$custom_css_class_w_dot.' figure:hover img {opacity:'.esc_attr( $img_hover_opacity ).'}' : '';
			
			if ( ( $hover_effect == 'honey' || $hover_effect == 'sarah' ) && $effect ){
				$css_output.= $custom_css_class_w_dot. ' figure.effect-honey figcaption::before, figure.effect-sarah h2::after { background:'.esc_attr( $effect ).' }';
			}
			
			elseif ( $effect ){
				$css_output.= 
				$custom_css_class_w_dot.'.uber_wpb_simple_banner figure.effect-oscar figcaption::before,'		
				.$custom_css_class_w_dot.'.uber_wpb_simple_banner figure.effect-layla figcaption::after,'		
				.$custom_css_class_w_dot.'.uber_wpb_simple_banner figure.effect-layla figcaption::before,'		
				.$custom_css_class_w_dot.'.uber_wpb_simple_banner figure.effect-bubba figcaption::before,'		
				.$custom_css_class_w_dot.'.uber_wpb_simple_banner figure.effect-bubba figcaption::after,'		
				.$custom_css_class_w_dot.'.uber_wpb_simple_banner figure.effect-roxy figcaption::before,'
				.$custom_css_class_w_dot.'.uber_wpb_simple_banner figure.effect-ruby p,'
				.$custom_css_class_w_dot.'.uber_wpb_simple_banner figure.effect-chico figcaption::before,'
				.$custom_css_class_w_dot.'.uber_wpb_simple_banner figure.effect-lexi:hover figcaption::before,'
				.$custom_css_class_w_dot.'.uber_wpb_simple_banner figure.effect-jazz figcaption::after,'
				.$custom_css_class_w_dot.'.uber_wpb_simple_banner figure.effect-apollo p{ border-color:'.esc_attr( $effect ).' }';
			}
		$css_output.= '</style>';
	}
   
	//image
	if ( $image ){
		$image_id = $image;
		$image_src_arr = wp_get_attachment_image_src( $image_id,'full' );
		$image_src = $image_src_arr[0];
	}
	else{
		$image_src = UBER_WPB_PLUGIN_SQ_IMG;
	}
  

	//second paragraph custom display for overlay styles
	if ( $hover_effect == 'layla' || $hover_effect == 'dexter' || $hover_effect == 'chico' || $hover_effect == 'milo' || $hover_effect == 'goliath' ||  $hover_effect == 'apollo'|| $hover_effect == 'lexi' || $hover_effect == 'duke'){
		$p_before = '<p class="second"><i class="'.esc_attr( $icon ).'"></i></p>'; 
		$p_after = '';
	}


	elseif ( $hover_effect == 'oscar' || $hover_effect == 'roxy' || $hover_effect == 'bubba' || $hover_effect == 'sarah' || $hover_effect == 'selena' || $hover_effect == 'steve' || $hover_effect == 'jazz' || $hover_effect == 'ming' ){
		$p_before = ''; $p_after = '<p class="second"><i class="'.esc_attr( $icon ).'"></i></p>';
	}
	else   { $p_before = ''; $p_after = ''; }
	
	$target = ( $target ) ? $target : '_self';
	
	$url_output_before = ( $url ) ? '<a href="'.esc_url( $url ).'"  target="'.esc_attr( $target ).'">' : '';
	$url_output_after  = ( $url ) ?  '</a>' : '';
	
	$html_output .= '<div class="uber_wpb_simple_banner '.esc_attr( $custom_css_class ).'"><!-- uber_wpb_simple_banner -->';
	$html_output.= '<div class="banner-simple-inner" '.$data_anim.''.$data_anim_delay.''.$data_anim_duration.'><!-- banner-simple-inner -->
		<div class="banner_container"><!-- banner_container -->
			'.$url_output_before.'
				<div class="grid"><!-- grid -->
				<figure class="effect-'.esc_attr( $hover_effect ).'"><!-- figure -->
					<img src="'.esc_url( $image_src ).'">
						<figcaption><!-- figcaption -->'
								.wp_kses_post( $p_before ).
									'<h2>'.esc_attr( $heading ).'</h2><p>'.esc_attr( $paragraph ).'</p>'
								.wp_kses_post( $p_after ).'
						</figcaption><!--/ figcaption -->			
				</figure><!--/ figure -->
				</div><!--/ grid -->
			'.$url_output_after.'
		</div><!-- /banner_container -->
	</div><!-- banner-simple-inner -->';
	$html_output .= '</div><!-- /uber_wpb_simple_banner -->';
   
   return $css_output.$html_output; //All variables inside $css_output and $html_output are properly escaped above
   
}


add_action( 'vc_before_init', 'uber_wpb_simple_banner_integrateWithVC' );
function uber_wpb_simple_banner_integrateWithVC() {
	
	$params = array( 

	
			array(
				'type' 			=> 'vc_links',
				'param_name' 	=> 'caption_url',
				'class'			=>	'ult_param_heading',
				'description' 	=> __( '<span style="Background: #03A9F4;padding: 10px; font-style: normal; display: block;font-weight:500;"><a href="https://wowlayers.com/infinito/?source=uber-plugin" style="color:#fff;text-decoration: none;" target="_blank">46 Ready Websites in One Wordpress Theme. Built with WPBakery.</a></span>', 'uber-wpbakery-addons' ),
			),
		array(
            'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'Heading text', 'uber-wpbakery-addons' ),
            'param_name' => 'heading',
            'value' => 'Developing amazing stuff',			
            'description' => esc_html__( 'Enter heading text', 'uber-wpbakery-addons' ),
			'admin_label' => true
        ),			
		array(
            'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'Paragraph text', 'uber-wpbakery-addons' ),
            'param_name' => 'paragraph',
            'value' => 'Brunch subway tile viral meh kale chips',			
            'description' => esc_html__( 'Enter paragraph text', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Hover effect', 'uber-wpbakery-addons' ),
			'param_name' => 'hover_effect',
					'value' => array(
									array("honey","Honey"),
									array("layla","Layla"),
									array("oscar","Oscar"),
									array("ruby","Ruby"),
									array("roxy","Roxy"),
									array("bubba","Bubba"),
									array("sarah","Sarah"),
									array("chico","Chico"),
									array("selena","Selena"),
									array("apollo","Apollo"),
									array("jazz","Jazz"),
									array("lexi","Lexi"),
							),
			'description' => esc_html__( 'Select your hover effect', 'uber-wpbakery-addons' ),
			'std' => 'bubba',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		), 		
		array(
			'type' => 'dropdown',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'heading' => esc_html__( 'Text alignment', 'uber-wpbakery-addons' ),
			'param_name' => 'alignment',
			'value' => array(
				esc_html__( 'Left', 'uber-wpbakery-addons' ) => 'left',
				esc_html__( 'Center', 'uber-wpbakery-addons' ) => 'center',
				esc_html__( 'Right', 'uber-wpbakery-addons' ) => 'right',

			),		
			'description' => esc_html__( 'Select alignment of text inside banner', 'uber-wpbakery-addons' ),
			'std' => 'left',
		),
		array(
            'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'URL', 'uber-wpbakery-addons' ),
            'param_name' => 'url',
            'value' => '',			
            'description' => esc_html__( 'Add banner URL. ( optional ) Don\'t forget http://', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'dropdown',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'heading' => esc_html__( 'Link target', 'uber-wpbakery-addons' ),
			'param_name' => 'target',
			'value' => array(
				esc_html__( 'Self', 'uber-wpbakery-addons' ) => '_self',
				esc_html__( 'Blank', 'uber-wpbakery-addons' ) => '_blank',
			),		
			'description' => esc_html__( 'Select banner url link target ( optional )', 'uber-wpbakery-addons' ),
			'std' => '_self',
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Hide heading on regular state ?', 'uber-wpbakery-addons' ),
			'description' => esc_html__( 'If checked it will hide heading on regular state, and show it only on banner hover', 'uber-wpbakery-addons' ),
			'param_name' => 'hide_heading',
		),		
		
		//icon tab
		array(
				'type' => 'uber_wpb_vc_fonts_select',
				'heading' => esc_html__("Select Icon", 'uber-wpbakery-addons'),
				'group' => esc_html__( 'Icon', 'uber-wpbakery-addons' ),
				'param_name' => "icon",
				'value' => '',
				'std' => 'uberwpb-webapplication-attachment',
				'description' => esc_html__( 'Please note that not all effects support icon', 'uber-wpbakery-addons' ),
				
            ),		
			array(
				"type" => "colorpicker",
				'group' => esc_html__( 'Icon', 'uber-wpbakery-addons' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				"class" => "",
				"heading" => esc_html__( "Color", 'uber-wpbakery-addons' ),
				"param_name" => "icon_color",
				"value" => '', //Default color
			),
			array(
				'type' => 'textfield',
				'group' => esc_html__( 'Icon', 'uber-wpbakery-addons' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Size', 'uber-wpbakery-addons' ),
				'param_name' => 'icon_size',
				'value' => '',
				'description' => esc_html__( 'Size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' ),
				"std" => '48px'
			),
			array(
				'type' => 'css_editor',
				'group' => esc_html__( 'Icon', 'uber-wpbakery-addons' ),
				'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
				'param_name' => 'icon_css_editor',
			),

		//image tab		
			array(
				'group' =>  esc_html__( 'Image', 'uber-wpbakery-addons' ),
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'uber-wpbakery-addons' ),
				'param_name' => 'image',
				'value' => "",					
				'description' => esc_html__( 'Upload your banner image', 'uber-wpbakery-addons' )
			),
				array(
					"type" => "colorpicker",
					'group' =>  esc_html__( 'Image', 'uber-wpbakery-addons' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					"heading" => esc_html__( "Background color", 'uber-wpbakery-addons' ),
					"param_name" => "bg_bnr",
					"value" => '', 	
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'style1','style2','style3'),
					),						
					"description" => esc_html__( "Choose background of banner", 'uber-wpbakery-addons' )
				),				
				array(
					"type" => "colorpicker",
					'group' =>  esc_html__( 'Image', 'uber-wpbakery-addons' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					"heading" => esc_html__( "Background hover color", 'uber-wpbakery-addons' ),
					"param_name" => "overlay_color",
					"value" => '',			
					"description" => esc_html__( "Choose hover background of banner", 'uber-wpbakery-addons' )
				),					
				array(
					"type" => "textfield",
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'group' =>  esc_html__( 'Image', 'uber-wpbakery-addons' ),
					"class" => "",
					"heading" => esc_html__( "Image opacity", 'uber-wpbakery-addons' ),
					"param_name" => "img_opacity",
					"value" => '',
					"description" => esc_html__( "Choose image opacity of banner. Enter values from 0.01 to 1", 'uber-wpbakery-addons' ),					
				), 		
				array(
					"type" => "textfield",
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'group' =>  esc_html__( 'Image', 'uber-wpbakery-addons' ),
					"class" => "",
					"heading" => esc_html__( "Hover image opacity", 'uber-wpbakery-addons' ),
					"param_name" => "img_hover_opacity",
					"value" => '',
					"description" => esc_html__( "Choose hover image opacity of banner. Enter values from 0.01 to 1", 'uber-wpbakery-addons' ),					
				),
			array(
				"type" => "colorpicker",
				'group' =>  esc_html__( 'Image', 'uber-wpbakery-addons' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				"class" => "",
				"heading" => esc_html__( "Effect color", 'uber-wpbakery-addons' ),
				"description" => esc_html__( "Choose hover effect color. I.e border color", 'uber-wpbakery-addons' ),
				"param_name" => "effect",
				"value" => '',
			),
		
		//Heading tab
		
		array(
			'type' => 'dropdown',
			'group' => esc_html__( 'Heading', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'Font', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
			),
			'param_name' => 'h1_font_selector',
			'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
		),		
		
		array(
			'type' => 'google_fonts',
			'group' => esc_html__( 'Heading', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
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
			'description' => esc_html__( 'Choose Font', 'uber-wpbakery-addons' ), // Description for field group
		),
        array(
            'type' => 'textfield',
			'group' => esc_html__( 'Heading', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'Font Size', 'uber-wpbakery-addons' ),
            'param_name' => 'h1_font_size',
            'value' => '',
            'description' => esc_html__( 'Font size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
        ),		
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => esc_html__( 'Heading', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'Line height', 'uber-wpbakery-addons' ),
			'param_name' => 'h1_line_height',
			'value' => '',
			'description' => esc_html__( 'Enter line height. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
		),	
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => esc_html__( 'Heading', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'Letter Spacing', 'uber-wpbakery-addons' ),
			'param_name' => 'h1_letterspacing',
			'value' => '',
			'description' => esc_html__( 'All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
		),	
		
        array(
            "type" => "colorpicker",
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => esc_html__( 'Heading', 'uber-wpbakery-addons' ),
            "class" => "",
            "heading" => esc_html__( "Text color", 'uber-wpbakery-addons' ),
            "param_name" => "h1_color",
            "value" => '', //Default color
            "description" => esc_html__( "Choose text color", 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'css_editor',
			'group' => esc_html__( 'Heading', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
			'param_name' => 'h1_css_editor',
		),
		
		//Paragraph tab
		
		array(
			'type' => 'dropdown',
			'group' => esc_html__( 'Paragraph', 'uber-wpbakery-addons' ),
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
			'group' => esc_html__( 'Paragraph', 'uber-wpbakery-addons' ),
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
			'group' => esc_html__( 'Paragraph', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'Font Size', 'uber-wpbakery-addons' ),
            'param_name' => 'p_font_size',
            'value' => '',
            'description' => esc_html__( 'Font size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
        ),		
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => esc_html__( 'Paragraph', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'Line height', 'uber-wpbakery-addons' ),
			'param_name' => 'p_line_height',
			'value' => '',
			'description' => esc_html__( 'Enter line height. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
		),	
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => esc_html__( 'Paragraph', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'Letter Spacing', 'uber-wpbakery-addons' ),
			'param_name' => 'p_letterspacing',
			'value' => '',
			'description' => esc_html__( 'All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
		),	
		
        array(
            "type" => "colorpicker",
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => esc_html__( 'Paragraph', 'uber-wpbakery-addons' ),
            "class" => "",
            "heading" => esc_html__( "Text color", 'uber-wpbakery-addons' ),
            "param_name" => "p_color",
            "value" => '', //Default color
            "description" => esc_html__( "Choose text color", 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'css_editor',
			'group' => esc_html__( 'Paragraph', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
			'param_name' => 'p_css_editor',
		),		
		
			//Animation tab
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
			'name' => esc_html__( 'Simple banner', 'uber-wpbakery-addons' ),
			'base' => 'uber_wpb_simple_banner',
			'weight' => 999,
			'icon' => 'uberwpb-webapplication-mail',
			'category' => array(esc_html__('Content','uber-wpbakery-addons'),esc_html__('Uber Addons','uber-wpbakery-addons')),
			'admin_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'admin_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'front_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'front_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'description' => esc_html__( 'Nice hover effect banner', 'uber-wpbakery-addons' ),
			'params' => $params
	) );
	
  
}

?>