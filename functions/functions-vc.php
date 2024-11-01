<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/*
=================================================================================================================
Let's include the function icons
=================================================================================================================
*/
require_once('functions-vc-icons.php');

/*
=================================================================================================================
uber_wpb_vcSetAsTheme() - Visual Composer set as theme
=================================================================================================================
*/
if( !function_exists( "uber_wpb_vcSetAsTheme" ) ){	
	add_action( 'vc_before_init', 'uber_wpb_vcSetAsTheme' );
	function uber_wpb_vcSetAsTheme() {
		vc_set_as_theme();
	}	
}

/*
=================================================================================================================
vc_set_default_editor_post_types() - enable Visual Composer for post types
=================================================================================================================
*/

$list = array( 'page','portfolio' );
	
if( function_exists( 'vc_set_default_editor_post_types' ) ){
	vc_set_default_editor_post_types( $list );
}

/*
=================================================================================================================
Function uber_wpb_google_fonts() - enqueue google styles for vc blocks
=================================================================================================================
*/
if( !function_exists( "uber_wpb_google_fonts" ) ){
	function uber_wpb_google_fonts($font){

			if($font && function_exists('vc_build_safe_css_class')){
				$css_output=array();
				
				$font=urldecode($font); //vc returns url encoded string
				$font=str_replace('font_family:','',$font);
				$font=str_replace('font_style:','',$font);
				$explode=explode('|',$font);
				if( count( $explode ) > 1  ){
					$google_fonts_data['values']['font_family']=$explode[0];
					$google_fonts_data['values']['font_style']=$explode[1];				
				}


				if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'] ) ) {
					$google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
					$css_output[]= "font-family:" . esc_attr($google_fonts_family[0]);
					$google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
					$css_output[]= "font-weight:" . esc_attr($google_fonts_styles[1]);
					$css_output[]= "font-style:" . esc_attr($google_fonts_styles[2]);
				}

				//enqueue style from google
				if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data['values']['font_family'] ) ) {
					wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . esc_attr( $google_fonts_data['values']['font_family'] ));
					}	
				if( $css_output ){
					return 	implode(";",$css_output);
				}
				else{
					return false;
				}
			}
			else return null;
	}
}
/*
=================================================================================================================
Function uber_wpb_vc_custom_font() - adds the custom fonts uploaded to theme options in VC
=================================================================================================================
*/
if( !function_exists( "uber_wpb_vc_custom_font" ) ){
	function uber_wpb_vc_custom_font(){
		global $uber_wpb_options;
		$uber_wpb_font_name = array();
		$uber_wpb_font_name[0] = 'None';
		if (!empty($uber_wpb_options['custom-font-name'])){
			$uber_wpb_font_name[$uber_wpb_options['custom-font-name']] = $uber_wpb_options['custom-font-name'];
		}	
		if (!empty($uber_wpb_options['custom-font-name1'])){
			$uber_wpb_font_name[$uber_wpb_options['custom-font-name1']] = $uber_wpb_options['custom-font-name1'];
		}	
		if (!empty($uber_wpb_options['custom-font-name2'])){
			$uber_wpb_font_name[$uber_wpb_options['custom-font-name2']] = $uber_wpb_options['custom-font-name2'];
		}
		return $uber_wpb_font_name;
	}
}


/*
=================================================================================================================
Function uber_wpb_vc_img_select_settings_field() - create an image select field for VC
=================================================================================================================
*/
if (function_exists('vc_add_shortcode_param')) {
vc_add_shortcode_param( 'uber_wpb_vc_img_select', 'uber_wpb_vc_img_select_settings_field' );
	if( !function_exists( "uber_wpb_vc_img_select_settings_field" ) ){
		function uber_wpb_vc_img_select_settings_field( $settings, $value ) {
			$ul_html='';
			if(is_array ($settings['value'])){
				
				$ul_html.='<ul class="uberwpb-vc-img-select">';
				
				foreach($settings['value'] as $img=>$val){
					$selected = ($val == $value) ? ' class="selected"' : '';
					$ul_html.= '<li class="vc_col-sm-3 vc_col-xs-6"><a'.$selected.' data-value='. esc_attr($val).' href="#"><img src="'. esc_url($img).'"/></a></li>';
				}
				$ul_html.='</ul>';
					
			} 

			$return = '<div class="uber_wpb_vc_img_select_block '.esc_attr( $settings['param_name'] ) .'">'
					 .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
					 esc_attr( $settings['param_name'] ) . ' ' .
					 esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />' .
					 $ul_html // $ul_html escaped above
				 .'</div>';
			return $return;
		}
	}
}
/*
=================================================================================================================
uber_wpb_vc_templates_dir() - Define VC default templates override directory
=================================================================================================================
*/
// Before VC Init
add_action( 'vc_before_init', 'uber_wpb_vc_templates_dir' );
if( !function_exists( "uber_wpb_vc_templates_dir" ) ){
	function uber_wpb_vc_templates_dir() {
		if( function_exists('vc_set_shortcodes_templates_dir') ){ 
			vc_set_shortcodes_templates_dir( UBER_WPB_PLUGIN_DIR . '/vc_extend/' );    
		}
	}
}
/*
=================================================================================================================
uber_wpb_vc_add_new_params() - Add new params to some default VC blocks
=================================================================================================================
*/
// After VC Init
add_action( 'vc_after_init', 'uber_wpb_vc_add_new_params' );
if( !function_exists( "uber_wpb_vc_add_new_params" ) ){
function uber_wpb_vc_add_new_params() {
	
	global $uber_wpb_options;		

		$theme_main_font = !empty ( $uber_wpb_options['ctypography']["font-family"] ) ? $uber_wpb_options['ctypography']["font-family"] : '';
		$is_google = !empty( $uber_wpb_options['ctypography']["google"] ) ? $uber_wpb_options['ctypography']["google"] : '';
		$theme_main_font_array = uber_wpb_theme_options_font_weights( $theme_main_font , $is_google );
		$theme_main_font_show = $theme_main_font ? ' (' . $theme_main_font . ')' :  esc_html__( ' (None)', 'uber-wpbakery-addons' );

		$theme_main_font2 = !empty ( $uber_wpb_options['ctypography2']["font-family"] ) ? $uber_wpb_options['ctypography2']["font-family"] : '';
		$is_google2 = !empty( $uber_wpb_options['ctypography2']["google"] ) ? $uber_wpb_options['ctypography2']["google"] : '';
		$theme_main_font_array2 = uber_wpb_theme_options_font_weights( $theme_main_font2 , $is_google2 );
		$theme_main_font2_show = $theme_main_font2 ? ' (' . $theme_main_font2 . ')' :  esc_html__( ' (None)', 'uber-wpbakery-addons' );	

	//Modify VC Single Image block
	$params_image = array(
		array(
			'type' => 'uber_wpb_attach_image',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'heading' => esc_html__( 'Image', 'uber-wpbakery-addons' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'media_library',
			),
			'param_name' => 'image',
			'description' => esc_html__( 'Choose image source.', 'uber-wpbakery-addons' ),
			'weight' => 1,
			"admin_label" => true,
		),		
	);
	vc_add_params( 'vc_single_image', $params_image );
   
  
   //Modify VC Single Image block settings in admin
    $settings_image = array (
		'admin_enqueue_js' =>  array( UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom_view.js' ),
		'js_view' => 'VcCustomElementView',
		'custom_markup' => '<div class="vc_custom-element-container"><span data-src="{{ params.image }}"></span><span data-src="{{ params.custom_src }}"></span></div>'
	);
	vc_map_update( 'vc_single_image',$settings_image );

	//row params
    $params_section = array(
         		

		//responsive options
		//paddings/margins
		
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 1200px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_row_1200',
			'group' => 'Responsive options',
			'description' => esc_html__( 'Add margin/padding to this row up to 1200px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),		
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 992px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_row_992',
			'group' => 'Responsive options',
			'description' => esc_html__( 'Add margin/padding to this row up to 992px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),		
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 768px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_row_768',
			'group' => 'Responsive options',
			'description' => esc_html__( 'Add margin/padding to this row up to 768px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),			
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 480px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_row_480',
			'group' => 'Responsive options',
			'description' => esc_html__( 'Add margin/padding to this row up to 480px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),		
		
		//1200px
		array(
			"type" => "uber_wpb_vc_separator",
			"group" => "Responsive options",
			"title" => "Large Devices, Wide Screens - up to 1200px",
			"param_name" => "separator_responsive4",
			'class' => 'fancy-line',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),		
		array(
            'type' => 'colorpicker',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background color', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_color_1200',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background color for this breakpoint', 'uber-wpbakery-addons' )
        ),		
		array(
            'type' => 'attach_image',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background image', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_1200',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background image for this breakpoint', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Left Top', 'uber-wpbakery-addons' ) => 'left top',
				esc_html__( 'Left Center', 'uber-wpbakery-addons' ) => 'left center',
				esc_html__( 'Left Bottom', 'uber-wpbakery-addons' ) => 'left bottom',
				esc_html__( 'Right Top', 'uber-wpbakery-addons' ) => 'right top',
				esc_html__( 'Right Center', 'uber-wpbakery-addons' ) => 'right center',
				esc_html__( 'Right Bottom', 'uber-wpbakery-addons' ) => 'right bottom',
				esc_html__( 'Center Top', 'uber-wpbakery-addons' ) => 'center top',
				esc_html__( 'Center Center', 'uber-wpbakery-addons' ) => 'center center',
				esc_html__( 'Center Bottom', 'uber-wpbakery-addons' ) => 'center bottom',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_pos_1200',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),		
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background repeat', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Repeat', 'uber-wpbakery-addons' ) => 'repeat',
				esc_html__( 'Repeat-x', 'uber-wpbakery-addons' ) => 'repeat-x',
				esc_html__( 'Repeat-y', 'uber-wpbakery-addons' ) => 'repeat-y',
				esc_html__( 'No-Repeat', 'uber-wpbakery-addons' ) => 'no-repeat',
				esc_html__( 'Initial', 'uber-wpbakery-addons' ) => 'initial',
				esc_html__( 'Inherit', 'uber-wpbakery-addons' ) => 'inherit',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_rep_1200',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),		
		
		
		//992px
		array(
			"type" => "uber_wpb_vc_separator",
			"group" => "Responsive options",
			"title" => "Medium Devices, Desktops - up to 992px",
			"param_name" => "separator_responsive3",
			'class' => 'fancy-line',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),		
		array(
            'type' => 'colorpicker',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background color', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_color_992',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background color for this breakpoint', 'uber-wpbakery-addons' )
        ),		
		array(
            'type' => 'attach_image',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background image', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_992',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background image for this breakpoint', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Left Top', 'uber-wpbakery-addons' ) => 'left top',
				esc_html__( 'Left Center', 'uber-wpbakery-addons' ) => 'left center',
				esc_html__( 'Left Bottom', 'uber-wpbakery-addons' ) => 'left bottom',
				esc_html__( 'Right Top', 'uber-wpbakery-addons' ) => 'right top',
				esc_html__( 'Right Center', 'uber-wpbakery-addons' ) => 'right center',
				esc_html__( 'Right Bottom', 'uber-wpbakery-addons' ) => 'right bottom',
				esc_html__( 'Center Top', 'uber-wpbakery-addons' ) => 'center top',
				esc_html__( 'Center Center', 'uber-wpbakery-addons' ) => 'center center',
				esc_html__( 'Center Bottom', 'uber-wpbakery-addons' ) => 'center bottom',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_pos_992',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),		
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background repeat', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Repeat', 'uber-wpbakery-addons' ) => 'repeat',
				esc_html__( 'Repeat-x', 'uber-wpbakery-addons' ) => 'repeat-x',
				esc_html__( 'Repeat-y', 'uber-wpbakery-addons' ) => 'repeat-y',
				esc_html__( 'No-Repeat', 'uber-wpbakery-addons' ) => 'no-repeat',
				esc_html__( 'Initial', 'uber-wpbakery-addons' ) => 'initial',
				esc_html__( 'Inherit', 'uber-wpbakery-addons' ) => 'inherit',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_rep_992',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),
		
		
		//768px
		array(
			"type" => "uber_wpb_vc_separator",
			"group" => "Responsive options",
			"title" => "Small Devices, Tablets - up to 768px",
			"param_name" => "separator_responsive2",
			'class' => 'fancy-line',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),		
		array(
            'type' => 'colorpicker',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background color', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_color_768',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background color for this breakpoint', 'uber-wpbakery-addons' )
        ),		
		array(
            'type' => 'attach_image',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background image', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_768',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background image for this breakpoint', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Left Top', 'uber-wpbakery-addons' ) => 'left top',
				esc_html__( 'Left Center', 'uber-wpbakery-addons' ) => 'left center',
				esc_html__( 'Left Bottom', 'uber-wpbakery-addons' ) => 'left bottom',
				esc_html__( 'Right Top', 'uber-wpbakery-addons' ) => 'right top',
				esc_html__( 'Right Center', 'uber-wpbakery-addons' ) => 'right center',
				esc_html__( 'Right Bottom', 'uber-wpbakery-addons' ) => 'right bottom',
				esc_html__( 'Center Top', 'uber-wpbakery-addons' ) => 'center top',
				esc_html__( 'Center Center', 'uber-wpbakery-addons' ) => 'center center',
				esc_html__( 'Center Bottom', 'uber-wpbakery-addons' ) => 'center bottom',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_pos_768',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),		
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background repeat', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Repeat', 'uber-wpbakery-addons' ) => 'repeat',
				esc_html__( 'Repeat-x', 'uber-wpbakery-addons' ) => 'repeat-x',
				esc_html__( 'Repeat-y', 'uber-wpbakery-addons' ) => 'repeat-y',
				esc_html__( 'No-Repeat', 'uber-wpbakery-addons' ) => 'no-repeat',
				esc_html__( 'Initial', 'uber-wpbakery-addons' ) => 'initial',
				esc_html__( 'Inherit', 'uber-wpbakery-addons' ) => 'inherit',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_rep_768',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),			
		
		
		//480px
		array(
			"type" => "uber_wpb_vc_separator",
			"group" => "Responsive options",
			"title" => "Extra Small Devices, Phones - up to 480px",
			"param_name" => "separator_responsive1",
			'class' => 'fancy-line',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),		
		array(
            'type' => 'colorpicker',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background color', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_color_480',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background color for this breakpoint', 'uber-wpbakery-addons' )
        ),		
		array(
            'type' => 'attach_image',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background image', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_480',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background image for this breakpoint', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Left Top', 'uber-wpbakery-addons' ) => 'left top',
				esc_html__( 'Left Center', 'uber-wpbakery-addons' ) => 'left center',
				esc_html__( 'Left Bottom', 'uber-wpbakery-addons' ) => 'left bottom',
				esc_html__( 'Right Top', 'uber-wpbakery-addons' ) => 'right top',
				esc_html__( 'Right Center', 'uber-wpbakery-addons' ) => 'right center',
				esc_html__( 'Right Bottom', 'uber-wpbakery-addons' ) => 'right bottom',
				esc_html__( 'Center Top', 'uber-wpbakery-addons' ) => 'center top',
				esc_html__( 'Center Center', 'uber-wpbakery-addons' ) => 'center center',
				esc_html__( 'Center Bottom', 'uber-wpbakery-addons' ) => 'center bottom',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_pos_480',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),		
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background repeat', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Repeat', 'uber-wpbakery-addons' ) => 'repeat',
				esc_html__( 'Repeat-x', 'uber-wpbakery-addons' ) => 'repeat-x',
				esc_html__( 'Repeat-y', 'uber-wpbakery-addons' ) => 'repeat-y',
				esc_html__( 'No-Repeat', 'uber-wpbakery-addons' ) => 'no-repeat',
				esc_html__( 'Initial', 'uber-wpbakery-addons' ) => 'initial',
				esc_html__( 'Inherit', 'uber-wpbakery-addons' ) => 'inherit',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_rep_480',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),			
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Left Top', 'uber-wpbakery-addons' ) => 'left top',
				esc_html__( 'Left Center', 'uber-wpbakery-addons' ) => 'left center',
				esc_html__( 'Left Bottom', 'uber-wpbakery-addons' ) => 'left bottom',
				esc_html__( 'Right Top', 'uber-wpbakery-addons' ) => 'right top',
				esc_html__( 'Right Center', 'uber-wpbakery-addons' ) => 'right center',
				esc_html__( 'Right Bottom', 'uber-wpbakery-addons' ) => 'right bottom',
				esc_html__( 'Center Top', 'uber-wpbakery-addons' ) => 'center top',
				esc_html__( 'Center Center', 'uber-wpbakery-addons' ) => 'center center',
				esc_html__( 'Center Bottom', 'uber-wpbakery-addons' ) => 'center bottom',
			),
			'std' => '',
			'param_name' => 'uber_wpb_row_background_position',
			'group' => 'Design Options',
		),
		
    );
	
	//row params
    $params_row = array(
             
		array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Label name', 'uber-wpbakery-addons' ),
            'param_name' => 'full_page_label',
            'description' => esc_html__( 'If you make a full page from Pages > Page Options > Full Page, here is where you put the label.', 'uber-wpbakery-addons' ),
            'admin_label' => true,
            'weight' => 996,
			"group" => "Full page",
        ),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Dark navigation bullets?', 'uber-wpbakery-addons' ),
			'param_name' => 'full_page_dark',
			'value' => array( esc_html__( 'Yes', 'uber-wpbakery-addons' ) => 'yes' ),
			'description' => esc_html__( 'By default the navigation bullets are white for each slide. If checked, it will make the bullets navigation black for this specific slide.', 'uber-wpbakery-addons' ),	"group" => "Full page",			
		),		

		//responsive options

		//paddings/margins
		
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 1200px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_row_1200',
			'group' => 'Responsive options',
			'description' => esc_html__( 'Add margin/padding to this row up to 1200px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),		
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 992px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_row_992',
			'group' => 'Responsive options',
			'description' => esc_html__( 'Add margin/padding to this row up to 992px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),		
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 768px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_row_768',
			'group' => 'Responsive options',
			'description' => esc_html__( 'Add margin/padding to this row up to 768px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),			
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 480px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_row_480',
			'group' => 'Responsive options',
			'description' => esc_html__( 'Add margin/padding to this row up to 480px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),		
		
		//1200px
		array(
			"type" => "uber_wpb_vc_separator",
			"group" => "Responsive options",
			"title" => "Large Devices, Wide Screens - up to 1200px",
			"param_name" => "separator_responsive4",
			'class' => 'fancy-line',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),		
		array(
            'type' => 'colorpicker',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background color', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_color_1200',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background color for this breakpoint', 'uber-wpbakery-addons' )
        ),		
		array(
            'type' => 'attach_image',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background image', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_1200',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background image for this breakpoint', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Left Top', 'uber-wpbakery-addons' ) => 'left top',
				esc_html__( 'Left Center', 'uber-wpbakery-addons' ) => 'left center',
				esc_html__( 'Left Bottom', 'uber-wpbakery-addons' ) => 'left bottom',
				esc_html__( 'Right Top', 'uber-wpbakery-addons' ) => 'right top',
				esc_html__( 'Right Center', 'uber-wpbakery-addons' ) => 'right center',
				esc_html__( 'Right Bottom', 'uber-wpbakery-addons' ) => 'right bottom',
				esc_html__( 'Center Top', 'uber-wpbakery-addons' ) => 'center top',
				esc_html__( 'Center Center', 'uber-wpbakery-addons' ) => 'center center',
				esc_html__( 'Center Bottom', 'uber-wpbakery-addons' ) => 'center bottom',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_pos_1200',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),		
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background repeat', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Repeat', 'uber-wpbakery-addons' ) => 'repeat',
				esc_html__( 'Repeat-x', 'uber-wpbakery-addons' ) => 'repeat-x',
				esc_html__( 'Repeat-y', 'uber-wpbakery-addons' ) => 'repeat-y',
				esc_html__( 'No-Repeat', 'uber-wpbakery-addons' ) => 'no-repeat',
				esc_html__( 'Initial', 'uber-wpbakery-addons' ) => 'initial',
				esc_html__( 'Inherit', 'uber-wpbakery-addons' ) => 'inherit',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_rep_1200',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),		
		
		
		//992px
		array(
			"type" => "uber_wpb_vc_separator",
			"group" => "Responsive options",
			"title" => "Medium Devices, Desktops - up to 992px",
			"param_name" => "separator_responsive3",
			'class' => 'fancy-line',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),		
		array(
            'type' => 'colorpicker',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background color', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_color_992',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background color for this breakpoint', 'uber-wpbakery-addons' )
        ),		
		array(
            'type' => 'attach_image',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background image', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_992',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background image for this breakpoint', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Left Top', 'uber-wpbakery-addons' ) => 'left top',
				esc_html__( 'Left Center', 'uber-wpbakery-addons' ) => 'left center',
				esc_html__( 'Left Bottom', 'uber-wpbakery-addons' ) => 'left bottom',
				esc_html__( 'Right Top', 'uber-wpbakery-addons' ) => 'right top',
				esc_html__( 'Right Center', 'uber-wpbakery-addons' ) => 'right center',
				esc_html__( 'Right Bottom', 'uber-wpbakery-addons' ) => 'right bottom',
				esc_html__( 'Center Top', 'uber-wpbakery-addons' ) => 'center top',
				esc_html__( 'Center Center', 'uber-wpbakery-addons' ) => 'center center',
				esc_html__( 'Center Bottom', 'uber-wpbakery-addons' ) => 'center bottom',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_pos_992',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),		
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background repeat', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Repeat', 'uber-wpbakery-addons' ) => 'repeat',
				esc_html__( 'Repeat-x', 'uber-wpbakery-addons' ) => 'repeat-x',
				esc_html__( 'Repeat-y', 'uber-wpbakery-addons' ) => 'repeat-y',
				esc_html__( 'No-Repeat', 'uber-wpbakery-addons' ) => 'no-repeat',
				esc_html__( 'Initial', 'uber-wpbakery-addons' ) => 'initial',
				esc_html__( 'Inherit', 'uber-wpbakery-addons' ) => 'inherit',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_rep_992',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),
		
		
		//768px
		array(
			"type" => "uber_wpb_vc_separator",
			"group" => "Responsive options",
			"title" => "Small Devices, Tablets - up to 768px",
			"param_name" => "separator_responsive2",
			'class' => 'fancy-line',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),		
		array(
            'type' => 'colorpicker',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background color', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_color_768',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background color for this breakpoint', 'uber-wpbakery-addons' )
        ),		
		array(
            'type' => 'attach_image',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background image', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_768',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background image for this breakpoint', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Left Top', 'uber-wpbakery-addons' ) => 'left top',
				esc_html__( 'Left Center', 'uber-wpbakery-addons' ) => 'left center',
				esc_html__( 'Left Bottom', 'uber-wpbakery-addons' ) => 'left bottom',
				esc_html__( 'Right Top', 'uber-wpbakery-addons' ) => 'right top',
				esc_html__( 'Right Center', 'uber-wpbakery-addons' ) => 'right center',
				esc_html__( 'Right Bottom', 'uber-wpbakery-addons' ) => 'right bottom',
				esc_html__( 'Center Top', 'uber-wpbakery-addons' ) => 'center top',
				esc_html__( 'Center Center', 'uber-wpbakery-addons' ) => 'center center',
				esc_html__( 'Center Bottom', 'uber-wpbakery-addons' ) => 'center bottom',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_pos_768',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),		
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background repeat', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Repeat', 'uber-wpbakery-addons' ) => 'repeat',
				esc_html__( 'Repeat-x', 'uber-wpbakery-addons' ) => 'repeat-x',
				esc_html__( 'Repeat-y', 'uber-wpbakery-addons' ) => 'repeat-y',
				esc_html__( 'No-Repeat', 'uber-wpbakery-addons' ) => 'no-repeat',
				esc_html__( 'Initial', 'uber-wpbakery-addons' ) => 'initial',
				esc_html__( 'Inherit', 'uber-wpbakery-addons' ) => 'inherit',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_rep_768',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),			
		
		
		//480px
		array(
			"type" => "uber_wpb_vc_separator",
			"group" => "Responsive options",
			"title" => "Extra Small Devices, Phones - up to 480px",
			"param_name" => "separator_responsive1",
			'class' => 'fancy-line',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),		
		array(
            'type' => 'colorpicker',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background color', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_color_480',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background color for this breakpoint', 'uber-wpbakery-addons' )
        ),		
		array(
            'type' => 'attach_image',
			'group' => 'Responsive options',
            'heading' => esc_html__( 'Background image', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_bg_480',
            
			'edit_field_class' => 'vc_col-sm-3 vc_column',
            'description' => esc_html__( 'Add new background image for this breakpoint', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Left Top', 'uber-wpbakery-addons' ) => 'left top',
				esc_html__( 'Left Center', 'uber-wpbakery-addons' ) => 'left center',
				esc_html__( 'Left Bottom', 'uber-wpbakery-addons' ) => 'left bottom',
				esc_html__( 'Right Top', 'uber-wpbakery-addons' ) => 'right top',
				esc_html__( 'Right Center', 'uber-wpbakery-addons' ) => 'right center',
				esc_html__( 'Right Bottom', 'uber-wpbakery-addons' ) => 'right bottom',
				esc_html__( 'Center Top', 'uber-wpbakery-addons' ) => 'center top',
				esc_html__( 'Center Center', 'uber-wpbakery-addons' ) => 'center center',
				esc_html__( 'Center Bottom', 'uber-wpbakery-addons' ) => 'center bottom',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_pos_480',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),		
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background repeat', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Repeat', 'uber-wpbakery-addons' ) => 'repeat',
				esc_html__( 'Repeat-x', 'uber-wpbakery-addons' ) => 'repeat-x',
				esc_html__( 'Repeat-y', 'uber-wpbakery-addons' ) => 'repeat-y',
				esc_html__( 'No-Repeat', 'uber-wpbakery-addons' ) => 'no-repeat',
				esc_html__( 'Initial', 'uber-wpbakery-addons' ) => 'initial',
				esc_html__( 'Inherit', 'uber-wpbakery-addons' ) => 'inherit',
			),
			'std' => '',
			'param_name' => 'uber_wpb_bg_rep_480',
			'group' => 'Responsive options',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),
		array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Div ID', 'uber-wpbakery-addons' ),
            'param_name' => 'el_id',           
			'edit_field_class' => 'vc_col-sm-12 vc_column',
            'description' => esc_html__( 'Add HTML Div ID. Enter it here, and then go to Appearance > Menus and add the same ID you just added here with a # in front. I.e #example.', 'uber-wpbakery-addons' )
        ),				
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Left Top', 'uber-wpbakery-addons' ) => 'left top',
				esc_html__( 'Left Center', 'uber-wpbakery-addons' ) => 'left center',
				esc_html__( 'Left Bottom', 'uber-wpbakery-addons' ) => 'left bottom',
				esc_html__( 'Right Top', 'uber-wpbakery-addons' ) => 'right top',
				esc_html__( 'Right Center', 'uber-wpbakery-addons' ) => 'right center',
				esc_html__( 'Right Bottom', 'uber-wpbakery-addons' ) => 'right bottom',
				esc_html__( 'Center Top', 'uber-wpbakery-addons' ) => 'center top',
				esc_html__( 'Center Center', 'uber-wpbakery-addons' ) => 'center center',
				esc_html__( 'Center Bottom', 'uber-wpbakery-addons' ) => 'center bottom',
			),
			'std' => '',
			'param_name' => 'uber_wpb_row_background_position',
			'group' => 'Design Options',
		),
		
    );

	//column params
	$params_column = array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Left Top', 'uber-wpbakery-addons' ) => 'left top',
				esc_html__( 'Left Center', 'uber-wpbakery-addons' ) => 'left center',
				esc_html__( 'Left Bottom', 'uber-wpbakery-addons' ) => 'left bottom',
				esc_html__( 'Right Top', 'uber-wpbakery-addons' ) => 'right top',
				esc_html__( 'Right Center', 'uber-wpbakery-addons' ) => 'right center',
				esc_html__( 'Right Bottom', 'uber-wpbakery-addons' ) => 'right bottom',
				esc_html__( 'Center Top', 'uber-wpbakery-addons' ) => 'center top',
				esc_html__( 'Center Center', 'uber-wpbakery-addons' ) => 'center center',
				esc_html__( 'Center Bottom', 'uber-wpbakery-addons' ) => 'center bottom',
			),
			'std' => '',
			'param_name' => 'uber_wpb_column_background_position',
			'group' => 'Design Options',
		),	
        array(
            "type" => "uber_wpb_vc_separator",
            "param_name" => "separator1",
			'std' => 'fancy-line',
			'title' => 'Custom border radius',
			'group' => 'Design Options',
			'description' => esc_html__( 'Please note that in order for this options to work, the border radius option above, must be set to None.', 'uber-wpbakery-addons' )
        ),	
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'group' => 'Design Options',
			'heading' => esc_html__( 'Border radius', 'uber-wpbakery-addons' ),
			'param_name' => 'uber_wpb_border_radius',
			'description' => esc_html__( 'Add border radius to this column. I.e 15px or 15px 10px 4px 7px. All units allowed px, em, rem etc.', 'uber-wpbakery-addons' )
		),
		
		//paddings/margins
		
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 1200px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_col_1200',
			'group' => 'Responsive Options',
			'description' => esc_html__( 'Add margin/padding to this row column to 1200px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),		
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 992px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_col_992',
			'group' => 'Responsive Options',
			'description' => esc_html__( 'Add margin/padding to this row column to 992px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),		
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 768px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_col_768',
			'group' => 'Responsive Options',
			'description' => esc_html__( 'Add margin/padding to this row column to 768px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),			
		array(
			'type' => 'uber_wpb_vc_responsive_box',
			'heading' => esc_html__( 'Up to 480px', 'uber-wpbakery-addons' ),
			'std' => '',
			'param_name' => 'uber_wpb_col_480',
			'group' => 'Responsive Options',
			'description' => esc_html__( 'Add margin/padding to this column up to 480px. Ie 10px 2em etc.', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_col-lg-3 vc_column',
		),			
	);

	$only_for_row = array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Slide direction', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'Vertical', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Horizontal', 'uber-wpbakery-addons' ) => 'horizontal',
			),
			'std' => '',
			'param_name' => 'full_page_slider_direction',
			'description' => esc_html__( 'Choose direction of the slide, horizontal or vertical. Note: For horizontal slides you need at least 2 consecutive slides to be set as horizontal in order to work.', 'uber-wpbakery-addons' ),
			"group" => 'Full page'
		),	
	);	
	
	$vc_row = array_merge($only_for_row,$params_row);
	
	
	$only_for_inner_row = array(
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'No column paddings', 'uber-wpbakery-addons' ),
            'param_name' => 'uber_wpb_columns_no_paddings',
            'description' => esc_html__( 'No paddings in columns of this inner row.', 'uber-wpbakery-addons' ),
            'weight' => 998,
        ),   
	);
	
	$vc_row_inner = array_merge($only_for_inner_row,$params_row);
	
	
	$empty_space_params = array(
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => 'Responsive Options',
			'heading' => esc_html__( 'Up to 1200px height', 'uber-wpbakery-addons' ),
			'param_name' => 'space_1200',
			'admin_label' => true,
			'description' => esc_html__( 'Enter height of this spacer up to 1200px screen resolution ( I.e 3px, 10em )', 'uber-wpbakery-addons' )
		),		
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => 'Responsive Options',
			'heading' => esc_html__( 'Up to 992px height', 'uber-wpbakery-addons' ),
			'param_name' => 'space_992',
			'admin_label' => true,
			'description' => esc_html__( 'Enter height of this spacer up to 992px screen resolution ( I.e 3px, 10em )', 'uber-wpbakery-addons' )
		),		
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => 'Responsive Options',
			'heading' => esc_html__( 'Up to 768px height', 'uber-wpbakery-addons' ),
			'param_name' => 'space_768',
			'admin_label' => true,
			'description' => esc_html__( 'Enter height of this spacer up to 768px screen resolution ( I.e 3px, 10em )', 'uber-wpbakery-addons' )
		),			
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => 'Responsive Options',
			'heading' => esc_html__( 'Up to 480px height', 'uber-wpbakery-addons' ),
			'param_name' => 'space_480',
			'admin_label' => true,
			'description' => esc_html__( 'Enter height of this spacer up to 480px screen resolution ( I.e 3px, 10em )', 'uber-wpbakery-addons' )
		),	  
	);	

	
	$progress_bar_params = array(
		array(
			'type' => 'dropdown',
			'heading' => "Style",
			'param_name' => 'style',
			'value' => array(
				esc_html__( 'Theme', 'uber-wpbakery-addons' ) => 'theme',
				esc_html__( 'Visual Composer', 'uber-wpbakery-addons' ) => '',

			),
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'std' => 'theme',
			'description' => esc_html__( "Display style", "js_composer" ),
			'weight' => 1,
			),
		array(
			"type" => "colorpicker",
			"heading" => esc_html__( "Units color", "js_composer" ),
			"param_name" => "uber_wpb_units_color",
			'dependency' => array(
				'element' => 'style',
				'value' => array('theme'),
			),	
			"value" => '', //Default color
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			"description" => esc_html__( "Units text color", "js_composer" ),
			'weight' => 2,
			),	
			array(
			"type" => "colorpicker",
			"heading" => esc_html__( "Bar background", "js_composer" ),
			"param_name" => "uber_wpb_regular_bg",
			'dependency' => array(
				'element' => 'style',
				'value' => array('theme'),
			),	
			"value" => '', //Default color
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			"description" => esc_html__( "This is the bar holder background. To change the progress bar background go to Color option bellow.", "js_composer" ),
			'weight' => 3,
			),
		
		array(
			"type" => "uber_wpb_vc_separator",
			"param_name" => "separator",
			'title' => 'Text',
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
			'param_name' => 'uber_wpb_h_font_selector',
			'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
		),		
		
		array(
			'type' => 'google_fonts',
			'group' => 'Typography',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'uber_wpb_h_font',
			'value' => '',// Not recommended, this will override 'settings'. Example:
			'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
						bold italic:900:italic'),
			'settings' => array(
							 
							 'no_font_style'=>true 
					),
			'dependency' => array(
				'element' => 'uber_wpb_h_font_selector',
				'value' => 'googlefont',
				),					
			'description' => esc_html__( 'Choose Font', 'uber-wpbakery-addons' ), // Description for field group
		),
		array(
			"type" => "uber_wpb_vc_separator",
			"param_name" => "separator2",
			'title' => 'Units',
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
			'param_name' => 'uber_wpb_p_font_selector',
			'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
		),		
		
		array(
			'type' => 'google_fonts',
			'group' => 'Typography',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'uber_wpb_p_font',
			'value' => '',// Not recommended, this will override 'settings'. Example:
			'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
						bold italic:900:italic'),
			'settings' => array(
							 
							 'no_font_style'=>true 
					),
			'dependency' => array(
				'element' => 'uber_wpb_p_font_selector',
				'value' => 'googlefont',
				),					
			'description' => esc_html__( 'Choose Font', 'uber-wpbakery-addons' ), // Description for field group
		),			
	);

	//Add new params to section, same as to row
	vc_add_params( 'vc_section', $params_section ); 
	
	//Add new params to row
	vc_add_params( 'vc_row', $vc_row );         
	vc_add_params( 'vc_row_inner', $vc_row_inner );     
	
	//Add new params to column	
	vc_add_params( 'vc_column', $params_column );         
	vc_add_params( 'vc_column_inner', $params_column ); 	
	
	//Add new params to empty space	
	vc_add_params( 'vc_empty_space', $empty_space_params );

	//add new params to progress bar
	vc_add_params( 'vc_progress_bar', $progress_bar_params ); 	       
}
}

/*
=================================================================================================================
Function uber_wpb_vc_animations() - WOW animations for VC
=================================================================================================================
*/
if (function_exists('vc_add_shortcode_param')) {
vc_add_shortcode_param( 'uber_wpb_vc_animations_in', 'uber_wpb_vc_animations_field' );

if ( !function_exists('uber_wpb_vc_animations_field') ) {
function uber_wpb_vc_animations_field($settings , $value ){
$html='';

$all_uber_wpb_animations_in =  array(
								'Fading Entrances' => array(
									'fadeIn' => 'fadeIn',
									'fadeInDown' => 'fadeInDown',
									'fadeInDownBig' => 'fadeInDownBig',
									'fadeInLeft' => 'fadeInLeft',
									'fadeInLeftBig' => 'fadeInLeftBig',
									'fadeInRight' => 'fadeInRight',
									'fadeInRightBig' => 'fadeInRightBig',
									'fadeInUp' => 'fadeInUp',
									'fadeInUpBig' => 'fadeInUpBig',
								),								
								'Bouncing Entrances' => array(
									'bounceIn' => 'bounceIn',
									'bounceInDown' => 'bounceInDown',
									'bounceInLeft' => 'bounceInLeft',
									'bounceInRight' => 'bounceInRight',
									'bounceInUp' => 'bounceInUp',

								),
								'Flippers' => array(
									'flip' => 'flip',
									'flipInX' => 'flipInX',
									'flipInY' => 'flipInY',
								),
								'Lightspeed' => array(
									'lightSpeedIn' => 'lightSpeedIn',
								),
								'Rotating Entrances' => array(
									'rotateIn' => 'rotateIn',
									'rotateInDownLeft' => 'rotateInDownLeft',
									'rotateInDownRight' => 'rotateInDownRight',
									'rotateInUpLeft' => 'rotateInUpLeft',
									'rotateInUpRight' => 'rotateInUpRight',
								),
								'Sliding Entrances' => array(
									'slideInUp' => 'slideInUp',
									'slideInDown' => 'slideInDown',
									'slideInLeft' => 'slideInLeft',
									'slideInRight' => 'slideInRight',
								),
								'Zoom Entrances' => array(
									'zoomIn' => 'zoomIn',
									'zoomInDown' => 'zoomInDown',
									'zoomInLeft' => 'zoomInLeft',
									'zoomInRight' => 'zoomInRight',
									'zoomInUp' => 'zoomInUp',
								),
								'Specials' => array(
									'rollIn' => 'rollIn',
								),
								'Attention Seekers' => array(
									'bounce' => 'bounce',
									'flash' => 'flash',
									'pulse' => 'pulse',
									'rubberBand' => 'rubberBand',
									'shake' => 'shake',
									'swing' => 'swing',
									'tada' => 'tada',
									'wobble' => 'wobble',
									'jello' => 'jello',
								),								

							);
				


	foreach($all_uber_wpb_animations_in as $group => $all_uber_wpb_animations_group){
		$html.= '<optgroup label="'.esc_attr( $group ).'">';
			
			foreach($all_uber_wpb_animations_group as $animation){
				$selected = ($value == $animation) ? 'selected' : '';
				$html.= '<option '.$selected.' value="'.esc_attr( $animation ).'">'.esc_html( $animation ).'</option>';
			}
			
		$html.= '</optgroup>';
	}	

	$return = '<div class="uber_wpb_vc_animations_field '.esc_attr( $settings['param_name'] ) .'">'
             .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value uber_wpb_vc_animations_field wpb-textinput ' 
             .esc_attr( $settings['param_name'] ) . ' ' 
             .esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />'
				.'<select class="wpb_vc_param_value uber_wpb_vc_animations_field wpb-textinput ' 
             .esc_attr( $settings['param_name'] ) . ' ' 
             .esc_attr( $settings['type'] ) . '_field" name="uber_wpb_vc_animations_select">'.$html.'</select>' //$html is escaped above
         .'</div>';
	return $return;	
}
}
}

/*
=================================================================================================================
Function uber_wpb_vc_msg_funct() - WOW message for VC 
=================================================================================================================
*/
if ( function_exists( 'vc_add_shortcode_param' ) ) {
vc_add_shortcode_param( 'uber_wpb_vc_msg', 'uber_wpb_vc_msg_funct' );
	if ( !function_exists('uber_wpb_vc_msg_funct') ) {
		function uber_wpb_vc_msg_funct( $settings , $value ){
			
			$return.= '<div class="'.esc_attr( $settings['param_name'] ) .'">'
						 .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput  '
						 .esc_attr( $settings['param_name'] ) . ' '
						 .esc_attr( $settings['type'] ) . '_field" type="hidden"  />' 
				 .'</div>';	
				 
			return $return;	
		}
	}
}


/*
=================================================================================================================
Function uber_wpb_vc_separator_funct() - WOW separator for VC used in admin mainly for design
=================================================================================================================
*/
if ( function_exists( 'vc_add_shortcode_param' ) ) {
vc_add_shortcode_param( 'uber_wpb_vc_separator', 'uber_wpb_vc_separator_funct' );
if ( !function_exists('uber_wpb_vc_separator_funct') ) {
		function uber_wpb_vc_separator_funct( $settings , $value ){
			
			$styling = $settings['title'] ? '<h2 class="uber_wpb_custom_admin_h2">'.esc_html( $settings['title'] ).'</h2><div class="'.esc_attr( $settings['class'] ).'"></div>' :  '<div class="'.esc_attr( $settings['class'] ).'"></div>';

			$return.= '<div class="uber_wpb_vc_separator_block '.esc_attr( $settings['param_name'] ) .'">'
						.$styling //$styling escaped above
				 .'</div>';

			$return.= '<div class="uber_wpb_vc_presets_block '.esc_attr( $settings['param_name'] ) .'">'
						 .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput  '
						 .esc_attr( $settings['param_name'] ) . ' '
						 .esc_attr( $settings['type'] ) . '_field" type="hidden"  />' 
						 .$html_out //$html_out escaped above
				 .'</div>';	
				 
			return $return;	
		}
	}
}

/*
=================================================================================================================
Function uber_wpb_vc_presets_preview() - Preview presets in VC
=================================================================================================================
*/
if (function_exists( 'vc_add_shortcode_param' ) ) {
vc_add_shortcode_param( 'uber_wpb_vc_presets', 'uber_wpb_vc_presets_preview' );
if ( !function_exists('uber_wpb_vc_presets_preview') ) {
function uber_wpb_vc_presets_preview($settings , $value ){
$html_out='';
$presets_thumbs = UBER_WPB_PLUGIN_URI.'vc_extend/thumbs/presets/';
$preset_id = 1;
	$on_row = $settings['on_row'] ? 12/$settings['on_row'] : 6;
	$html_out.= $settings['title'] ? '<h2 class="uber_wpb_vc_presets vc_col-sm-12">'.esc_attr( $settings['title'] ).'</h2>' :  '';
	$html_out.= $settings['info'] ? '<span class="uber_wpb_vc_presets_info vc_col-sm-12">'.$settings['info'].'</span>' :  ''; //escaped with esc_html__ on each VP BAKERY block that has preset info
	if( is_array( $settings['presets'] ) ){
		foreach( $settings['presets'] as $preset ){

			if( is_array($preset) ){
				
				$html_out.= '<div class="vc_col-sm-'.esc_attr( $on_row ).'"><!-- vc_col-sm -->';
					$html_out.= '<div class="uber_wpb_vc_presets_select"><!-- uber_wpb_vc_presets_select -->';
						$html_out.= '<div class="uber_wpb_preset_id"><!-- uber_wpb_preset_id -->
										
										<a href="#" class="uber_wpb_preset_id_link" data-id="'.esc_attr( $preset_id ).'">
											<img title="Preset Image" src="'.esc_url($presets_thumbs.$preset['img']).'"/>
											<h4>'.esc_attr( $preset['title'] ).'</h4>
										</a>
										
										<div class="uber_wpb_confirm_box"><!-- uber_wpb_confirm_box -->
											<h3>'.esc_html__('Are you sure?','uber-wpbakery-addons').'</h3>
											<p>'.esc_html__('Current data will be lost. I.e : Text, Colors, etc...','uber-wpbakery-addons').'</p>
											<div class="uber_wpb_confirm_box_buttons">
												<a href="#" data-do="no" class="vc_general vc_ui-button vc_ui-button-default vc_ui-button-shape-rounded">'.esc_html__('No','uber-wpbakery-addons').'</a>
												<a href="#" data-do="yes" class="vc_general vc_ui-button vc_ui-button-action vc_ui-button-shape-rounded">'.esc_html__('Yes','uber-wpbakery-addons').'</a>
											</div>
										</div><!--/ uber_wpb_confirm_box -->
									
									</div><!-- /uber_wpb_preset_id -->
									
									<div class="uber_wpb_vc_presets_description"><p>'.esc_attr( $preset['description'] ).'</p></div>
								
								</div><!-- /uber_wpb_vc_presets_select -->';

				$html_out.= '</div><!--/ vc_col-sm -->';
			}
			$preset_id++;
		}
	}
	$return.= '<div class="uber_wpb_vc_presets_block '.esc_attr( $settings['param_name'] ) .'">'
				 .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput  '
				 .esc_attr( $settings['param_name'] ) . ' '
				 .esc_attr( $settings['type'] ) . '_field" type="hidden"  />' 
				 .$html_out //$html_out escaped above
         .'</div>';	
	
	return $return;	
}
}
}

/*
=================================================================================================================
Function uber_wpb_vc_simple_list() - simple list fields in VC
=================================================================================================================
*/
if ( function_exists( 'vc_add_shortcode_param' ) ) {
vc_add_shortcode_param( 'uber_wpb_vc_simple_list', 'uber_wpb_vc_simple_list_func' );
if ( !function_exists('uber_wpb_vc_simple_list_func') ) {
function uber_wpb_vc_simple_list_func( $settings, $value ) {
$list_fields=$icon=$list_all=$general_icon=$general_color='';	

	if( empty($value) ){
		$value = '{"list0":{"text":"Viral chicharrones bespoke vhs","second_text":"299"},"general_icon":"","general_color":"","list1":{"text":"Cronut fanny pack","second_text":"130"},"list2":{"text":"Sriracha salvia listicle cold-pressed","second_text":"216"},"list3":{"text":"They sold out cray vaporware","second_text":"9090"},"list4":{"text":"Moon vice austin enamel pin chartreuse","second_text":"5718"},"list5":{"text":"Chia shaman williamsburg","second_text":"1548"}}';
	}

	if(!empty($value)){
		$list_all = json_decode($value,true);
		if (json_last_error() == 0){
			
				//get general icon and color
				if(array_key_exists ('general_icon',$list_all)){
					$general_icon = $list_all['general_icon'];
					unset($list_all['general_icon']);
				}
				
				if(array_key_exists ('general_color',$list_all)){
					$general_color =  ' style="background-color:'. esc_attr( $list_all['general_color'] ).'"';
					unset($list_all['general_color']);
				}
				
				foreach($list_all as $key => $val){
					$color='';
					$color_custom='';					
					$icon =  array_key_exists ('custom_icon',$val) ? ' custom '.$val['custom_icon'] : ' '.$general_icon;
					if(array_key_exists ('custom_color',$val)){
						$color = ' style="background-color:'. esc_attr( $val['custom_color'] ).'"';
						$color_custom = ' custom';
					}
					else{
						$color = $general_color;
					}
					
					$list_element = str_replace("list","",$key);
					
					$list_fields.= '
					<div class="uber_wpb_vc_list_values" data-list-element="'.esc_attr( $list_element ).'">
						<div class="vc_col-sm-4"><div class="wpb_element_label">'.esc_html__('Add your text','uber-wpbakery-addons').'</div><input name="uber_wpb_vc_list_desc[]" class="uber_wpb_vc_list_desc" type="text" value="'. esc_attr( $val['text'] ).'"/></div>
						<div class="vc_col-sm-3"><div class="wpb_element_label">'.esc_html__('Second text','uber-wpbakery-addons').'</div><input name="uber_wpb_vc_list_second_text[]" class="uber_wpb_vc_list_second_text" type="text" value="'. esc_attr( $val['second_text'] ).'"/></div>
						<div class="vc_col-sm-2">
							<div class="vc_col-sm-6"><div class="wpb_element_label">'.esc_html__('Icon','uber-wpbakery-addons').'</div><span class="uber_wpb_list_icon'. esc_attr( $icon ).'"></span></div>
							<div class="vc_col-sm-6" style="position:relative">
								<div class="wpb_element_label">'.esc_html__('Color','uber-wpbakery-addons').'</div>
								<span class="uber_wpb_list_color '. esc_attr( $color_custom ).'" '.$color //$color escaped above
								.'></span>
							<div class="list_color_picker">
								<input class="uberwpb-list-color-picker"></input>
							</div>

							</div>
						</div>
						<div class="vc_col-sm-1 uber_wpb_list_holder">
							<div class="wpb_element_label">Link</div>
							<div class="link_input_holder">
								<h2>'.esc_html__('Add / Edit link','uber-wpbakery-addons').'</h2>
								<input class="uberwpb-list-link" value="'. esc_attr( $val['url'] ).'"></input>								
								<a class="link_button save" href="#">'.esc_html__('Save','uber-wpbakery-addons').'</a>
							</div>
							<div class="link_holder"><a title="'.esc_html__('Click to add Link','uber-wpbakery-addons').'" class="link_plus" href="#"><i class="uberwpb-texteditor-link-alt"></i></a></div>
						</div>
						<div class="vc_col-sm-2"><a class="plus" href="#">+</a><a class="minus" href="#">-</a></div>
					</div>
					';
				}
		}			

	}

	$default = '<div class="uber_wpb_vc_list_values default">
					<div class="vc_col-sm-4"><div class="wpb_element_label">'.esc_html__('List element','uber-wpbakery-addons').'</div><input name="uber_wpb_vc_list_desc[]" class="uber_wpb_vc_list_desc" type="text" value=""/></div>
					<div class="vc_col-sm-3"><div class="wpb_element_label">'.esc_html__('Second text','uber-wpbakery-addons').'</div><input name="uber_wpb_vc_list_second_text[]" class="uber_wpb_vc_list_second_text" type="text" value=""/></div>
					<div class="vc_col-sm-2">
						<div class="vc_col-sm-6"><div class="wpb_element_label">'.esc_html__('Icon','uber-wpbakery-addons').'</div><span class="uber_wpb_list_icon"></span></div>
						<div class="vc_col-sm-6"  style="position:relative">
							<div class="wpb_element_label">'.esc_html__('Color','uber-wpbakery-addons').'</div>
							<span class="uber_wpb_list_color"></span>
							<div class="list_color_picker">
								<input class="uberwpb-list-color-picker"></input>
							</div>
						</div>
					</div>
						<div class="vc_col-sm-1 uber_wpb_list_holder">
							<div class="wpb_element_label">Link</div>
							<div class="link_input_holder">
								<h2>'.esc_html__('Add / Edit link','uber-wpbakery-addons').'</h2>
								<input class="uberwpb-list-link"></input>								
								<a class="link_button save" href="#">'.esc_html__('Save','uber-wpbakery-addons').'</a>
							</div>
							<div class="link_holder"><a title="'.esc_html__('Click to add Link','uber-wpbakery-addons').'" class="link_plus" href="#"><i class="uberwpb-texteditor-link-alt"></i></a></div>
						</div>
					<div class="vc_col-sm-2"><a class="plus" href="#">+</a><a class="minus" href="#">-</a></div>
				</div>';
	if(empty($list_fields)){

		$list_fields.= '
			<div class="uber_wpb_vc_list_values" data-list-element="1">
				<div class="vc_col-sm-4"><div class="wpb_element_label">'.esc_html__('List element','uber-wpbakery-addons').'</div><input name="uber_wpb_vc_list_desc[]" class="uber_wpb_vc_list_desc" type="text" value=""/></div>
				<div class="vc_col-sm-3"><div class="wpb_element_label">'.esc_html__('Second text','uber-wpbakery-addons').'</div><input name="uber_wpb_vc_list_second_text[]" class="uber_wpb_vc_list_second_text" type="text" value=""/></div>
				<div class="vc_col-sm-2">
					<div class="vc_col-sm-6"><div class="wpb_element_label">'.esc_html__('Icon','uber-wpbakery-addons').'</div><span class="uber_wpb_list_icon"></span></div>
					<div class="vc_col-sm-6"  style="position:relative">
						<div class="wpb_element_label">'.esc_html__('Color','uber-wpbakery-addons').'</div>
						<span class="uber_wpb_list_color"></span>
						<div class="list_color_picker">
							<input class="uberwpb-list-color-picker"></input>
						</div>
					</div>
				</div>
						<div class="vc_col-sm-1 uber_wpb_list_holder">
							<div class="wpb_element_label">Link</div>
							<div class="link_input_holder">
								<h2>'.esc_html__('Add / Edit link','uber-wpbakery-addons').'</h2>
								<input class="uberwpb-list-link"></input>								
								<a class="link_button save" href="#">'.esc_html__('Save','uber-wpbakery-addons').'</a>
							</div>
							<div class="link_holder"><a title="'.esc_html__('Click to add Link','uber-wpbakery-addons').'" class="link_plus" href="#"><i class="uberwpb-texteditor-link-alt"></i></a></div>
						</div>
				<div class="vc_col-sm-2"><a class="plus" href="#">+</a><a class="minus" href="#">-</a></div>
			</div>
		';		
		
	}

	$return = '	
			<div class="uber_wpb_vc_list_block '.esc_attr( $settings['param_name'] ) .'"  data-list-saved=\''. esc_attr( $value ) .'\'>'
			  .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput uber_wpb_vc_list_all '
              .esc_attr( $settings['param_name'] ) . ' '
              .esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />' 
			  .$default //$default escaped above
			  .$list_fields //$list_fields escaped above
         .'</div>';
	return $return;
}
}
}

/*
=================================================================================================================
Function uber_wpb_vc_pricing_table_func() - pricing table custom fields in VC
=================================================================================================================
*/
if (function_exists('vc_add_shortcode_param')) {
vc_add_shortcode_param( 'uber_wpb_vc_pricing_table', 'uber_wpb_vc_pricing_table_func' );
	if ( !function_exists('uber_wpb_vc_pricing_table_func') ) {
	function uber_wpb_vc_pricing_table_func( $settings, $value ) {
	$pricing_table_fields='';	
		
		if(!empty($value)){
			
			$all_values = json_decode($value , true);
			
			foreach($all_values as $val){
				$pricing_table_fields.= '
				<div class="uber_wpb_vc_pricing_values">
					<div class="vc_col-sm-5 "><div class="wpb_element_label">'.esc_html__('Feature','uber-wpbakery-addons').'</div><input name="uber_wpb_vc_pricing_table_desc[]" class="uber_wpb_vc_pricing_table_desc" type="text" value="' . esc_html( $val['desc'] ). '"/></div>
					<div class="vc_col-sm-5 "><div class="wpb_element_label">'.esc_html__('Feature Highlighted','uber-wpbakery-addons').'</div><input name="uber_wpb_vc_pricing_table_desc_highlight[]"  class="uber_wpb_vc_pricing_table_desc_highlight" type="text" value="' . esc_html( $val['highlight'] ). '"/></div>
					<div class="vc_col-sm-2 "><a class="plus" href="#">+</a><a class="minus" href="#">-</a></div>
				</div>
				';			
			}
		}
		
		if(empty($pricing_table_fields)){
			$pricing_table_fields.= '
			<div class="uber_wpb_vc_pricing_values">
				<div class="vc_col-sm-5 "><div class="wpb_element_label">'.esc_html__('Feature','uber-wpbakery-addons').'</div><input name="uber_wpb_vc_pricing_table_desc[]" class="uber_wpb_vc_pricing_table_desc" type="text" placeholder="'.esc_html__("Number of databeses", "js_composer").'" value=""/></div>
				<div class="vc_col-sm-5 "><div class="wpb_element_label">'.esc_html__('Feature Highlighted','uber-wpbakery-addons').'</div><input name="uber_wpb_vc_pricing_table_desc_highlight[]"  class="uber_wpb_vc_pricing_table_desc_highlight" placeholder="'.esc_html__("20", "js_composer").'" type="text" value=""/></div>
				<div class="vc_col-sm-2 "><a class="plus" href="#">+</a><a class="minus" href="#">-</a></div>
			</div>
			';		
			
		}
		
		$return = '<div class="uber_wpb_vc_pricing_table_block '.esc_attr( $settings['param_name'] ) .'">'
				 .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput uber_wpb_vc_pricing_table_all ' .
				 esc_attr( $settings['param_name'] ) . ' ' .
				 esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />' 
				 .$pricing_table_fields //$pricing_table_fields escaped above
			 .'</div>';
		return $return;
	}
	}
}

/*
=================================================================================================================
uber_wpb_vc_fancy_overlay_css($hover_effect) - output custom css for fancy hover effects
=================================================================================================================
*/
if ( !function_exists('uber_wpb_vc_fancy_overlay_css') ) {
function uber_wpb_vc_fancy_overlay_css($hover_effect = NULL){
	
	global $uber_wpb_options;
	$css_output = '';
	
	//lily efect
	if ($hover_effect == 'lily'){
	}
	
	//honey efect	
	if ($hover_effect == 'honey'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-honey figcaption::before{background:#ff4949 !important}';
				$css_output.= 'figure.effect-honey p{display:none;}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-honey figcaption::before{background:'. esc_attr( $uber_wpb_options['theme-color1'] ).' !important}';
				$css_output.= 'figure.effect-honey p{display:none;}';
			$css_output.='</style>';
		}
	}


	//layla efect
	if ($hover_effect == 'layla'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-layla figcaption::before{border-top: 1px solid #ff4949 !important; border-bottom: 1px solid #ff4949 !important;}';
				$css_output.= 'figure.effect-layla figcaption::after {border-left: 1px solid #ff4949 !important; border-right: 1px solid #ff4949 !important;}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-layla figcaption::before{border-top: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important; border-bottom: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important;}';
				$css_output.= 'figure.effect-layla figcaption::after {border-left: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important; border-right: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important;}';
			$css_output.='</style>';
		}
	}	
	
	//oscar efect
	if ($hover_effect == 'oscar'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-oscar figcaption::before{border: 1px solid #ff4949 !important}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-oscar figcaption::before{border: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important}';
			$css_output.='</style>';
		}
	}	
	
	//marley efect
	if ($hover_effect == 'marley'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-marley h2::after{background: #ff4949 !important}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-marley h2::after{background: '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important}';
			$css_output.='</style>';
		}
	}
	
	//ruby efect
	if ($hover_effect == 'ruby'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-ruby p{border: 1px solid #ff4949 !important}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-ruby p{border: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important}';
			$css_output.='</style>';
		}
	}		
	
	//roxy efect
	if ($hover_effect == 'roxy'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-roxy figcaption::before{border: 1px solid #ff4949 !important}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-roxy figcaption::before{border: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important}';
			$css_output.='</style>';
		}
	}
	
	//bubba efect
	if ($hover_effect == 'bubba'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-bubba figcaption::before{border-top: 1px solid #ff4949 !important; border-bottom: 1px solid #ff4949 !important;}';
				$css_output.= 'figure.effect-bubba figcaption::after {border-left: 1px solid #ff4949 !important; border-right: 1px solid #ff4949 !important;}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-bubba figcaption::before{border-top: 1px solid '.esc_attr( $uber_wpb_options['theme-color1']).' !important; border-bottom: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important;}';
				$css_output.= 'figure.effect-bubba figcaption::after {border-left: 1px solid '.esc_attr( $uber_wpb_options['theme-color1']).' !important; border-right: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important;}';
			$css_output.='</style>';
		}
	}	

	//romeo efect
	if ($hover_effect == 'romeo'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-romeo figcaption::before, figure.effect-romeo figcaption::after{background: #ff4949 !important;}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-romeo figcaption::before, figure.effect-romeo figcaption::after{background: '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important;}';
			$css_output.='</style>';
		}
	}
	
	//dexter efect
	if ($hover_effect == 'dexter'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-dexter:hover figcaption::after{border: 1px solid #ff4949 !important;}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-dexter:hover figcaption::after{border: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important;}';
			$css_output.='</style>';
		}
	}	
	
	//sarah efect
	if ($hover_effect == 'sarah'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-sarah h2::after{background: #ff4949 !important;}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-sarah h2::after{background: '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important;}';
			$css_output.='</style>';
		}
	}
	
	//chico efect
	if ($hover_effect == 'chico'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-chico figcaption::before{border: 1px solid #ff4949 !important}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-chico figcaption::before{border: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important}';
			$css_output.='</style>';
		}
	}	
	
	//milo efect
	if ($hover_effect == 'milo'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-milo p{border-right: 1px solid #ff4949 !important}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-milo p{border-right: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important}';
			$css_output.='</style>';
		}
	}	
	
	//hera efect
	if ($hover_effect == 'hera'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-hera figcaption::before{border: 2px solid #ff4949 !important}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-hera figcaption::before{border: 2px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important}';
			$css_output.='</style>';
		}
	}	
	
	//phoebe efect
	if ($hover_effect == 'phoebe'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-phoebe p a {background: #ff4949 !important}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-phoebe p a {background:'.esc_attr( $uber_wpb_options['theme-color1'] ).' !important}';
			$css_output.='</style>';
		}
	}	

	//jazz efect
	if ($hover_effect == 'jazz'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-jazz figcaption::after{border-top: 1px solid #ff4949 !important; border-bottom: 1px solid #ff4949 !important;}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-jazz figcaption::after{border-top: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important; border-bottom: 1px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important;}';
			$css_output.='</style>';
		}
	}		
	
	//lexi efect
	if ($hover_effect == 'lexi'){
		if (!$uber_wpb_options['theme-color1']){
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-lexi figcaption::before{border: 2px solid #ff4949 !important}';
			$css_output.='</style>';
		}			
		else{
			$css_output.='<style type="text/css">';
				$css_output.= 'figure.effect-lexi figcaption::before{border: 2px solid '.esc_attr( $uber_wpb_options['theme-color1'] ).' !important}';
			$css_output.='</style>';
		}
	}	

	return $css_output;
	
}
}




/*
=================================================================================================================
uber_wpb_fix_vc_google_font() - Load google fonts in header instead of footer ( as VC does ) as the font looks like
						   they have no styles attached for 1-2 seconds
=================================================================================================================
*/
if ( !function_exists('uber_wpb_fix_vc_google_font') ) {
	function uber_wpb_fix_vc_google_font(){
		
		$explode = '';
		$page = get_post(uber_wpb_get_the_post_id());
		
		if ( !empty($page->post_content) ){
			
			if ( stripos($page->post_content, 'font_family:') ){
			
				$explode = explode('font_family:' ,$page->post_content);
				
				for ( $i=1; $i<=count($explode)-1; $i++ ){

					//font name
					$font_raw      = uber_wpb_get_string_between($explode[$i],'','|');
					$font_clean    = str_replace('%20','+',$font_raw);
					
					//replaces
					$search  = array( '%20','%2c','%3A' );
					$replace = array( '','','' );
					
					//font vc
					$font_vc_raw 		= uber_wpb_get_string_between($explode[$i],'','|');
					
					$font_vc_raw2     	= str_ireplace( $search,$replace,$font_vc_raw );
					$font_vc    		= strtolower( $font_vc_raw2 );
					$font_vc_css_name   = 'vc_google_fonts_'.$font_vc;
					
					//font weight
					$font_weight   = uber_wpb_get_string_between( $explode[$i],'|font_style:','%20' );
					
					//enqueue
					wp_enqueue_style( $font_vc_css_name, 'https://fonts.googleapis.com/css?family='. esc_attr( $font_clean ) .':'.esc_attr( $font_weight ).'');
					
				}
				
			}
		}
		
	}
}
/*
=================================================================================================================
Function uber_wpb_attach_image_field() - uber_wpb_attach_image - custom image attach
=================================================================================================================
*/

if ( function_exists( 'vc_add_shortcode_param' ) ) {
vc_add_shortcode_param( 'uber_wpb_attach_image', 'uber_wpb_attach_image_field' );
	if ( !function_exists('uber_wpb_attach_image_field') ) {
		function uber_wpb_attach_image_field( $settings, $value ) {
		$style = '';

		if (!empty ( $value ) )	{

			//image is local or external - if external skip aq_resize
			$is_local = stripos($value, get_site_url() );
				
			if ($is_local !== false) {			
				$img = aq_resize($value, 82, 82, true, true, true);
			}
			else{
				$img = $value;
			}

			$style =  'style="display:block;background:url(\''. esc_url( $img ) .'\') no-repeat center;background-size:cover"';
		}
		
		$output = '<div class="uber_wpb_attach_image">
						<div class="custom_media_url_remove_holder" '. $style .'><a class="custom_media_url_remove" href="javascript:void(0);">X</a></div>'. // $style escaped above
						''.
						'<img class="custom_media_image" src="'. esc_url( $value ).'">					<input type="button" value="+" class="button custom_media_upload"   id="custom_image_uploader">		
			
						<input name="' . esc_attr( $settings['param_name'] ) . '" class="custom_media_url wpb_vc_param_value  wpb-textinput ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" type="hidden"  value="'.esc_attr( $value ).'" />
					</div>
			';
			return $output;
		}
	}
}


/*
=================================================================================================================
Function uber_wpb_attach_gallery_field() - uber_wpb_attach_gallery - custom image gallery attach
=================================================================================================================
*/

if ( function_exists( 'vc_add_shortcode_param' ) ) {
vc_add_shortcode_param( 'uber_wpb_attach_gallery', 'uber_wpb_attach_gallery_field' );
	if ( !function_exists('uber_wpb_attach_image_field') ) {
	function uber_wpb_attach_image_field( $settings, $value ) {
	
		$style = $output = '';
		$output.= '<div class="uber_wpb_attach_image">';
		if (isset($value)){
			$val_array = json_decode($value, true);
			foreach($val_array as $val){
				
				if($val){
					
					$img_resized = aq_resize($val, 82, 82, true, true, true);
					
					$style =  'style="display:block;background-image:url(\''.esc_url( $img_resized ).'\');"';
					
							$output.= '		<div class="custom_gallery_url_remove_holder" '. $style .'><a class="custom_gallery_url_remove" href="javascript:void(0);">X</a></div>'; // $style escaped above
				}
			}
			
			$output.= '
			<input type="button" value="+" class="button custom_media_gallery"   id="custom_image_uploader">	
			<input name="' . esc_attr( $settings['param_name'] ). '" class="custom_gallery_url wpb_vc_param_value  wpb-textinput ' .  esc_attr( $settings['param_name'] ). ' ' .  esc_attr( $settings['type'] ) . '_field" type="hidden"  value="'.esc_attr($value).'" />
			</div>
			';
		}
		else{
		
			$output = '<div class="uber_wpb_attach_image">
		

						<input type="button" value="+" class="button custom_media_gallery"   id="custom_image_uploader">		
			
						<input name="' . esc_attr( $settings['param_name'] ) . '" class="custom_gallery_url wpb_vc_param_value  wpb-textinput ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" type="hidden"  value="'.esc_attr( $value ).'" />
					</div>
			';		
		
		}

		return $output;
	}
	}
}


/*
=================================================================================================================
Function uber_wpb_vc_set_default_editor_post_types() - Enable VC by default on a list of Post Types
=================================================================================================================
*/
if ( !function_exists('uber_wpb_vc_set_default_editor_post_types') ) {
	function uber_wpb_vc_set_default_editor_post_types() {
		if( function_exists('vc_set_default_editor_post_types') ){ 
			$list = array(
				'page',
				'post',
				'portfolio',
			);
			vc_set_default_editor_post_types( $list );   
		}  
	}
}
add_action( 'vc_after_init', 'uber_wpb_vc_set_default_editor_post_types' );



if ( !function_exists('uber_wpb_vc_get_type_posts_data') ) {
	function uber_wpb_vc_get_type_posts_data( $do_only = null ) {
	$result = array();	
			
			if(  !$do_only || $do_only == 'posts'){
				$posts = get_posts( array(
					'posts_per_page'    => -1,
					'post_type'         => 'post',
				));

				foreach ( $posts as $post ) {
								
					$result[] = array(
						'value' => $post->ID,
						'label' => str_replace("&","",$post->post_title),
						'group' => esc_html__( 'Posts', 'uber-wpbakery-addons' ),
					);
				}
			}
			
			if(  !$do_only || $do_only == 'portfolio'){
				
				$posts = get_posts( array(
					'posts_per_page'    => -1,
					'post_type'         => 'portfolio',
				));
				foreach ( $posts as $post ) {
					$result[] = array(
						'value' => $post->ID,
						'label' => str_replace("&","",$post->post_title),
						'group' => esc_html__( 'Portfolio', 'uber-wpbakery-addons' ),
					);
				}
			}
			
			if(  !$do_only || $do_only == 'pages'){
				
				$pages = get_pages();
				foreach ( $pages as $page ) {
					$result[] = array(
						'value' => $page->ID,
						'label' => !empty( $post->post_title ) ? str_replace("&","",$post->post_title) : '',
						'group' => esc_html__( 'Pages', 'uber-wpbakery-addons' ),
					);
				}			
			}
		return $result;
	}
}
/*
=================================================================================================================
Function uber_wpb_vc_presets() - Add some default presets to visual composer
=================================================================================================================
*/
if ( !function_exists('uber_wpb_vc_presets') ) {
	function uber_wpb_vc_presets( $base_name , $uber_wpb_preset_id ){
		global $uber_wpb_options;
		$tc1 = !empty( $uber_wpb_options['theme-color1'] ) ? $uber_wpb_options['theme-color1'] : '#ff4949' ;
		$tc2 = !empty( $uber_wpb_options['theme-color2'] ) ? $uber_wpb_options['theme-color2'] : '#ff4d6f';
		$hc  = !empty( $uber_wpb_options['h1-font']['color'] ) ? $uber_wpb_options['h1-font']['color'] : '#000';
		if (  !$base_name && !$uber_wpb_preset_id) { return false; }
		require_once( UBER_WPB_PLUGIN_DIR.'/vc_extend/presets/'.$base_name.'/'.$uber_wpb_preset_id.'.php' );
		return $presets;

	}
}
/*
=================================================================================================================
Function uber_wpb_vc_resposive_box_settings_field() - create a design box for responsive layout
=================================================================================================================
*/
if (function_exists('vc_add_shortcode_param')) {
	vc_add_shortcode_param( 'uber_wpb_vc_responsive_box', 'uber_wpb_vc_resposive_box_settings_field' );
	if ( !function_exists('uber_wpb_vc_resposive_box_settings_field') ) {
		function uber_wpb_vc_resposive_box_settings_field( $settings, $value ) {
			$ul_html='';
			if( $value ){
				$value_no_bracket = str_replace(array("{","}","!important"),"",$value);
				$x = explode(";",$value_no_bracket);
				foreach( $x as $val ){
					$xx = explode(":",$val);
					$data[trim($xx[0])] = trim($xx[1]);
				}
			} 
			$inputs = '
					<div class="uber_wpb_layout-onion"> 
						<div class="uber_wpb_margin">  
						   <label>Margin</label>
							   <input type="text" name="margin_top" data-name="margin-top" class="uber_wpb_top" placeholder="-" data-attribute="margin" value="'.$data['margin-top'].'">
							   <input type="text" name="margin_right" data-name="margin-right" class="uber_wpb_right" placeholder="-" data-attribute="margin" value="'.$data['margin-right'].'">
							   <input type="text" name="margin_bottom" data-name="margin-bottom" class="uber_wpb_bottom" placeholder="-" data-attribute="margin" value="'.$data['margin-bottom'].'">
							   <input type="text" name="margin_left" data-name="margin-left" class="uber_wpb_left" placeholder="-" data-attribute="margin" value="'.$data['margin-left'].'">          
							   
							   <div class="uber_wpb_padding">
								  <label>Padding</label>
								  <input type="text" name="padding_top" data-name="padding-top" class="uber_wpb_top" placeholder="-" data-attribute="padding" value="'.$data['padding-top'].'">
								  <input type="text" name="padding_right" data-name="padding-right" class="uber_wpb_right" placeholder="-" data-attribute="padding" value="'.$data['padding-right'].'">
								  <input type="text" name="padding_bottom" data-name="padding-bottom" class="uber_wpb_bottom" placeholder="-" data-attribute="padding" value="'.$data['padding-bottom'].'">
								  <input type="text" name="padding_left" data-name="padding-left" class="uber_wpb_left" placeholder="-" data-attribute="padding" value="'.$data['padding-left'].'">
								  <div class="uber_wpb_content"> </div>
							   </div>	   
						</div>
					</div>		
		';
			$return = '<div class="uber_wpb_responsive_design_block vc_css-editor '.esc_attr( $settings['param_name'] ) .'">'.
						$inputs
					 .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
					 esc_attr( $settings['param_name'] ) . ' ' .
					 esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" /></div>';
			return $return;
		}
	}
}



/*
=================================================================================================================
Function uber_wpb_vc_maps_settings_field() - generate google map
=================================================================================================================
*/
if (function_exists('vc_add_shortcode_param')) {
	vc_add_shortcode_param( 'uber_wpb_vc_maps', 'uber_wpb_vc_maps_settings_field' );
	if ( !function_exists('uber_wpb_vc_maps_settings_field') ) {
		function uber_wpb_vc_maps_settings_field( $settings, $value ) {
			$ul_html='';
			if( $value ){
				
				$saved_input = '<input id="uberwpb-maps-saved-values" type="hidden" name="uberwpb-maps-saved-values" value="' . esc_attr( $value ) . '">';
				
					
			} 
			else{
				$saved_input = '<input id="uberwpb-maps-saved-values" type="hidden" name="uberwpb-maps-saved-values" value="no_val">';
			}

			$map_inputs = '
			<input id="pac-input" class="controls" type="text"
				placeholder="Enter a location">
				'. $saved_input  //$saved_input escaped above
			.'<div id="map"></div>
			<div id="infowindow-content">
			  <span id="place-name"  class="title"></span><br>
			  <span id="zoom"  class="title"></span>
			</div>
		';
			
			$return = '<div class="uber_wpb_maps_block '.esc_attr( $settings['param_name'] ) .'">'
					 .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
					 esc_attr( $settings['param_name'] ) . ' ' .
					 esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />' .
					 $map_inputs //$map_inputs escaped above
				 .'</div>';
			return $return;
		}
	}
}


/*
=================================================================================================================
uber_wpb_css_box() - used for wpbakery CSS box
=================================================================================================================
*/
if ( !function_exists('uber_wpb_css_box') ) {
	function uber_wpb_css_box( $css_box ){
		
		if( !$css_box ) return false;
		$css_box = str_ireplace(array(" !important","!important"),"",$css_box);
		$only_css_attr = uber_wpb_get_string_between($css_box, "{", "}");
		$css_atts = explode(";",$only_css_attr);
		return array_filter( $css_atts );
	}
}

/*
=================================================================================================================
uber_wpb_get_all_wpcf7() - Get a dropdown list of all contact form 7 shortcode(s)
=================================================================================================================
*/
if ( !function_exists('uber_wpb_get_all_wpcf7') ) {
	function uber_wpb_get_all_wpcf7(){
		$is_post_type_wpcf7 =  get_posts( array( 'post_type' => 'wpcf7_contact_form' ) );
		if ( class_exists( 'WPCF7' ) and $is_post_type_wpcf7  ){
			$options = array();
			$options[esc_attr__('-- Select contact form shortcode --','uber-wpbakery-addons')] = '';

				$wpcf7_posts = get_posts(array(
					'post_type'     => 'wpcf7_contact_form',
					'numberposts'   => -1
				));
				if ( is_array( $wpcf7_posts  ) ){
					foreach ( $wpcf7_posts as $wpcf7_post ) {
						$options[esc_attr( $wpcf7_post->post_title ).' ( '.esc_attr( $wpcf7_post->ID ).' )'] = esc_attr( $wpcf7_post->ID ) ;
					}
				}
				return $options ;
		}
		else{
			$options[0] = esc_attr__('-- Please activate WPCF7 Plugin and create at least one shortcode --','uber-wpbakery-addons');
			return $options;
		}
	}
}
/*
=================================================================================================================
uber_wpb_do_shortcode_wpcf7() - Display the contact form 7 shortcode by id
=================================================================================================================
*/
if ( !function_exists('uber_wpb_do_shortcode_wpcf7') ) {
	function uber_wpb_do_shortcode_wpcf7( $id ){
		if ( class_exists( 'WPCF7' ) ) {
			if ( !$id ) {
				return false;
			}
			else{
				return do_shortcode('[contact-form-7 id="'.esc_attr( $id ).'" title="'.esc_attr( get_the_title( $id ) ).'"]');
			}
		}
		else {
			return false;
		}
	}
}