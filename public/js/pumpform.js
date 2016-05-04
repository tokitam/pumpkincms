// pumpform.js

function pc_notification(message) {
	$.notify.defaults({ className: "success" });
	//$.notify(message, { globalPosition:"top center" });
	$.notify(message, { globalPosition:"top right" });
}

$(document).ready(function(){
    $('a[rel=tooltip]').tooltip();
    
    $('#main_form').submit(function(){
    	$('#submit_button').attr('disabled', 'disabled');
    	$('#main_form').submit();
    });

    $('#pumpform_delete_button').click(function (){
		var confirm_text = $('#pumpform_delete_confirm').val();

    	if (confirm(confirm_text)) {
			id = $('#target_id').val();
			var data = {id: id};
			var url = $('#pumpform_delte_url').val();

            var ret_url = '';
            if ($('#delete_post_redirect').val()) {
                ret_url = $('#delete_post_redirect').val();
            } else {
                ret_url = $('#pumpform_module_url').val();
            }

            $.ajax({
                type: 'POST',
                url: url,
                data: data,

                success: function(data, dataType)
                {
                    location.href = ret_url;
                },

                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    alert('Error : ' + errorThrown);
                }
            });
    	}
    });
});
