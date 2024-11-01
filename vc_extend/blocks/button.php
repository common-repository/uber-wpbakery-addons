<?php
/**
 * Visual Composer Custom Button Block
 *
 * @package Uber WPBakery Addons
 * @author WOW Layers
 * @link https://wowlayers.com
 */


/*
=================================================================================================================
uber_wpb_button_func( $atts, $content = null ) - Output the button custom block
=================================================================================================================
*/
add_shortcode( 'uber_wpb_button', 'uber_wpb_button_func' );
function uber_wpb_button_func( $atts, $content = NULL ) {
$custom_css_class = $data_anim = $data_anim_delay = $data_anim_duration = $css_output = $html_output = '';
$html_classes = array();  
$html_classes['general'] = array(); 

	    //default variables
	    extract( shortcode_atts( array(
		   'text' => 'I am a cool button',
		   'second_text' => 'CLICK ME NOW',
		   'url' => '',
		   'target' => '_self',
		   'btn_font_selector' => '',
		   'btn_font' => '',
		   'btn_font_m_bottom' => '',
		   'btn_font_weight' => '',
		   'btn_font_weight2' => '',
		   'letter_spacing1' => '',
		   'btn_custom_font' => '',		   
		   'btn_font_selector2' => '',
		   'btn_font2' => '',
		   'btn_custom_font2' => '',		   
		   'btn_font2_weight' => '',
		   'btn_font2_weight2' => '',
		   'letter_spacing2' => '',
		   'style' => 'fancy',
		   'font_size' => '16px',
		   'underline' => '',
		   'size' => '',
		   'shape' => 'rounded',
		   'align' => 'center',
		   'add_icon' => 'yes',
		   'icon' => '',
		   'icon_size' => '22px',
		   'icon_align' => 'left',
		   'general_css_editor' => '',
		   'padding_top'	=> '22px',
		   'padding_right'	=> '38px',
		   'padding_bottom'	=> '22px',
		   'padding_left'	=> '38px',
		   'el_class'	=> '',
		   
		   'text_color'	=> '#ffffff',
		   'hover_text_color'	=> '#505050',
		   
		   'text_icon_color' => '#ffffff',
		   'first_text_color' => '#ffffff',
		   'second_text_color' => '#ffffff',
		   'icon_color' => '#ffffff',
		   'gradient_bg_1' => '#ff1c47',
		   'gradient_bg_2' => '#4cd2de',
		   'background' => '#ff4949',
		   'box_shadow_color' => '#ff9400',
		   'border' => '#ff4949',
		   'border_size' => '2px',		   
		   'border_fancy' => '',
		   'border_fancy_size' => 'none',
		   'border_icon' => '#ffe37f',
		   'icon_bg' => '#212121',
		   'box_shadow_thickness' => '5px',
		   'gradient_type' => 'linear_diagonal',
		   
		   
		   'hover_text_icon_color' => '#FFFFFF',
		   'hover_first_text_color' => '#FFFFFF',
		   'hover_second_text_color' => '#FFFFFF',
		   'hover_icon_color' => '#FFFFFF',
		   'hover_gradient_bg_1' => '#4cd2de',
		   'hover_gradient_bg_2' => '#ff1c47',
		   'hover_background' => '#212121',
		   'hover_box_shadow_color' => '#4b4b4b',
		   'hover_border' => '#212121',
		   'hover_border_fancy' => '',
		   'hover_border_icon' => '#ffe37f',
		   'hover_icon_bg' => '#ff4949',
		   'effect_hover' => 'hvr-sweep-to-right',
		   'fancy_anim' => 'from_top',
		   
		   //animation
		   'animate' => '',
		   'animation' =>'fadeIn',	  
		   'animation_duration' => '',
		   'animation_delay' => '',	

		), $atts ) );
		
		$size = empty( $size ) && $style == 'fancy'  ? 'large' : $size;
		
		$custom_css_class = 'custom_css_'.uniqid("", true);
		$custom_css_class = str_replace('.','-',$custom_css_class);
		$custom_css_class_w_dot = '.'.esc_attr($custom_css_class); //we escape it here as we use it in many places		
	    /*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		//ESCAPED ALMOST ALL VARAIBLES HERE AS THERE IS A LARGE NUMBER OF USE //
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
	    $text 				= esc_attr($text);
	    $second_text 		= esc_attr($second_text);
	    $url 				= esc_url($url);
		$target 			= esc_attr($target);
		$btn_font_selector 	= esc_attr($btn_font_selector);
		$btn_font 			= esc_attr($btn_font);		
		$btn_custom_font 	= esc_attr($btn_custom_font);
		$btn_font_selector2 = esc_attr($btn_font_selector2);
		$btn_font2 			= esc_attr($btn_font2);
		$btn_custom_font2 	= esc_attr($btn_custom_font2);
		$style 				= esc_attr($style);
		$size 				= esc_attr($size);
		$align 				= esc_attr($align);

		$text_icon_color 		= esc_attr($text_icon_color);
		$first_text_color 		= esc_attr($first_text_color);
		$second_text_color 		= esc_attr($second_text_color);
		$icon_color 			= esc_attr($icon_color);
		$gradient_bg_1 			= esc_attr($gradient_bg_1);
		$gradient_bg_2 			= esc_attr($gradient_bg_2);
		$background 			= esc_attr($background);
		$box_shadow_color   	= esc_attr($box_shadow_color);
		$border					= esc_attr($border);
		$border_size			= esc_attr($border_size);
		$border_fancy			= esc_attr($border_fancy);
		$border_fancy_size		= esc_attr($border_fancy_size);
		$border_icon			= esc_attr($border_icon);
		$icon_bg 				= esc_attr($icon_bg);	   
		$box_shadow_thickness 	= esc_attr($box_shadow_thickness);	   
		$gradient_type 			= esc_attr($gradient_type);	   
		
		$hover_text_icon_color 	 = esc_attr($hover_text_icon_color);
		$hover_first_text_color  = esc_attr($hover_first_text_color);
		$hover_second_text_color = esc_attr($hover_second_text_color);
		$hover_icon_color 		 = esc_attr($hover_icon_color);
		$hover_gradient_bg_1 	 = esc_attr($hover_gradient_bg_1);
		$hover_gradient_bg_2 	 = esc_attr($hover_gradient_bg_2);
		$hover_background 		 = esc_attr($hover_background);
		$hover_box_shadow_color  = esc_attr($hover_box_shadow_color);
		$hover_border 	 		 = esc_attr($hover_border);
		$hover_border_fancy 	 = esc_attr($hover_border_fancy);
		$hover_border_icon 	 	 = esc_attr($hover_border_icon);
		$hover_icon_bg 			 = esc_attr($hover_icon_bg);
		$effect_hover 			 = esc_attr($effect_hover);
		$fancy_anim 			 = esc_attr($fancy_anim);
		
		$animation 			 = esc_attr($animation);
		$animation_duration  = esc_attr($animation_duration);
		$animation_delay 	 = esc_attr($animation_delay);

		wp_enqueue_style( 'hover', UBER_WPB_PLUGIN_URI.'css/hover.css' );
		
		//enqueue stuff
		if ($icon){
			uber_wpb_vc_font_icons_enqueue( $icon );
		}
		//animations
		if($animate){
			wp_enqueue_script( 'vc_waypoints' );
			wp_enqueue_script( 'script-animate' );
		}
		
		//animation output
	    if($animate){
			$data_anim    		= ' data-animate="'.$animation.'"';
			$data_anim_delay    = ' data-animate-delay="'.$animation_delay.'"';
			$data_anim_duration = ' data-animate-duration="'.$animation_duration.'"';
	    }

		//if user enter url on button
		$url_before = $url ? '<a href="'.$url.'" target="'.$target.'">' : '';
		$url_after  = $url ? '</a>' : '';		
		
		//some defaults
		//$background	  		  = (empty($background)) 		    ? '#f73838' : $background;
		$box_shadow_color	  = (empty($box_shadow_color)) 		? '#ff7171' : $box_shadow_color;
		$gradient_bg_1 	  	  = (empty($gradient_bg_1))    		? '#f73838' : $gradient_bg_1;
		$gradient_bg_2 	 	  = (empty($gradient_bg_2))    		? '#ff7171' : $gradient_bg_2;		
		$hover_gradient_bg_1  = (empty($hover_gradient_bg_1))   ? '#ff7171' : $hover_gradient_bg_1;
		$hover_gradient_bg_2  = (empty($hover_gradient_bg_2))   ? '#f73838' : $hover_gradient_bg_2;
		$border 	 		  = (empty($border))    	? '#ff7171' : $border;
		$hover_border 		  = (empty($hover_border)) 	? '#f73838' : $hover_border;
		
		$size = $style == 'fancy' && empty ( $size ) ? ' small' : $size;
		
		if( $style=='fancy' ) {
			$regular_fancy	= ' fancy';
		}
		elseif ( $style=='3d' ){
			$regular_fancy	= ' regular style-3d';
		}
		else {
			$regular_fancy	= ' regular';
		}
		
	
		//hover effect for styles flat, 3d, gradient
		$effect_hover 	  = (empty($effect_hover))    ? 'hvr-classic' : $effect_hover;
		
		//we add a space to some css classes
		$shape = ' '.$shape;		
		$align = ' '.$align;
		$size = $size ? ' '.$size : '';
		$effect_hover_w_dot = ' .'.$effect_hover;
		$effect_hover = ' '.$effect_hover;
		
		
		//font btn_custom_font
		if     ($btn_font_selector == 'googlefont') { $font   = esc_attr( uber_wpb_google_fonts($btn_font)); }
		elseif ($btn_font_selector == 'customfont' && !empty($btn_custom_font)) { $font = "font-family:'".esc_attr($btn_custom_font)."'"; }
		else   { $font = '';}		

		//font btn_custom_font 2
		if     ($btn_font_selector2 == 'googlefont') { $font2   = esc_attr( uber_wpb_google_fonts($btn_font2)); }
		elseif ($btn_font_selector2 == 'customfont' && !empty($btn_custom_font2)) { $font2 = "font-family:'".esc_attr($btn_custom_font2)."'"; }
		else   { $font2 = '';}
		
		//extra class for text padding left/right - only if an icon is added, and for fancy style we add a left/right class (for border radius purpose - via css)
		if (!empty($icon) && $add_icon == 'yes' ){
			$fancy_left_right      = ($icon_align == 'left') ? ' left' : ' right';
			$padding_left_right  = ($icon_align == 'left') ? ' padding_left' : ' padding_right';
		}
		else{
			$fancy_left_right 	 = '';
			$padding_left_right  = '';
		}
		
		//icon animation for fancy style
		$fancy_icon_anim = '';
		$fancy_anim_class = ' '.$fancy_anim;
		$icon_width_fix ='';
		if ($style == 'fancy'){
			if ($fancy_anim != 'none' && $icon && $add_icon == 'yes'){
				$fancy_icon_anim = '<div class="icon'.$regular_fancy.$size.$fancy_left_right.$shape.$padding_left_right.'"><span><i class="'.$icon.$fancy_anim_class.'"></i><i class="'.$icon.$fancy_anim_class.' second"></i></span></div>';
			}		
			else{
				$fancy_icon_anim = '<div class="icon'.$regular_fancy.$size.$fancy_left_right.$shape.$padding_left_right.'"><span><i class="'.$icon.'"></i></span></div>';
			}
		}
		else{
			$icon_width_fix = $custom_css_class_w_dot. ' .icon{width:'.esc_attr( $icon_size ).'}'; 
			if ($fancy_anim != 'none' && $icon && $add_icon == 'yes'){
				$fancy_icon_anim = '<span class="icon"><i class="'.$icon.$fancy_anim_class.'"></i><i class="'.$icon.$fancy_anim_class.' second"></i></span>';
			}
			else{
				$fancy_icon_anim = '<span class="icon"><i class="'.$icon.'"></i></span>';
			}
		}
		
		
		//if has icon for styles different than fancy
		if ($style != 'fancy'){
			$has_icon = ( !empty($icon) && $add_icon == 'yes' ) ? $fancy_icon_anim : '';
		}
		//if has icon for fancy style
		else{
			$has_icon = ( !empty($icon) && $add_icon == 'yes') ? $fancy_icon_anim : '';
		}
		
		//secondary text button - for style fancy only
		$second_text_output = ($style == 'fancy' && $second_text) ? '<div class="text2">'.$second_text.'</div>' : '';


		//icon and text position alignment and css classes when styles are different from fancy
		if ($style != 'fancy'){
			$icon_text_position = ($icon_align == 'left') ? ''.$has_icon.'<span class="text">'.$text.'</span>' : '<span class="text">'.$text.'</span>'.$has_icon.'';
		}
		//icon and text position for fancy style
		else{	
			$icon_text_position = $has_icon.'<div class="text">'.$text.'</div>'.$second_text_output.'';
		}

				//dymanic css

				$css_output.= '<style type="text/css">';
				
				$css_output .=  $icon_width_fix;

				$css_output .=  $font ? $custom_css_class_w_dot.' .uberwpb-button .text {'.$font.'}' : '' ;
				$css_output .=  $font2 ? $custom_css_class_w_dot.' .uberwpb-button .text2{'.$font2.'}' : '' ;
				
				//letter-spacing
				$css_output .=  $letter_spacing1 ? $custom_css_class_w_dot.' .uberwpb-button .text{ letter-spacing:'.esc_attr( $letter_spacing1 ).' }' : '' ;
				$css_output .=  $letter_spacing2 ? $custom_css_class_w_dot.' .uberwpb-button .text2{ letter-spacing:'.esc_attr( $letter_spacing2 ).' }' : '' ;
				
				
				if ($style == 'simple'){
					$css_output .=  $underline ? $custom_css_class_w_dot.' .uberwpb-button { text-decoration:underline }' : '' ;
					$css_output .=  $custom_css_class_w_dot.' .uberwpb-button { background:none }' ;
					$css_output .=  $custom_css_class_w_dot.' .uberwpb-button.regular span.text { line-height:2em }' ;
					
					if ( $icon_size || $font_size ){
						
						$ic = $icon_size ? absint( $icon_size ) : 22;
						$fo = $font_size ? absint( $font_size ) : 16;

						if ( $ic < $fo ){
							$css_output .=  $custom_css_class_w_dot.' .uberwpb-button { height:'.esc_attr( $fo * 2 ).'px }';
						}
						else{
							$css_output .=  $custom_css_class_w_dot.' .uberwpb-button { height:'.esc_attr( $icon_size ).' }';
						}						
					}					
				}
				
				if ($style != 'fancy'){
					$css_output .=  $text_icon_color ? $custom_css_class_w_dot.' .uberwpb-button { color:'.$text_icon_color.' }' : '' ;
					$css_output .=  $hover_text_icon_color ? $custom_css_class_w_dot.' .uberwpb-button:hover{ color:'.$hover_text_icon_color.' }' : '';
					$css_output .=  $hover_text_icon_color ? $custom_css_class_w_dot.' a:hover .uberwpb-button span{ color:'.$hover_text_icon_color.' !important }' : '';
					
					if ( $fancy_anim == 'none' ){
						$css_output .=  $hover_text_icon_color ? $custom_css_class_w_dot.' .uberwpb-button:hover i{ color:'.$hover_text_icon_color.'}' : '' ;
					}
					else{
						$css_output .=  $text_icon_color ? $custom_css_class_w_dot.' .uberwpb-button .icon i { color:'.$text_icon_color.' }' : '' ;
						$css_output .=  $hover_text_icon_color ? $custom_css_class_w_dot.'  .uberwpb-button .icon i.second { color:'.$hover_text_icon_color.' }' : '' ;
					}
				}
				if ($style != 'gradient' and $style != 'simple'){
					$css_output .=  $background ? $custom_css_class_w_dot.' .uberwpb-button { background:'.$background.' }' : '';
					$css_output .=  $hover_background ? $custom_css_class_w_dot.$effect_hover_w_dot.':hover { background:'.$hover_background.' }' : '';
				}
				if ($style == '3d'){
					$css_output .=  ($box_shadow_thickness != 'none') ? $custom_css_class_w_dot.' .uberwpb-button { box-shadow: 0 '.$box_shadow_thickness.' 0 '.$box_shadow_color.' }' : '';
					$css_output .=  ($box_shadow_thickness != 'none') ? $custom_css_class_w_dot.' .uberwpb-button:hover{ box-shadow: 0 '.$box_shadow_thickness.' 0 '.$hover_box_shadow_color.' }' : '';
					$css_output .=  ($box_shadow_thickness != 'none') ? $custom_css_class_w_dot.' .style-3d {margin-bottom:' . $box_shadow_thickness  . '; }' : '';
				}					
				if ($style == 'outline'){
					$css_output .=  ( $border_size != 'none' ) ? $custom_css_class_w_dot.' .uberwpb-button { background:none; border:solid '.$border_size.' '.$border.'  }' : '';
					$css_output .=  ( $border_size != 'none' ) ? $custom_css_class_w_dot.' .uberwpb-button:hover{ background:none; border:solid '.$border_size.' '.$hover_border.'  }' : '';
				}				
				if ($style == 'gradient'){
					
					$css_output .= $custom_css_class_w_dot.' .uberwpb-button{ background-size: 130% auto !important; }'; 
					$css_output .= $custom_css_class_w_dot.' .uberwpb-button:hover{  background-position: right center !important; /* change the direction of the change here */ }'; 
					if ($gradient_type == 'linear_top_bottom'){
						$css_output .= '
							'.$custom_css_class_w_dot.' .uberwpb-button {
								background: '.$gradient_bg_1.';
								background: -webkit-linear-gradient('.$gradient_bg_1.', '.$gradient_bg_2.');
								background: -o-linear-gradient('.$gradient_bg_1.', '.$gradient_bg_2.');
								background: -moz-linear-gradient('.$gradient_bg_1.', '.$gradient_bg_2.');
								background: linear-gradient('.$gradient_bg_1.', '.$gradient_bg_2.');								
							}
						';						
						$css_output .= '
							'.$custom_css_class_w_dot.$effect_hover_w_dot.':hover {
								background: '.$hover_gradient_bg_1.';
								background: -webkit-linear-gradient('.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: -o-linear-gradient('.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: -moz-linear-gradient('.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: linear-gradient('.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
							}
						';
					}					
					elseif ($gradient_type == 'linear_left_right'){
						$css_output .= '
							'.$custom_css_class_w_dot.' .uberwpb-button {
								background: '.$gradient_bg_1.';
								background: -webkit-linear-gradient(left,'.$gradient_bg_1.', '.$gradient_bg_2.');
								background: -o-linear-gradient(right,'.$gradient_bg_1.', '.$gradient_bg_2.');
								background: -moz-linear-gradient(right,'.$gradient_bg_1.', '.$gradient_bg_2.');
								background: linear-gradient(to right,'.$gradient_bg_1.', '.$gradient_bg_2.');								
							}							
							'.$custom_css_class_w_dot.$effect_hover_w_dot.':hover {
								background: '.$hover_gradient_bg_1.';
								background: -webkit-linear-gradient(left,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: -o-linear-gradient(right,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: -moz-linear-gradient(right,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: linear-gradient(to right,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');								
							}
						';
					}					
					elseif ($gradient_type == 'linear_diagonal'){
						$css_output .= '
							'.$custom_css_class_w_dot.' .uberwpb-button {
								background: '.$gradient_bg_1.';
								background: -webkit-linear-gradient(left top,'.$gradient_bg_1.', '.$gradient_bg_2.');
								background: -o-linear-gradient(bottom right,'.$gradient_bg_1.', '.$gradient_bg_2.');
								background: -moz-linear-gradient(bottom right,'.$gradient_bg_1.', '.$gradient_bg_2.');
								background: linear-gradient(to bottom right,'.$gradient_bg_1.', '.$gradient_bg_2.');								
							}						
							'.$custom_css_class_w_dot.$effect_hover_w_dot.':hover {
								background: '.$hover_gradient_bg_1.';
								background: -webkit-linear-gradient(left top,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: -o-linear-gradient(bottom right,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: -moz-linear-gradient(bottom right,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: linear-gradient(to bottom right,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');								
							}
						';
					}					
					elseif ($gradient_type == 'radial'){
						$css_output .= '
							'.$custom_css_class_w_dot.' .uberwpb-button {
								background: '.$gradient_bg_1.';
								background: webkit-radial-gradient(circle,'.$gradient_bg_1.', '.$gradient_bg_2.');
								background: -o-radial-gradient(circle,'.$gradient_bg_1.', '.$gradient_bg_2.');
								background: -moz-radial-gradient(circle,'.$gradient_bg_1.', '.$gradient_bg_2.');
								background: radial-gradient(circle,'.$gradient_bg_1.', '.$gradient_bg_2.');								
							}							
							'.$custom_css_class_w_dot.$effect_hover_w_dot.':hover {
								background: '.$hover_gradient_bg_1.';
								background: webkit-radial-gradient(circle,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: -o-radial-gradient(circle,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: -moz-radial-gradient(circle,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');
								background: radial-gradient(circle,'.$hover_gradient_bg_1.', '.$hover_gradient_bg_2.');								
							}
						';
					}
				}
				if ($style == 'fancy'){
					$css_output .=  $hover_background ? $custom_css_class_w_dot.$effect_hover_w_dot.':before { background:'.$hover_background.' }' : '';
					$css_output .=  ($border_fancy_size != 'none') ? $custom_css_class_w_dot.' .uberwpb-button { border:solid '.$border_fancy_size.' '.$border_fancy.' }' : '';				
					$css_output .=  $hover_border_fancy ? $custom_css_class_w_dot.' .uberwpb-button:hover{ border:solid '.$border_fancy_size.' '.$hover_border_fancy.' }' : '';				
					
					$css_output .=  $icon_bg ? $custom_css_class_w_dot.' .uberwpb-button div.icon.fancy { background:'.$icon_bg.' }' : '';		
					$css_output .=  $hover_icon_bg ? $custom_css_class_w_dot.' .uberwpb-button:hover div.icon.fancy{ background:'.$hover_icon_bg.' }' : '';		
					
					$css_output .=  $first_text_color ? $custom_css_class_w_dot.' .uberwpb-button.fancy .text { color:'.$first_text_color.' }' : '';		
					$css_output .=  $second_text_color ? $custom_css_class_w_dot.' .uberwpb-button.fancy .text2 { color:'.$second_text_color.' }' : '';		
					$css_output .=  $icon_color ? $custom_css_class_w_dot.' .uberwpb-button div.icon.fancy span i { color:'.$icon_color.' }' : '';		
					$css_output .=  $hover_first_text_color ? $custom_css_class_w_dot.' .uberwpb-button:hover.fancy .text{ color:'.$hover_first_text_color.' }' : '';		
					$css_output .=  $hover_second_text_color ? $custom_css_class_w_dot.' .uberwpb-button:hover.fancy .text2{ color:'.$hover_second_text_color.' }' : '';		
					$css_output .=  $hover_icon_color ? $custom_css_class_w_dot.' .uberwpb-button:hover div.icon.fancy span i{ color:'.$hover_icon_color.' }' : '';		
						
					if( $btn_font_m_bottom ){
						$css_output .=  $custom_css_class_w_dot.' .uberwpb-button.fancy .text{ margin-bottom:'.$btn_font_m_bottom.' }';
						$css_output .=  $custom_css_class_w_dot.'.uber_wpb_btn_container .uberwpb-button:hover i.from_top{    
										-webkit-transform: translate3d(0, calc(200% + '.esc_attr( $btn_font_m_bottom ).'), 0); 
										transform: translate3d(0, calc(200% + '.esc_attr( $btn_font_m_bottom ).'), 0);
										}';
						$css_output .=	'.uber_wpb_btn_container .uberwpb-button:hover i.second.from_top{    -webkit-transform: translate3d(0, 0, 0);transform: translate3d(0, 0, 0);}';
					}
					
					//if we have background for the icon
					if ($border_icon && $icon){
						if ($icon_align == 'left'){
							$css_output .=  $border_icon ? $custom_css_class_w_dot.' .uberwpb-button div.icon.fancy.left { border-right:solid 1px '.$border_icon.' }' : '';
							$css_output .=  $hover_border_icon ? $custom_css_class_w_dot.' .uberwpb-button:hover div.icon.fancy.left { border-right:solid 1px '.$hover_border_icon.' }' : '';
						}							
						if ($icon_align == 'right'){
							$css_output .=  $border_icon ? $custom_css_class_w_dot.' .uberwpb-button div.icon.fancy.right { border-left:solid 1px '.$border_icon.' }' : '';
							$css_output .=  $hover_border_icon ? $custom_css_class_w_dot.' .uberwpb-button:hover div.icon.fancy.right { border-left:solid 1px '.$hover_border_icon.' }' : '';
						}
					}
				}
				
				//some paddings and text size for style that alow it							
				if ( $style == 'simple' || $style == 'flat' || $style == 'gradient' || $style == 'outline' || $style == '3d'){
											
					
					if ( $style != 'simple' ){
						
						//see if paddings have px at the end, if not append px
						$padding_top = strtolower ( substr($padding_top, -2) ) == 'px' ? $padding_top : $padding_top.'px';
						$padding_right = strtolower ( substr($padding_right, -2) ) == 'px' ? $padding_right : $padding_right.'px';
						$padding_bottom = strtolower ( substr($padding_bottom, -2) ) == 'px' ? $padding_bottom : $padding_bottom.'px';
						$padding_left = strtolower ( substr($padding_left, -2) ) == 'px' ? $padding_left : $padding_left.'px';
						
						$css_output .=  $custom_css_class_w_dot.' .uberwpb-button .text{ padding-top:'. esc_attr( $padding_top ).' }';
						$css_output .=  $custom_css_class_w_dot.' .uberwpb-button .text{ padding-right:'. esc_attr( $padding_right ).' }';
						$css_output .=  $custom_css_class_w_dot.' .uberwpb-button .text{ padding-bottom:'. esc_attr( $padding_bottom ).' }';
						$css_output .=  $custom_css_class_w_dot.' .uberwpb-button .text{ padding-left:'. esc_attr( $padding_left ).' }';
					}
					
					$css_output .=  $font_size ? $custom_css_class_w_dot.' .uberwpb-button .text{ font-size:'. esc_attr( $font_size ) .';}' : '';
				
					if ( !empty($icon) and $add_icon == 'yes'){
						
						$font_size_no = str_replace(array('px','em'),'',$font_size);
						$font_size_no = $font_size_no/2;
						

						$icon_size_no = str_replace(array('px','em'),'',$icon_size);
						$half_icon_size = ceil($icon_size_no / 2);
						
						$padding_left_no = str_replace(array('px','em'),'',$padding_left);
						$padding_right_no = str_replace(array('px','em'),'',$padding_right);
						
						$left_padding_calc = $icon_size ? ceil ( $icon_size_no + $padding_left_no +  $icon_size_no/6 + 6 ) : ceil ( $font_size_no*2 + $padding_left_no +  $font_size_no/2 + 6 );
						$right_padding_calc = $icon_size ? ceil ( $icon_size_no + $padding_right_no +  $icon_size_no/6 + 6 ) :  ceil ( $font_size_no*2 + $padding_right_no +  $font_size_no/2 + 6 );
						
						$simple_left_padding_calc = $icon_size ? ceil ( $icon_size_no  +  $icon_size_no/6 ) : ceil ( $font_size_no*2 +  $font_size_no/2 );
						$simple_right_padding_calc = $icon_size ? ceil ( $icon_size_no  +  $icon_size_no/6 ) :  ceil ( $font_size_no*2 +  $font_size_no/2 );						
						
						$css_output .= $icon_size ? $custom_css_class_w_dot.' .uberwpb-button .icon i{ font-size:'. esc_attr( $icon_size ) .' !important; height: '. esc_attr( $icon_size ) .' !important; }' : 
						$custom_css_class_w_dot.' .uberwpb-button .icon i{ font-size:'. esc_attr( $font_size ) .' !important; height: '. esc_attr( $font_size ) .' !important; }';
						$css_output .= $custom_css_class_w_dot.' .uberwpb-button .icon{ top : calc(50% - '. ceil( esc_attr( $half_icon_size) ) .'px );  height: '. esc_attr( $icon_size_no ) .'px; }';
						
						if ($icon_align  == 'right' ){
							$css_output .= $icon_size ? $custom_css_class_w_dot.' .uberwpb-button .icon{ right:'. esc_attr (ceil ( $padding_right ) ).'px !important}' : 
							$custom_css_class_w_dot.' .uberwpb-button .icon{ right:'. esc_attr (ceil ( $padding_right_no + $font_size_no*2) ).'px !important}';
							
							$css_output .= $custom_css_class_w_dot.' .uberwpb-button.regular.small.padding_right span.icon i{margin-left:0}';
							$css_output .= $custom_css_class_w_dot.' .uberwpb-button .text{ padding-right:'. esc_attr( $right_padding_calc ).'px  !important}';
							
						}
						elseif( $icon_align  == 'left' ){
							$css_output .= $custom_css_class_w_dot.' .uberwpb-button .icon{ left:'. esc_attr( $padding_left ).' !important}';
							$css_output .= $custom_css_class_w_dot.' .uberwpb-button .text{ padding-left:'. esc_attr( $left_padding_calc ).'px  !important}' ;
						}												
					}								
				}	
		$css_output.= '</style>';

		//woocommerce css classes fix
		if( get_post_type() == "product" ){			
			$woo_css = str_replace( $custom_css_class_w_dot , ".woocommerce " . $custom_css_class_w_dot , $css_output);			
			$css_output .=  $woo_css;
		}
		
		//visual composer css box
		$html_classes['general'][] = ($general_css_editor) ? apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( esc_attr($general_css_editor)) ) : false;
		
		$general_custom_css_class = (array_filter($html_classes['general'])) ? ' '.esc_attr(implode(' ', array_filter($html_classes['general']))) : "";
		
	    //we add a space to $custom_css_class
	    $custom_css_class = ($custom_css_class) ? ' '.$custom_css_class : '';
		$el_class = $el_class ? ' '.esc_attr($el_class) : '';
		
		//output the button
		$html_output .= '
		<div class="uber_wpb_btn_container'.$custom_css_class.$align.$general_custom_css_class.$el_class.'"'.$data_anim.$data_anim_delay.$data_anim_duration.'>
			'.$url_before.'
			<button class="uberwpb-button'.$regular_fancy.$size.$shape.$padding_left_right.$effect_hover.'">
				'.$icon_text_position.'
			</button>
			'.$url_after.'
		</div>
			';
		
	   return $css_output."\n".$html_output; //All variables inside $css_output and $html_output are propelry escaped above

}

/*
=================================================================================================================
uber_wpb_button_integrateWithVC() - Adds the button block in VCs
=================================================================================================================
*/
add_action( 'vc_before_init', 'uber_wpb_button_integrateWithVC' );
function uber_wpb_button_integrateWithVC() {

		$thumb_url = UBER_WPB_PLUGIN_URI.'vc_extend/thumbs/';
		
		$params = array(
			array(
				'type' 			=> 'vc_links',
				'param_name' 	=> 'caption_url',
				'class'			=>	'ult_param_heading',
				'description' 	=> __( '<span style="Background: #03A9F4;padding: 10px; font-style: normal; display: block;font-weight:500;"><a href="https://wowlayers.com/infinito/?source=uber-plugin" style="color:#fff;text-decoration: none;" target="_blank">46 Ready Websites in One Wordpress Theme. Built with WPBakery.</a></span>', 'uber-wpbakery-addons' ),
			),	
		
			array(
				'type' => 'textfield',
				'class' => 'padding_fix',
				'heading' => esc_html__( 'Text on the button', 'uber-wpbakery-addons' ),
				'param_name' => 'text',
				'value' => "Button text",
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				
				'std' => 'I am a cool button',
				'admin_label' => true
			),				
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Secondary Text on the button (optional) ', 'uber-wpbakery-addons' ),
				'param_name' => 'second_text',
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				'value' => "",
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				
				'std' => 'CLICK ME NOW',
			),			
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Button URL', 'uber-wpbakery-addons' ),
				'param_name' => 'url',
				'value' => "",
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				
				'std' => '#',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Link target', 'uber-wpbakery-addons' ),
				'param_name' => 'target',
				'value' => array(
					esc_html__( 'Blank', 'uber-wpbakery-addons' ) => '_blank',				
					esc_html__( 'Self', 'uber-wpbakery-addons' ) => '_self',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__( 'The link will open in the same/new tab in browser.', 'uber-wpbakery-addons' ),
				'std' => '_self',
			),
			array(
				"type" => "uber_wpb_vc_separator",
				"param_name" => "separator1",
				'class' => 'fancy-line',
				'title' => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Style', 'uber-wpbakery-addons' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Simple ( Text Only )', 'uber-wpbakery-addons' ) => 'simple',
					esc_html__( 'Flat', 'uber-wpbakery-addons' ) => 'flat',				
					esc_html__( '3D', 'uber-wpbakery-addons' ) => '3d',
					esc_html__( 'Gradient', 'uber-wpbakery-addons' ) => 'gradient',
					esc_html__( 'Outline', 'uber-wpbakery-addons' ) => 'outline',
					esc_html__( 'Fancy', 'uber-wpbakery-addons' ) => 'fancy',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				
				'std' => 'fancy',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Shape', 'uber-wpbakery-addons' ),
				'param_name' => 'shape',
				'value' => array(
					esc_html__( 'Square', 'uber-wpbakery-addons' ) => 'square',				
					esc_html__( 'Rounded', 'uber-wpbakery-addons' ) => 'rounded',
					esc_html__( 'Round', 'uber-wpbakery-addons' ) => 'circle',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				
				'std' => 'rounded',
				'dependency' => array(
					'element' => 'style',
					'value_not_equal_to' => 'simple',
				),					
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Size', 'uber-wpbakery-addons' ),
				'param_name' => 'size',
				'value' => array(
					esc_html__( 'Small', 'uber-wpbakery-addons' ) => 'small',				
					esc_html__( 'Medium', 'uber-wpbakery-addons' ) => 'medium',
					esc_html__( 'Large', 'uber-wpbakery-addons' ) => 'large',
					esc_html__( 'Xtra Large', 'uber-wpbakery-addons' ) => 'xtra_large',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				
				'std' => 'large',
				'dependency' => array(
					'element' => 'style',
					'value_not_equal_to' => array('simple','flat','gradient','outline','3d')
				),				
			),			

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button Alignment', 'uber-wpbakery-addons' ),
				'param_name' => 'align',
				'value' => array(
					esc_html__( 'Left', 'uber-wpbakery-addons' ) => 'left',				
					esc_html__( 'Center', 'uber-wpbakery-addons' ) => 'center',
					esc_html__( 'Right', 'uber-wpbakery-addons' ) => 'right',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__( '*Note: Center alignment works with only one button on row.', 'uber-wpbakery-addons' ),
				'std' => 'center',
			),
			array(
				'type' => 'textfield',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Font size', 'uber-wpbakery-addons' ),
				'param_name' => 'font_size',
				'value' => '',
				'description' => esc_html__( 'Font size. All css units allowed. i.e 15px, 1em', 'uber-wpbakery-addons' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('simple','flat','gradient','outline','3d')
					),				
				'std' => '16px',				
			),		
			array(
				'type' => 'dropdown',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Underline?', 'uber-wpbakery-addons' ),
				'param_name' => 'underline',
				'description' => esc_html__( 'Show a line under text.', 'uber-wpbakery-addons' ),
				'value' => array(
					esc_html__( 'No', 'uber-wpbakery-addons' ) => '',				
					esc_html__( 'Yes', 'uber-wpbakery-addons' ) => 'yes',
				),
				'dependency' => array(
					'element' => 'style',
					'value' => 'simple',
				),
				'std' => '',
			),			
			array(
				"type" => "uber_wpb_vc_separator",
				"param_name" => "separator2",
				'class' => 'fancy-line',
				'title' => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Add Icon?', 'uber-wpbakery-addons' ),
				'param_name' => 'add_icon',
				
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				"std" => 'yes',
				'value' => array(
					esc_html__( 'No', 'uber-wpbakery-addons' ) => '',				
					esc_html__( 'Yes', 'uber-wpbakery-addons' ) => 'yes',
				),
			),
			array(
				'type' => 'uber_wpb_vc_fonts_select',
				'heading' => esc_html__("Select icon", "js_composer"),
				'param_name' => "icon",
				'value' => '',
				'dependency' => array(
					'element' => 'add_icon',
					'value' => 'yes',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				//'std' => 'uberwpb-webapplication-maximize'
			),
			array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Icon size*', 'uber-wpbakery-addons' ),
					'param_name' => 'icon_size',
					'value' => '',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency' => array(
						'element' => 'add_icon',
						'value' => 'yes',
					),
					'description' => esc_html__( 'Icon size in px, eg: 25px. *Does not work with Fancy style', 'uber-wpbakery-addons' )
			),			
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon Alignment', 'uber-wpbakery-addons' ),
				'param_name' => 'icon_align',
				'value' => array(
					esc_html__( 'Left', 'uber-wpbakery-addons' ) => 'left',
					esc_html__( 'Right', 'uber-wpbakery-addons' ) => 'right',
				),
				'dependency' => array(
					'element' => 'add_icon',
					'value' => 'yes',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				
				'std' => 'left',
			),
			array(
				"type" => "uber_wpb_vc_separator",
				"param_name" => "separator2",
				'class' => 'fancy-line',
				'title' => '',
			),		
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'First text margin bottom', 'uber-wpbakery-addons' ),
				'param_name' => 'btn_font_m_bottom',
				'value' => "",
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__( 'Add a margin bottom to first button font. All units allowed. I.e 15px, 1em', 'uber-wpbakery-addons' ),
				'std' => '',
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
			),			
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( '1st text font', 'uber-wpbakery-addons' ),
				'value' => array(
					esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
					esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'param_name' => 'btn_font_selector',
				
			),				
			array(
				'type' => 'google_fonts',
				'param_name' => 'btn_font',
				'value' => '',// Not recommended, this will override 'settings'. Example:
				'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
							bold italic:900:italic'),
				'settings' => array(
								 
								 'no_font_style'=>true 
						),
				'dependency' => array(
					'element' => 'btn_font_selector',
					'value' => 'googlefont',
					),					
				 // Description for field group
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( '1st text letter spacing', 'uber-wpbakery-addons' ),
				'param_name' => 'letter_spacing1',
				'value' => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),				
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( '2nd text font', 'uber-wpbakery-addons' ),
				'value' => array(
					esc_html__( 'None', 'uber-wpbakery-addons' ) => '',
					esc_html__( 'Google Font', 'uber-wpbakery-addons' ) => 'googlefont',
				),
				'dependency' => array(
						'element' => 'style',
						'value' => 'fancy',
					),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'param_name' => 'btn_font_selector2',
				
			),		
			
			array(
				'type' => 'google_fonts',
				'param_name' => 'btn_font2',
				'value' => '',// Not recommended, this will override 'settings'. Example:
				'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
							bold italic:900:italic'),
				'settings' => array(
								 
								 'no_font_style'=>true 
						),
				'dependency' => array(
					'element' => 'btn_font_selector2',
					'value' => 'googlefont',
					),					
				 // Description for field group
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( '2nd text letter spacing', 'uber-wpbakery-addons' ),
				'param_name' => 'letter_spacing2',
				'dependency' => array(
						'element' => 'style',
						'value' => 'fancy',
					),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),						
			array(
				"type" => "uber_wpb_vc_separator",
				"param_name" => "separator3",
				'class' => 'fancy-line',
				'title' => 'Paddings',
				'description' => esc_html__( 'Enter values in px, eg: 10px, 22px or simply just 10, 22 ', 'uber-wpbakery-addons' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array('flat','gradient','outline','3d')
						),						
			),	
			array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Top', 'uber-wpbakery-addons' ),
					'param_name' => 'padding_top',
					'value' => '',
					'edit_field_class' => 'vc_col-sm-3 vc_column',
					'dependency' => array(
						'element' => 'style',
						'value' => array('flat','gradient','outline','3d')
						),							
			),
			array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Right', 'uber-wpbakery-addons' ),
					'param_name' => 'padding_right',
					'value' => '',
					'edit_field_class' => 'vc_col-sm-3 vc_column',
					'dependency' => array(
						'element' => 'style',
						'value' => array('flat','gradient','outline','3d')
						),							
			),	
			array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Bottom', 'uber-wpbakery-addons' ),
					'param_name' => 'padding_bottom',
					'value' => '',
					'edit_field_class' => 'vc_col-sm-3 vc_column',
					'dependency' => array(
						'element' => 'style',
						'value' => array('flat','gradient','outline','3d')
						),							
			),	
			array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Left', 'uber-wpbakery-addons' ),
					'param_name' => 'padding_left',
					'value' => '',
					'edit_field_class' => 'vc_col-sm-3 vc_column',	
					'dependency' => array(
						'element' => 'style',
						'value' => array('flat','gradient','outline','3d')
						),							
			),				
			array(
				"type" => "uber_wpb_vc_separator",
				"param_name" => "separator4",
				'class' => 'fancy-line',
				'title' => '',
			),				
			array(
				'type' => 'textfield',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'heading' => esc_html__( 'Extra class name', 'uber-wpbakery-addons' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'Add your custom css class for this element.', 'uber-wpbakery-addons' )
			),			
			
			array(
				'type' => 'css_editor',
				'heading' => esc_html__( 'CSS box', 'uber-wpbakery-addons' ),
				'param_name' => 'general_css_editor',
			),
			array(
				"type" => "uber_wpb_vc_separator",
				"group" => "Design Options",
				"title" => "Colors",
				"param_name" => "separator5",
				'class' => 'fancy-line',
			),
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Text Color &amp; Icon Color", "js_composer" ),
				"param_name" => "text_icon_color",
				'dependency' => array(
					'element' => 'style',
					'value' => array('simple','flat','3d','gradient','outline'),
				),	
				"value" => '',
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => "#ffffff"
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"heading" => esc_html__( "Text Color ", "js_composer" ),
				"param_name" => "first_text_color",
				"value" => '',
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#ffffff'
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"heading" => esc_html__( "Second Text Color ", "js_composer" ),
				"param_name" => "second_text_color",
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#ffffff'
			),				
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"heading" => esc_html__( "Icon Color ", "js_composer" ),
				"param_name" => "icon_color",
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#ffffff'
			),					
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Gradient Background 1", "js_composer" ),
				"param_name" => "gradient_bg_1",
				'dependency' => array(
					'element' => 'style',
					'value' => 'gradient',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#ff1c47',
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Gradient Background 2", "js_composer" ),
				"param_name" => "gradient_bg_2",
				'dependency' => array(
					'element' => 'style',
					'value' => 'gradient',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#4cd2de',
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Button Background", "js_composer" ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('flat','3d','fancy'),
				),
				"param_name" => "background",
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#ff4949'
			),
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "3D Bottom Background", "js_composer" ),
				"param_name" => "box_shadow_color",
				'dependency' => array(
					'element' => 'style',
					'value' => '3d',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#ff9400',
			),				
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Outline Color", "js_composer" ),
				"param_name" => "border",
				'dependency' => array(
					'element' => 'style',
					'value' => 'outline',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#ff4949'
			),
			array(
				"type" => "dropdown",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Outline border size", "js_composer" ),
				"param_name" => "border_size",
				'dependency' => array(
					'element' => 'style',
					'value' => 'outline',
				),	
				'value' => array(
					esc_html__( 'None', 'uber-wpbakery-addons' ) => 'none',
					esc_html__( '1px', 'uber-wpbakery-addons' ) => '1px',
					esc_html__( '2px', 'uber-wpbakery-addons' ) => '2px',
					esc_html__( '3px', 'uber-wpbakery-addons' ) => '3px',
					esc_html__( '4px', 'uber-wpbakery-addons' ) => '4px',
					esc_html__( '5px', 'uber-wpbakery-addons' ) => '5px',
					esc_html__( '6px', 'uber-wpbakery-addons' ) => '6px',
					esc_html__( '7px', 'uber-wpbakery-addons' ) => '7px',
					esc_html__( '8px', 'uber-wpbakery-addons' ) => '8px',
					esc_html__( '9px', 'uber-wpbakery-addons' ) => '9px',
					esc_html__( '10px', 'uber-wpbakery-addons' ) => '10px',
					esc_html__( '11px', 'uber-wpbakery-addons' ) => '11px',
					esc_html__( '12px', 'uber-wpbakery-addons' ) => '12px',
					esc_html__( '13px', 'uber-wpbakery-addons' ) => '13px',
					esc_html__( '14px', 'uber-wpbakery-addons' ) => '14px',
					esc_html__( '15px', 'uber-wpbakery-addons' ) => '15px',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				'std' => '2px',
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Icon Background", "js_composer" ),
				"param_name" => "icon_bg",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => "#212121",
			),
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Border Color", "js_composer" ),
				"param_name" => "border_fancy",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
			),
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Icon Border Color", "js_composer" ),
				"param_name" => "border_icon",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "This will add a border to the icon on the left/right side, depending on the alignment of the icon.", "js_composer" ),
				"std" => "#ffe37f",
			),
			array(
				"type" => "dropdown",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Border thickness", "js_composer" ),
				"param_name" => "border_fancy_size",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				'value' => array(
					esc_html__( 'None', 'uber-wpbakery-addons' ) => 'none',
					esc_html__( '1px', 'uber-wpbakery-addons' ) => '1px',
					esc_html__( '2px', 'uber-wpbakery-addons' ) => '2px',
					esc_html__( '3px', 'uber-wpbakery-addons' ) => '3px',
					esc_html__( '4px', 'uber-wpbakery-addons' ) => '4px',
					esc_html__( '5px', 'uber-wpbakery-addons' ) => '5px',
					esc_html__( '6px', 'uber-wpbakery-addons' ) => '6px',
					esc_html__( '7px', 'uber-wpbakery-addons' ) => '7px',
					esc_html__( '8px', 'uber-wpbakery-addons' ) => '8px',
					esc_html__( '9px', 'uber-wpbakery-addons' ) => '9px',
					esc_html__( '10px', 'uber-wpbakery-addons' ) => '10px',
					esc_html__( '11px', 'uber-wpbakery-addons' ) => '11px',
					esc_html__( '12px', 'uber-wpbakery-addons' ) => '12px',
					esc_html__( '13px', 'uber-wpbakery-addons' ) => '13px',
					esc_html__( '14px', 'uber-wpbakery-addons' ) => '14px',
					esc_html__( '15px', 'uber-wpbakery-addons' ) => '15px',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				'std' => 'none',
			),
			array(
				"type" => "dropdown",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Box shadow thickness", "js_composer" ),
				"param_name" => "box_shadow_thickness",
				'dependency' => array(
					'element' => 'style',
					'value' => '3d',
				),	
				'value' => array(
					esc_html__( 'None', 'uber-wpbakery-addons' ) => 'none',
					esc_html__( '1px', 'uber-wpbakery-addons' ) => '1px',
					esc_html__( '2px', 'uber-wpbakery-addons' ) => '2px',
					esc_html__( '3px', 'uber-wpbakery-addons' ) => '3px',
					esc_html__( '4px', 'uber-wpbakery-addons' ) => '4px',
					esc_html__( '5px', 'uber-wpbakery-addons' ) => '5px',
					esc_html__( '6px', 'uber-wpbakery-addons' ) => '6px',
					esc_html__( '7px', 'uber-wpbakery-addons' ) => '7px',
					esc_html__( '8px', 'uber-wpbakery-addons' ) => '8px',
					esc_html__( '9px', 'uber-wpbakery-addons' ) => '9px',
					esc_html__( '10px', 'uber-wpbakery-addons' ) => '10px',
					esc_html__( '11px', 'uber-wpbakery-addons' ) => '11px',
					esc_html__( '12px', 'uber-wpbakery-addons' ) => '12px',
					esc_html__( '13px', 'uber-wpbakery-addons' ) => '13px',
					esc_html__( '14px', 'uber-wpbakery-addons' ) => '14px',
					esc_html__( '15px', 'uber-wpbakery-addons' ) => '15px',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				'std' => '5px',
			),				
			array(
				"type" => "dropdown",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Gradient Type", "js_composer" ),
				"param_name" => "gradient_type",
				'dependency' => array(
					'element' => 'style',
					'value' => 'gradient',
				),	
				'value' => array(
					esc_html__( 'Linear Gradient - Top to Bottom', 'uber-wpbakery-addons' ) => 'linear_top_bottom',
					esc_html__( 'Linear Gradient - Left to Right', 'uber-wpbakery-addons' ) => 'linear_left_right',
					esc_html__( 'Linear Gradient - Diagonal', 'uber-wpbakery-addons' ) => 'linear_diagonal',
					esc_html__( 'Radial Gradient', 'uber-wpbakery-addons' ) => 'radial',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				'std' => 'linear_diagonal',
			),			
			array(
				"type" => "uber_wpb_vc_separator",
				"group" => "Design Options",
				"title" => "Hover Colors",
				"param_name" => "separator6",
				'class' => 'fancy-line',
			),		
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Text Color &amp; Icon Color", "js_composer" ),
				"param_name" => "hover_text_icon_color",
				'dependency' => array(
					'element' => 'style',
					'value' => array('simple','flat','3d','gradient','outline'),
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#ffffff'
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"heading" => esc_html__( "Text Color ", "js_composer" ),
				"param_name" => "hover_first_text_color",
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => "#FFFFFF",
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"heading" => esc_html__( "Second Text Color ", "js_composer" ),
				"param_name" => "hover_second_text_color",
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => "#FFFFFF",
			),				
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"heading" => esc_html__( "Icon Color ", "js_composer" ),
				"param_name" => "hover_icon_color",
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => "#FFFFFF",
			),	
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Gradient Background 1", "js_composer" ),
				"param_name" => "hover_gradient_bg_1",
				'dependency' => array(
					'element' => 'style',
					'value' => 'gradient',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#4cd2de',
				
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Gradient Background 2", "js_composer" ),
				"param_name" => "hover_gradient_bg_2",
				'dependency' => array(
					'element' => 'style',
					'value' => 'gradient',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#ff1c47'
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Button Background", "js_composer" ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('flat','3d','fancy'),
				),
				"param_name" => "hover_background",
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => "#212121",
			),
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "3D Bottom Background", "js_composer" ),
				"param_name" => "hover_box_shadow_color",
				'dependency' => array(
					'element' => 'style',
					'value' => '3d',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#4b4b4b',
			),				
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Outline Color", "js_composer" ),
				"param_name" => "hover_border",
				'dependency' => array(
					'element' => 'style',
					'value' => 'outline',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => '#212121',
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Icon Background", "js_composer" ),
				"param_name" => "hover_icon_bg",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				"std" => "#ff4949",
			),
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Border Color", "js_composer" ),
				"param_name" => "hover_border_fancy",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
			),
			array(
				"type" => "colorpicker",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Icon Border Color", "js_composer" ),
				"param_name" => "hover_border_icon",
				'dependency' => array(
					'element' => 'style',
					'value' => 'fancy',
				),	
				"value" => '', //Default color
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "This will add a border to the icon on the left/right side, depending on the alignment of the icon.", "js_composer" ),
				"std" => "#ffe37f",
			),
			array(
				"type" => "dropdown",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Hover effect", "js_composer" ),
				"param_name" => "effect_hover",
				'dependency' => array(
					'element' => 'style',
					'value' => array('fancy'),
				),	
				'value' => array(
					esc_html__( 'Classic', 'uber-wpbakery-addons' ) => 'hvr-classic',
					esc_html__( 'Classic fade', 'uber-wpbakery-addons' ) => 'hvr-fade',
					esc_html__( 'Rectangle out', 'uber-wpbakery-addons' ) => 'hvr-rectangle-out',
					esc_html__( 'Shutter out horizontal', 'uber-wpbakery-addons' ) => 'hvr-shutter-out-horizontal',
					esc_html__( 'Sweep right', 'uber-wpbakery-addons' ) => 'hvr-sweep-to-right',
					esc_html__( 'Sweep left', 'uber-wpbakery-addons' ) => 'hvr-sweep-to-left',
					esc_html__( 'Sweep bottom', 'uber-wpbakery-addons' ) => 'hvr-sweep-to-bottom',
					esc_html__( 'Sweep top', 'uber-wpbakery-addons' ) => 'hvr-sweep-to-top',
					esc_html__( 'Bounce right', 'uber-wpbakery-addons' ) => 'hvr-bounce-to-right',
					esc_html__( 'Bounce left', 'uber-wpbakery-addons' ) => 'hvr-bounce-to-left',
					esc_html__( 'Bounce bottom', 'uber-wpbakery-addons' ) => 'hvr-bounce-to-bottom',
					esc_html__( 'Bounce top', 'uber-wpbakery-addons' ) => 'hvr-bounce-to-top',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				'std' => 'hvr-sweep-to-right',				
			),			
			array(
				"type" => "dropdown",
				'group' => 'Design Options',
				"class" => "",
				"heading" => esc_html__( "Icon hover animation", "js_composer" ),
				"param_name" => "fancy_anim",
				'dependency' => array(
					'element' => 'add_icon',
					'value' => 'yes',
				),
				'value' => array(
					esc_html__( 'None', 'uber-wpbakery-addons' ) => 'none',
					esc_html__( 'From Top', 'uber-wpbakery-addons' ) => 'from_top',
					esc_html__( 'From Bottom', 'uber-wpbakery-addons' ) => 'from_bottom',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				"description" => esc_html__( "", "js_composer" ),
				'std' => 'from_top',
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
			
		);
	
		vc_map( array(
			'name' => esc_html__( 'Button', 'uber-wpbakery-addons' ),
			'base' => 'uber_wpb_button',
			'weight' => 999,
			'icon' => 'pe-7f-expand',
			'category' => array(esc_html__('Content','uber-wpbakery-addons'),esc_html__('Uber Addons','uber-wpbakery-addons')),
			'admin_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'admin_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'front_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'front_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'description' => esc_html__( 'Add button.', 'uber-wpbakery-addons' ),
			'params' => $params
		) );

  
}

?>