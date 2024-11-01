<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $height
 * @var $el_class
 * @var $el_id
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Empty_space
 */
$height = $el_class = $el_id = $css = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
// allowed metrics: http://www.w3schools.com/cssref/css_units.asp
$regexr = preg_match( $pattern, $height, $matches );
$value = isset( $matches[1] ) ? (float) $matches[1] : (float) WPBMap::getParam( 'vc_empty_space', 'height' );
$unit = isset( $matches[2] ) ? $matches[2] : 'px';
$height = $value . $unit;

//custom css class for use on responsive custom height
$custom_css_class = 'custom_css_'.uniqid("", true);
$custom_css_class = str_replace('.','-',$custom_css_class);
$custom_css_class_w_dot = '.'.$custom_css_class;

$inline_css = ( (float) $height >= 0.0 ) ? ' style="height: ' . esc_attr( $height ) . '"' : '';

$class = 'vc_empty_space ' . $this->getExtraClass( $el_class ) . vc_shortcode_custom_css_class( $css, ' ' );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts ).' '.$custom_css_class;
$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
?>
<?php 
if ( $space_1200 or $space_992 or $space_768 or $space_480 ){
	echo '<style type="text/css">';
		if ( $space_1200 ) { echo '@media (max-width: 1200px) { '.esc_attr( $custom_css_class_w_dot ).'{height:'.esc_attr( $space_1200 ).' !important} }'; }
		if ( $space_992 ) { echo '@media (max-width: 992px) { '.esc_attr( $custom_css_class_w_dot ).'{height:'.esc_attr( $space_992 ).' !important} }'; }
		if ( $space_768 ) { echo '@media (max-width: 768px) { '.esc_attr( $custom_css_class_w_dot ).'{height:'.esc_attr( $space_768 ).' !important} }'; }
		if ( $space_480 ) { echo '@media (max-width: 480px) { '.esc_attr( $custom_css_class_w_dot ).'{height:'.esc_attr( $space_480 ).' !important} }'; }
	echo '</style>';
}
?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?> <?php echo $inline_css; ?> ><span class="vc_empty_space_inner"></span></div>
