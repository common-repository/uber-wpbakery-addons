<?php
/**
 * Visual Composer Custom Social Block
 *
 * @package Uber WPBakery Addons
 * @author WOW Layers
 * @link https://wowlayers.com
 */


/*
=================================================================================================================
uber_wpb_social_func( $atts, $content = null ) - Output the social custom block
=================================================================================================================
*/
add_shortcode( 'uber_wpb_social', 'uber_wpb_social_func' );
function uber_wpb_social_func( $atts, $content = NULL ) {
$html_output = $css_output = $custom_css_class = $data_anim = $data_anim_delay = $data_anim_duration = '';	   
		
		//default variables
		extract( shortcode_atts( array(
			'facebook_url' => '',
			'facebook_text' => '',
			'twitter_url' => '',
			'twitter_text' => '',
			'google_url' => '',
			'google_text' => '',
			'vimeo_url' => '',
			'vimeo_text' => '',
			'youtube_url' => '',
			'youtube_text' => '',
			'skype_url' => '',
			'skype_text' => '',
			'flickr_url' => '',
			'flickr_text' => '',
			'linkedin_url' => '',
			'linkedin_text' => '',
			'pinterest_url' => '',
			'pinterest_text' => '',
			'dribbble_url' => '',
			'dribbble_text' => '',
			'instagram_url' => '',
			'instagram_text' => '',
			'behance_url' => '',
			'behance_text' => '',
			'tumblr_url' => '',
			'tumblr_text' => '',
			'viadeo_url' => '',
			'viadeo_text' => '',
			'xing_url' => '',
			'xing_text' => '',

			'el_class' => '',
			
			//design options
			'target' => '_blank',
			'icon_color' => '',
			'small_text_color' => '',
			'big_text_color' => '',
			'odd_bg' => '',
			'even_bg' => '',
			'icon_hover_color' => '',
			'small_text_hover_color' => '',
			'big_text_hover_color' => '',
			'block_bg' => '',
			'bg_hover' => '',
			
		    //animation
		    'animate' => '',
		    'animation' =>'fadeIn',	  
		    'animation_duration' => '',
		    'animation_delay' => '',
		    'animation_style' => 'one',
			
			
			
		), $atts ) );
		
		//enqueue the social font icons
		wp_enqueue_style( 'social', UBER_WPB_PLUGIN_URI.'fonts/icons/social/style.css');
		
		//if animations are enabled let's enqueue some scripts
	    if($animate){
			wp_enqueue_script( 'vc_waypoints' );
			wp_enqueue_script( 'script-animate' );
	    }
	   	
	    /*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		//ESCAPED ALMOST ALL VARAIBLES HERE AS THERE IS A LARGE NUMBER OF USE //
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		/*--------------------------------------------------------------------*/
		$target 				= esc_attr($target);
		$icon_color 			= esc_attr($icon_color);
		$small_text_color 		= esc_attr($small_text_color);
		$big_text_color			= esc_attr($big_text_color);
		$odd_bg 				= esc_attr($odd_bg);
		$even_bg 				= esc_attr($even_bg);
		$icon_hover_color 		= esc_attr($icon_hover_color);
		$small_text_hover_color = esc_attr($small_text_hover_color);
		$big_text_hover_color 	= esc_attr($big_text_hover_color);
		$block_bg 				= esc_attr($block_bg);	
	
		//let's make an array from all the social with icons, URLs and text - custom 
		$social_arr = array(
			'uberwpb-social-facebook' 	=> array($facebook_url , $facebook_text, 'facebook'), 
			'uberwpb-social-twitter' 	=> array($twitter_url , $twitter_text, 'twitter'), 
			'uberwpb-social-google-plus'		=> array($google_url , $google_text, 'google+'), 
			'uberwpb-social-vimeo' 		=> array($vimeo_url , $vimeo_text, 'vimeo'), 
			'uberwpb-social-youtube' 	=> array($youtube_url , $youtube_text, 'youtube'), 
			'uberwpb-social-skype'		=> array($skype_url , $skype_text, 'skype'), 
			'uberwpb-social-flickr' 		=> array($flickr_url , $flickr_text, 'flickr'), 
			'uberwpb-social-linkedin' 	=> array($linkedin_url , $linkedin_text, 'linkedin'),
			'uberwpb-social-pinterest' 	=> array($pinterest_url , $pinterest_text, 'pinterest'), 
			'uberwpb-social-dribbble' 	=> array($dribbble_url , $dribbble_text, 'dribbble'),
			'uberwpb-social-instagram' 	=> array($instagram_url , $instagram_text, 'instagram'), 
			'uberwpb-social-behance' 	=> array($behance_url , $behance_text, 'behance'), 
			'uberwpb-social-tumblr' 		=> array($tumblr_url , $tumblr_text, 'tumblr'), 
			'uberwpb-social-viadeo' 		=> array($viadeo_url , $viadeo_text, 'viadeo'), 
			'uberwpb-social-xing' 		=> array($xing_url , $xing_text, 'xing'),
		);
		
		//we add a unique css class at start of output for custom css styling
				$custom_css_class = 'custom_css_'.uniqid("", true);
				$custom_css_class = str_replace('.','-',$custom_css_class);
				$custom_css_class_w_dot = '.'.esc_attr( $custom_css_class );  //escaped here as there is a large number of use	

		//custom css from block options - are variables are escaped above
		if ( $icon_color || $small_text_color || $big_text_color || $odd_bg || $even_bg || $icon_hover_color || $small_text_hover_color || $big_text_hover_color || $block_bg ){	
			$css_output.= '<style type="text/css">';
					$css_output.= ($icon_color) ? $custom_css_class_w_dot. '.social_block .social_profile i{ color:'.$icon_color.' }' : '';
					$css_output.= ($small_text_color) ? $custom_css_class_w_dot. '.social_block .social_profile small{ color:'.$small_text_color.' }' : '';
					$css_output.= ($big_text_color) ? $custom_css_class_w_dot. '.social_block .social_profile h3{ color:'.$big_text_color.' }' : '';
					$css_output.= ($odd_bg) ? $custom_css_class_w_dot.  '.social_block a .social_profile{ background:'.$odd_bg.' }' : '';	
					$css_output.= ($even_bg) ? $custom_css_class_w_dot. '.social_block a:nth-child(2n) .social_profile{ background:'.$even_bg.' }' : '';
					$css_output.= ($icon_hover_color) ? $custom_css_class_w_dot. '.social_block .social_profile:hover i{ color:'.$icon_hover_color.' }' : '';
					$css_output.= ($small_text_hover_color) ? $custom_css_class_w_dot. '.social_block .social_profile:hover small{ color:'.$small_text_hover_color.' }' : '';
					$css_output.= ($big_text_hover_color) ? $custom_css_class_w_dot. '.social_block .social_profile:hover h3{ color:'.$big_text_hover_color.' }' : '';
			$css_output.= '</style>';
		}

		//let's set the hover bg color for the blocks
		if   ($block_bg) { $bg_hover = '.social_block a .social_profile:hover{ background:'.$block_bg.' }'; }
		
		//output the custom css for hover bg
		if ($bg_hover){
			$css_output.= '<style type="text/css">';
				$css_output.= $custom_css_class_w_dot. $bg_hover;
			$css_output.= '</style>';
		}		
		
		//we add a space to $custom_css_class
	    $custom_css_class = ($custom_css_class) ? ' '.$custom_css_class : '';	
		
		//start html output
		$el_class = $el_class ? ' '.$el_class : '';
		$html_output .= '<div class="social_block'.esc_attr( $custom_css_class ). esc_attr( $el_class ) .'"><!-- social_block -->';
		
	

			$counter = 0;
			foreach ($social_arr as $icon => $url_text){
				if ($url_text[0]){
					$counter++;
				}
			}
			if ($counter != 0){
				$counter 	 = esc_attr($counter);
				$grid_divide = 100 / $counter.'%';
				$grid_divide = esc_attr($grid_divide);
				
				//all variables are escaped above
				$css_output.= '<style type="text/css">';
						$css_output.= $custom_css_class_w_dot. '.social_block a.grid'.$counter.'{ width:'.$grid_divide.'; }';
				$css_output.= '</style>';
			}			

		
			
			$divide = $counter/2;
			$divide = esc_attr(round($divide));
			
			//if animation delay it's empty we set a default value
			if (empty($animation_delay)) { $animation_delay = 0.3; }

			if ($animation_style == 'one'){
				$j=0;
				$i=1;
			}			
			
			if ($animation_style == 'two'){
				$j=$animation_delay*$divide+$animation_delay;
				$i=1;
			}
			
			foreach ($social_arr as $icon => $url_text){
				if ($url_text[0]){
					
					//animation one calc
					if ($animation_style == 'one'){
						if ($i <= $divide ) { $j=$j+$animation_delay; }  
						elseif ($i <= $divide+1 && $counter % 2 == 0) { $j=$j; }
						else { $j = $j-$animation_delay; }
					}
					
					//animation two calc
					if ($animation_style == 'two'){
						if ($i==$divide && $counter % 2 != 0) { $j=-$animation_delay; }
						elseif(($i==$divide || $i==$divide+1) && $counter % 2 == 0) $j=-$animation_delay;
						else { $j =$j-$animation_delay; }
					}
					
					//animation output
					if($animate){
						$data_anim    		= 'data-animate="'.esc_attr($animation).'"';
						$data_anim_delay    = 'data-animate-delay="'.esc_attr(abs($j)).'"';
						$data_anim_duration = 'data-animate-duration="'.esc_attr($animation_duration).'"';
					}	
					
					if (empty($url_text[1])) { $url_text[1] = esc_html__('Follow me on','uber-wpbakery-addons'); }
						//html output  - all variables are escaped above
						$html_output .= '
						<a href="'.esc_url($url_text[0]).'" target="'.$target.'" class="grid'.$counter.'" '.$data_anim.''.$data_anim_delay.''.$data_anim_duration.'>
							<div class="social_profile"><!-- social_profile -->
								<div class="social_profile_inner"><!-- social_profile_inner -->
									<i class="'.esc_attr($icon).'"></i>
									<small>'.$url_text[1].'</small>
									<h3>'.$url_text[2].'</h3>
								</div><!--/ social_profile_inner -->
							</div><!--/ social_profile -->
						</a>';
					if ($animation_style == 'one' || $animation_style == 'two'){
						$i++;
					}		
				}
			}
	
		


		
		$html_output .= '</div><!--/ social_block -->';
		
		return $css_output.$html_output;  //All variables inside $css_output and $html_output are propelry escaped above

}

/*
=================================================================================================================
uber_wpb_social_integrateWithVC() - Adds the social block in VCs
=================================================================================================================
*/
add_action( 'vc_before_init', 'uber_wpb_social_integrateWithVC' );
function uber_wpb_social_integrateWithVC() {



		$params = array(
		
			array(
				'type' 			=> 'vc_links',
				'param_name' 	=> 'caption_url',
				'class'			=>	'ult_param_heading',
				'description' 	=> __( '<span style="Background: #03A9F4;padding: 10px; font-style: normal; display: block;font-weight:500;"><a href="https://wowlayers.com/infinito/?source=uber-plugin" style="color:#fff;text-decoration: none;" target="_blank">46 Ready Websites in One Wordpress Theme. Built with WPBakery.</a></span>', 'uber-wpbakery-addons' ),
			),		
			
			//Facebook
			array(
				'type' => 'checkbox',
				'param_name' => 'fb_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Facebook', 'uber-wpbakery-addons' ) => 'facebook',
				),

				
			),
			//Twitter
			array(
				'type' => 'checkbox',
				'param_name' => 'tw_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Twitter', 'uber-wpbakery-addons' ) => 'twitter',
				),
				

			),
			//Google +
			array(
				'type' => 'checkbox',
				'param_name' => 'go_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Google +', 'uber-wpbakery-addons' ) => 'google',
				),
				

			),
			//Vimeo
			array(
				'type' => 'checkbox',
				'param_name' => 'vi_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Vimeo', 'uber-wpbakery-addons' ) => 'vimeo',
				),
				

			),
			//YouTube
			array(
				'type' => 'checkbox',
				'param_name' => 'yt_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'YouTube', 'uber-wpbakery-addons' ) => 'youtube',
				),
				

			),
			//Skype
			array(
				'type' => 'checkbox',
				'param_name' => 'sk_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Skype', 'uber-wpbakery-addons' ) => 'skype',
				),
				

			),
			//Flickr
			array(
				'type' => 'checkbox',
				'param_name' => 'fl_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Flickr', 'uber-wpbakery-addons' ) => 'flickr',
				),
				

			),
			//LinkedIn
			array(
				'type' => 'checkbox',
				'param_name' => 'li_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'LinkedIn', 'uber-wpbakery-addons' ) => 'linkedin',
				),
				

			),
			//Pinterest
			array(
				'type' => 'checkbox',
				'param_name' => 'pi_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Pinterest', 'uber-wpbakery-addons' ) => 'pinterest',
				),
				

			),
			//Dribbble
			array(
				'type' => 'checkbox',
				'param_name' => 'dr_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Dribbble', 'uber-wpbakery-addons' ) => 'dribbble',
				),
				

			),
			//Instagram
			array(
				'type' => 'checkbox',
				'param_name' => 'in_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Instagram', 'uber-wpbakery-addons' ) => 'instagram',
				),
				

			),
			//Behance
			array(
				'type' => 'checkbox',
				'param_name' => 'be_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Behance', 'uber-wpbakery-addons' ) => 'behance',
				),
				

			),
			//Tumblr
			array(
				'type' => 'checkbox',
				'param_name' => 'tu_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Tumblr', 'uber-wpbakery-addons' ) => 'tumblr',
				),
				

			),			
			//Viadeo
			array(
				'type' => 'checkbox',
				'param_name' => 'va_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Viadeo', 'uber-wpbakery-addons' ) => 'viadeo',
				),
				

			),			
			//Xing
			array(
				'type' => 'checkbox',
				'param_name' => 'xi_social',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'value' => array(
					esc_html__( 'Xing', 'uber-wpbakery-addons' ) => 'xing',
				),
				

			),

			//Facebook Options			
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Facebook Custom URL', 'uber-wpbakery-addons' ),
				'param_name' => 'facebook_url',
				'value' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'fb_social',
					'value' => 'facebook',
				),				
				'description' => esc_html__( 'Enter URL. Don\'t forget the http://', 'uber-wpbakery-addons' ),
			),				
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Facebook Text', 'uber-wpbakery-addons' ),
				'param_name' => 'facebook_text',
				'value' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'fb_social',
					'value' => 'facebook',
				),				
				'description' => esc_html__( 'Enter Text ( i.e Follow me )', 'uber-wpbakery-addons' )
			),	
			
			//Twitter Options				
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Twitter Custom URL', 'uber-wpbakery-addons' ),
				'param_name' => 'twitter_url',
				'value' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'tw_social',
					'value' => 'twitter',
				),				
				'description' => esc_html__( 'Enter URL. Don\'t forget the http://', 'uber-wpbakery-addons' ),
			),				
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Twitter Text', 'uber-wpbakery-addons' ),
				'param_name' => 'twitter_text',
				'value' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'tw_social',
					'value' => 'twitter',
				),				
				'description' => esc_html__( 'Enter Text ( i.e Follow me )', 'uber-wpbakery-addons' )
			),	
			
			//Google + Options				
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Google Custom URL', 'uber-wpbakery-addons' ),
				'param_name' => 'google_url',
				'value' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'go_social',
					'value' => 'google',
				),				
				'description' => esc_html__( 'Enter URL. Don\'t forget the http://', 'uber-wpbakery-addons' ),
			),				
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Google Text', 'uber-wpbakery-addons' ),
				'param_name' => 'google_text',
				'value' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'go_social',
					'value' => 'google',
				),				
				'description' => esc_html__( 'Enter Text ( i.e Follow me )', 'uber-wpbakery-addons' )
			),
			
			//Vimeo Options				
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Vimeo Custom URL', 'uber-wpbakery-addons' ),
				'param_name' => 'vimeo_url',
				'value' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'vi_social',
					'value' => 'vimeo',
				),				
				'description' => esc_html__( 'Enter URL. Don\'t forget the http://', 'uber-wpbakery-addons' ),
			),				
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Vimeo Text', 'uber-wpbakery-addons' ),
				'param_name' => 'vimeo_text',
				'value' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'vi_social',
					'value' => 'vimeo',
				),				
				'description' => esc_html__( 'Enter Text ( i.e Follow me )', 'uber-wpbakery-addons' )
			),				
		
			
			//YouTube Options				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "YouTube Custom URL", "js_composer" ),
				"param_name" => "youtube_url",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "yt_social",
					"value" => "youtube",
				),				
				"description" => esc_html__( "Enter URL. Don't forget the http://", "js_composer" ),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "YouTube Text", "js_composer" ),
				"param_name" => "youtube_text",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "yt_social",
					"value" => "youtube",
				),				
				"description" => esc_html__( "Enter Text ( i.e Follow me )", "js_composer" )
			),		
			
			//Skype Options				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Skype Custom URL", "js_composer" ),
				"param_name" => "skype_url",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "sk_social",
					"value" => "skype",
				),				
				"description" => esc_html__( "Enter URL. Don't forget the http://", "js_composer" ),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Skype Text", "js_composer" ),
				"param_name" => "skype_text",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "sk_social",
					"value" => "skype",
				),				
				"description" => esc_html__( "Enter Text ( i.e Follow me )", "js_composer" )
			),		
			
			//Flickr Options				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Flickr Custom URL", "js_composer" ),
				"param_name" => "flickr_url",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "fl_social",
					"value" => "flickr",
				),				
				"description" => esc_html__( "Enter URL. Don't forget the http://", "js_composer" ),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Flickr Text", "js_composer" ),
				"param_name" => "flickr_text",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "fl_social",
					"value" => "flickr",
				),				
				"description" => esc_html__( "Enter Text ( i.e Follow me )", "js_composer" )
			),		
			
			//LinkedIn Options				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "LinkedIn Custom URL", "js_composer" ),
				"param_name" => "linkedin_url",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "li_social",
					"value" => "linkedin",
				),				
				"description" => esc_html__( "Enter URL. Don't forget the http://", "js_composer" ),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "LinkedIn Text", "js_composer" ),
				"param_name" => "linkedin_text",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "li_social",
					"value" => "linkedin",
				),				
				"description" => esc_html__( "Enter Text ( i.e Follow me )", "js_composer" )
			),		
			
			//Pinterest Options				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Pinterest Custom URL", "js_composer" ),
				"param_name" => "pinterest_url",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "pi_social",
					"value" => "pinterest",
				),				
				"description" => esc_html__( "Enter URL. Don't forget the http://", "js_composer" ),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Pinterest Text", "js_composer" ),
				"param_name" => "pinterest_text",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "pi_social",
					"value" => "pinterest",
				),				
				"description" => esc_html__( "Enter Text ( i.e Follow me )", "js_composer" )
			),		
			
			//Dribbble Options				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Dribbble Custom URL", "js_composer" ),
				"param_name" => "dribbble_url",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "dr_social",
					"value" => "dribbble",
				),				
				"description" => esc_html__( "Enter URL. Don't forget the http://", "js_composer" ),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Dribbble Text", "js_composer" ),
				"param_name" => "dribbble_text",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "dr_social",
					"value" => "dribbble",
				),				
				"description" => esc_html__( "Enter Text ( i.e Follow me )", "js_composer" )
			),		
			
			//Instagram Options				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Instagram Custom URL", "js_composer" ),
				"param_name" => "instagram_url",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "in_social",
					"value" => "instagram",
				),				
				"description" => esc_html__( "Enter URL. Don't forget the http://", "js_composer" ),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Instagram Text", "js_composer" ),
				"param_name" => "instagram_text",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "in_social",
					"value" => "instagram",
				),				
				"description" => esc_html__( "Enter Text ( i.e Follow me )", "js_composer" )
			),		
			
			//Behance Options				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Behance Custom URL", "js_composer" ),
				"param_name" => "behance_url",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "be_social",
					"value" => "behance",
				),				
				"description" => esc_html__( "Enter URL. Don't forget the http://", "js_composer" ),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Behance Text", "js_composer" ),
				"param_name" => "behance_text",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "be_social",
					"value" => "behance",
				),				
				"description" => esc_html__( "Enter Text ( i.e Follow me )", "js_composer" )
			),		
			
			//Tumblr Options				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Tumblr Custom URL", "js_composer" ),
				"param_name" => "tumblr_url",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "tu_social",
					"value" => "tumblr",
				),				
				"description" => esc_html__( "Enter URL. Don't forget the http://", "js_composer" ),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Tumblr Text", "js_composer" ),
				"param_name" => "tumblr_text",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "tu_social",
					"value" => "tumblr",
				),				
				"description" => esc_html__( "Enter Text ( i.e Follow me )", "js_composer" )
			),		
			
			//Viadeo Options				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Viadeo Custom URL", "js_composer" ),
				"param_name" => "viadeo_url",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "va_social",
					"value" => "viadeo",
				),				
				"description" => esc_html__( "Enter URL. Don't forget the http://", "js_composer" ),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Viadeo Text", "js_composer" ),
				"param_name" => "viadeo_text",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "va_social",
					"value" => "viadeo",
				),				
				"description" => esc_html__( "Enter Text ( i.e Follow me )", "js_composer" )
			),		
			
			//Xing Options				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Xing Custom URL", "js_composer" ),
				"param_name" => "xing_url",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "xi_social",
					"value" => "xing",
				),				
				"description" => esc_html__( "Enter URL. Don't forget the http://", "js_composer" ),
			),				
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Xing Text", "js_composer" ),
				"param_name" => "xing_text",
				"value" => esc_html__( "", "js_composer" ),
				"edit_field_class" => "vc_col-sm-6 vc_column",
				"dependency" => array(
					"element" => "xi_social",
					"value" => "xing",
				),				
				"description" => esc_html__( "Enter Text ( i.e Follow me )", "js_composer" )
			),			
			
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'uber-wpbakery-addons' ),
				'param_name' => 'el_class',
				'value' => '',
				'edit_field_class' => 'vc_col-sm-42 vc_column',
				'description' => esc_html__( 'Add your custom css class for this element.', 'uber-wpbakery-addons' )
			),
			//Options Tab
			array(
				"type" => "uber_wpb_vc_separator",
				'group' => 'Options',
				"title" => esc_html__( "Animations", "js_composer" ),
				"param_name" => "separator",
				"class" => 'line',
			),			
			array(
				'type' => 'checkbox',
				'group' => 'Options',
				'heading' => esc_html__( 'Animate?', 'uber-wpbakery-addons' ),
				'param_name' => 'animate',
				'std' => 'false',
			),
			array(
				'type' => 'uber_wpb_vc_animations_in',
				'group' => 'Options',
				'heading' => esc_html__( 'Animation List', 'uber-wpbakery-addons' ),
				'param_name' => 'animation',
				'value' =>'',
				'dependency' => array(
					'element' => 'animate',
					'value' => 'true',
				),
				'description' => esc_html__( 'Choose list animation', 'uber-wpbakery-addons' ),
			),
			array(
				'type' => 'textfield',
				'group' => 'Options',
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
				'group' => 'Options',
				'heading' => esc_html__( 'Animation Delay', 'uber-wpbakery-addons' ),
				'param_name' => 'animation_delay',
				'value' => '',
				'dependency' => array(
					'element' => 'animate',
					'value' => 'true',
					),
				'description' => esc_html__( 'Units are in seconds. Enter without "s", eg: 0.2 or 1.2', 'uber-wpbakery-addons' )
			),	
			array(
				'type' => 'dropdown',
				'group' => 'Options',
				'heading' => esc_html__( 'Animation Style', 'uber-wpbakery-addons' ),
				'param_name' => 'animation_style',
				'dependency' => array(
					'element' => 'animate',
					'value' => 'true',
				),
				'value' => array(
					esc_html__( 'Edge to Center', 'uber-wpbakery-addons' ) => 'one',				
					esc_html__( 'Center to Edge' , 'uber-wpbakery-addons') => 'two',
				),
				'description' => esc_html__( 'This will apply for both facebook and twitter, or for the whole div if first style is selected.', 'uber-wpbakery-addons' ),
				'std' => 'one',
			),				
			array(
				"type" => "uber_wpb_vc_separator",
				'group' => 'Options',
				"title" => esc_html__( "Link Options", "js_composer" ),
				"param_name" => "separator",
				"class" => 'line',
			),
			array(
				'type' => 'dropdown',
				'group' => 'Options',
				'heading' => esc_html__( 'Link target', 'uber-wpbakery-addons' ),
				'param_name' => 'target',
				'value' => array(
					esc_html__( 'Blank', 'uber-wpbakery-addons' ) => '_blank',				
					esc_html__( 'Self', 'uber-wpbakery-addons' ) => '_self',
				),
				'description' => esc_html__( 'Select how the URLs will open.', 'uber-wpbakery-addons' )
			),			
			array(
				"type" => "uber_wpb_vc_separator",
				'group' => 'Options',
				"title" => esc_html__( "Text Color Options", "js_composer" ),
				"param_name" => "separator",
				"class" => 'line',
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Options',
				"heading" => esc_html__( "Icon Color", "js_composer" ),
				"param_name" => "icon_color",
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Options',
				"heading" => esc_html__( "Small Text Color", "js_composer" ),
				"param_name" => "small_text_color",
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),				
			array(
				"type" => "colorpicker",
				'group' => 'Options',
				"heading" => esc_html__( "Big Text Color", "js_composer" ),
				"param_name" => "big_text_color",
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),
			array(
				"type" => "uber_wpb_vc_separator",
				'group' => 'Options',
				"title" => esc_html__( "Background Options", "js_composer" ),
				"param_name" => "separator",
				"class" => 'line',
			),
			array(
				"type" => "colorpicker",
				'group' => 'Options',
				"heading" => esc_html__( "Odd Blocks Background", "js_composer" ),
				"param_name" => "odd_bg",
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"description" => esc_html__( "This is the color for odd blocks background. i.e. (1st, 3rd, 5th block)", "js_composer" )
			),				
			array(
				"type" => "colorpicker",
				'group' => 'Options',
				"heading" => esc_html__( "Even Blocks Background", "js_composer" ),
				"param_name" => "even_bg",
				"edit_field_class" => "vc_col-sm-4 vc_column",
				"description" => esc_html__( "This is the color for even blocks background. i.e. (2nd, 4th, 6th block)", "js_composer" )
			),				
			array(
				"type" => "uber_wpb_vc_separator",
				'group' => 'Options',
				"title" => esc_html__( "Hover Options", "js_composer" ),
				"param_name" => "separator",
				"class" => 'line',
			),
			array(
				"type" => "colorpicker",
				'group' => 'Options',
				"heading" => esc_html__( "Icon Hover Color", "js_composer" ),
				"param_name" => "icon_hover_color",
				"edit_field_class" => "vc_col-sm-3 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Options',
				"heading" => esc_html__( "Small Text Hover Color", "js_composer" ),
				"param_name" => "small_text_hover_color",
				"edit_field_class" => "vc_col-sm-3 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),				
			array(
				"type" => "colorpicker",
				'group' => 'Options',
				"heading" => esc_html__( "Big Text Hover Color", "js_composer" ),
				"param_name" => "big_text_hover_color",
				"edit_field_class" => "vc_col-sm-3 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),			
			array(
				"type" => "colorpicker",
				'group' => 'Options',
				"heading" => esc_html__( "Block Hover Background", "js_composer" ),
				"param_name" => "block_bg",
				"edit_field_class" => "vc_col-sm-3 vc_column",
				"description" => esc_html__( "Leave blank for theme default color.", "js_composer" )
			),			
		);
	
		vc_map( array(
			'name' => esc_html__( 'Social', 'uber-wpbakery-addons' ),
			'base' => 'uber_wpb_social',
			'weight' => 999,
			'icon' => 'uberwpb-mobileui-social-link',
			'category' => array(esc_html__('Content','uber-wpbakery-addons'),esc_html__('Uber Addons','uber-wpbakery-addons')),
			'admin_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'admin_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),
			'front_enqueue_js' =>  array(UBER_WPB_PLUGIN_URI .'/vc_extend/js/custom.js'),
			'front_enqueue_css' => array(UBER_WPB_PLUGIN_URI .'/vc_extend/css/style.css'),			
			'description' => esc_html__( 'Add a social block', 'uber-wpbakery-addons' ),
			'params' => $params
		) );

}

?>