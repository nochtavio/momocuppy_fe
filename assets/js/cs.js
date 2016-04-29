$(document).ready(function(){
  //Function
  var send_message = function(){
    //Set Parameter
    var email = $('#email_subscribe');
    //End Set Parameter
    
    $.ajax({
      url: 'apics.php',
      type: 'POST',
      data:
        {
          email: email.val()
        },
      dataType: 'json',
      beforeSend : function (){
        email.prop('disabled', true);
        $('#submitcs').prop('disabled', true);
        $('.pop-up-img-success').hide();
        $('.pop-up-img-failed').hide();
      },
      success: function (result) {
        email.prop('disabled', false);
        $('#submitcs').prop('disabled', false);
        
        var title = "Success";
        if(result['result'] == 'f'){
          title = "Oops..!";
          $('.pop-up-img-failed').show();
        }else{
          $('.pop-up-img-success').show();
          email.val('');
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
  $('#submitcs').click(function(event){
    event.preventDefault();
    send_message();
  });
  
  $('#popok').click(function(){
    $.magnificPopup.close();
  });
  //End User Action
});