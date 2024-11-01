<?php
/*
=================================================================================================================
uber_wpb_woo_vc_product_loop_tabs() - create the loop and output products on the given parameters
=================================================================================================================
*/
function uber_wpb_woo_vc_product_loop_tabs( $sort_by, $how_many = int, $banner_img = false, $banner_url = false, $category_from = false ){
	
	$html = '';
	global $product, $uber_wpb_woo_vc_tabs_per_row, $uber_wpb_woo_prod_display_style, $uber_wpb_options,$uber_wpb_md,$uber_wpb_sm,$uber_wpb_xs;
	$woo_grid = ( !empty ( $uber_wpb_woo_vc_tabs_per_row ) ) ? $uber_wpb_woo_vc_tabs_per_row : '3' ;

	//responsive per row
	$md = $uber_wpb_md ? ' vc_col-md-'.$uber_wpb_md : ' vc_col-md-4';
	$sm = $uber_wpb_sm ? ' vc_col-sm-'.$uber_wpb_sm : ' vc_col-sm-6';
	$xs = $uber_wpb_xs ? ' vc_col-xs-'.$uber_wpb_xs : ' vc_col-xs-12';


	$uber_wpb_prod_style = ( !empty( $uber_wpb_woo_prod_display_style ) )  ? $uber_wpb_woo_prod_display_style : $uber_wpb_options['styling-woo-prod-display-style'];
	$uber_wpb_woo_classes = array( 'vc_col-lg-'.esc_attr( $woo_grid ).esc_attr( $xs ).esc_attr( $sm ).esc_attr( $md ).' '.esc_attr( $uber_wpb_prod_style ).'' );
	
	if ( $banner_url ) { $banner_before_url = '<a href="'.esc_url( $banner_url ).'" target="_self">'; $banner_after_url = '</a>';   }
	else 			   { $banner_before_url = ''; $banner_after_url = '';   }
	
	$html .=  '<div class="woocommerce"><!-- woocomerce -->';
		$html .= '<ul class="products"><!-- products -->';
			if ( $sort_by == 'new' ) 	 { $args = array('post_type' => 'product','posts_per_page' => $how_many, 'orderby' => 'date', 'order' => 'desc','meta_key' => ''); }
			if ( $sort_by == 'popular' ) { $args = array('post_type' => 'product','posts_per_page' => $how_many, 'orderby' => 'total_sales', 'order' => 'desc','meta_key' => ''); }
			if ( $sort_by == 'rating' )  { $args = array('post_type' => 'product','posts_per_page' => $how_many, 'orderby' => 'rating', 'order' => 'desc','meta_key' => ''); }
			if ( $sort_by == 'random' )  { $args = array('post_type' => 'product','posts_per_page' => $how_many, 'orderby' => 'rand', 'order' => 'asc','meta_key' => ''); }
			if ( $sort_by == 'sale' )    { $args = array('post_type' => 'product','posts_per_page' => $how_many, 'meta_query' => array( 'relation' => 'OR', array( 'key' => '_sale_price', 'value' => 0,'compare' => '>','type' => 'numeric' ), array('key' => '_min_variation_sale_price','value' => 0,'compare' => '>','type' => 'numeric' ) ) ); }
			
			if ( $category_from ){
				$args['taxonomy'] = 'product_cat';
				$args['product_cat'] = $category_from ;
			}
			ob_start();
			$loop = new WP_Query( $args );
			if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();
				
?>
						<li <?php post_class( $uber_wpb_woo_classes ) ; //$uber_wpb_woo_classes escaped above ?>>
							<?php
							do_action( 'woocommerce_before_shop_loop_item' );
							do_action( 'woocommerce_shop_loop_item_title' );
							do_action( 'woocommerce_before_shop_loop_item_title' );
							do_action( 'woocommerce_after_shop_loop_item_title' );
							do_action( 'woocommerce_after_shop_loop_item' );
							?>
						</li>
						<?php
				endwhile;
				if ( $banner_img ){
					echo  '<li class="vc_col-lg-'.esc_attr( $woo_grid ).esc_attr( $xs ).esc_attr( $sm ).esc_attr( $md ).'">'.$banner_before_url.'<img src="'.esc_url( $banner_img ).'" alt="'.esc_attr( get_the_title() ).'" >'.$banner_after_url.'</li>';
				}
				
			} else {
				echo  '<li class="vc_col-md-12"><h3>'.esc_html__( 'No products found','uber-wpbakery-addons' ).'</h3></li>';
			}
			wp_reset_postdata();
	$html.= ob_get_clean  ();
		$html .= '</ul><!--/ products -->';
	$html .= '</div><!-- woocomerce -->';
	return $html;
}