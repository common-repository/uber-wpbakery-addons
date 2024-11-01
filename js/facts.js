//Intitialize facts counters
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

(function ($) {
	"use strict";

	
	$('.facts .count, .banners .count').each(function (){

		var count_finished = $(this).attr('data-counter-finished');
		var tthis = $(this);
		
		if(typeof count_finished === 'undefined' && count_finished != 'yes' && isNumber( $(this).text() ) ){
	
			var count_speed = $(this).attr('data-counter-speed');
			if(!count_speed){
				count_speed = 1000;
			}
			  
			var waypoint_facts = new VcWaypoint({
				element: $(this),
				handler: function(direction) {
					
					tthis.animate({
						now: '+=' +  parseInt( tthis.text() )
						}, {
						duration: parseInt(count_speed),
						easing: 'swing',
						step: function (now) {
							tthis.text(Math.ceil(now));
						}
					});				
					
					tthis.attr('data-counter-finished', 'yes');
					this.destroy();			  
				},
				offset: '100%'
			})			
		}
	});		
	
})(jQuery);
