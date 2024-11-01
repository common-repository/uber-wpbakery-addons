<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $values
 * @var $units
 * @var $bgcolor
 * @var $custombgcolor
 * @var $customtxtcolor
 * @var $options
 * @var $el_class
 * @var $css
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Progress_Bar
 */
$title = $values = $units = $bgcolor = $css = $custombgcolor = $customtxtcolor = $options = $el_class = $css_animation = $uber_wpb_css_output = '';
$output = '';
$uber_wpb_css_output_array['h'] = array();
$uber_wpb_css_output_array['p'] = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$atts = $this->convertAttributesToNewProgressBar( $atts );

extract( $atts );
wp_enqueue_script( 'vc_waypoints' );

$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$bar_options = array();
$options = explode( ',', $options );
if ( in_array( 'animated', $options ) ) {
	$bar_options[] = 'animated';
}
if ( in_array( 'striped', $options ) ) {
	$bar_options[] = 'striped';
}

if ( 'custom' === $bgcolor && '' !== $custombgcolor ) {
	$custombgcolor = ' style="' . vc_get_css_color( 'background-color', $custombgcolor ) . '"';
	if ( '' !== $customtxtcolor ) {
		$customtxtcolor = ' style="' . vc_get_css_color( 'color', $customtxtcolor ) . '"';
	}
	$bgcolor = '';
} else {
	$custombgcolor = '';
	$customtxtcolor = '';
	$bgcolor = 'vc_progress-bar-color-' . esc_attr( $bgcolor );
	$el_class .= ' ' . $bgcolor;
}

global $uber_wpb_options;

//custom css class
$uber_wpb_custom_css_class = 'custom_css_'.uniqid("", true);
$uber_wpb_custom_css_class = str_replace('.','-',$uber_wpb_custom_css_class);
$uber_wpb_custom_css_class_w_dot = '.'.$uber_wpb_custom_css_class;

//typography of text
if     ($uber_wpb_h_font_selector == 'googlefont') { $uber_wpb_css_output_array['h'][]   = esc_attr( uber_wpb_google_fonts($uber_wpb_h_font)) ; }
elseif ($uber_wpb_h_font_selector == 'customfont' && !empty($uber_wpb_h_customfont)) { $uber_wpb_css_output_array['h'][] = "font-family:'".esc_attr( $uber_wpb_h_customfont )."'"; }
else 									   { $uber_wpb_css_output_array['h'][] = '';}
		
if ( $uber_wpb_h_font_weight && $uber_wpb_h_font_selector == 'themefont' ){
	$uber_wpb_get_weight_style = explode( ':' , $uber_wpb_h_font_weight );
	$uber_wpb_css_output_array['h'][]= 'font-family:'.esc_attr( $uber_wpb_options['ctypography']["font-family"] );
	$uber_wpb_css_output_array['h'][]= 'font-weight:'.esc_attr($uber_wpb_get_weight_style[0]);
	$uber_wpb_css_output_array['h'][]= 'font-style:'.esc_attr($uber_wpb_get_weight_style[1]);
}
if ( $uber_wpb_h_font_weight2 && $uber_wpb_h_font_selector == 'themefont2' ){
	$uber_wpb_get_weight_style = explode( ':' , $uber_wpb_h_font_weight2 );
	$uber_wpb_css_output_array['h'][]= 'font-family:'.esc_attr( $uber_wpb_options['ctypography2']["font-family"] ).' !important';
	$uber_wpb_css_output_array['h'][]= 'font-weight:'.esc_attr($uber_wpb_get_weight_style[0]);
	$uber_wpb_css_output_array['h'][]= 'font-style:'.esc_attr($uber_wpb_get_weight_style[1]);
}	
$uber_wpb_h_array = array_filter($uber_wpb_css_output_array['h']);


//typography of units
if     ($uber_wpb_p_font_selector == 'googlefont') { $uber_wpb_css_output_array['p'][]   = esc_attr( uber_wpb_google_fonts($uber_wpb_p_font)) ; }
elseif ($uber_wpb_p_font_selector == 'customfont' && !empty($uber_wpb_p_customfont)) { $uber_wpb_css_output_array['p'][] = "font-family:'".esc_attr( $uber_wpb_p_customfont )."'"; }
else 									   { $uber_wpb_css_output_array['p'][] = '';}
		
if ( $uber_wpb_p_font_weight && $uber_wpb_p_font_selector == 'themefont' ){
	$uber_wpb_get_weight_style = explode( ':' , $uber_wpb_p_font_weight );
	$uber_wpb_css_output_array['p'][]= 'font-family:'.esc_attr( $uber_wpb_options['ctypography']["font-family"] );
	$uber_wpb_css_output_array['p'][]= 'font-weight:'.esc_attr($uber_wpb_get_weight_style[0]);
	$uber_wpb_css_output_array['p'][]= 'font-style:'.esc_attr($uber_wpb_get_weight_style[1]);
}
if ( $uber_wpb_p_font_weight2 && $uber_wpb_p_font_selector == 'themefont2' ){
	$uber_wpb_get_weight_style = explode( ':' , $uber_wpb_p_font_weight2 );
	$uber_wpb_css_output_array['p'][]= 'font-family:'.esc_attr( $uber_wpb_options['ctypography2']["font-family"] ).' !important';
	$uber_wpb_css_output_array['p'][]= 'font-weight:'.esc_attr($uber_wpb_get_weight_style[0]);
	$uber_wpb_css_output_array['p'][]= 'font-style:'.esc_attr($uber_wpb_get_weight_style[1]);
}
	
$uber_wpb_h_array = array_filter($uber_wpb_css_output_array['h']);
$uber_wpb_p_array = array_filter($uber_wpb_css_output_array['p']);

$class_to_filter = 'vc_progress_bar wpb_content_element';


$class_to_filter .= $style == 'theme' ? ' uber_wpb_progress_bar' : '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts ).' '.$uber_wpb_custom_css_class;

$output = '<div class="' . esc_attr( $css_class ) . '">';

$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_progress_bar_heading' ) );


$values = (array) vc_param_group_parse_atts( $values );
$max_value = 0.0;
$graph_lines_data = array();
foreach ( $values as $data ) {
	$new_line = $data;
	$new_line['value'] = isset( $data['value'] ) ? $data['value'] : 0;
	$new_line['label'] = isset( $data['label'] ) ? $data['label'] : '';
	$new_line['bgcolor'] = isset( $data['color'] ) && 'custom' !== $data['color'] ? '' : $custombgcolor;
	$new_line['txtcolor'] = isset( $data['color'] ) && 'custom' !== $data['color'] ? '' : $customtxtcolor;
	if ( isset( $data['customcolor'] ) && ( ! isset( $data['color'] ) || 'custom' === $data['color'] ) ) {
		$new_line['bgcolor'] = ' style="background-color: ' . esc_attr( $data['customcolor'] ) . ';"';
	}
	if ( isset( $data['customtxtcolor'] ) && ( ! isset( $data['color'] ) || 'custom' === $data['color'] ) ) {
		$new_line['txtcolor'] = ' style="color: ' . esc_attr( $data['customtxtcolor'] ) . ';"';
	}

	if ( $max_value < (float) $new_line['value'] ) {
		$max_value = $new_line['value'];
	}
	$graph_lines_data[] = $new_line;
}

if ( $style == 'theme' )
	{
		$uber_wpb_regular_bg = $uber_wpb_regular_bg ? $uber_wpb_regular_bg : '#f0f0f0';
		$uber_wpb_units_color = isset( $uber_wpb_units_color ) ? 'style="color:'.esc_attr( $uber_wpb_units_color ).';"' : '';
		foreach ( $graph_lines_data as $line ) {
			$uber_wpb_unit = ( '' !== $units ) ? esc_attr( $line['value'] ) . esc_attr( $units ) : esc_attr( $line['value'] );
						$output .= '<div class="uber_wpb_progress_bar_holder">';
							$output .= '<div class="uber_wpb_progress_bar_text"' . $line['txtcolor'] . '>'.esc_html( $line['label'] ).'</div>';  //escaped above
							$output .= '<div class="uber_wpb_progress_bar_unit"' . $uber_wpb_units_color . '>'.$uber_wpb_unit.'</div>';  //escaped above
						$output .= '</div>';
			$output .= '<div class="vc_general vc_single_bar" style="background-color:'.esc_attr( $uber_wpb_regular_bg ).';" >';
			$output .= '<small class="vc_label"></small>';
			if ( $max_value > 100.00 ) {
				$percentage_value = (float) $line['value'] > 0 && $max_value > 100.00 ? round( (float) $line['value'] / $max_value * 100, 4 ) : 0;
			} else {
				$percentage_value = $line['value'];
			}
			$output .= '<span class="vc_bar ' . esc_attr( implode( ' ', $bar_options ) ) . '" data-percentage-value="' . esc_attr( $percentage_value ) . '" data-value="' . esc_attr( $line['value'] ) . '"' . $line['bgcolor'] . '></span>';
			$output .= '</div>';
			
		}	
		
	}
else {
		foreach ( $graph_lines_data as $line ) {
			$uber_wpb_unit = ( '' !== $units ) ? ' <span class="vc_label_units">' . esc_html ( $line['value'] ) . esc_html( $units ) . '</span>' : ' <span class="vc_label_units">' . esc_html ( $line['value'] ). '</span>';
			$output .= '<div class="vc_general vc_single_bar' . ( ( isset( $line['color'] ) && 'custom' !== $line['color'] ) ?
					' vc_progress-bar-color-' . esc_attr( $line['color'] ) : '' )
				. '">';
			$output .= '<small class="vc_label"' . $line['txtcolor'] . '>' . esc_html( $line['label'] ) .  $uber_wpb_unit  . '</small>'; //escaped above
			if ( $max_value > 100.00 ) {
				$percentage_value = (float) $line['value'] > 0 && $max_value > 100.00 ? round( (float) $line['value'] / $max_value * 100, 4 ) : 0;
			} else {
				$percentage_value = $line['value'];
			}
			$output .= '<span class="vc_bar ' . esc_attr( implode( ' ', $bar_options ) ) . '" data-percentage-value="' . esc_attr( $percentage_value ) . '" data-value="' . esc_attr( $line['value'] ) . '"' . $line['bgcolor'] . '></span>';
			$output .= '</div>';
		}	
}
$output .= '</div>';

if( $uber_wpb_h_array || $uber_wpb_p_array  ){ //check if there are any custom css
	$uber_wpb_css_output.= '<style type="text/css">';
		if ( $style == 'theme' ){
			$uber_wpb_css_output.= ($uber_wpb_h_array) ? esc_attr( $uber_wpb_custom_css_class_w_dot )." .uber_wpb_progress_bar_text{". implode(';', array_filter($uber_wpb_h_array)).'}' : ''; //escaped above in $uber_wpb_uber_wpb_css_output_array
			$uber_wpb_css_output.= ($uber_wpb_p_array) ? esc_attr( $uber_wpb_custom_css_class_w_dot )." .uber_wpb_progress_bar_unit{". implode(';', array_filter($uber_wpb_p_array)).'}' : ''; //escaped above in $uber_wpb_uber_wpb_css_output_array
		}		
		else{
			$uber_wpb_css_output.= ($uber_wpb_h_array) ? esc_attr( $uber_wpb_custom_css_class_w_dot )." .vc_label{". implode(';', array_filter($uber_wpb_h_array)).'}' : ''; //escaped above in $uber_wpb_uber_wpb_css_output_array
			$uber_wpb_css_output.= ($uber_wpb_p_array) ? esc_attr( $uber_wpb_custom_css_class_w_dot )." .vc_label_units{". implode(';', array_filter($uber_wpb_p_array)).'}' : ''; //escaped above in $uber_wpb_uber_wpb_css_output_array
		}
	$uber_wpb_css_output.= '</style>';
}
		
echo $uber_wpb_css_output; //escaped above

echo $output;
