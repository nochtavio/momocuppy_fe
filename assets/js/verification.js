$(document).ready(function () {
  //Function
  var resend_verification = function () {
    var email = $('#resend_email').val();

    $.ajax({
      url: base_url + 'api/resend_verification',
      type: 'POST',
      data:
        {
          email: email
        },
      dataType: 'json',
      beforeSend : function (){
        $('#popok').hide();
        $('#poptitle').text('Loading');
        $('#popmessage').text('Please wait ...');
        $.magnificPopup.open({
          items: {
            src: '#mfp_message',
            type: 'inline'
          },
          closeOnBgClick: false
        }, 0);
        $('#btn_resend_verification').prop('disabled', true);
      },
      success: function (result) {
        $.magnificPopup.close();
        $('#popok').show();
        if (result['result'] === 's')
        {
          $('#poptitle').text('Success');
          $('#popmessage').text(result['message']);
          $.magnificPopup.open({
            items: {
              src: '#mfp_message',
              type: 'inline'
            }
          }, 0);
        }
        else
        {
          $('#poptitle').text('Failed');
          $('#popmessage').text(result['message']);
          $.magnificPopup.open({
            items: {
              src: '#mfp_message',
              type: 'inline'
            }
          }, 0);
        }
      }
    });
  };
  //End Function

  //Initial Setup
  
  //End Initial Setup
  
  //User Action
  $('#btn_resend_verification').click(function(){
    resend_verification();
  });
  
  $('#popok').click(function(){
    $.magnificPopup.close();
  });
  //End User Action
});