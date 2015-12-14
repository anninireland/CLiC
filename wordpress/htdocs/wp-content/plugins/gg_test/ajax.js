
function gg_noun(){
	jQuery.post(the_ajax_script.ajaxurl,  jQuery("#gg_start").serialize()
		,
function(response_from_gg_action_function){
jQuery("#noun_area").html(response_from_gg_action_function);
}
);
}

