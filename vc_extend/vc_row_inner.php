<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $css
 * @var $el_id
 * @var $equal_height
 * @var $content_placement
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row_Inner
 */
$el_class = $equal_height = $content_placement = $css = $el_id = $uber_wpb_css_responsive_output = '';
$disable_element = '';
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$vc_custom_class = vc_shortcode_custom_css_class( $css );

//custom css class
$uber_wpb_custom_css_class = 'custom_css_'.uniqid("", true);
$uber_wpb_custom_css_class = str_replace('.','-',$uber_wpb_custom_css_class);
$uber_wpb_custom_css_class_w_dot = '.'.$uber_wpb_custom_css_class;

$uber_wpb_responsive_class = ( $vc_custom_class ) ? $vc_custom_class : $uber_wpb_custom_css_class ;

$css_classes = array(
	'vc_row',
	'wpb_row', //deprecated
	'vc_inner',
	'vc_row-fluid',
	$el_class,
	$vc_custom_class,
	$uber_wpb_responsive_class,
);

//no paddings class
if( $uber_wpb_columns_no_paddings == "true" ){
	$css_classes[] = 'uber_wpb_inner_row_no_paddings';
}

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
	$css_classes[]='vc_row-has-fill';
}

if (!empty($atts['gap'])) {
	$css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_row-flex';
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	wp_enqueue_script('simple_one_page');
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

//background position
$uber_wpb_background_position_output = ( $uber_wpb_row_background_position && $uber_wpb_row_background_position != 'none' ) ? '<style type="text/css">.vc_row.'.$vc_custom_class .' {background-position: '.esc_attr($uber_wpb_row_background_position).' !important}</style>' : '';


//vertical text align
$uber_wpb_v_align = !empty($uber_wpb_align) ? 'vertical-align:'.esc_attr($uber_wpb_align).';' : '';

//responsive options
$uber_wpb_responsive_class_final = '.vc_row.'.$uber_wpb_responsive_class;

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

$output .= $uber_wpb_background_position_output;
$output .= $uber_wpb_css_responsive_output;
$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div>';
$output .= $after_output;

echo $output;
