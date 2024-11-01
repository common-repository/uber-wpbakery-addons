jQuery(function($){
	
	"use strict";
function uber_wpb_presets_load( preset , thisObj){
	
	"use strict";
	
	if( $.isEmptyObject(preset) ) return false;
	
	var $main_panel,$vc_element,
		$vc_element_settings,obj,
		param_type , has_dependency = false;
	
	$main_panel = thisObj.closest(".vc_panel-tabs");
	
	for (var key in preset) {
		if (preset.hasOwnProperty(key)) {
			
			var param_name = key;
			var new_value = preset[key];
			
			$vc_element = $main_panel.find('[data-vc-shortcode-param-name="' + key + '"]');
			$vc_element_settings = $vc_element.attr("data-param_settings");
	
			if( $vc_element_settings ){
			
				obj = JSON.parse($vc_element_settings);
				param_type = obj["type"];

				if ( obj["dependency"] ){
					var dependant_to_element = obj["dependency"]["element"];
					var dependant_to_val = obj["dependency"]["value"];
					var dependant_NOT_eq_to = obj["dependency"]["value_not_equal_to"];
					
					if(dependant_to_element in preset){
						
						//dependant_to_val
						
						if( dependant_to_val ){
							if( Array.isArray(dependant_to_val) ) {
								
								if( dependant_to_val.indexOf(preset[dependant_to_element]) >= 0 ){
									has_dependency = true;
								}
								else{
									has_dependency = false;
								}
							}
							else{
								if( dependant_to_val == preset[dependant_to_element] ){
									has_dependency = true;							
								}
								else{
									has_dependency = false;								
								}	
							}							
						}
						else if( dependant_NOT_eq_to ){
							//dependant_NOT_eq_to
							
							if( Array.isArray(dependant_NOT_eq_to) ) {
								
								if( dependant_NOT_eq_to.indexOf(preset[dependant_to_element])  >= 0 ){
									has_dependency = false;
								}
								else{
									has_dependency = true;
								}
							}
							else{
								if( dependant_NOT_eq_to == preset[dependant_to_element] ){
									has_dependency = false;							
								}
								else{
									has_dependency = true;								
								}	
							}							
						}
	
						if( has_dependency ){
							uber_wpb_presets_dependency_stuff( param_name , $main_panel );
						}
						else{
							uber_wpb_presets_not_dependency_stuff( param_name , $main_panel );
						}
						
					} else {
						//$has_dependency = false;
					}				
				}
			
				uber_wpb_presets_process( param_name, new_value ,  param_type , has_dependency , $main_panel);
			}
			
		} //if (preset.hasOwnProperty(key))
	} //for
} //uber_wpb_presets_load()

function uber_wpb_presets_process( param_name, new_value ,  param_type , has_dependency , $main_panel){
	
	"use strict";
	
	var common_param_types = ["textfield","dropdown","uber_wpb_vc_img_select","uber_wpb_vc_animations_in","uber_wpb_vc_simple_list","uber_wpb_attach_image","uber_wpb_attach_gallery","uber_wpb_vc_fonts_select","vc_column","vc_column_inner","uber_wpb_vc_pricing_table"];
	
	if( common_param_types.indexOf(param_type) >= 0 ){
		uber_wpb_presets_common_types( param_name, new_value ,  param_type , has_dependency , $main_panel );
	}
	else{

		switch (param_type) {
			case "textarea":
				uber_wpb_presets_textarea( param_name, new_value ,  param_type , has_dependency , $main_panel );
				break;
			case "textarea_html":
				uber_wpb_presets_textarea_html( param_name, new_value ,  param_type , has_dependency , $main_panel );
				break;
			case "css_editor":
				uber_wpb_presets_css_editor( param_name, new_value ,  param_type , has_dependency , $main_panel );
				break;
			case "google_fonts":
				uber_wpb_presets_google_fonts( param_name, new_value ,  param_type , has_dependency , $main_panel );
				break;
			case "checkbox":
				uber_wpb_presets_checkbox( param_name, new_value ,  param_type , has_dependency , $main_panel );
				break;
		}
	
	}
	
}

function uber_wpb_presets_google_fonts( param_name, new_value ,  param_type , has_dependency , $main_panel ){
	
	"use strict";
	//vc_google_fonts_form_field-font_style-select
	
	var split_new_value = new_value.split ("|");
	var google_font = split_new_value[0],google_font_weight = split_new_value[1];	
	
	if( google_font &&  google_font_weight){
		$main_panel.find('div[data-vc-shortcode-param-name="' + param_name + '"] .vc_google_fonts_form_field-font_family-select').change();
		$main_panel.find('div[data-vc-shortcode-param-name="' + param_name + '"] .vc_google_fonts_form_field-font_family-select').val(google_font).change();
		
		setTimeout(function(){
		 $main_panel.find('div[data-vc-shortcode-param-name="' + param_name + '"] .vc_google_fonts_form_field-font_style-select').val(google_font_weight).change();
		}, 1200);		
	}

}


function uber_wpb_presets_textarea( param_name, new_value ,  param_type , has_dependency , $main_panel ){
	
	"use strict";
	
	$main_panel.find('div[data-vc-shortcode-param-name="' + param_name + '"] textarea').val(new_value);
}


function uber_wpb_presets_checkbox( param_name, new_value ,  param_type , has_dependency , $main_panel ){
	
	"use strict";

	if( new_value == true ||  new_value == 'yes' ){
		//$main_panel.find("[name='" + param_name + "']").attr( "checked", true );
		$main_panel.find("[name='" + param_name + "']").prop( "checked", true );
	}
	else{
		//$main_panel.find("[name='" + param_name + "']").attr( "checked", false );
		$main_panel.find("[name='" + param_name + "']").prop( "checked", false );
	}
}

function uber_wpb_presets_css_editor( param_name, new_value ,  param_type , has_dependency , $main_panel ){
	
	"use strict";

	if( new_value !== null && typeof new_value === 'object' ){
			
		$.each(new_value, function (key, value) {
				
			if( key == 'image' ){
				var image_html = '<li class="added">  <div class="inner" style="width: 80px; height: 80px; overflow: hidden;text-align: center;">    <img src="' + value + '" class="vc_ce-image">  </div>  <a href="#" class="vc_icon-remove"><i class="vc-composer-icon vc-c-icon-close"></i></a></li>';
				$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] .vc_image").html(image_html);
			}
			else if( key == 'background_color' || key == 'border_color' ){
					
				if( value ){
					$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] .wp-color-picker[name='" + key + "']").wpColorPicker('color', value);
				}
				else{
					$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + key + "']").closest(".wp-picker-input-wrap").find(".wp-picker-clear").trigger('click'); //wpColorPicker bug: doesn't support empty color 
				}
			}
			else{
				$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + key + "']  ").val(value);
			}
				
		});			
	}
}

function uber_wpb_presets_textarea_html( param_name, new_value ,  param_type , has_dependency , $main_panel ){
	
	"use strict";

	$main_panel.find('[data-vc-shortcode-param-name="content"] #wpb_tinymce_content_ifr').contents().find("body").html(new_value);
	
}

function pricing_tables_html_build(json_params){
	var row, html = '';
	if( json_params ){
		
		var values = JSON.parse(json_params);
		
			for(var i in values){
				var dataCopy = values[i];
				row = '<div class="uber_wpb_vc_pricing_values"><div class="vc_col-sm-5"><div class="wpb_element_label">Feature</div><input name="uber_wpb_vc_pricing_table_desc[]" class="uber_wpb_vc_pricing_table_desc" type="text" value="' + values[i]['desc'] + '"></div><div class="vc_col-sm-5 "><div class="wpb_element_label">Feature Highlighted</div><input name="uber_wpb_vc_pricing_table_desc_highlight[]" class="uber_wpb_vc_pricing_table_desc_highlight" type="text" value="' + values[i]['highlight'] + '"></div><div class="vc_col-sm-2"><a class="plus" href="#">+</a><a class="minus" href="#">-</a></div></div>';
				html = html + row;
				
			}		
	}	
	return html;	
}

function uber_wpb_presets_common_types( param_name, new_value ,  param_type , has_dependency , $main_panel ){
	
	"use strict";
	if( !has_dependency ){
		
		$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + param_name + "']").val(new_value);
		
		if( param_type == 'uber_wpb_vc_pricing_table' ){
			$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + param_name + "'] ~ .uber_wpb_vc_pricing_values").remove();
			$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + param_name + "']").parent().append(pricing_tables_html_build(new_value));
		}
	}
	else{
	
			if( param_type == 'dropdown' ){
					
				var value_exists = false, first_value;
				$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + param_name + "'] option").each(function( i, el ){
								
					if ( i === 0) {
						first_value = $(this).val();
					}								
									
					if( new_value ==  $(this).val() ){		value_exists = true; 	}

				});
				
				if( value_exists ){
					$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + param_name + "']").val(new_value);
				}
				else{
								$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + param_name + "']").val(first_value);
				}
			}
			else if ( param_type == 'uber_wpb_vc_img_select' ){
				
				$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + param_name + "']").val(new_value);
				$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + param_name + "'] ~ .uberwpb-vc-img-select li a").removeClass("selected");
				$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + param_name + "'] ~ .uberwpb-vc-img-select li a[data-value='" + new_value +"']").addClass("selected");

			}
			else if ( param_type == 'uber_wpb_vc_fonts_select' ){
						
				$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] .selected-icon i").removeClass().addClass(new_value);
				$main_panel.find("[name='" + param_name + "']").val(new_value);
			}
			else{
				$main_panel.find("[data-vc-shortcode-param-name='" + param_name + "'] [name='" + param_name + "']").val(new_value);
			}			
		
	}
	
}

function uber_wpb_presets_dependency_stuff( param_name , $main_panel){
	
	"use strict";

	$main_panel.find('div[data-vc-shortcode-param-name="' + param_name + '"]').removeClass("vc_dependent-hidden");			
	//make group visible
	var panel_tab = $main_panel.find("[name='" + param_name + "']").closest('[data-vc-ui-element="panel-edit-element-tab"]');
	var panel_tab_id = panel_tab.attr('id');
	var panel_tab_id_no = parseInt( panel_tab_id.replace("vc_edit-form-tab-", "") );
					
	$(".vc_ui-tabs-line [data-tab-index='" + panel_tab_id_no + "']").removeClass("vc_dependent-hidden");		
	
}

function uber_wpb_presets_not_dependency_stuff( param_name , $main_panel){
	
	"use strict";

	$main_panel.find('div[data-vc-shortcode-param-name="' + param_name + '"]').addClass("vc_dependent-hidden");				
	
}


	
	//presets
	$(document).on('click', '.uber_wpb_preset_id_link', function(event) {
		
		event.preventDefault();
			var tthis = $(this);
			$(".uber_wpb_confirm_box").hide();
			$(this).parent().find(".uber_wpb_confirm_box").show(100);
			
		$(document).off('click', '.uber_wpb_confirm_box_buttons a').on('click', '.uber_wpb_confirm_box_buttons a', function(event) {
		
			event.preventDefault();		
			
			if( $(this).attr("data-do") == 'yes' ){
				
				//$('[data-vc-ui-element="button-save"]').css("display","none");
				//$('[data-vc-ui-element="button-save"]').parent().append('<div class="uber_wpb_vc_preset_loading_msg" style="display: inline-block;">Please wait, preset is loading...</div>');
				
				var preset_id = parseInt( tthis.attr("data-id") );
				var base_name = tthis.closest("[data-vc-shortcode]").attr("data-vc-shortcode");
				var canBeLoaded = true;
				
				var obj = { "base_name":base_name, "preset_id":preset_id};
				var query = JSON.stringify(obj);

				
				var data = {
					'action': 'uber_wpb_vc_presets',
					'query': query, // that's how we get params from wp_localize_script() function
				};
				
				if( canBeLoaded == true){
									
					$.ajax({
						url : uber_wpb_vc_presets_params.ajaxurl, // AJAX handler
						data : data,
						type : 'POST',
						beforeSend : function ( xhr ) {
							// the AJAX call is in process, we shouldn't run it again until complete
							canBeLoaded = false; 
							$('.ajax_loader').show();
						},
						complete: function(){
							$('.ajax_loader').hide();
						},	
						success : function( data ){
							if( data ) {

								var preset_data = JSON.parse(data);
								var preset = preset_data[0];

								uber_wpb_presets_load( preset , tthis);
								
								canBeLoaded = true; // the ajax is completed, now we can run it again
								
							} 
						}
					});
				}
				$(".uber_wpb_confirm_box").hide();

				/*setTimeout(function(){
					$('[data-vc-ui-element="button-save"] ~ .uber_wpb_vc_preset_loading_msg').remove();
					$('[data-vc-ui-element="button-save"]').css("display","inline-block");
				}, 2500);	*/
			}
			else{
				$(".uber_wpb_confirm_box").hide();
			}
		});	
	});				
	
});