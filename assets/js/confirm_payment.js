$(document).ready(function() { 
	$("#orderid").focusout(function() {
		var orderid = $('#orderid');
    if(orderid.val().length > 5){
      $.ajax({
          url: base_url+'api/get_order_payment/',
          type: 'post',
          data: {
            orderid:orderid.val()
          },
          dataType: 'json',
          beforeSend : function (){
            $('#labelbank').html('Please wait...');
          },
          success: function (result) {
            if(result['result'] == 's'){
              $.each(result['content'], function (key, value) {
                $('#labelbank').html(value['payment_name']+' / '+value['payment_account']+' / '+value['payment_account_name']);
              });
            }else{
              $('#labelbank').html(result['message']);
            }
          }
      });	
    }else{
      $('#labelbank').html('Please insert your ORDER ID first');
    }
	});
	
	$("input#amount").on("keypress keyup blur",function (event) {    
		 $(this).val($(this).val().replace(/[^\d].+/, ""));
			if ((event.which < 48 || event.which > 57)) {
					event.preventDefault();
			}
	});

});