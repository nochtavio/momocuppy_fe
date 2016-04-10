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

  var get_cart = function () {
    $('#shopbaglist').empty();
    $('#div-hidden').empty();

    $.ajax({
      url: base_url + 'api/get_cart',
      type: 'POST',
      data:
        {
        },
      dataType: 'json',
      beforeSend : function (){
        $('#txt_total_products').text("Loading ...");
        $('#txt_weight').text("Loading ...");
        $('#txt_sub_total').text("Loading ...");
        $('#txt_point').text("Loading ...");
      },
      success: function (result) {
        totalobject = 0;
        subtotal = 0;
        var totalweight = 0;
        var point = 0;
        var temp_height = 0;
        var temp_width = 0;
        if (result['result'] === 's'){
          $.each(result['content'], function (key, value) {
            $('#shopbaglist').append("\
              <li>\
                <div class='bag_prodimg'><img id='cart_img_" + value['id'] + "' src='/mmcp/images/products/" + value['img'] + "' width=85 height=115 /></div>\
                <div class='bag_proddesc'><span>" + value['product_name'] + "</span></div>\
                <div class='bag_qty'><span>" + value['qty'] + "</span></div>\
                <div class='bag_color'><span>" + value['color_name'] + "</span></div>\
                <div class='bag_price'><span>" + format_number(value['product_price']) + "</span></div>\
                <div class='bag_delete'><a id='btn_remove" + value['id'] + "' href='#'>X</a></div>\
                <div class='bag_weight'><span>" + value['product_weight'] + "</span></div>\
                <div class='bag_total'><span>" + format_number(parseInt(value['product_price']) * parseInt(value['qty'])) + "</span></div>\
              </li>\
            ");
            $('#div-hidden').append("\
              <input type='hidden' id='object" + totalobject + "' value='" + value['id'] + "' />\
            ");
            
            //Check Image Resolution
            temp_height = $('#cart_img_'+value['id']).height();
            temp_width = $('#cart_img_'+value['id']).width();
            if(temp_width > temp_height){
              $('#cart_img_'+value['id']).addClass("img-landscape");
            }else{
              $('#cart_img_'+value['id']).addClass("img-portrait");
            }
            //End Check Image Resolution
            
            totalobject++;
            subtotal = parseInt(subtotal) + (parseInt(value['qty']) * parseInt(value['product_price']));
            totalweight = parseFloat(totalweight) + (parseInt(value['qty']) * parseFloat(value['product_weight']));
          });
          set_remove();

          $('#txt_total_products').text(totalobject);
          $('#txt_weight').text(totalweight + " KG");
          $('#txt_sub_total').text("IDR " + format_number(subtotal));
          $('#txt_point').text(calculate_point);

          calculate_grand_total();
        }else{
          //Cart is empty
          $('#txt_total_products').text("0");
          $(".cartelement").hide();
          $('#shopbaglist').append("\
            <li>Cart is empty</li>\
          ");
        }
        $('.shopbaglist').jScrollPane(); 
      }
    });
  };

  var set_remove = function () {
    var id = [];
    for (var x = 0; x < totalobject; x++)
    {
      id[x] = $('#object' + x).val();
    }

    $.each(id, function (x, val) {
      $(document).off('click', '#btn_remove' + val);
      $(document).on('click', '#btn_remove' + val, function (event) {
        event.preventDefault();
        $.magnificPopup.open({
          items: {
            src: '.mfp-question',
            type: 'inline'
          },
          callbacks: {
            open: function () {
              $('#txt_remove_id').val(val);
            }
          }
        }, 0);
      });
    });
  };

  var set_voucher = function () {
    var voucher_code = $('#vouchercode').val();

    $.ajax({
      url: base_url + 'api/get_voucher',
      type: 'POST',
      data:
        {
          voucher_code: voucher_code
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          $.each(result['content'], function (key, value) {
            discount = Math.floor(parseInt(subtotal)*parseInt(value['discount'])/100);
          });
          $('#txt_discount').text("IDR "+format_number(discount));
          calculate_grand_total();
          $('#poptitle').text('Success');
          $('#popmessage').text(result['message']);
        }
        else
        {
          $('#poptitle').text('Failed');
          $('#popmessage').text(result['message']);
          discount = 0;
          $('#txt_discount').text("IDR 0");
          $('#vouchercode').val("");
          calculate_grand_total();
        }
      }
    });
  };
  
  var set_referral = function () {
    var referral = $('#referralcode').val();

    $.ajax({
      url: base_url + 'api/get_referral',
      type: 'POST',
      data:
        {
          referral: referral
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          $('#txt_point').text(parseInt(calculate_point())+parseInt(5));
          $('#poptitle').text('Success');
          $('#popmessage').text(result['message']);
        }
        else
        {
          $('#poptitle').text('Failed');
          $('#popmessage').text(result['message']);
          $('#txt_point').text(parseInt(calculate_point()));
          $('#referralcode').val('');
        }
      }
    });
  };
  
  var set_shipping = function(){
    var courier = $('input:radio[name=radshipping]:checked').val();
    $.ajax({
      url: base_url + 'api/get_shipping',
      type: 'POST',
      data:
        {
          courier: courier
        },
      dataType: 'json',
      success: function (result) {
        
      }
    });
  };
  
  var calculate_grand_total = function(){
    var grand_total = 0;
    grand_total = parseInt(subtotal)-parseInt(discount)+parseInt(shipping);
    $('#txt_grand_total').text("IDR "+format_number(grand_total));
  };
  
  var calculate_point = function(){
    point = Math.floor(parseInt(subtotal) / parseInt(50000));
    return point;
  };
  
  var remove_session_order = function(){
    $.ajax({
      url: base_url + 'api/remove_session_order',
      type: 'POST',
      data:
        {
        },
      dataType: 'json',
      success: function (result) {
      }
    });
  };
  
  var session_order_alert = function(){
    $.ajax({
      url: base_url + 'api/get_session_order_alert',
      type: 'POST',
      data:
        {
        },
      dataType: 'json',
      success: function (result) {
        if(result['result'] == 'r1'){
          $('#poptitle').text('Failed');
          $('#popmessage').text(result['order_alert']);
          
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
  id_product = $('#txt_id_product').val();
  subtotal = 0;
  discount = 0;
  shipping = 0;
  var totalobject = 0;
  remove_session_order();
  get_cart();
  set_shipping();
  session_order_alert();
  //End Initial Setup
  
  //User Action
  $('#add_voucher').click(function(){
    $.magnificPopup.open({
      items: {
        src: '#mfp_message',
        type: 'inline'
      }
    }, 0);
    set_voucher();
  });
  
  $('#add_referral').click(function(){
    $.magnificPopup.open({
      items: {
        src: '#mfp_message',
        type: 'inline'
      }
    }, 0);
    set_referral();
  });
  
  $('input:radio[name=radshipping]').click(function() {
    set_shipping();
  });
  
  $('#yesbtn').click(function () {
    var id = $('#txt_remove_id').val();
    $.ajax({
      url: base_url + 'api/remove_cart',
      type: 'POST',
      data:
        {
          id: id
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          location.reload();
        }
        else
        {
          $.magnificPopup.open({
            items: {
              src: '.mfp-alert',
              type: 'inline'
            },
            callbacks: {
              open: function () {
                $('#poptitle').text('Failed');
                $('#popmessage').text('Error in connection.');
              }
            }
          }, 0);
          get_cart();
        }
      }
    });
  });
  
  $('#nobtn').click(function () {
    $.magnificPopup.close();
  });
  
  $('#popok').click(function(){
    $.magnificPopup.close();
  });
  //End User Action
});