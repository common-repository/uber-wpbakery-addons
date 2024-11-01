//Intitialize animations
(function ($) {
	
	"use strict";


	window.uberwpb_animate = function() {
		
		//blocks animations
		$('[data-animate]').each(function (){

			if ( $(this).hasClass('portfolio_container') &&  $(this).closest(".portfolio-block").find(".iso-filters").html())  { //no animations for portfolio when filter is enabled			
				$(this).css('opacity','1');
			}
			else{
				
				var tthis = $(this);
				var waypoint_anim = new VcWaypoint({
				  element: $(this),
				  handler: function(direction) {
				  
							var anim_effect = tthis.attr('data-animate');
							var anim_delay = tthis.attr('data-animate-delay');
							var anim_duration = tthis.attr('data-animate-duration');
							if(anim_delay){
								tthis.css("animation-delay",anim_delay + "s");
								tthis.css("-webkit-animation-delay",anim_delay + "s");
							}
							if(anim_duration){
								tthis.css("animation-duration",anim_duration + "s");
								tthis.css("-webkit-animation-duration",anim_duration + "s");
							}	  
							  
							tthis.addClass( 'animated ' + anim_effect);

							this.destroy();			  
				  },
				  offset: '85%'
				})
			}
		});
	}			
	
	uberwpb_animate();
	
})(jQuery);