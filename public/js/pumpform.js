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

        $('#pumpform_add_account_button').prop('disabled', true);

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
                $('#pumpform_add_account_button').prop('disabled', false);
                return;
            } 

            /*
            $('#email').val('');
            $('#password').val('');

            $('#add-account-dialog-title').text(data.message);
            $('#pumpform-add-account-dialog').modal('show');
            */
            window.location.reload();

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

        $('#user-confirm-dialog-title').html(message);
        $('#user-confirm-dialog').modal('show');

        $('#user-confirm-yes').click(function(event) {
            url = $('#base_url').val() + '/user/user_rel/delete';
            data = {id: targetid};

            $.ajax({
                method: 'POST',
                url: url,
                data: data,
                dataType: 'json'
            }).done(function(data) {
                console.log(data);
                $('#user-confirm-dialog').modal('hide');
                $('#rel-user-' + targetid).hide();
                $('#dropdown-user-rel-link-' + targetid).hide();
                //alert(message2);

                $('#user-info-dialog-title').html(message2);
                $('#user-info-dialog').modal('show');
            }).fail(function(jqXHR, textStatus) {
                console.log(jqXHR);
                console.log('error : ' + textStatus);
            });
        });
        
        $('#user-confirm-no').click(function(event) {
            $('#user-confirm-dialog').modal('hide');
        });

        $('#user-info-ok-button').click(function(event) {
            $('#user-info-dialog').modal('hide');
        });
    });
    
    $('.pumpform_image').on('change', function(e) {
        var file = e.target.files[0];
        var reader = new FileReader();
	t = this;
        $preview = $('#' + t.name + "_preview");

        if(file.type.indexOf("image") < 0){
            return false;
        }
	
        // do nothing if not image
        if(file.type.indexOf("image") < 0){
            return false;
        }
			  
        reader.onload = (function(file) {
            return function(e) {
                $preview.empty();
                $preview.append($('<img>').attr({
                    src: e.target.result,
                    width: "50px",
                    class: "preview",
                    title: file.name,
		    style: 'padding-top: 0px;',
                }));
            };
        })(file);
      
        reader.readAsDataURL(file);
    });
});
