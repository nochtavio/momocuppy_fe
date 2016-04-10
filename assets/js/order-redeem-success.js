$(document).ready(function () {
  //Function
  var get_session_redeem = function(){
    $.ajax({
      url: base_url + 'api/get_session_redeem',
      type: 'POST',
      data:
        {
        },
      dataType: 'json',
      success: function (result) {
        if(result['result'] == 'r1'){
          $('#order_no').text(result['order_no']);
        }else{
          window.location.href = "/redeem/";
        }
      }
    });
  };
  //End Function

  //Initial Setup
  get_session_redeem();
  //End Initial Setup

  //User Action
  
  //End User Action
});