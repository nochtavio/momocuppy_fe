$(document).ready(function(){
  //Function
  var send_message = function(){
    //Set Parameter
    var name = $('#name');
    var email = $('#email');
    var subject = $('#subject');
    var message = $('#message');
    var verify = $('#verify');
    //End Set Parameter
    
    $.ajax({
      url: base_url + 'api/sendMail',
      type: 'POST',
      data:
        {
          name: name.val(),
          subject: subject.val(),
          message: message.val(),
          email: email.val(),
          verify: verify.val()
        },
      dataType: 'json',
      beforeSend : function (){
        name.prop('disabled', true);
        email.prop('disabled', true);
        subject.prop('disabled', true);
        message.prop('disabled', true);
        verify.prop('disabled', true);
        $('#submitmsg').prop('disabled', true);
        $('.pop-up-img-success').hide();
        $('.pop-up-img-failed').hide();
      },
      success: function (result) {
        name.prop('disabled', false);
        email.prop('disabled', false);
        subject.prop('disabled', false);
        message.prop('disabled', false);
        verify.prop('disabled', false);
        $('#submitmsg').prop('disabled', false);
        
        var title = "Success";
        if(result['result'] == 'f'){
          title = "Oops..!";
          $('.pop-up-img-failed').show();
        }else{
          $('.pop-up-img-success').show();
          name.val('');
          subject.val('');
          message.val('');
          email.val('');
          verify.val('');
        }
        
        $.magnificPopup.close();
        $.magnificPopup.open({
          items: {
            src: '.mfp-alert',
            type: 'inline'
          },
          callbacks: {
            open: function () {
              $('#poptitle').text(title);
              $('#popmessage').text(result['message']);
            }
          }
        }, 0);
      }
    });
  };
  
  //End Function
  
  //Initial Setup
  
  //End Initial Setup
  
  //User Action
  $('#submitmsg').click(function(event){
    event.preventDefault();
    send_message();
  });
  
  $('#popok').click(function(){
    $.magnificPopup.close();
  });
  //End User Action
});