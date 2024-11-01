(function($) {
	"use strict";
	window.VcCustomElementView = vc.shortcode_view.extend( {
		elementTemplate: false,
		$wrapper: false,
		changeShortcodeParams: function ( model ) {
			var params;

			window.VcCustomElementView.__super__.changeShortcodeParams.call( this, model );
			params = _.extend( {}, model.get( 'params' ) );

			if ( ! this.elementTemplate ) {
				this.elementTemplate = this.$el.find( '.vc_custom-element-container' ).html();
			}
			if ( ! this.$wrapper ) {
				this.$wrapper = this.$el.find( '.wpb_element_wrapper' );
			}
			if ( _.isObject( params ) ) {
				var template = vc.template( this.elementTemplate, vc.templateOptions.custom );
				
				this.$wrapper.find( '.vc_custom-element-container' ).html( template( { params: params } ) );
			}
			
			var get_src_obj = this.$wrapper.find( '.vc_custom-element-container span' );
			
			var image_src;
			
			$( get_src_obj ).each(function() {
			  
			  if( $(this).attr("data-src") ){
				  
				  image_src = $(this).attr("data-src");
				  return false;
				  
			  }
			});
			
			if( params.source == 'featured_image' ){
				image_src = $( "#postimagediv img" ).attr("src");
			}
			
			if( image_src ){
				this.$wrapper.find( '.vc_custom-element-container' ).html('<img src="' + image_src + '" height=80 />' ) ;
			}
			
		}
	} );
})(window.jQuery)