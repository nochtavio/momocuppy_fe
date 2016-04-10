$(document).ready(function() {
  //Authenticate Login
  $(document).on('click', '#mfp_login', function () {
    $("#mfp_email").val("");  
    $("#mfp_pwd").val("");  			
    $("#wrapforgot").addClass("hide");
    $('span#warning_login').empty();
    $.magnificPopup.open({
      items: {
        src: '#wrapformlogin',
        type: 'inline',
        focus: '#mfp_email',
        mainClass: 'mfp-fade'
      }
    }, 0);
  });
  
  $(document).on('click', '#btn_activate_login', function () {
    $("#mfp_email").val("");  
    $("#mfp_pwd").val("");  			
    $("#wrapforgot").addClass("hide");
    $('span#warning_login').empty();
    $.magnificPopup.open({
      items: {
        src: '#wrapformlogin',
        type: 'inline',
        focus: '#mfp_email',
        mainClass: 'mfp-fade'
      }
    }, 0);
  });
  
  //ajax login
  $(document).on('click', '#mfp_submit', function (event) {
    event.preventDefault();
    $('span#loading').show();
    $('span#warning_login').empty();
    var ajax_usn = $('input#mfp_email').val();
    var ajax_pwd = $('input#mfp_pwd').val();

    $.ajax({
      url: base_url + 'api/member_login',
      type: 'POST',
      data:
        {
          email: ajax_usn,
          password: ajax_pwd
        },
      dataType: 'json',
      success: function (result) {
        $('span#loading').hide();
        if(result['result'] == 'r1'){
          document.location.href = cur_url;
        }else if(result['result'] == 'r3'){
          document.location.href = '/member/register/activation/?email='+ajax_usn+'#maincontent';
        }else{
          $('span#warning_login').text(result['result_message']);
        }
      }
    });
  });
  //ajax login
  
  //ajax forgot password
  $(document).on('click', '#mfp_forgot_password', function (event) {
    event.preventDefault();
    var forgot_email = $('#txt_forgot_email').val();
    
    $.ajax({
      url: base_url + 'api/member_forget_password',
      type: 'POST',
      data:
        {
          email: forgot_email
        },
      dataType: 'json',
      beforeSend : function (){
        $('.forgotloading').html('Loading ...');
        $('.forgotloading').show();
        $('#txt_forgot_email').prop('disabled', true);
        $('#mfp_forgot_password').prop('disabled', true);
      },
      success: function (result) {
        $('.forgotloading').html(result['result_message']);
        $('#txt_forgot_email').prop('disabled', false);
        $('#mfp_forgot_password').prop('disabled', false);
      }
    });
  });
  //ajax forgot password
	
	$("#forgotpwd").click(function() {  
    $('.forgotloading').html();
    $('.forgotloading').hide();
    $('#txt_forgot_email').val('');
		$("#wrapforgot").removeClass("hide");
	});	
	
	$(".closeforgot").click(function() {  
		$("#wrapforgot").addClass("hide");   
	});
});
