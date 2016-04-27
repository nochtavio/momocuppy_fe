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
  $("#phone").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
  });

  $("#postalcode").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
  });
  
  //End User Action
});