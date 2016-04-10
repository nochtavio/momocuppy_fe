$(document).ready(function () {
  //Function
  var get_err_register = function(){
    $('.warningtext').remove();
    $.ajax({
      url: base_url + 'api/get_err_register',
      type: 'POST',
      data:
        {
        },
      dataType: 'json',
      success: function (result) {
        if(result['result'] == 'f'){
          if(typeof result['member_err']['firstname'] !== 'undefined' ){
            $('#cont-firstname').append('<span class="warningtext">'+result['member_err']['firstname']+'</span');
            $('#firstname').addClass('warning');
          }else{
            $('#firstname').val(result['member_firstname']);
          }
          if(typeof result['member_err']['lastname'] !== 'undefined' ){
            $('#cont-lastname').append('<span class="warningtext">'+result['member_err']['lastname']+'</span');
            $('#lastname').addClass('warning');
          }else{
            $('#lastname').val(result['member_lastname']);
          }
          if(typeof result['member_err']['phone'] !== 'undefined' ){
            $('#cont-phone').append('<span class="warningtext">'+result['member_err']['phone']+'</span');
            $('#phone').addClass('warning');
          }else{
            $('#phone').val(result['member_phone']);
          }
          if(typeof result['member_err']['email'] !== 'undefined' ){
            $('#cont-email').append('<span class="warningtext">'+result['member_err']['email']+'</span');
            $('#email').addClass('warning');
          }else{
            $('#email').val(result['member_email']);
          }
          if(typeof result['member_err']['password'] !== 'undefined' ){
            $('#cont-password').append('<span class="warningtext">'+result['member_err']['password']+'</span');
            $('#password').addClass('warning');
          }
          if(typeof result['member_err']['cpassword'] !== 'undefined' ){
            $('#cont-cpassword').append('<span class="warningtext">'+result['member_err']['cpassword']+'</span');
            $('#cpassword').addClass('warning');
          }
          if(typeof result['member_err']['dob'] !== 'undefined' ){
            $('#cont-dob').append('<span class="warningtext">'+result['member_err']['dob']+'</span');
            $('#dob').addClass('warning');
          }else{
            $('#dob').val(result['member_dob']);
          }
          if(typeof result['member_err']['streetname'] !== 'undefined' ){
            $('#cont-streetname').append('<span class="warningtext">'+result['member_err']['streetname']+'</span');
            $('#streetname').addClass('warning');
          }else{
            $('#streetname').val(result['member_streetname']);
          }
          if(typeof result['member_err']['postalcode'] !== 'undefined' ){
            $('#cont-postalcode').append('<span class="warningtext">'+result['member_err']['postalcode']+'</span');
            $('#postalcode').addClass('warning');
          }else{
            $('#postalcode').val(result['member_postalcode']);
          }
          if(typeof result['member_err']['country'] !== 'undefined' ){
            $('#cont-country').append('<span class="warningtext">'+result['member_err']['country']+'</span');
            $('#country').addClass('warning');
          }else{
            $('#country').val(result['member_country']);
          }
        }
      }
    });
  };
  //End Function

  //Initial Setup
  get_err_register();
  //End Initial Setup

  //User Action
	$("#postalcode").on("keypress keyup blur",function (event) {    
		 $(this).val($(this).val().replace(/[^\d].+/, ""));
			if ((event.which < 48 || event.which > 57)) {
					event.preventDefault();
			}
	});  
	
	$("#phone").on("keypress keyup blur",function (event) {    
		 $(this).val($(this).val().replace(/[^\d].+/, ""));
			if ((event.which < 48 || event.which > 57)) {
					event.preventDefault();
			}
	});   //End User Action
});