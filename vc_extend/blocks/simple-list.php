<?php
/**
 * Visual Composer Custom List Block
 *
 * @package Uber WPBakery Addons
 * @author WOW Layers
 * @link https://wowlayers.com
 */


/*
=================================================================================================================
uber_wpb_simple_list_func( $atts, $content = null ) - Output the Simple List custom block
=================================================================================================================
*/
add_shortcode( 'uber_wpb_simple_list', 'uber_wpb_simple_list_func' );
function uber_wpb_simple_list_func( $atts, $content = null ) { // New function parameter $content is added!
$output = $html_output = $css_output = $custom_css_class = $url_before = $url_after = $link_attr = $data_anim = $data_anim_delay = $data_anim_duration = '';
$general_css_box = array();
$css_output_array = array();
$html_classes = array();

$css_output_array['global'] = array();
$css_output_array['first_text'] = array();
$css_output_array['responsive'] = array();
$html_classes['global'] = array();
		
    extract( shortcode_atts( array(
		'list' => '',
		
		'icon' => '',
		'position' => 'left',
		'font_size' => '',
		'color' => '',
		'text_color' => '',
		'text_color2' => '',
		'line_height' => '',
		
		'font_selector' => '',
		'font' => '',
		'customfont' => '',
	    'font_weight'	=> '',
	    'font_weight2'	=> '',

		'font2_selector' => '',
		'font2' => '',
		'customfont2' => '',
	    'font2_weight'	=> '',
	    'font2_weight2'	=> '',			
		
		'css_editor'	=> '',
		'text_transform'	=> '',
		'new_tab'	=> '',
		'nofollow'	=> '',
		'el_class' => '',
		'css_editor' => '',	

		//animations
		'animate' => '',
		'animation' => 'fadeIn',
		'animation_duration' => '0.2',
		'animation_delay' => '0.2',
   ), $atts ) );
  
	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

	$custom_css_class = 'custom_css_'.uniqid("", true);
	$custom_css_class = str_replace('.','-',$custom_css_class);
	$custom_css_class_w_dot = '.'.esc_attr( $custom_css_class );  //escaped here as there is a large number of use
				
	if( $animate ){
			wp_enqueue_script( 'vc_waypoints' );
			wp_enqueue_script('script-animate');
	}		
	
	/*=====  CSS OUTPUT BEGIN ======*/

	//fonts processing
	// first_text 
	if     ($font_selector == 'googlefont') { $css_output_array['first_text'][]   = esc_attr( uber_wpb_google_fonts($font)); }
	else { $css_output_array['first_text'][] = '';}
	
	
	$css_output_array['first_text'][] = $text_color ? "color:".esc_attr( $text_color ): "";

	//second_text
	if     ($font2_selector == 'googlefont') { $css_output_array['second_text'][]   = uber_wpb_google_fonts($font2); }
	else { $css_output_array['second_text'][] = '';}
	

	$css_output_array['second_text'][] = $text_color2 ? "color:".esc_attr( $text_color2 ): "";
	
	//global css
	if( $css_editor ){
		$general_css_box = uber_wpb_css_box($css_editor);
		$css_output_array['global'][]= "{".implode(";",$general_css_box)."}";			
	}	

	$css_output_array['global'][] = $color ? "ul li i{color:".esc_attr( $color ) . "}" : '';

	if( $font_size ){
		$css_output_array['first_text'][] = "font-size:".esc_attr( $font_size );
		$css_output_array['second_text'][] = "font-size:".esc_attr( $font_size );
		$css_output_array['global'][] = "ul li i{font-size:".esc_attr( $font_size ) . "}";
	}
	if( $line_height ){
		$css_output_array['first_text'][] = "line-height:". esc_attr( $line_height );
		$css_output_array['second_text'][] = "line-height:". esc_attr( $line_height );
	}
	
	$css_output_array['global'][] = $text_transform ? "ul li{text-transform:".esc_attr( $text_transform ) . "}" : '';
	
		//css for every li
		if(!empty($list)){

			//vc bug fix - vc replaces " with ``
			$list = str_replace(
						array("``",':""','""',':"\"'),
						array('"',':"\"','\""',':""'),
						$list
					);
			$list_all = json_decode($list,true);
			if (json_last_error() == 0){
				unset($list_all['general_icon']);
				unset($list_all['general_color']);
				$li_no = 1;
				foreach($list_all as $key => $val){
					if(array_key_exists ('custom_color',$val)){
				
						//get li number
						
						$css_output_array['global'][]= 'ul li.'.esc_attr( $key ).' i{color:'.esc_attr( $val['custom_color'] ).'}';

					}
				}
			}
		}

	//responsive
	$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot,  "css_atts" =>$general_css_box);	
	$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' .first_text,' . $custom_css_class_w_dot.' .second_text, ' . $custom_css_class_w_dot.' ul li i',  "css_atts" =>$css_output_array['first_text'] ,"default_font_size" => 'p');		
		
	//delete empty array values so we don't get ';' when there is no css
	$global_array = (is_array($css_output_array['global'])) ? array_filter($css_output_array['global']) : '';	
	$first_text_array = (is_array($css_output_array['first_text'])) ? array_filter($css_output_array['first_text']) : '';	
	$second_text_array = (is_array($css_output_array['second_text'])) ? array_filter($css_output_array['second_text']) : '';	
	$responsive_array  = (is_array($css_output_array['responsive'])) ? array_filter($css_output_array['responsive']) : '';
		
	if( $global_array || $first_text_array || $second_text_array || $responsive_array) //check if there are any custom css
		{
			$css_output.= '<style type="text/css">';
				$css_output.= ($global_array) ? $custom_css_class_w_dot.' '. implode($custom_css_class_w_dot.' ',$global_array ) : ''; //escaped above in $css_output_array
				
				$css_output.= ($first_text_array) ? $custom_css_class_w_dot." .first_text{". implode(';', $first_text_array).'}' : ''; //escaped above in $css_output_array
				$css_output.= ($second_text_array) ? $custom_css_class_w_dot." .second_text{". implode(';', $second_text_array).'}' : ''; //escaped above in $css_output_array
				$css_output.= ($responsive_array)  ? uber_wpb_responsive( $responsive_array) : '';
			$css_output.= '</style>'; //close css styles
		}	
	
	/*=====  CSS OUTPUT END ======*/
	
	
	/*=====  HTML OUTPUT BEGIN ======*/
	//vc custom styles
	$html_classes['global'][] = $position == "right" ? 'icon_right' : '';
	$html_classes['global'][] = $custom_css_class ? $custom_css_class : '';
	$html_classes['global'][] = $el_class ? $el_class : '';	
	
	$global_class = (array_filter($html_classes['global'])) ? ' '.implode(' ', array_filter($html_classes['global'])) : ""; //escaped above in $css_output_array
	
	$html_output.= '<div class="simple-list'.$global_class.'">';
		if(!empty($list)){
			$html_output.= '<ul>';
	
			//vc bug fix - vc replaces " with ``
			$list = str_replace(
						array("``",':""','""',':"\"'),
						array('"',':"\"','\""',':""'),
						$list
					);
			
			$list_all = json_decode($list,true);
			
			if (json_last_error() == 0){
				unset($list_all['general_icon']);
				unset($list_all['general_color']);

				$i=1;
				foreach($list_all as $key => $val){
					if(array_key_exists ('custom_icon',$val) ){
						if( $val['custom_icon'] != 'none' ){
							$icon_list =  '<span class="icon"><i class="'.esc_attr( $val['custom_icon'] ).'"></i></span>';
							uber_wpb_vc_font_icons_enqueue($val['custom_icon']);
						}
						else { $icon_list = ''; }
					}
					elseif(!empty($icon)){
						$icon_list =  '<span class="icon"><i class="'.esc_attr( $icon ).'"></i></span>';
						uber_wpb_vc_font_icons_enqueue($icon);
					}
					else{ $icon_list = ''; }
					
					if( $animate ){
						
						$anim_html = ' data-animate="'.esc_attr( $animation ).'" data-animate-delay="'. esc_attr( floatval ( $animation_delay )  * $i ).'" data-animate-duration="'. esc_attr( floatval ( $animation_duration ) ) .'"';
						
					}
					else{
						$anim_html = '';
					}
					
					$val['text'] = str_replace(" ","&nbsp;",$val['text']);
					$val['second_text'] = str_replace(" ","&nbsp;",$val['second_text']);
					
					$first_text = $val['text'] ? '<span class="first_text">'.esc_attr( $val['text'] ).'</span>' : '';
					$second_text = $val['second_text'] ? '<span class="second_text">'.esc_attr( $val['second_text'] ).'</span>' : '';
					
					if( isset( $val['url'] ) && !empty( $val['url'] ) ){
						
						$link_attr .= $new_tab ? ' target="_blank" ' : '';
						$link_attr .= $nofollow ? ' rel="nofollow" ' : '';
						
						$url_before = '<a href="'.esc_url( $val['url'] ).'"'. $link_attr .'>';
						$url_after = '</a>';
					}
					else{
						$url_before = $url_after = $link_attr = '';
					}

					//all variables are properly escaped above
					if( is_rtl() ){
						
						if( $position == 'left' ){
							$html_output.= '<li class="'.esc_attr( $key ).'"'. $anim_html .'>' . $url_before . '<p>' . $first_text . $second_text .  $icon_list . '</p>' . $url_after . '</li>';
						}
						else{
							$html_output.= '<li class="'.esc_attr( $key ).'"'. $anim_html .'>' . $url_before. '<p>' . $icon_list . $first_text . $second_text . '</p>' . $url_after . '</li>';
						}						
					}
					else{
						
						if( $position == 'left' ){
							$html_output.= '<li class="'.esc_attr( $key ).'"'. $anim_html .'>' . $url_before . '<p>' . $icon_list . $first_text . $second_text . '</p>' . $url_after . '</li>';
						}
						else{
							$html_output.= '<li class="'.esc_attr( $key ).'"'. $anim_html .'>' . $url_before . '<p>' . $first_text . $second_text .  $icon_list . '</p>' . $url_after . '</li>';
						}												
					}
					
					$i++;
				}
			}
			$html_output.= '</ul>';
		}
	
	$html_output.= '</div>'; //simple-list div end	
	
	/*=====  HTML OUTPUT END ======*/
	
	$output=$css_output."\n".$html_output;  //All variables inside $css_output and $html_output are propelry escaped above
	return $output;	
}


add_action( 'vc_before_init', 'uber_wpb_simple_list_integrateWithVC' );
function uber_wpb_simple_list_integrateWithVC() {
		
	$params = array(
	
				array(
				'type' 			=> 'vc_links',
				'param_name' 	=> 'caption_url',
				'class'			=>	'ult_param_heading',
				'description' 	=> __( '<span style="Background: #03A9F4;padding: 10px; font-style: normal; display: block;font-weight:500;"><a href="https://wowlayers.com/infinito/?source=uber-plugin" style="color:#fff;text-decoration: none;" target="_blank">46 Ready Websites in One Wordpress Theme. Built with WPBakery.</a></span>', 'uber-wpbakery-addons' ),
			),
	
		//general tab
			array(
				'type' => 'uber_wpb_vc_simple_list',
				'heading' => esc_html__( 'List', 'uber-wpbakery-addons' ),
				'param_name' => 'list',
				'value' => '',
				"std" => '',
				'description' => esc_html__( 'Use general icon and color in Settings tab. You can override those by choosing icon and color for every list element in General tab.', 'uber-wpbakery-addons' )
			),		
		//settings tab
		array(
			'type' => 'uber_wpb_vc_fonts_select',
			'heading' => esc_html__("General icon", "js_composer"),
			'group' =>  esc_html__( 'Settings', 'uber-wpbakery-addons' ),
			'param_name' => "icon",
			'value' => '',
			'edit_field_class' => 'vc_col-sm-8 vc_column',
			'description' => esc_html__( 'This icon will apply to all rows that does not have custom icon.Note: You can change every row icon in general tab', 'uber-wpbakery-addons' ),
			'std' => '',
		),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__( "Icon Color", "js_composer" ),
			'group' =>  esc_html__( 'Settings', 'uber-wpbakery-addons' ),
            "param_name" => "color",
            "value" => '', //Default color
			'edit_field_class' => 'vc_col-sm-4 vc_column',
            "description" => esc_html__( "Choose icon color", "js_composer" )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__( "Text Color", "js_composer" ),
			'group' =>  esc_html__( 'Settings', 'uber-wpbakery-addons' ),
            "param_name" => "text_color",
            "value" => '', //Default color
			'edit_field_class' => 'vc_col-sm-4 vc_column',
            "description" => esc_html__( "Choose text color", "js_composer" )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__( "Second Text Color", "js_composer" ),
			'group' =>  esc_html__( 'Settings', 'uber-wpbakery-addons' ),
            "param_name" => "text_color2",
            "value" => '', //Default color
			'edit_field_class' => 'vc_col-sm-4 vc_column',
            "description" => esc_html__( "Choose text color", "js_composer" )
        ),
        array(
            "type" => "uber_wpb_vc_separator",
			'group' =>  esc_html__( 'Settings', 'uber-wpbakery-addons' ),
            "param_name" => "separator",
			'class' => 'fancy-line',
        ),	
		array(
			'type' => 'dropdown',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' =>  esc_html__( 'Settings', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'Icon position', 'uber-wpbakery-addons' ),
			'param_name' => 'position',
			'value' => array(
				esc_html__( 'Left', 'uber-wpbakery-addons' ) => 'left',
				esc_html__( 'Right', 'uber-wpbakery-addons' ) => 'right',

			),
			'std' => 'left',
		),
		array(
            'type' => 'dropdown',
			'group' =>  esc_html__( 'Settings', 'uber-wpbakery-addons' ),
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
			'type' => 'checkbox',
			'group' =>  esc_html__( 'Settings', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'Links in new tab', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'new_tab',
			'value' => array( esc_html__( 'Yes', 'uber-wpbakery-addons' ) => 'yes' ),
			'description' => esc_html__( 'Open links in a new tab', 'uber-wpbakery-addons' ),				
		),		
		array(
			'type' => 'checkbox',
			'group' =>  esc_html__( 'Settings', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'Links nofollow', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'nofollow',
			'value' => array( esc_html__( 'Yes', 'uber-wpbakery-addons' ) => 'yes' ),
			'description' => esc_html__( 'Add nofollow option to links', 'uber-wpbakery-addons' ),				
		),		
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'uber-wpbakery-addons' ),
			'group' =>  esc_html__( 'Settings', 'uber-wpbakery-addons' ),
            'param_name' => 'el_class',
            'value' => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'description' => esc_html__( 'Add your custom css class for this element.', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
			'group' =>  esc_html__( 'Settings', 'uber-wpbakery-addons' ),
			'param_name' => 'css_editor',
		),
        array(
            "type" => "uber_wpb_vc_separator",
			'group' =>  esc_html__( 'Typography', 'uber-wpbakery-addons' ),
            "param_name" => "separator",
			'class' => 'fancy-line',
			'title' => 'General',
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Font size', 'uber-wpbakery-addons' ),
			'group' =>  esc_html__( 'Typography', 'uber-wpbakery-addons' ),
            'param_name' => 'font_size',
            'value' => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'description' => esc_html__( 'Font size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Line height', 'uber-wpbakery-addons' ),
			'group' =>  esc_html__( 'Typography', 'uber-wpbakery-addons' ),
            'param_name' => 'line_height',
            'value' => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'description' => esc_html__( 'All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
        ),		
        array(
            "type" => "uber_wpb_vc_separator",
			'group' =>  esc_html__( 'Typography', 'uber-wpbakery-addons' ),
            "param_name" => "separator",
			'class' => 'fancy-line',
			'title' => 'Primary text',
        ),
		
		array(
			'type' => 'dropdown',
			'group' =>  esc_html__( 'Typography', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'Font', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
			),
			'param_name' => 'font_selector',
			'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
		),	
		array(
			'type' => 'google_fonts',
			'group' =>  esc_html__( 'Typography', 'uber-wpbakery-addons' ),
			'param_name' => 'font',
			'value' => '',// Not recommended, this will override 'settings'. Example:
			'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
						bold italic:900:italic'),
			'settings' => array(
							 
							 'no_font_style'=>true 
					),
			'dependency' => array(
				'element' => 'font_selector',
				'value' => 'googlefont',
				),					
			'description' => esc_html__( 'Choose Font', 'uber-wpbakery-addons' ), // Description for field group
		),
        array(
            "type" => "uber_wpb_vc_separator",
			'group' =>  esc_html__( 'Typography', 'uber-wpbakery-addons' ),
            "param_name" => "separator",
			'class' => 'fancy-line',
			'title' => 'Secondary text',
        ),	
		array(
			'type' => 'dropdown',
			'group' =>  esc_html__( 'Typography', 'uber-wpbakery-addons' ),
			'heading' => esc_html__( 'Font', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
			),
			'param_name' => 'font2_selector',
			'description' => esc_html__( 'Choose font.', 'uber-wpbakery-addons' ),
		),	
		array(
			'type' => 'google_fonts',
			'group' =>  esc_html__( 'Typography', 'uber-wpbakery-addons' ),
			'param_name' => 'font2',
			'value' => '',// Not recommended, this will override 'settings'. Example:
			'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
						bold italic:900:italic'),
			'settings' => array(
							 
							 'no_font_style'=>true 
					),
			'dependency' => array(
				'element' => 'font2_selector',
				'value' => 'googlefont',
				),					
			'description' => esc_html__( 'Choose Font', 'uber-wpbakery-addons' ), // Description for field group
		),
		//animations tab
		array(
			'type' => 'dropdown',
			'group' => 'Animations',
			'heading' => esc_html__( 'Animate?', 'uber-wpbakery-addons' ),
			'param_name' => 'animate',
			'value' => array(
				esc_html__( 'No', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Yes', 'uber-wpbakery-addons' ) => 'yes',	
			),
			'std' => '',
		),
        array(
            'type' => 'uber_wpb_vc_animations_in',
			'group' => 'Animations',
            'heading' => esc_html__( 'Animation List', 'uber-wpbakery-addons' ),
            'param_name' => 'animation',
			'value' =>'',
			'dependency' => array(
				'element' => 'animate',
				'value' => 'yes',
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
				'value' => 'yes',
				),
			'std' =>'0.2',
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
				'value' => 'yes',
				),
			'std' =>'0.2',
			'description' => esc_html__( 'Every list element will be incremented with this value. Units are in seconds. Enter without "s", eg: 0.2 or 1.2', 'uber-wpbakery-addons' )
        ),
		
	);
	
	vc_map( array(
			'name' => esc_html__( 'Simple List', 'uber-wpbakery-addons' ),
			'base' => 'uber_wpb_simple_list',
			'weight' => 1000,
			'icon' => 'uberwpb-texteditor-listing-number',
			'category' => array(esc_html__('Content','uber-wpbakery-addons'),esc_html__('Uber Addons','uber-wpbakery-addons')),
			'admin_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'admin_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'front_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'front_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),				
			'description' => esc_html__( 'Simple list with icons as bullets', 'uber-wpbakery-addons' ),
			'params' => $params
	) );
	
  
}

?>