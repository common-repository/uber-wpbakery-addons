<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var WPBakeryShortCode_Vc_Row $this
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = $css_animation = $uber_wpb_css_responsive_output = $uber_wpb_rtl_css = '';
$disable_element = '';
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

global $uber_wpb_options;

//themecolors
if ( is_array ( $atts ) ){
	foreach ($atts as &$att) {
		$att = str_replace(array('themecolor1','themecolor2','themecolor3'), array($uber_wpb_options['theme-color1'],$uber_wpb_options['theme-color2'],$uber_wpb_options['theme-color3']), $att);
	}
}	

$vc_custom_class = vc_shortcode_custom_css_class( $css );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$css_classes = array(
	'vc_section',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

//custom css class
$uber_wpb_custom_css_class = 'custom_css_'.uniqid("", true);
$uber_wpb_custom_css_class = str_replace('.','-',$uber_wpb_custom_css_class);
$uber_wpb_custom_css_class_w_dot = '.'.$uber_wpb_custom_css_class;	

$uber_wpb_responsive_class = ( $vc_custom_class ) ? $vc_custom_class : $uber_wpb_custom_css_class ;

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

if ( vc_shortcode_custom_css_has_property( $css, array(
	'border',
	'background',
) ) || $video_bg || $parallax
) {
	$css_classes[] = 'vc_section-has-fill';
}


$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	}
	$after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = 'vc_row-o-full-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_section-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_section-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$parallax_speed = $parallax_speed_bg;
if ( $has_video_bg ) {
	$parallax = $video_bg_parallax;
	$parallax_speed = $parallax_speed_video;
	$parallax_image = $video_bg_url;
	$css_classes[] = 'vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"'; // parallax speed
	$css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( false !== strpos( $parallax, 'fade' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( false !== strpos( $parallax, 'fixed' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
}

if ( ! empty( $parallax_image ) ) {
	if ( $has_video_bg ) {
		$parallax_image_src = $parallax_image;
	} else {
		$parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
		$parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
		if ( ! empty( $parallax_image_src[0] ) ) {
			$parallax_image_src = $parallax_image_src[0];
		}
	}
	$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

//background position
$uber_wpb_background_position_output = ( $uber_wpb_row_background_position && $uber_wpb_row_background_position != 'none' ) ? '<style type="text/css">.vc_section.'.$vc_custom_class .' {background-position: '.esc_attr($uber_wpb_row_background_position).' !important}</style>' : '';

//responsive options
$uber_wpb_responsive_class_final = '.vc_section.'.$uber_wpb_responsive_class;

//1200
if ( $uber_wpb_bg_color_1200 or $uber_wpb_bg_1200 or $uber_wpb_bg_pos_1200 or $uber_wpb_bg_rep_1200 or $uber_wpb_row_1200 ){
	$uber_wpb_css_responsive_output .= '@media (max-width: 1200px) {';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_color_1200 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-color:'.esc_attr( $uber_wpb_bg_color_1200 ).' !important; background-image:none !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_1200 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-image:url( '.esc_url( wp_get_attachment_url ( $uber_wpb_bg_1200 ) ).' ) !important  }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_pos_1200 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-position: '.esc_attr( $uber_wpb_bg_pos_1200 ).' !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_rep_1200 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-repeat: '.esc_attr( $uber_wpb_bg_rep_1200 ).' !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_row_1200 ) ? esc_attr( $uber_wpb_responsive_class_final ).esc_attr( $uber_wpb_row_1200 ) : '';
	$uber_wpb_css_responsive_output .= '}';
}

//992
if ( $uber_wpb_bg_color_992 or $uber_wpb_bg_992 or $uber_wpb_bg_pos_992 or $uber_wpb_bg_rep_992 or $uber_wpb_row_992 ){
	$uber_wpb_css_responsive_output .= '@media (max-width: 992px) {';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_color_992 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-color:'.esc_attr( $uber_wpb_bg_color_992 ).' !important; background-image:none !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_992 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-image:url( '.esc_url( wp_get_attachment_url ( $uber_wpb_bg_992 ) ).' ) !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_pos_992 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-position: '.esc_attr( $uber_wpb_bg_pos_992 ).' !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_rep_992 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-repeat: '.esc_attr( $uber_wpb_bg_rep_992 ).' !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_row_992 ) ? esc_attr( $uber_wpb_responsive_class_final ).esc_attr( $uber_wpb_row_992 ) : '';
	$uber_wpb_css_responsive_output .= '}';
}

//768
if ( $uber_wpb_bg_color_768 or $uber_wpb_bg_768 or $uber_wpb_bg_pos_768 or $uber_wpb_bg_rep_768 or $uber_wpb_row_768 ){
	$uber_wpb_css_responsive_output .= '@media (max-width: 768px) {';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_color_768 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-color:'.esc_attr( $uber_wpb_bg_color_768 ).' !important; background-image:none !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_768 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-image:url( '.esc_url( wp_get_attachment_url ( $uber_wpb_bg_768 ) ).' ) !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_pos_768 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-position: '.esc_attr( $uber_wpb_bg_pos_768 ).' !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_rep_768 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-repeat: '.esc_attr( $uber_wpb_bg_rep_768 ).' !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_row_768 ) ? esc_attr( $uber_wpb_responsive_class_final ).esc_attr( $uber_wpb_row_768 ) : '';
	$uber_wpb_css_responsive_output .= '}';
}

//480
if ( $uber_wpb_bg_color_480 or $uber_wpb_bg_480 or $uber_wpb_bg_pos_480 or $uber_wpb_bg_rep_480 or $uber_wpb_row_480 ){
	$uber_wpb_css_responsive_output .= '@media (max-width: 480px) {';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_color_480 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-color:'.esc_attr( $uber_wpb_bg_color_480 ).' !important; background-image:none !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_480 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-image:url( '.esc_url( wp_get_attachment_url ( $uber_wpb_bg_480 ) ).' ) !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_pos_480 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-position: '.esc_attr( $uber_wpb_bg_pos_480 ).' !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_bg_rep_480 ) ? esc_attr( $uber_wpb_responsive_class_final ).' { background-repeat: '.esc_attr( $uber_wpb_bg_rep_480 ).' !important }' : '';
	$uber_wpb_css_responsive_output .=  ( $uber_wpb_row_480 ) ? esc_attr( $uber_wpb_responsive_class_final ).esc_attr( $uber_wpb_row_480 ) : '';
	$uber_wpb_css_responsive_output .= '}';
}

$uber_wpb_css_responsive_output = $uber_wpb_css_responsive_output  ? '<style type="text/css">'. $uber_wpb_css_responsive_output .'</style>' : '';
$uber_wpb_rtl_css .=  is_rtl()  ? '<style type="text/css">.wpb_column.vc_column_container{ float:right }</style>' : '';

$output .= '<section ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= $uber_wpb_background_position_output;
$output .= $uber_wpb_css_responsive_output.$uber_wpb_rtl_css;
$output .= wpb_js_remove_wpautop( $content );
$output .= '</section>';
$output .= $after_output;

// @codingStandardsIgnoreLine
echo $output;
