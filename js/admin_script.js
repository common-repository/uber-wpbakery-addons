
jQuery(document).ready(function($){
	
	"use strict";
	
	//responsive design box
	$('[data-vc-ui-element="button-save"]').on( "click", function() {
		
		var save_el=''; 
		
		$( ".uber_wpb_responsive_design_block" ).each(function() {
			
			$( ".uber_wpb_margin > input",$(this) ).each(function() {
				
				if( $(this).val() ){
					save_el += $(this).attr("data-name") + ":" + $(this).val() + " !important;";
				}
			});	
			
			$( ".uber_wpb_padding > input",$(this) ).each(function() {
				
				if( $(this).val() ){
					save_el += $(this).attr("data-name") + ":" + $(this).val() + " !important;";
				}			
			});
			
			if( save_el ){
				save_el = "{" + save_el + "}";
				$(".uber_wpb_vc_responsive_box_field",$(this)).val( save_el );	
				save_el = '';
			}
			else{
				$(".uber_wpb_vc_responsive_box_field",$(this)).val( "" );
			}
			
		});		

	});

});
