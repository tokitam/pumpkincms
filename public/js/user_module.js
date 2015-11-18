
$(document).ready(function(){

    $('#submit_button').click(function (){
		var id = $('#inputId').val();
        var email = $('#inputEmail').val()

        if (id == '') {
            $('#input_id_label').show();
            return;
        }

        if (email == '') {
            $('#input_email_label').show();
            return;
        }

    	if (true) {
			var data = {id: id};
            var base_url = $('#base_url').val();
            var url = base_url + '/user/oauth/check_id'; //?id=' + encodeURIComponent(id);
            alert(' url '  + url);

            $.ajax({
                type: 'GET',
                url: url,
                data: data,

                success: function(data, dataType)
                {
                    obj = eval('(' + data + ')');
                    alert( 'OK');
                    alert(' data ' + data);
                    alert(' exists: ' + obj.exists);
                },

                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    alert('Error : ' + errorThrown);
                }
            });
    	}

        return false;
    });
});
