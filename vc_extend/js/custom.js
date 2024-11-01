(function ($) {
	
	"use strict";
	
	$(document).on('click', "ul.uberwpb-vc-img-select li a", function(event) {
			 event.preventDefault();
			$(".uberwpb-vc-img-select li a").removeClass("selected");
			$(this).addClass("selected");
			var get_selected = $(this).attr("data-value");
			$(this).parent().parent().parent().find( "input" ).val(get_selected).change();
	});

	
	//WOW custom VC params - vc animations
	$(document).on('change', "select.uber_wpb_vc_animations_field", function() {

		$(this).parent().find( "input.uber_wpb_vc_animations_field" ).val($(this).val());

	});	
	
	//WOW custom VC params - vc-icon-font
	
	$(document).on('click', ".uber_wpb_vc_font_icon_block .selector-button", function() {
		
		$(this).toggleClass( "closed" );
		var ul_element,drop_down,search_val,saved_class;
		ul_element = $(this).parent().parent().find(".uberwpb-vc-font-icon-select ul");
		drop_down = $(this).parent().parent().find(".uber_wpb_vc_font_icon_class");	
		search_val = $(this).parent().parent().find(".uber_wpb_vc_font_icon_search");
		
		if($(this).hasClass("closed")){
			ul_element.removeClass("view_element");
			search_val.removeClass("view_element");
			drop_down.removeClass("view_element");
			$("i",$(this)).removeClass("uberwpb-directional-arrow-up").addClass("uberwpb-directional-arrow-down");
		}
		else{
			saved_class = $(this).parent().parent().parent().find(".uberwpb-vc-font-icon-select").attr("data-icon-class");

			if(!saved_class) saved_class = 'abstract';
			
				$(this).parent().parent().find(".uberwpb-vc-font-icon-select ul." + saved_class).addClass("view_element"); 
				$(this).parent().parent().find(".uber_wpb_vc_font_icon_class").val(saved_class).change();
			
			search_val.addClass("view_element");
			drop_down.addClass("view_element");
			
			$("i",$(this)).removeClass("uberwpb-directional-arrow-down").addClass("uberwpb-directional-arrow-up");
		}	
	});
	
	$(document).on("focus", ".uber_wpb_vc_font_icon_search", function(){
		
		if($(this).val() == 'Search Icons' || $(this).val() == ''){
			$(this).val("");
		}
        

    });
	
	$(document).on('keyup', "input.uber_wpb_vc_font_icon_search", function() {
		if($(this).val().length >2 && $(this).val() != 'Search Icons'){

			$(this).parent().find(".uberwpb-vc-font-icon-select ul").removeClass("view_element");
			var selector = $(this).parent().find(".uberwpb-vc-font-icon-select ul li i[class*='" + $(this).val() + "']");
			$(".uberwpb-vc-font-icon-select ul li i").css("display","none");
			$(selector).css("display","block");
			$(this).parent().find(".uberwpb-vc-font-icon-select ul").addClass("view_element");
		}
	});	
	
	$(document).on('change', ".uber_wpb_vc_font_icon_class", function() {
		$(".uberwpb-vc-font-icon-select ul").removeClass("view_element");
		var changed_val = $(this).val();
		
		$(this).parent().parent().find("ul." + changed_val + " li i").css("display","block");
		$(this).parent().parent().find("ul." + changed_val).addClass("view_element");
		$(this).parent().parent().parent().find(".uber_wpb_vc_font_icon_search").val("Search Icons");
		
	});
	
	$(document).on('click', "div.uberwpb-vc-font-icon-select li i", function() {

			$(".uberwpb-vc-font-icon-select li i").removeClass("selected");
			$(this).addClass("selected");
			var get_selected = $(this).attr("data-value");
			$(this).parent().parent().parent().parent().find( "input.uber_wpb_vc_font_icon_select" ).val(get_selected).change();
			$(this).parent().parent().parent().parent().find( ".selected-icon i" ).removeClass();
			$(this).parent().parent().parent().parent().find( ".selected-icon i" ).addClass(get_selected);
			$(this).parent().parent().parent().parent().find( ".uber_wpb_vc_font_icon_class" ).removeClass("view_element");
			$("ul.view_element").removeClass("view_element");
			$(".uber_wpb_vc_font_icon_search").removeClass("view_element");
			$(".uber_wpb_vc_font_icon_search").val("Search Icons");
			$(this).parent().parent().parent().parent().find(".selector-button").addClass("closed");
	});

	$(document).on('click', ".uber_wpb_vc_font_icon_block .selector-delete-button", function() {
		
		$(this).closest(".uber_wpb_vc_font_icon_block").find("input.uber_wpb_vc_font_icon_select").val("").change();
		$(this).closest(".uber_wpb_vc_font_icon_block").find(".uberwpb-vc-font-icon-select li i").removeClass("selected");
		$(this).closest(".uber_wpb_vc_font_icon_block").find(".selected-icon i").removeClass();
		
			$(this).parent().parent().parent().parent().find( ".uber_wpb_vc_font_icon_class" ).removeClass("view_element");
			$("ul.view_element").removeClass("view_element");
			$(".uber_wpb_vc_font_icon_search").removeClass("view_element");
			$(".uber_wpb_vc_font_icon_search").val("Search Icons");
			$(this).parent().parent().parent().parent().find(".selector-button").addClass("closed");		
		
	});
	
	/* Pricing Tables */
	$(document).on('keyup', ".uber_wpb_vc_pricing_table_desc, .uber_wpb_vc_pricing_table_desc_highlight", function() {
		var to_copy;
		var pricing_table_all={};
		var pricing_table_desc,pricing_table_desc_highlight;
		var first_this = $(this);
		$(this).parent().parent().parent().parent().find(".uber_wpb_vc_pricing_values").each(function( index ) {
			pricing_table_desc = $(this).find(".uber_wpb_vc_pricing_table_desc").val();
			pricing_table_desc_highlight = $(this).find(".uber_wpb_vc_pricing_table_desc_highlight").val();
			if(pricing_table_desc) {
				pricing_table_all[index]= {"desc": pricing_table_desc, "highlight": pricing_table_desc_highlight};
			}			
		});
		
		if(pricing_table_all){
			$(".uber_wpb_vc_pricing_table_all").val(JSON.stringify(pricing_table_all));
		}
	});
	
	$(document).on('click', "div.uber_wpb_vc_pricing_values a", function(event) {

		event.preventDefault();
		var pricing_table_desc,pricing_table_desc_highlight,
			to_copy ='',pricing_table_all ={};
		
		if($(this).hasClass('plus')){
			to_copy = $(this).closest(".uber_wpb_vc_pricing_values").html();
			
			$(this).closest(".uber_wpb_vc_pricing_values").after('<div class="uber_wpb_vc_pricing_values">' + to_copy + '</div>');
			
			$(".uber_wpb_vc_pricing_values").each(function( index ) {
				pricing_table_desc = $(this).find(".uber_wpb_vc_pricing_table_desc").val();
				pricing_table_desc_highlight = $(this).find(".uber_wpb_vc_pricing_table_desc_highlight").val();

					if(pricing_table_desc) {
						pricing_table_all[index]= {"desc": pricing_table_desc, "highlight": pricing_table_desc_highlight};
					}	
			});		
			if(pricing_table_all){
				$(".uber_wpb_vc_pricing_table_all").val(JSON.stringify(pricing_table_all));
			}					

		}
		if($(this).hasClass('minus')){

			if($(this).parent().parent().parent().find(".uber_wpb_vc_pricing_values").length > 1){
				$(this).parent().parent().remove();			
			
					$(".uber_wpb_vc_pricing_values").each(function( index ) {
					pricing_table_desc = $(this).find(".uber_wpb_vc_pricing_table_desc").val();
					pricing_table_desc_highlight = $(this).find(".uber_wpb_vc_pricing_table_desc_highlight").val();

						if(pricing_table_desc) {
							pricing_table_all[index]= {"desc": pricing_table_desc, "highlight": pricing_table_desc_highlight};
						}	
				});		
				if(pricing_table_all){
					$(".uber_wpb_vc_pricing_table_all").val(JSON.stringify(pricing_table_all));
				}		
			}
		}
	});	

	/* Simple List */
	var list_all={};
	var load_saved_once = 0;
	function load_saved(load_saved_once){
			
			if (load_saved_once == 1) return true; 
			
			$(".uber_wpb_vc_list_values:not(.default)").each(function() {
				var list_element = $(this).attr("data-list-element");
				var list_text = $(this).find(".uber_wpb_vc_list_desc").val();
				var list_second_text = $(this).find(".uber_wpb_vc_list_second_text").val();
				var list_link = $(this).find(".uberwpb-list-link").val();
				var list_icon, list_custom_color, list_color, list_custom_icon;
				
				if (typeof list_all['list' + list_element] === "undefined") {
					list_all['list' + list_element] = {};
				}
				
				list_all['list' + list_element]['text'] = list_text;
				list_all['list' + list_element]['second_text'] = list_second_text;
				list_all['list' + list_element]['url'] = list_link;

				if($(this).find(".uber_wpb_list_icon").hasClass("custom")){
					list_custom_icon = $(this).find(".uber_wpb_list_icon").attr("class").replace("custom","").replace("uber_wpb_list_icon","").trim();
					list_all['list' + list_element]['custom_icon'] = list_custom_icon;	
				}
				else{
					list_icon = $(this).find(".uber_wpb_list_icon:not(.custom)").attr("class").replace("uber_wpb_list_icon","").trim();
					if (list_icon){
						list_all['general_icon'] = list_icon;	
					}
				}
				if($(this).find(".uber_wpb_list_color").hasClass("custom")){
					list_custom_color = $(this).find(".uber_wpb_list_color").css("background-color");
					list_all['list' + list_element]['custom_color'] = list_custom_color;	
				}				

				list_color = $(this).find(".uber_wpb_list_color:not(.custom)").css("background-color");
				if (list_color != 'rgba(0, 0, 0, 0)'){
					list_all['general_color'] = list_color;	
				}
				
			});	
			load_saved_once	= 1;		
		
	}

	$(document).on('keyup', ".uber_wpb_vc_list_desc", function(event) {
		var list_element;
	
		//get saved stuff
		load_saved(load_saved_once);

		
		list_element = String($(this).parent().parent().attr("data-list-element"));
	
		if (typeof list_all['list' + list_element] === "undefined") {
			list_all['list' + list_element] = {};
		}
		list_all['list' + list_element]['text'] = $(this).val();
		
		$(this).closest('.uber_wpb_vc_list_block').find('input.uber_wpb_vc_list_all').val(JSON.stringify(list_all));
	});
	
	$(document).on('keyup', ".uber_wpb_vc_list_second_text", function(event) {
		var list_element;
	
		//get saved stuff
		load_saved(load_saved_once);

		
		list_element = String($(this).parent().parent().attr("data-list-element"));
	
		if (typeof list_all['list' + list_element] === "undefined") {
			list_all['list' + list_element] = {};
		}
		list_all['list' + list_element]['second_text'] = $(this).val();
		
		$(this).closest('.uber_wpb_vc_list_block').find('input.uber_wpb_vc_list_all').val(JSON.stringify(list_all));
	});
	
	
	$(document).on('click', "div.uber_wpb_vc_list_values a", function(event) {
		event.preventDefault();
		var to_copy,list_element; 
		
		if($(this).hasClass('plus')){
			
			load_saved(load_saved_once);
			
			to_copy = $(this).closest(".uber_wpb_vc_list_values").html();
			
			console.log(list_all);
			list_element = parseInt($(this).closest(".uber_wpb_vc_list_values").attr("data-list-element"));
			$(this).closest(".uber_wpb_vc_list_values").after('<div class="uber_wpb_vc_list_values" data-list-element="' + list_element + '">' + to_copy + '</div>');
			
			var list_element_counter = list_element +1;
			
			var nextAll = $(this).closest(".uber_wpb_vc_list_values").nextAll(".uber_wpb_vc_list_values");
			nextAll.each(function(index){
				
				var list_elem_id = parseInt($(this).attr("data-list-element"));
				$(this).attr("data-list-element",(list_elem_id+1));
				list_element_counter = list_element_counter + 1;
			});	
			load_saved(load_saved_once);
			$('.uber_wpb_vc_list_all').val(JSON.stringify(list_all));
		}
		if($(this).hasClass('minus')){

			if($(this).parent().parent().parent().find(".uber_wpb_vc_list_values:not(.default)").length > 1){
				$(this).parent().parent().remove();
				load_saved(load_saved_once);
				
				list_element = String($(this).parent().parent().attr("data-list-element"));
				delete list_all['list' + list_element];
				$('.uber_wpb_vc_list_all').val(JSON.stringify(list_all));
			}
		}
	});		

	//overall icon
	$(document).on('click', "[data-vc-shortcode='uber_wpb_simple_list'] .uber_wpb_vc_font_icon_block .uberwpb-vc-font-icon-select li i", function(event) {
		
		var get_selected = $(this).attr("data-value");
		$(".uber_wpb_list_icon:not(.custom)").attr("class", "uber_wpb_list_icon " + get_selected);
		load_saved(load_saved_once);
		list_all["general_icon"] ='';
		list_all["general_icon"] = get_selected;
		$('.uber_wpb_vc_list_all').val(JSON.stringify(list_all));
	});	
	
	//overall color
	$(document).on('change', "[data-vc-shortcode-param-name='color'] .colorpicker_field", function(event) {
		var color_selected = $(this).val();
		$(".uber_wpb_list_color:not(.custom)").css("background",color_selected);
		load_saved(load_saved_once);
		list_all["general_color"]='';
		list_all["general_color"] = color_selected;
		$('.uber_wpb_vc_list_all').val(JSON.stringify(list_all));
	});	
	
	//delete overall icon
	$(document).on('click', "[data-vc-shortcode='uber_wpb_simple_list'] [data-vc-shortcode-param-name='icon'] .selector-delete-button", function(event) {
		
		$(".uber_wpb_list_icon:not(.custom)").attr("class", "uber_wpb_list_icon");
		load_saved(load_saved_once);
		list_all["general_icon"] ='';
		$('.uber_wpb_vc_list_all').val(JSON.stringify(list_all));
	});
	
	//delete one icon
	$(document).on('click', "[data-vc-shortcode='uber_wpb_simple_list'] [data-vc-shortcode-param-name='list'] .selector-delete-button", function(event) {
		
		$(this).closest(".uber_wpb_vc_list_values").find(".uber_wpb_list_icon").attr("class", "uber_wpb_list_icon");

		load_saved(load_saved_once);
		var list_element = $(this).closest(".uber_wpb_vc_list_values").attr("data-list-element");
		list_all['list' + list_element]["custom_icon"] = 'none';
		$('.uber_wpb_vc_list_all').val(JSON.stringify(list_all));
		$(this).closest(".uber_wpb_vc_list_block").find(".uber_wpb_list_change_font .selected-icon i").removeClass();
		$(this).closest(".uber_wpb_vc_list_block").find(".uber_wpb_list_change_font").remove();
		
	});	
	
	//close/open font list tab
	$(document).on('click', ".uber_wpb_list_change_font .selector-button", function(event) {
		
		$(this).closest(".uber_wpb_list_change_font").remove();
		
	});	
		
	//custom icon for every list row
	$(document).on('click', "[data-vc-shortcode='uber_wpb_simple_list'] .uber_wpb_list_icon", function(event) {
			$(".uber_wpb_list_change_font").remove();
			var font_classes = $(".uber_wpb_vc_font_icon_class").parent().html();
			$(this).parent().parent().parent().find(".uber_wpb_vc_list_desc").parent().prepend( '<div class="uber_wpb_list_change_font">'+ font_classes + '</div>' );
			
			var this_classes = $(this).attr("class");
			
			var icon_class = this_classes.replace('uber_wpb_list_icon','').replace('none','').replace('custom','').trim();
			
			if( this_classes ){

				if ( icon_class == ''){
					$(".uber_wpb_vc_font_icon_class").val("webapplication").change();
					$(".uberwpb-vc-font-icon-select ul.webapplication").addClass("view_element");
				}
				else{
					var font_category = $(".uberwpb-vc-font-icon-select i." + icon_class).closest("ul").attr("class");
					$(".uber_wpb_vc_font_icon_class").val(font_category).change();
					$(".uberwpb-vc-font-icon-select i").removeClass("selected");
					$(".uberwpb-vc-font-icon-select i." + icon_class).addClass("selected").closest("ul").addClass("view_element");
					$(".uber_wpb_list_change_font .selected-icon i").removeClass().addClass(icon_class);					
					
				}
			}
					
			$(".uber_wpb_list_change_font input.uber_wpb_vc_font_icon_select").remove();
	});			
	
	//choosing custom icon for every list row
	$(document).on('click', ".uber_wpb_list_change_font .uberwpb-vc-font-icon-select li i", function(event) {
		var list_element;
		var get_selected = $(this).attr("data-value");
		$(this).parent().parent().parent().parent().parent().parent().find(".uber_wpb_list_icon").attr("class", "uber_wpb_list_icon custom " + get_selected);
		list_element = $(this).parent().parent().parent().parent().parent().parent().attr("data-list-element");
		$(this).parent().parent().parent().parent().parent().find(".uber_wpb_list_change_font").remove();
		load_saved(load_saved_once);
		list_all['list' + list_element]['custom_icon'] = get_selected;	
		$('.uber_wpb_vc_list_all').val(JSON.stringify(list_all));
	});
	
	//choosing custom color for every list row
	$(document).on('click', "[data-vc-shortcode='uber_wpb_simple_list'] .uber_wpb_list_color", function(event) {
		var list_element;
		var this_is_this;
		
		list_element = $(this).parent().parent().parent().attr("data-list-element");
		load_saved(load_saved_once);
		this_is_this = $(this);
		var all_input = $(this).parent().parent().parent().parent().find(".uber_wpb_vc_list_all");
		var current_val = all_input.val();
		var color_picker_el = $(this).parent().find(".list_color_picker .uberwpb-list-color-picker");
		color_picker_el.closest(".list_color_picker").show();
		color_picker_el.wpColorPicker({
			            hide: true,
						clear: function() {
							this_is_this.css('background','none');
							all_input.val( current_val);
							
							if (typeof list_all['list' + list_element] !== "undefined") {
								delete list_all['list' + list_element]['custom_color'];
							}			
							$(this).closest('.uber_wpb_vc_list_block').find('input.uber_wpb_vc_list_all').val(JSON.stringify(list_all));
						},
						change: function(event, ui){
							this_is_this.css( 'background', ui.color.toString()).addClass("custom");
							all_input.val( current_val + ui.color.toString());
							
							if (typeof list_all['list' + list_element] !== "undefined") {
								list_all['list' + list_element]['custom_color'] = ui.color.toString();
							}						
							
							$(this).closest('.uber_wpb_vc_list_block').find('input.uber_wpb_vc_list_all').val(JSON.stringify(list_all));
						}
		});

	});	
	
	//choosing link for every list row
	$(document).on('click', "[data-vc-shortcode='uber_wpb_simple_list'] .link_plus", function(event) {
		
		event.preventDefault();
		
		var list_element;
		list_element = $(this).closest(".uber_wpb_vc_list_values").attr("data-list-element");
		
		$(".link_input_holder").removeClass("visible");
		$(".uber_wpb_vc_list_values[data-list-element=" + list_element + "] .link_input_holder").addClass("visible");

	});			

	$(document).on('click', '.uber_wpb_vc_list_values .link_button.save', function() {

		var list_element;
		list_element = $(this).closest(".uber_wpb_vc_list_values").attr("data-list-element");
	
		load_saved(load_saved_once);
				
		var link_val = $(this).closest(".link_input_holder").find(".uberwpb-list-link").val();
				
		$(this).closest(".link_input_holder").removeClass("visible");
				
		if (typeof list_all['list' + list_element] !== "undefined") {
			list_all['list' + list_element]['url'] = link_val;
		}						
									
		$(this).closest('.uber_wpb_vc_list_block').find('input.uber_wpb_vc_list_all').val(JSON.stringify(list_all));	
	});	

	
	$(document).on('click', function(e) {

				if( !$(e.target).is(".uber_wpb_list_color") ){
					$(".list_color_picker").hide();
				}

	});	

	//wow image attach
	$(document).on('click', ".uber_wpb_attach_image .custom_media_url_remove", function(event) {

		$(this).parent().css("display","none");
	});	
	
	//wow image attach
	$(document).on('change', ".uber_wpb_attach_image .custom_media_url", function(event) {
		var bg_image;
		bg_image = $(this).val();
		if ( bg_image ) {
			$(this).parent().find(".custom_media_url_remove_holder").css("background","url('" + bg_image + "')" );
			$(this).parent().find(".custom_media_url_remove_holder").css("background-size","cover").css("display","block");
		}
	});
	
})(jQuery);