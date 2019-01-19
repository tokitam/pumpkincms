// pumpform.js

function pump_loading() {
    b = document.querySelector('body');
    newDiv = document.createElement("div");
    newDiv.innerHTML = "<div style='position: fixed; width: 300px; height: 300px; text-align: center; vertical-align: middle; background-color: white; color: white;'>test test test</div>";
    //b.append(newDiv);
}

function pc_notification(message) {
    $.notify.defaults({ className: "success" });
    //$.notify(message, { globalPosition:"top center" });
    $.notify(message, { globalPosition:"top right" });
}



$(document).ready(function(){
    pump_loading();
    
    if (document.getElementById('ckeditor4_text') != null) {
        CKEDITOR.replace( 'ckeditor4_text', {
            toolbar: [
                { name: 'document', items: [ 'Print' ] },
                { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
                { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'align', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
                { name: 'links', items: [ 'Link', 'Unlink' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
                { name: 'insert', items: [ 'Image', 'Table' ] },
                { name: 'tools', items: [ 'Maximize' ] },
                { name: 'editing', items: [ 'Scayt' ] }
            ],
            filebrowserImageUploadUrl: '/image/upload/add/'
        } );
        $('ckeditor4_text').css('display', 'block');
    }

    //$('a[rel=tooltip]').tooltip();
    
    $('#main_form').submit(function(){
        $('#submit_button').attr('disabled', 'disabled');
        $('#main_form').submit();
    });

    $('#pumpform_delete_button').click(function (){
        var confirm_text = $('#pumpform_delete_confirm').val();

        if (confirm(confirm_text)) {
            id = $('#target_id').val();
            csrf_token = $('#csrf_token').val();
            
            var data = { id: id, csrf_token : csrf_token };
            var url = $('#pumpform_delete_url').val();

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

    $('.pump_message_item').click(function(event){
        var target = $(event.target);
        message_id = target.attr('messageid');
        //alert('ok ' + targetid);

        url = $('#base_url').val() + '/message/ajax_get_modal';

        $.ajax({
            url: url,
            type:'GET',
            data:{
                'messageid': message_id
            }
        })
        // Ajaxリクエストが成功した時発動
        .done( (data) => {
            //alert(data);
            $('#pump-message-modal-default').remove();
            $('body').append(data);
            $('#pump-message-modal-default').modal('show');
            //console.log(data);
        })
        // Ajaxリクエストが失敗した時発動
        .fail( (data) => {
            //$('.result').html(data);
            console.log(data);
        });
return;
        url = $('#base_url').val() + '/message/ajax_get_timeline';

        $.ajax({
            url: url,
            type:'GET',
            data:{
                'messageid': message_id
            }
        })
        // Ajaxリクエストが成功した時発動
        .done( (data) => {
            //alert(data);
            $('#pump-message-modal-default').remove();
            $('body').append(data);
            $('#pump-message-modal-default').modal('show');
            //console.log(data);
        })
        // Ajaxリクエストが失敗した時発動
        .fail( (data) => {
            //$('.result').html(data);
            console.log(data);
        });
    });
});
