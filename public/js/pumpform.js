// pumpform.js

function pc_notification(message) {
	$.notify.defaults({ className: "success" });
	//$.notify(message, { globalPosition:"top center" });
	$.notify(message, { globalPosition:"top right" });
}

$(document).ready(function(){
    //$('a[rel=tooltip]').tooltip();
    
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
                    console.log(errorThrown);
                }
            });
    	}
    });

    $('#pumpform_add_account_button').click(function() {
        email = $('#inputEmail').val();
        password = $('#inputPassword').val();
        url = $('#base_url').val() + '/user/user_rel/add';
        data = {email: email, password: password};

        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            dataType: 'json'
        }).done(function(data) {
            console.log(data);
            if (data.error == 1) {
                $('#add-account-dialog-title').text(data.message);
                $('#pumpform-add-account-dialog').modal('show');
                return;
            } 

            window.location.reload();

            $('#email').val('');
            $('#password').val('');

            $('#add-account-dialog-title').text(data.message);
            $('#pumpform-add-account-dialog').modal('show');
        }).fail(function(jqXHR, textStatus) {
            console.log(jqXHR);
            console.log('error : ' + textStatus);
        });
    });

    $('#add-account-button').click(function() {
        $('#pumpform-add-account-dialog').modal('hide');
    });

    var targetid;
    $('.rel-user-edit-link').click(function(event) {
        var target = $(event.target);
        targetid = target.attr('targetid');
        message = $('#_MD_USER_DELETE_USER_REL').val();
        message2 = $('#_MD_USER_DELETED_USER_REL').val();

        if (confirm(message)) {
            url = $('#base_url').val() + '/user/user_rel/delete';
            data = {id: targetid};

            $.ajax({
                method: 'POST',
                url: url,
                data: data,
                dataType: 'json'
            }).done(function(data) {
                console.log(data);
                $('#rel-user-' + targetid).hide();
                alert(message2);
                /*
                if (data.error == 1) {
                    $('#add-account-dialog-title').text(data.message);
                    $('#pumpform-add-account-dialog').modal('show');
                    return;
                } 

                $('#email').val('');
                $('#password').val('');

                $('#add-account-dialog-title').text(data.message);
                $('#pumpform-add-account-dialog').modal('show');
                */
            }).fail(function(jqXHR, textStatus) {
                console.log(jqXHR);
                console.log('error : ' + textStatus);
            });
        }
    });
});
