// JavaScript Document
(function($){  
	"use strict";
    //toggle the component with class accordion_body
    $(document).on('click', ".accordion_head",function (e) { 
        if ( $(this).parent().find('.accordion_body').is(':visible')) {
			
            $(this).parent().find(".accordion_body").slideUp(300);
            $(this).parent().find(".plusminus").text('+');
        }
        if ($(this).next(".accordion_body").is(':visible')) {
            $(this).next(".accordion_body").slideUp(300);
            $(this).children(".plusminus").text('+');
        } else {
            $(this).next(".accordion_body").slideDown(300);
            $(this).children(".plusminus").text('-');
        }
    });
})(jQuery);