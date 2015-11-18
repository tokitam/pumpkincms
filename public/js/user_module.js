
$(document).ready(function(){

    $('#submit_button').click(function (){
        alert(' OK ');
        /*
		var confirm_text = $('#pumpform_delete_confirm').val();

    	if (confirm(confirm_text)) {
			id = $('#target_id').val();
			var data = {id: id};
			var url = $('#pumpform_delte_url').val();
			var ret_url = $('#pumpform_module_url').val();

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
        */
    });
});
