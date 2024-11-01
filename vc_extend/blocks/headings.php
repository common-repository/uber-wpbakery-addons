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
add_shortcode( 'uber_wpb_headings', 'uber_wpb_headings_func' );
function uber_wpb_headings_func( $atts, $content = null ) { // New function parameter $content is added!

$output = $html_output = $css_output = $custom_css_class = $data_anim = $data_anim_delay = $data_anim_duration = '';
$css_output_array = array();

$css_output_array['general'] = array();
$css_output_array['h1'] = array();
$css_output_array['h2'] = array();
$css_output_array['p'] = array();
$css_output_array['p_content'] = array();
$css_output_array['responsive'] = array();

	//extract	
   extract( shortcode_atts( array(

	  'h1'	=> 'I AM A COOL HEADING',
	  'h2'	=> 'Check Out Some Cool Stuff We Can Do For You',
	  'alignment' => 'center',
	  'general_css_editor' => '',
	  'el_class'	=> '',
	  
	  'h1_html'	=> 'h4',
	  'h1_font'	=> '',
	  'h1_line_height'	=> '',
	  'h1_font_weight'	=> '',
	  'h1_font_weight2'	=> '',
	  'h1_font_selector' => '',
	  'h1_customfont' => '',
	  'h1_font_size' => '',
	  'h1_color' => '',
	  'h1_texttransform' => '',
	  'h1_letterspacing' => '',
	  'h1_underline' => 'yes',
	  'h1_underline_color' => '',
	  'h1_underline_width' => '',
	  'h1_underline_height' => '',
	  'h1_css_editor' => '',
		
	  'h2_html'	=> 'h2',
	  'h2_font'	=> '',
	  'h2_line_height'	=> '',
	  'h2_font_weight'	=> '',
	  'h2_font_weight2'	=> '',
	  'h2_font_selector' => '',
	  'h2_customfont' => '',
	  'h2_font_size' => '',
	  'h2_color' => '',
	  'h2_letterspacing' => '',
	  'h2_texttransform' => '',
	  'h2_underline' => '',
	  'h2_underline_color' => '',
	  'h2_underline_width' => '',
	  'h2_underline_height' => '',
	  'h2_light' => '',
	  'h2_css_editor' => '',
	  
	  'p_font' => '',
	  'p_line_height'	=> '',
	  'p_letterspacing'	=> '',
	  'p_font_weight'	=> '',
	  'p_font_weight2'	=> '',
	  'p_font_selector' => '',
	  'p_customfont' => '',
	  'p_font_size'	=> '',
	  'p_texttransform'	=> '',
	  'p_color' => '',
	  'p_alignment' => 'center',
	  'p_css_editor' => '',
	  
	  //animation
	  'animate' => '',
	  'animation' =>'fadeIn',	  
	  'animation_duration' => '',
	  'animation_delay' => '',	 
	 

   ), $atts ) );
		//if default content align text to center - this can't be done with std or empty value because its the $content;
		$content = ( $content == 'Wolf moon affogato humblebrag fap mixtape shabby chic polaroid selfies. Before they sold out squid butcher blog umami.' ) ? '<p style="text-align: center;">Wolf moon affogato humblebrag fap mixtape shabby chic polaroid selfies. Before they sold out squid butcher blog umami.</p>' : $content;
		
		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

		//animations
		if($animate){
			wp_enqueue_script( 'vc_waypoints' );
			wp_enqueue_script('script-animate');
		}	

		$custom_css_class = 'custom_css_'.uniqid("", true);
		$custom_css_class = str_replace('.','-',$custom_css_class);
		$custom_css_class_w_dot = '.'.esc_attr( $custom_css_class );  //escaped here as there is a large number of use		
		
		/*=====  CSS OUTPUT BEGIN ======*/

		//general
		
		if( $general_css_editor ){
			$general_css_box = uber_wpb_css_box($general_css_editor);
			$css_output_array['general'] = $general_css_box;			
		}

		
		//heading styles
		$h1_css_box = uber_wpb_css_box($h1_css_editor);
		$css_output_array['h1'] = $h1_css_box;
		if     ($h1_font_selector == 'googlefont') { $css_output_array['h1'][]   = esc_attr(uber_wpb_google_fonts($h1_font)); }
		else 									   { $css_output_array['h1'][] = '';}
		$css_output_array['h1'][]= ($h1_font_size)   ? 'font-size:'.esc_attr($h1_font_size) : '';
		$css_output_array['h1'][]= ($h1_color)       ? 'color:'.esc_attr($h1_color) : '';
		$css_output_array['h1'][]= ($h1_line_height || strlen($h1_line_height) >= 1 ) ? 'line-height:'.esc_attr($h1_line_height) : '';
		$css_output_array['h1'][]= ($h1_letterspacing) ? 'letter-spacing:'.esc_attr($h1_letterspacing) : '';
		$css_output_array['h1'][]= ($h1_texttransform) ? 'text-transform:'.esc_attr($h1_texttransform) : '';

		
		//h2 styles
		$h2_css_box = uber_wpb_css_box($h2_css_editor);
		$css_output_array['h2'] = $h2_css_box;
		if     ($h2_font_selector == 'googlefont') { $css_output_array['h2'][]   = esc_attr(uber_wpb_google_fonts($h2_font)); }
		else 									   { $css_output_array['h2'][] = '';}
		$css_output_array['h2'][]= 'display:inline-block';
		$css_output_array['h2'][]= ($h2_font_size)   ? 'font-size:'.esc_attr($h2_font_size) : '';
		$css_output_array['h2'][]= ($h2_color)       ? 'color:'.esc_attr($h2_color) : '';
		$css_output_array['h2'][]= ($h2_line_height || strlen($h2_line_height) >= 1) ? 'line-height:'.esc_attr($h2_line_height) : '';
		$css_output_array['h2'][]= ($h2_letterspacing) ? 'letter-spacing:'.esc_attr($h2_letterspacing) : '';
		$css_output_array['h2'][]= ($h2_texttransform) ? 'text-transform:'.esc_attr($h2_texttransform) : '';
		
		//paragraph styles
		$p_css_box = uber_wpb_css_box($p_css_editor);
		$css_output_array['p_content'] = $p_css_box;
		
		//inner paragraph styles
		if     ($p_font_selector == 'googlefont') { $css_output_array['p_content'][]   = esc_attr(uber_wpb_google_fonts($p_font)); }
		else 									  { $css_output_array['p_content'][] = '';}	
		
		$css_output_array['p_content'][]= ($p_font_size)   ? 'font-size:'.esc_attr($p_font_size) : '';
		$css_output_array['p_content'][]= ($p_color)       ? 'color:'.esc_attr($p_color) : '';
		$css_output_array['p_content'][]= ($p_line_height || strlen($p_line_height) >= 1) ? 'line-height:'.esc_attr($p_line_height) : '';
		$css_output_array['p_content'][]= ($p_letterspacing) ? 'letter-spacing:'.esc_attr($p_letterspacing) : '';
		$css_output_array['p_content'][]= ($p_texttransform) ? 'text-transform:'.esc_attr($p_texttransform) : '';
		
		
		if( $p_alignment == 'center' ){
			$css_output_array['p'][]= 'justify-content: center';
		}
		elseif( $p_alignment == 'right' ){
			$css_output_array['p'][]= 'justify-content: flex-end;';
		}
		
		//responsive
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot ,  "css_atts" =>$css_output_array['general'] ,"default_font_size" => '');		
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' .heading1 '.$h1_html ,  "css_atts" =>$css_output_array['h1'] ,"default_font_size" => 14);
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' .heading2 '.$h2_html ,  "css_atts" =>$css_output_array['h2'],"default_font_size" => 42);
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' .headings_p' ,  "css_atts" =>$css_output_array['p'],"default_font_size" => 24);
		$css_output_array['responsive'][]= array('selector'=>$custom_css_class_w_dot.' .headings_p > *' ,  "css_atts" =>$css_output_array['p_content'],"default_font_size" => 24);
		
		//delete empty array values so we don't get ';' when there is no css
		$general_array = array_filter($css_output_array['general']);
		$h1_array = array_filter($css_output_array['h1']);
		$h2_array = array_filter($css_output_array['h2']);
		$p_array  = array_filter($css_output_array['p']);
		$p_content_array  = array_filter($css_output_array['p_content']);		
		$responsive_array  = array_filter($css_output_array['responsive']);
	
		if( $general_array  || $h1_array || $h2_array || $p_array || $p_content_array || $h1_underline || $h2_underline || $responsive_array  ){ //check if there are any custom css
				
				$css_output.= '<style type="text/css">';

				if ( $h1_underline and $h1 ){
					  $css_output.=$custom_css_class_w_dot.' .heading1 '. esc_attr( $h1_html ).' { padding-bottom: 25px;}';
				}				
				
				if ( $h2_underline and $h2 and $content ){
					  $css_output.=$custom_css_class_w_dot.' .headings_p { padding-top: 25px;}';
				}
				if ( $h1_underline_color ){
					 $css_output.=$custom_css_class_w_dot.' .heading1 .title-line { background:'.esc_attr($h1_underline_color).'}';
				}	
				if ( $h1_underline_width ){
					 $css_output.=$custom_css_class_w_dot.' .heading1 .title-line { width:'.esc_attr($h1_underline_width).'}';
				}					
				if ( $h1_underline_height ){
					 $css_output.=$custom_css_class_w_dot.' .heading1 .title-line { height:'.esc_attr($h1_underline_height).'}';
				}
				if ( $h2_underline_color ){
					 $css_output.=$custom_css_class_w_dot.' .heading2 .title-line { background:'.esc_attr($h2_underline_color).'}';
				}					
				if ( $h2_underline_width ){
					 $css_output.=$custom_css_class_w_dot.' .heading2 .title-line { width:'.esc_attr($h2_underline_width).'}';
				}				
				if ( $h2_underline_height ){
					 $css_output.=$custom_css_class_w_dot.' .heading2 .title-line { height:'.esc_attr($h2_underline_height).'}';
				}
				
				$css_output.= ($general_array) ? $custom_css_class_w_dot . '{'.implode(';', $general_array ).'}' : ''; //escaped above in $css_output_array
				
				$css_output.= ($h1_array) ? $custom_css_class_w_dot.' .heading1 '.esc_attr( $h1_html ).'{'.implode(';', $h1_array ).'}' : ''; //escaped above in $css_output_array
				

				$css_output.= ($h2_array) ? $custom_css_class_w_dot.' .heading2 '.esc_attr( $h2_html ).'{'.implode(';', $h2_array ).'}' : '';  //escaped above in $css_output_array
						
				$css_output.= ($p_array)  ? $custom_css_class_w_dot.' .headings_p{'. implode(';', $p_array ).'}' : '';  //escaped above in $css_output_array
				$css_output.= ($p_content_array)  ? $custom_css_class_w_dot.' .headings_p > *{'. implode(';', $p_content_array ).'}' : '';  //escaped above in $css_output_array
				
				$css_output.= ($responsive_array)  ? uber_wpb_responsive( $responsive_array) : '';
				
				$css_output.= '</style>';
		}
	    /*=====  CSS OUTPUT END ======*/
	
	
		/*=====  HTML OUTPUT BEGIN ======*/
		//vc custom styles
		
		//animation output
	    if($animate){
			$data_anim    		= ' data-animate="'.esc_attr( $animation ).'"';
			$data_anim_delay    = ' data-animate-delay="'.esc_attr( $animation_delay ).'"';
			$data_anim_duration = ' data-animate-duration="'.esc_attr( $animation_duration ).'"';
	    }
		
		//all variables are escaped above
		$html_output.= '<div class="headings '. esc_attr( $custom_css_class ) . " " . esc_attr( $el_class ).'" '.$data_anim.''.$data_anim_delay.''.$data_anim_duration.'>';

		
		if($h1){
			$h1=esc_attr($h1);
			$h1=str_replace('|newline|','<br>',$h1);
			
			//all variables are escaped above
			$html_output.= '<div class="heading1 text-'.esc_attr($alignment).'">';
			$html_output.= '<'.esc_attr( $h1_html ).'>'.$h1.'</'.esc_attr( $h1_html ).'>';
			$html_output.= ($h1_underline) ? '<div class="line-holder"><div class="title-line themecolor1_bg"></div></div>' : '';
			$html_output.= '</div>';
		}
				

		if($h2){
			
			//lighter text
			$h2=esc_attr($h2);
			$h2=str_replace('|newline|','<br>',$h2);
			if ($h2_light){
				$h2_light_parts = explode(';',$h2_light);
				foreach ( $h2_light_parts as $value ){
					$h2=str_replace($value,'<span class="light_heading">'.esc_attr($value).'</span>',$h2);
					$h2=str_replace ('\n','<br>',$h2);
				
				}
			}
			$html_output.= '<div class="heading2 text-'.esc_attr($alignment).'">';
			$html_output.= '<'.esc_attr( $h2_html ).'>'.$h2.'</'.esc_attr( $h2_html ).'>';
			$html_output.= ($h2_underline) ? '<div class="line-holder"><div class="title-line themecolor1_bg"></div></div>' : '';
			$html_output.= '</div>';
		}

		if($content){

			$html_output.= '<div class="headings_p">'.wp_kses_post( $content ).'</div>' ;
			
		}

		$html_output.='</div>'; //headings div end
		/*=====  HTML OUTPUT END ======*/
		
		$output=$css_output."\n".$html_output;  //All variables inside $css_output and $html_output are properly escaped above
		return $output;	
}


add_action( 'vc_before_init', 'uber_wpb_heading_integrateWithVC' );
function uber_wpb_heading_integrateWithVC() {
	
	$params = array(
	
			array(
				'type' 			=> 'vc_links',
				'param_name' 	=> 'caption_url',
				'class'			=>	'ult_param_heading',
				'description' 	=> __( '<span style="Background: #03A9F4;padding: 10px; font-style: normal; display: block;font-weight:500;"><a href="https://wowlayers.com/infinito/?source=uber-plugin" style="color:#fff;text-decoration: none;" target="_blank">46 Ready Websites in One Wordpress Theme. Built with WPBakery.</a></span>', 'uber-wpbakery-addons' ),
			),	

		//general tab
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Heading 1', 'uber-wpbakery-addons' ),
            'param_name' => 'h1',
            'value' => '',
			'admin_label' => true,
            'description' => esc_html__( 'Enter Heading 1 text. Note: If you need to break the text on the new line, simply enter |newline| where you need it.', 'uber-wpbakery-addons' ),
			'std' => 'I AM A COOL HEADING'
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Heading 2', 'uber-wpbakery-addons' ),
            'param_name' => 'h2',
			'admin_label' => true,
            'value' => '',
			'description' => esc_html__( 'Enter Heading 2 text. Note: If you need to break the text on the new line, simply enter |newline| where you need it.', 'uber-wpbakery-addons' ),
			'std' => 'Check Out Some Cool Stuff We Can Do For You'
        ),

		array(
            'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'Heading 2 lighter text ( optional )', 'uber-wpbakery-addons' ),
            'param_name' => 'h2_light',
            'value' => '',
            'description' => esc_html__( 'This will make some parts of your font lighter. You can use multiple words/sentence separated by semicolon (;). Note:* case sensitive. Works only if font has multiple weights.', 'uber-wpbakery-addons' )
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
			'std' => 'center',
		),		
        array(
            'type' => 'textarea_html',
			'holder' => 'div',
            'class' => '',
            'heading' => esc_html__( 'Paragraph', 'uber-wpbakery-addons' ),
            'param_name' => 'content', // Important: Only one textarea_html param per content element allowed and it should have 'content' as a 'param_name'
            'value' => 'Wolf moon affogato humblebrag fap mixtape shabby chic polaroid selfies. Before they sold out squid butcher blog umami.',
            'description' => esc_html__( 'Enter your text content. Html is welcome.', 'uber-wpbakery-addons' ),
			"std" => 'Wolf moon affogato humblebrag fap mixtape shabby chic polaroid selfies. Before they sold out squid butcher blog umami.'
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
			'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
			//'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'general_css_editor',
		),		


		//Heading1 tab
        array(
            "type" => "colorpicker",
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading1',
            "class" => "",
            "heading" => esc_html__( "Text color", "js_composer" ),
            "param_name" => "h1_color",
            "value" => '', //Default color
            "description" => esc_html__( "Choose text color", "js_composer" )
        ),	

		array(
			'type' => 'dropdown',
			'edit_field_class' => 'vc_col-sm-2 vc_column',
			'group' => 'Heading1',
			'heading' => esc_html__( 'Underline?', 'uber-wpbakery-addons' ),
			'param_name' => 'h1_underline',
			'description' => esc_html__( 'Show a line under this heading.', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'No', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Yes', 'uber-wpbakery-addons' ) => 'yes',	
			),
			'std' => 'yes',
		),
        array(
            'type' => 'colorpicker',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading1',
            'heading' => esc_html__( 'Underline color', 'uber-wpbakery-addons' ),
            'param_name' => 'h1_underline_color',
            'value' => '',
			'dependency' => array(
				'element' => 'h1_underline',
				'value' => 'yes',
			),
            'description' => esc_html__( 'Add a color to this underline', 'uber-wpbakery-addons' ),
        ),        
		array(
            'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-2 vc_column',
			'group' => 'Heading1',
            'heading' => esc_html__( 'Underline width', 'uber-wpbakery-addons' ),
            'param_name' => 'h1_underline_width',
            'value' => '',
			'dependency' => array(
				'element' => 'h1_underline',
				'value' => 'yes',
			),
            'description' => esc_html__( 'Add a width in px to this underline (I.e 50px)', 'uber-wpbakery-addons' ),
        ),        
		array(
            'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-2 vc_column',
			'group' => 'Heading1',
            'heading' => esc_html__( 'Underline height', 'uber-wpbakery-addons' ),
            'param_name' => 'h1_underline_height',
            'value' => '',
			'dependency' => array(
				'element' => 'h1_underline',
				'value' => 'yes',
			),
            'description' => esc_html__( 'Add a height in px to this underline (I.e 5px)', 'uber-wpbakery-addons' ),
        ),			
		array(
			'type' => 'dropdown',
			'group' => 'Heading1',
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
			'group' => 'Heading1',
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
			'group' => 'Heading1',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'Font Size', 'uber-wpbakery-addons' ),
            'param_name' => 'h1_font_size',
            'value' => '',
            'description' => esc_html__( 'Font size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
        ),
		array(
			'type' => 'dropdown',
			'group' => 'Heading1',
			'heading' => esc_html__( 'Html tag', 'uber-wpbakery-addons' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'value' => array(
				esc_html__( 'H1', 'uber-wpbakery-addons' ) => 'h1',
				esc_html__( 'H2', 'uber-wpbakery-addons' ) => 'h2',
				esc_html__( 'H3', 'uber-wpbakery-addons' ) => 'h3',
				esc_html__( 'H4', 'uber-wpbakery-addons' ) => 'h4',
				esc_html__( 'H5', 'uber-wpbakery-addons' ) => 'h5',
				esc_html__( 'H6', 'uber-wpbakery-addons' ) => 'h6',
			),
			'std' => 'h4',
			'param_name' => 'h1_html',
		),
		array(
            'type' => 'dropdown',
			'group' => 'Heading1',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'Text Transform', 'uber-wpbakery-addons' ),
			'param_name' => 'h1_texttransform',
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Uppercase', 'uber-wpbakery-addons' ) => 'uppercase',
				esc_html__( 'Lowercase', 'uber-wpbakery-addons' ) => 'lowercase',
				esc_html__( 'Capitalize', 'uber-wpbakery-addons' ) => 'capitalize',
			),           
        ),			
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading1',
			'heading' => esc_html__( 'Line height', 'uber-wpbakery-addons' ),
			'param_name' => 'h1_line_height',
			'value' => '',
			'description' => esc_html__( 'Enter line height. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
		),	
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading1',
			'heading' => esc_html__( 'Letter Spacing', 'uber-wpbakery-addons' ),
			'param_name' => 'h1_letterspacing',
			'value' => '',
			'description' => esc_html__( 'All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
		),	
		array(
			'type' => 'css_editor',
			//'edit_field_class' => 'vc_col-sm-6 vc_column',
			'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
			'param_name' => 'h1_css_editor',
			// 'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'uber-wpbakery-addons' ),
			'group' => esc_html__( 'Heading1', 'uber-wpbakery-addons' )
		),


		//Heading2 tab
        array(
            "type" => "colorpicker",
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading2',
            "class" => "",
            "heading" => esc_html__( "Text color", "js_composer" ),
            "param_name" => "h2_color",
            "value" => '', //Default color
            "description" => esc_html__( "Choose text color", "js_composer" )
        ),		
		array(
			'type' => 'dropdown',
			'edit_field_class' => 'vc_col-sm-2 vc_column',
			'group' => 'Heading2',
			'heading' => esc_html__( 'Underline?', 'uber-wpbakery-addons' ),
			'param_name' => 'h2_underline',
			'description' => esc_html__( 'Show a line under this heading.', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'No', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Yes', 'uber-wpbakery-addons' ) => 'yes',
			),
			'std' => '',
		),
        array(
            'type' => 'colorpicker',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading2',
            'heading' => esc_html__( 'Underline color', 'uber-wpbakery-addons' ),
            'param_name' => 'h2_underline_color',
            'value' => '',
			'dependency' => array(
				'element' => 'h2_underline',
				'value' => 'yes',
			),
            'description' => esc_html__( 'Add a color to this underline', 'uber-wpbakery-addons' ),
        ),
        array(
            'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-2 vc_column',
			'group' => 'Heading2',
            'heading' => esc_html__( 'Underline width', 'uber-wpbakery-addons' ),
            'param_name' => 'h2_underline_width',
            'value' => '',
			'dependency' => array(
				'element' => 'h2_underline',
				'value' => 'yes',
			),
            'description' => esc_html__( 'Add a width in px to this underline (I.e 50px)', 'uber-wpbakery-addons' ),
        ),        
		array(
            'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-2 vc_column',
			'group' => 'Heading2',
            'heading' => esc_html__( 'Underline height', 'uber-wpbakery-addons' ),
            'param_name' => 'h2_underline_height',
            'value' => '',
			'dependency' => array(
				'element' => 'h2_underline',
				'value' => 'yes',
			),
            'description' => esc_html__( 'Add a height in px to this underline (I.e 5px)', 'uber-wpbakery-addons' ),
        ),	
		array(
			'type' => 'dropdown',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading2',
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
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading2',
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
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading2',
            'heading' => esc_html__( 'Font Size', 'uber-wpbakery-addons' ),
            'param_name' => 'h2_font_size',
            'value' => '',
            'description' => esc_html__( 'Font size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
        ),	
		array(
			'type' => 'dropdown',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading2',
			'heading' => esc_html__( 'Html tag', 'uber-wpbakery-addons' ),
			'value' => array(
				esc_html__( 'H1', 'uber-wpbakery-addons' ) => 'h1',
				esc_html__( 'H2', 'uber-wpbakery-addons' ) => 'h2',
				esc_html__( 'H3', 'uber-wpbakery-addons' ) => 'h3',
				esc_html__( 'H4', 'uber-wpbakery-addons' ) => 'h4',
				esc_html__( 'H5', 'uber-wpbakery-addons' ) => 'h5',
				esc_html__( 'H6', 'uber-wpbakery-addons' ) => 'h6',
			),
			'std' => 'h2',
			'param_name' => 'h2_html',
		),
		array(
            'type' => 'dropdown',
			'group' => 'Heading2',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'Text Transform', 'uber-wpbakery-addons' ),
			'param_name' => 'h2_texttransform',
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Uppercase', 'uber-wpbakery-addons' ) => 'uppercase',
				esc_html__( 'Lowercase', 'uber-wpbakery-addons' ) => 'lowercase',
				esc_html__( 'Capitalize', 'uber-wpbakery-addons' ) => 'capitalize',
			),           
        ),		
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading2',
			'heading' => esc_html__( 'Line height', 'uber-wpbakery-addons' ),
			'param_name' => 'h2_line_height',
			'value' => '',
			'description' => esc_html__( 'Enter line height. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
		),
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Heading2',
			'heading' => esc_html__( 'Letter Spacing', 'uber-wpbakery-addons' ),
			'param_name' => 'h2_letterspacing',
			'value' => '',
			'description' => esc_html__( 'All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
		),			
		array(
			'type' => 'css_editor',
			//'edit_field_class' => 'vc_col-sm-6 vc_column',
			'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
			'param_name' => 'h2_css_editor',
			// 'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'uber-wpbakery-addons' ),
			'group' => esc_html__( 'Heading2', 'uber-wpbakery-addons' )
		),	

		//Paragraph tab
        array(
            "type" => "colorpicker",
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Paragraph',
            "class" => "",
            "heading" => esc_html__( "Text color", "js_composer" ),
            "param_name" => "p_color",
            "value" => '', //Default color
            "description" => esc_html__( "Choose text color", "js_composer" ),
			"std" => '#505050'
        ),	
		
		array(
			'type' => 'dropdown',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Paragraph',
			'heading' => esc_html__( 'Alignment', 'uber-wpbakery-addons' ),
			'param_name' => 'p_alignment',
			'value' => array(
				esc_html__( 'Left', 'uber-wpbakery-addons' ) => 'left',
				esc_html__( 'Center', 'uber-wpbakery-addons' ) => 'center',
				esc_html__( 'Right', 'uber-wpbakery-addons' ) => 'right',

			),
			'description' => esc_html__( 'Select alignment of the paragraph. *Note: this is not text align. Text align can be done from General tab -> Paragraph editor.', 'uber-wpbakery-addons' ),
			'std' => 'center',
		),
		array(
			'type' => 'dropdown',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Paragraph',
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
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Paragraph',
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
			'group' => 'Paragraph',
            'heading' => esc_html__( 'Font Size', 'uber-wpbakery-addons' ),
            'param_name' => 'p_font_size',
            'value' => '',
            'description' => esc_html__( 'Font size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
        ),
		array(
            'type' => 'dropdown',
			'group' => 'Paragraph',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'heading' => esc_html__( 'Text Transform', 'uber-wpbakery-addons' ),
			'param_name' => 'p_texttransform',
			'value' => array(
				esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
				esc_html__( 'Uppercase', 'uber-wpbakery-addons' ) => 'uppercase',
				esc_html__( 'Lowercase', 'uber-wpbakery-addons' ) => 'lowercase',
				esc_html__( 'Capitalize', 'uber-wpbakery-addons' ) => 'capitalize',
			),           
        ),			
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Paragraph',
			'heading' => esc_html__( 'Line height', 'uber-wpbakery-addons' ),
			'param_name' => 'p_line_height',
			'value' => '',
			'description' => esc_html__( 'Enter line height. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
		),
		array(
			'type' => 'textfield',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => 'Paragraph',
			'heading' => esc_html__( 'Letter Spacing', 'uber-wpbakery-addons' ),
			'param_name' => 'p_letterspacing',
			'value' => '',
			'description' => esc_html__( 'All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' )
		),
		array(
			'type' => 'css_editor',
			//'edit_field_class' => 'vc_col-sm-6 vc_column',
			'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
			'param_name' => 'p_css_editor',
			// 'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'uber-wpbakery-addons' ),
			'group' => esc_html__( 'Paragraph', 'uber-wpbakery-addons' )
		),
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
			'description' => esc_html__( 'Units are in seconds. Enter without `s`, eg: 0.2 or 1.2', 'uber-wpbakery-addons' )
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
			'description' => esc_html__( 'Units are in seconds. Enter without `s`, eg: 0.2 or 1.2', 'uber-wpbakery-addons' )
        ),
			array(
				'type' => 'uber_wpb_vc_presets',
				'group' => 'Presets',
				'param_name' => 'presets',
				'info' => sprintf( '%s<br> <strong><em>%s</em></strong>%s<br>%s',
					esc_html__( 'Choose your preset and click save.', 'uber-wpbakery-addons' ), 
					esc_html__( 'Important Note:', 'uber-wpbakery-addons' ),
					esc_html__( 'The font(s) may vary, because they is/are the one(s) selected from theme options. ( Appearance -> Theme Options -> Typography -> Theme main font  / Theme main font 2 ).', 'uber-wpbakery-addons' ),
					esc_html__( 'If you need exactly the font you see in the preset, read bellow each preset which font(s) are used, and select them from the First title, Second title, Paragraph Tab etc. ( Select Google Font -> your desired font , or add them in theme options ( Appearance -> Theme Options -> Typography -> Theme main font  / Theme main font 2 ) and use the Theme Main font / Theme main font 2 dropdown option.  )', 'uber-wpbakery-addons' )
				),
				'on_row' => '2', //how many 
				'presets' => array(
					array('img' => 'headings/heading1.gif', 'title' => 'Heading font: Poppins / Paragraph font: Lato', 'description' => ''),
					array('img' => 'headings/heading2.gif', 'title' => 'Heading font: Poppins / Paragraph font: Lato', 'description' => ''),
					array('img' => 'headings/heading3.gif', 'title' => 'Heading font: Poppins / Paragraph font: Lato', 'description' => ''),
					array('img' => 'headings/heading4.gif', 'title' => 'Heading font: Poppins / Paragraph font: Lato', 'description' => ''),
					array('img' => 'headings/heading5.gif', 'title' => 'Heading font: Poppins / Paragraph font: Lato', 'description' => ''),
					array('img' => 'headings/heading6.gif', 'title' => 'Heading font: Poppins / Paragraph font: Lato', 'description' => ''),
					array('img' => 'headings/heading7.gif', 'title' => 'Heading font: Roboto / Paragraph font: Roboto', 'description' => ''),
					array('img' => 'headings/heading8.gif', 'title' => 'Heading font: Roboto / Paragraph font: Roboto', 'description' => ''),
					array('img' => 'headings/heading9.gif', 'title' => 'Heading font: Roboto', 'description' => ''),
					array('img' => 'headings/heading10.gif', 'title' => 'Heading font: Roboto', 'description' => ''),
					array('img' => 'headings/heading11.gif', 'title' => 'Heading font: Lato', 'description' => ''),
					array('img' => 'headings/heading12.gif', 'title' => 'Heading font: Lato', 'description' => ''),
					array('img' => 'headings/heading13.gif', 'title' => 'Heading font: Raleway / Paragraph font: Raleway', 'description' => ''),
					array('img' => 'headings/heading14.gif', 'title' => 'Heading font: Raleway / Paragraph font: Raleway', 'description' => ''),
					array('img' => 'headings/heading15.gif', 'title' => 'Heading font: Raleway / Paragraph font: Raleway', 'description' => ''),
					array('img' => 'headings/heading16.gif', 'title' => 'Heading font: Raleway / Paragraph font: Raleway', 'description' => ''),
					array('img' => 'headings/heading17.gif', 'title' => 'Heading font: Raleway / Paragraph font: Raleway', 'description' => ''),
					array('img' => 'headings/heading18.gif', 'title' => 'Heading font: Raleway / Paragraph font: Raleway', 'description' => ''),
					array('img' => 'headings/heading19.gif', 'title' => 'Heading font: Raleway / Paragraph font: Raleway', 'description' => ''),
					array('img' => 'headings/heading20.gif', 'title' => 'Heading font: Raleway / Paragraph font: Raleway', 'description' => ''),
					array('img' => 'headings/heading21.gif', 'title' => 'Heading font: Raleway / Paragraph font: Raleway', 'description' => ''),
					array('img' => 'headings/heading22.gif', 'title' => 'Heading font: Raleway / Paragraph font: Raleway', 'description' => ''),
					array('img' => 'headings/heading23.gif', 'title' => 'Heading font: Poppins / Paragraph font: Poppins', 'description' => ''),
					array('img' => 'headings/heading24.gif', 'title' => 'Heading font: Poppins / Paragraph font: Poppins', 'description' => ''),
					array('img' => 'headings/heading25.gif', 'title' => 'Heading font: Poppins / Montserrat', 'description' => ''),
					array('img' => 'headings/heading26.gif', 'title' => 'Heading font: Poppins / Montserrat', 'description' => ''),
					array('img' => 'headings/heading27.gif', 'title' => 'Heading font: Montserrat / Paragraph font: Montserrat', 'description' => ''),
					array('img' => 'headings/heading28.gif', 'title' => 'Heading font: Montserrat / Paragraph font: Montserrat', 'description' => ''),
					array('img' => 'headings/heading29.gif', 'title' => 'Heading font: Poppins', 'description' => ''),
					array('img' => 'headings/heading30.gif', 'title' => 'Heading font: Poppins', 'description' => ''),
					array('img' => 'headings/heading31.gif', 'title' => 'Heading font: Poppins / Paragraph font: Poppins', 'description' => ''),
					array('img' => 'headings/heading32.gif', 'title' => 'Heading font: Poppins / Paragraph font: Poppins', 'description' => ''),
					array('img' => 'headings/heading33.gif', 'title' => 'Heading font: Montserrat / Paragraph font: Roboto', 'description' => ''),
					array('img' => 'headings/heading34.gif', 'title' => 'Heading font: Montserrat / Paragraph font: Roboto', 'description' => ''),
					array('img' => 'headings/heading35.gif', 'title' => 'Heading font: Montserrat / Paragraph font: Roboto', 'description' => ''),
					array('img' => 'headings/heading36.gif', 'title' => 'Heading font: Montserrat / Paragraph font: Roboto', 'description' => ''),
					array('img' => 'headings/heading37.gif', 'title' => 'Heading font: Homemade Apple / Montserrat', 'description' => ''),
					array('img' => 'headings/heading38.gif', 'title' => 'Heading font: Homemade Apple / Montserrat', 'description' => ''),
					array('img' => 'headings/heading39.gif', 'title' => 'Heading font: Oswald - Montserrat / Paragraph font: Montserrat', 'description' => ''),
					array('img' => 'headings/heading40.gif', 'title' => 'Heading font: Oswald - Montserrat / Paragraph font: Montserrat', 'description' => ''),
					array('img' => 'headings/heading41.gif', 'title' => 'Heading font: Ubuntu / Paragraph font: Ubuntu', 'description' => ''),
					array('img' => 'headings/heading42.gif', 'title' => 'Heading font: Ubuntu / Paragraph font: Ubuntu', 'description' => ''),
					array('img' => 'headings/heading43.gif', 'title' => 'Heading font: Poppins - Oswald  / Paragraph font: Poppins', 'description' => ''),
					array('img' => 'headings/heading44.gif', 'title' => 'Heading font: Poppins - Oswald  / Paragraph font: Poppins', 'description' => ''),
					array('img' => 'headings/heading45.gif', 'title' => 'Heading font: Poppins / Paragraph font: Poppins', 'description' => ''),
					array('img' => 'headings/heading46.gif', 'title' => 'Heading font: Poppins / Paragraph font: Poppins', 'description' => ''),
					array('img' => 'headings/heading47.gif', 'title' => 'Heading font: Roboto / Paragraph font: Roboto', 'description' => ''),
					array('img' => 'headings/heading48.gif', 'title' => 'Heading font: Roboto / Paragraph font: Roboto', 'description' => ''),					
					array('img' => 'headings/heading49.gif', 'title' => 'Heading font: Ubuntu - American Captain / Paragraph font: Ubuntu', 'description' => ''),
					array('img' => 'headings/heading50.gif', 'title' => 'Heading font: Ubuntu - American Captain / Paragraph font: Ubuntu', 'description' => ''),
					array('img' => 'headings/heading51.gif', 'title' => 'Heading font: Poppins / Paragraph font: Poppins', 'description' => ''),
					array('img' => 'headings/heading52.gif', 'title' => 'Heading font: Poppins / Paragraph font: Poppins', 'description' => ''),					
					array('img' => 'headings/heading53.gif', 'title' => 'Heading font: Poppins / Paragraph font: Poppins', 'description' => ''),
					array('img' => 'headings/heading54.gif', 'title' => 'Heading font: Poppins / Paragraph font: Poppins', 'description' => ''),
				),
			)
		
	);
		
	vc_map( array(
			'name' => esc_html__( 'Heading', 'uber-wpbakery-addons' ),
			'base' => 'uber_wpb_headings',
			'weight' => 999,
			'icon' => 'uberwpb-texteditor-font',
			'category' => array(esc_html__('Content','uber-wpbakery-addons'),esc_html__('Uber Addons','uber-wpbakery-addons')),
			'admin_enqueue_js' =>  array( UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js' ),
			'admin_enqueue_css' => array( UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css' ),
			'front_enqueue_js' =>  array( UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js' ),
			'front_enqueue_css' => array( UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css' ),
			'description' => esc_html__( 'Add headings to content', 'uber-wpbakery-addons' ),
			'params' => $params
	) );
	
  
}
?>