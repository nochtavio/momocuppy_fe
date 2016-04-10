$(document).ready(function () {
  //Function
  var format_number = function (num) {
    if (typeof (num) != 'string')
      num = num.toString();
    var reg = new RegExp('([0-9]+)([0-9]{3})');
    while (reg.test(num))
      num = num.replace(reg, '$1.$2');
    return num;
  };
  
  var get_session_order = function(){
    $.ajax({
      url: base_url + 'api/get_session_order',
      type: 'POST',
      data:
        {
        },
      dataType: 'json',
      success: function (result) {
        if(result['result'] == 'r1'){
          $('#order_no').text(result['order_no']);
          $('#grand_total').text('IDR '+format_number(result['grand_total']));
          $('#point').text(result['point']);
          $('#payment').text(result['payment_name'] + ' / ' + result['payment_account_name'] + ' / ' + result['payment_account']);
        }else{
          window.location.href = "index.php";
        }
      }
    });
  };
  //End Function

  //Initial Setup
  get_session_order();
  //End Initial Setup

  //User Action
  
  //End User Action
});