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

  var generate_member_address = function () {
    $('#box_address').empty();
    $('#div-hidden').empty();
    $('#sel_address').empty();
    $.ajax({
      url: base_url + 'api/generate_member_address',
      type: 'POST',
      data:
        {
          
        },
      dataType: 'json',
      success: function (result) {
        totalobject = 0;
        $('#sel_address').append("\
          <option value='0'>Select Address</option>\
        ");
        if (result['result'] === 's')
        {
          $.each(result['content'], function (key, value) {
            $('#box_address').append("\
              <div class='box_address'>\
                <h3>" + value['firstname'] + " " + value['lastname'] + "</h3>\
                <span class='address_detail'>\
                  " + value['street_address'] + " <br /> " + value['city_name'] + " " + value['zip_code'] + " <br /> Indonesia\
                </span>\
                <span class='phone_number'>" + value['phone'] + "</span>\
                <a id='btn_edit" + value['id'] + "' href='#' class='btnedit popaddress'>edit</a>\
              </div>\
            ");
            $('#sel_address').append("\
              <option value='" + value['id'] + "'>[" + value['city_name'] + "] " + value['street_address'] + "</option>\
            ");
            $('#div-hidden').append("\
              <input type='hidden' id='object" + totalobject + "' value='" + value['id'] + "' />\
            ");
            totalobject++;
          });
          shipping = 0;
          $('#txt_shipping_fee').text("IDR " + format_number(shipping));
          $('#order_shipping_cost').val(shipping);
          $('#order_firstname').val("");
          $('#order_lastname').val("");
          $('#order_phone').val("");
          $('#order_street_address').val("");
          $('#order_zip_code').val("");
          $('#order_country').val("");
          $('#order_city').val("");
          set_edit();
        }
      }
    });
  };

  var set_edit = function () {
    var id = [];
    for (var x = 0; x < totalobject; x++)
    {
      id[x] = $('#object' + x).val();
    }

    $.each(id, function (x, val) {
      $(document).off('click', '#btn_edit' + val);
      $(document).on('click', '#btn_edit' + val, function () {
        $.magnificPopup.open({
          items: {
            src: '#popaddress',
            type: 'inline'
          },
          callbacks: {
            open: function () {
              $('#poptitle').text("Edit Address");
              get_address(val);
              state = "edit";
            }
          }
        }, 0);
      });
    });
  };

  var get_address = function (id) {
    $.ajax({
      url: base_url + 'api/generate_member_address',
      type: 'POST',
      data:
        {
          id: id
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          $.each(result['content'], function (key, value) {
            $('#firstname').val(value['firstname']);
            $('#lastname').val(value['lastname']);
            $('#phone').val(value['phone']);
            $('#streetname').val(value['street_address']);
            $('#postalcode').val(value['zip_code']);
            $('#country').val(value['country']);
            $('#city').val(value['city']);
            $('#txt_id').val(value['id']);
          });
          
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
        } else {
          $('#poptitle').text('Failed');
          $('#popmessage').text(result['message']);
          $.magnificPopup.open({
            items: {
              src: '#mfp_message',
              type: 'inline'
            }
          }, 0);
          $('#firstname').val("");
          $('#lastname').val("");
          $('#phone').val("");
          $('#streetname').val("");
          $('#postalcode').val("");
          $('#country').val("");
          $('#city').val("");
          $('#txt_id').val("");
        }
      }
    });
  };

  var edit_address = function () {
    var id = $('#txt_id').val();
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var phone = $('#phone').val();
    var street_address = $('#streetname').val();
    var zip_code = $('#postalcode').val();
    var country = $('#country').val();
    var city = $('#city').val();

    $.ajax({
      url: base_url + 'api/edit_address',
      type: 'POST',
      data:
        {
          id: id,
          firstname: firstname,
          lastname: lastname,
          phone: phone,
          street_address: street_address,
          zip_code: zip_code,
          country: country,
          city: city
        },
      dataType: 'json',
      success: function (result) {
        $('#poptitle').text('Success');
        $('#popmessage').text(result['result_message']);
        $.magnificPopup.open({
          items: {
            src: '#mfp_message',
            type: 'inline'
          }
        }, 0);
        generate_member_address();
      }
    });
  };

  var add_address = function () {
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var phone = $('#phone').val();
    var street_address = $('#streetname').val();
    var zip_code = $('#postalcode').val();
    var country = $('#country').val();
    var city = $('#city').val();

    $.ajax({
      url: base_url + 'api/add_address',
      type: 'POST',
      data:
        {
          firstname: firstname,
          lastname: lastname,
          phone: phone,
          street_address: street_address,
          zip_code: zip_code,
          country: country,
          city: city
        },
      dataType: 'json',
      success: function (result) {
        $('#poptitle').text('Success');
        $('#popmessage').text(result['result_message']);
        $.magnificPopup.open({
          items: {
            src: '#mfp_message',
            type: 'inline'
          }
        }, 0);
        generate_member_address();
      }
    });
  };
  
  var get_shipping_cost = function(city_id){
    $.ajax({
      url: base_url + 'api/get_cost',
      type: 'POST',
      data:
        {
          city_id:city_id,
          weight: totalweight*1000
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
        
        $('#txt_grand_total').text("Loading ...");
        $('#txt_discount').text("Loading ...");
        $('#txt_weight').text("Loading ...");
        $('#txt_sub_total').text("Loading ...");
        $('#txt_point').text("Loading ...");
        $('#btn_checkout').prop('disabled', true);
        $('#txt_shipping_fee').text("Loading ...");
      },
      success: function (result) {
        $('#btn_checkout').prop('disabled', false);
        $('#popok').show();
        $.magnificPopup.close();
        
        if(result['result'] == 'r1'){
          shipping = 0;
        }else if(result['result'] == 'r2'){
          $('#poptitle').text('Failed');
          var err_msg = result['message'];
          if(err_msg == null){
            err_msg = 'Mohon maaf, terjadi error dalam pengambilan ongkos kirim. Silahkan coba kembali';
          }
          $('#popmessage').text(err_msg);
          $.magnificPopup.open({
            items: {
              src: '#mfp_message',
              type: 'inline'
            }
          }, 0);
          shipping = 0;
          $('#sel_address').val('0');
          $('#order_firstname').val("");
          $('#order_lastname').val("");
          $('#order_phone').val("");
          $('#order_street_address').val("");
          $('#order_zip_code').val("");
          $('#order_country').val("");
          $('#order_city').val("");
        }else{
          window.location.href = '/redeem/';
          shipping = 0;
        }
        $('#order_shipping_cost').val(shipping);
      }
    });
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
        if(result['result'] == 'r2'){
          $('#poptitle').text('Failed');
          $('#popmessage').text(result['order_error']);
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
  shipping = 0;
  totalweight = 1;
  var state = "";
  get_session_order();
  generate_member_address();
  //End Initial Setup

  //User Action
  $('#btn_submit').click(function (event) {
    event.preventDefault();
    if (state == "add") {
      add_address();
    } else {
      edit_address();
    }
  });

  $(document).on('click', '#btn_add', function () {
    $('#poptitle').text("Add Address");
    $('#firstname').val("");
    $('#lastname').val("");
    $('#phone').val("");
    $('#streetname').val("");
    $('#postalcode').val("");
    $('#city').val("");
    $('#txt_id').val("");
    state = "add";
    
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

    $.magnificPopup.open({
      items: {
        src: '#popaddress',
        type: 'inline'
      }
    }, 0);
  });

  $(document).on('change', '#sel_address', function () {
    var city_id = $('#sel_address').val();
    if (city_id == 0) {
      $('#poptitle').text('Failed');
      $('#popmessage').text('Mohon pilih alamat pengiriman');
      $.magnificPopup.open({
        items: {
          src: '#mfp_message',
          type: 'inline'
        }
      }, 0);
      $('#order_firstname').val("");
      $('#order_lastname').val("");
      $('#order_phone').val("");
      $('#order_street_address').val("");
      $('#order_zip_code').val("");
      $('#order_country').val("");
      $('#order_city').val("");
      $('#order_shipping_cost').val(0);
    } else {
      $.ajax({
        url: base_url + 'api/generate_member_address',
        type: 'POST',
        data:
          {
            id: city_id
          },
        dataType: 'json',
        success: function (result) {
          if (result['result'] === 's')
          {
            $.each(result['content'], function (key, value) {
              $('#order_firstname').val(value['firstname']);
              $('#order_lastname').val(value['lastname']);
              $('#order_phone').val(value['phone']);
              $('#order_street_address').val(value['street_address']);
              $('#order_zip_code').val(value['zip_code']);
              $('#order_country').val(value['country']);
              $('#order_city').val(value['city_name']);
              get_shipping_cost(value['city']);
            });
          } else {
            $('#order_firstname').val("");
            $('#order_lastname').val("");
            $('#order_phone').val("");
            $('#order_street_address').val("");
            $('#order_zip_code').val("");
            $('#order_country').val("");
            $('#order_city').val("");
          }
        }
      });
    }
  });

  $(document).on('click', 'input:radio[name=paymethod]', function () {
    var id = $(this).val();
    $.ajax({
      url: base_url + 'api/generate_list_payment',
      type: 'POST',
      data:
        {
          id: id
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          $.each(result['content'], function (key, value) {
            $('#order_payment_name').val(value['payment_name']);
            $('#order_payment_account').val(value['rek_no']);
            $('#order_payment_account_name').val(value['rek_name']);
          });
        } else {
          $('#order_payment_name').val("");
          $('#order_payment_account').val("");
          $('#order_payment_account_name').val("");
        }
      }
    });
  });
  
  $('#popok').click(function(){
    $.magnificPopup.close();
  });
  //End User Action
});