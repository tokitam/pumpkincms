// pumpform.js

function pc_notification(message) {
	$.notify.defaults({ className: "success" });
	//$.notify(message, { globalPosition:"top center" });
	$.notify(message, { globalPosition:"top right" });
}

$(document).ready(function(){
    $('#main_form').submit(function(){
    	$('#submit_button').attr('disabled', 'disabled');
    	$('#main_form').submit();
    });
});
