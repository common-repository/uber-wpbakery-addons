<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column_Inner
 */
$el_class = $el_id = $width = $parallax_speed_bg = $parallax_speed_video = $parallax = $parallax_image = $video_bg = $video_bg_url = $video_bg_parallax = $css = $offset = $css_animation = $css_output = '';
$output = $uber_wpb_css_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

//custom css class
$uber_wpb_custom_css_class = 'custom_css_'.uniqid("", true);
$uber_wpb_custom_css_class = str_replace('.','-',$uber_wpb_custom_css_class);
$uber_wpb_custom_css_class_w_dot = '.'.$uber_wpb_custom_css_class;
$uber_wpb_custom_css_class_space = ' '.$uber_wpb_custom_css_class;

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$css_classes = array(
	$this->getExtraClass( $el_class ),
	'wpb_column',
	'vc_column_container',
	$width,
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
	$css_classes[]='vc_col-has-fill';
}

if  ( $css_animation != 'none' ){
	$css_classes[] = ' '.$css_animation;
	$css_classes[] .= ' wpb_animate_when_almost_visible';
	$css_classes[] .= ' wpb_'.$css_animation;
	$css_classes[] .= ' wpb_start_animation ';
	$css_classes[] .= ' animated';
}

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

//custom border radius
$uber_wpb_vc_custom_css_class = esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) );

$uber_wpb_border_radius_output = ( $uber_wpb_border_radius ) ? '.'.$uber_wpb_vc_custom_css_class.' { border-radius: '.esc_attr( $uber_wpb_border_radius ).'}' : '';


//background position
$uber_wpb_background_position_output = ( $uber_wpb_column_background_position && $uber_wpb_column_background_position != 'none' ) ? '.'.$uber_wpb_vc_custom_css_class.' {background-position: '.esc_attr($uber_wpb_column_background_position).' !important}' : '';

//css output
$uber_wpb_css_output.= $uber_wpb_border_radius_output.$uber_wpb_background_position_output ;

if( $uber_wpb_css_output ){
	echo '<style type="text/css">';
		echo $uber_wpb_css_output;
	echo '</style>';
}


//responsive options
$uber_wpb_css_responsive_output  = '';
if (  $uber_wpb_col_1200 or $uber_wpb_col_992 or $uber_wpb_col_768 or $uber_wpb_col_480  ) {
	$uber_wpb_css_responsive_output .= '<style type="text/css">';
		$uber_wpb_css_responsive_output .= ( $uber_wpb_col_1200 ) ? '@media (max-width: 1200px) { '.esc_attr( $uber_wpb_custom_css_class_w_dot ).esc_attr( $uber_wpb_col_1200 ).' }' : '';
		$uber_wpb_css_responsive_output .= ( $uber_wpb_col_992 ) ? '@media (max-width: 992px) { '.esc_attr( $uber_wpb_custom_css_class_w_dot ).esc_attr( $uber_wpb_col_992 ).' }' : '';
		$uber_wpb_css_responsive_output .= ( $uber_wpb_col_768 ) ? '@media (max-width: 768px) { '.esc_attr( $uber_wpb_custom_css_class_w_dot ).esc_attr( $uber_wpb_col_768 ).' }' : '';
		$uber_wpb_css_responsive_output .= ( $uber_wpb_col_480 ) ? '@media (max-width: 480px) { '.esc_attr( $uber_wpb_custom_css_class_w_dot ).esc_attr( $uber_wpb_col_480 ).' }' : '';
	$uber_wpb_css_responsive_output .= '</style>';
}

$output .= $uber_wpb_css_responsive_output;
$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= '<div class="vc_column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) . esc_attr( $uber_wpb_custom_css_class_space  ). '">';
$output .= '<div class="wpb_wrapper">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;