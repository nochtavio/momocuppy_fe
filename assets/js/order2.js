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
    $('#div-hidden-item').empty();

    $.ajax({
      url: base_url + 'api/get_cart',
      type: 'POST',
      data:
        {
          
        },
      dataType: 'json',
      beforeSend : function (){
        $('#txt_grand_total').text("Loading ...");
        $('#txt_discount').text("Loading ...");
        $('#txt_weight').text("Loading ...");
        $('#txt_sub_total').text("Loading ...");
        $('#txt_point').text("Loading ...");
        $('#btn_checkout').prop('disabled', true);
      },
      success: function (result) {
        subtotal = 0;
        totalweight = 0;
        totalitem = 0;
        var point = 0;
        var grand_total = 0;
        var img = "";
				var more = "...";	
        $('#btn_checkout').prop('disabled', false);

        if (result['result'] === 's') {
          $.each(result['content'], function (key, value) {
            img = '/mmcp/images/products/' + value['img'];
            if(value['img'] == null){
              img = '/images/products/no-img-potrait.jpg';
            }
						
						if(value['color_name'].length > 8){
							color_name = value['color_name'].substr(0,5) + more;
						}else{
							color_name = value['color_name'];
						}							
						
            $('#shopbaglist').append("\
              <li>\
                <div class='confirmbag_img'><img id='cart_img_" + value['id'] + "' src='" + img + "' /></div>\
                <div class='confirmbag_color'>\
                  <div class='confirmbag_data' title='"+value["color_name"]+"'><strong class='confirmbag_title' >color</strong><br />" + color_name + "</div>\
                </div>\
                <div class='confirmbag_weight'>\
                  <div class='confirmbag_data'><strong class='confirmbag_title'>weight</strong><br />" + value['product_weight'] + "</div>\
                </div>\
                <div class='confirmbag_qty'>\
                  <div class='confirmbag_data'><strong class='confirmbag_title'>qty</strong><br />" + value['qty'] + "</div>\
                </div>\
                <div class='confirmbag_price'>\
                  <div class='confirmbag_data'><strong class='confirmbag_title'>price</strong><br />" + format_number(value['product_price']) + "</div>\
                </div>\
              </li>\
            ");
            $('#div-hidden-item').append("\
              <input type='hidden' id='objectitem" + totalitem + "' value='" + value['id'] + "' />\
            ");
            totalitem++;
            subtotal = parseInt(subtotal) + (parseInt(value['qty']) * parseInt(value['product_price']));
            totalweight = parseFloat(totalweight) + (parseInt(value['qty']) * parseFloat(value['product_weight']));
          });
          $('.shopbaglist').jScrollPane(); 
          set_resolution();
          calculate();
        } else {
          //Cart is empty
          window.location.href = '/order/';
          $(".cartelement").hide();
          $('#shopbaglist').append("\
            <li>Cart is empty</li>\
          ");
        }
      }
    });
  };
  
  var set_resolution = function(){
    var id = [];
    for (var x = 0; x < totalitem; x++)
    {
      id[x] = $('#objectitem' + x).val();
    }
    var temp_height = 0;
    var temp_width = 0;
    $.each(id, function (x, val) {
      setTimeout(function(){
        //Check Image Resolution
        temp_height = $('#cart_img_'+val).height();
        temp_width = $('#cart_img_'+val).width();
        if(temp_width <= temp_height){
          $('#cart_img_'+val).addClass("img-portrait");
        }else{
          $('#cart_img_'+val).addClass("img-landscape");
        }
        //End Check Image Resolution
      }, 250);
    });
  };
  
  var calculate = function(){
    //Calculate Point
    point = Math.floor(parseInt(subtotal) / parseInt(50000));

    //Get Session Voucher
    $.ajax({
      url: base_url + 'api/get_session_voucher',
      type: 'POST',
      data: {},
      dataType: 'json',
      success: function (result) {
        if (result['result'] == 's') {
          discount = Math.floor(parseInt(subtotal) * parseInt(result['discount']) / 100);
        }
        else {
          discount = 0;
        }

        //For Order Post
        $('#order_voucher_code').val(result['voucher_code']);
        $('#order_discount').val(result['discount']);

        //Get Session Referral
        $.ajax({
          url: base_url + 'api/get_session_referral',
          type: 'POST',
          data: {},
          dataType: 'json',
          success: function (result) {
            if (result['result'] == 's') {
              point = parseInt(point) + parseInt(5);
            }
            grand_total = parseInt(subtotal) - parseInt(discount) + parseInt(shipping);
            $('#txt_grand_total').text("IDR " + format_number(grand_total));
            $('#txt_discount').text("IDR " + format_number(discount));
            $('#txt_weight').text(totalweight + " KG");
            $('#txt_sub_total').text("IDR " + format_number(subtotal));
            $('#txt_point').text(point);

            //For Order Post
            $('#order_referral').val(result['referral']);
          }
        });
      }
    });
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
        $('.warning').removeClass('warning');
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
          
          $("input#phone").on("keypress keyup blur",function (event) {    
						 $(this).val($(this).val().replace(/[^\d].+/, ""));
							if ((event.which < 48 || event.which > 57)) {
									event.preventDefault();
							}
					});  
          
          $("input#postalcode").on("keypress keyup blur",function (event) {    
						 $(this).val($(this).val().replace(/[^\d].+/, ""));
							if ((event.which < 48 || event.which > 57)) {
									event.preventDefault();
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

 var validate_field = function(){
    var firstname = $('#firstname');
    var lastname = $('#lastname');
    var phone = $('#phone');
    var street_address = $('#streetname');
    var zip_code = $('#postalcode');
    
    if(firstname.val() == ""){
      firstname.addClass('warning');
    }else{
      firstname.removeClass('warning');
    }
    
    if(lastname.val() == ""){
      lastname.addClass('warning');
    }else{
      lastname.removeClass('warning');
    }
    
    if(phone.val() == ""){
      phone.addClass('warning');
    }else{
      phone.removeClass('warning');
    }
    
    if(street_address.val() == ""){
      street_address.addClass('warning');
    }else{
      street_address.removeClass('warning');
    }
    
    if(zip_code.val() == ""){
      zip_code.addClass('warning');
    }else{
      zip_code.removeClass('warning');
    }
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
        $('#popmessage').text(result['result_message']);
        if(result['result'] == "r2"){
          validate_field();
        }else{
          $.magnificPopup.open({
            items: {
              src: '#mfp_message',
              type: 'inline'
            }
          }, 0);
          generate_member_address();
        }
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
        $('#popmessage').text(result['result_message']);
        if(result['result'] == "r2"){
          validate_field();
        }else{
          $.magnificPopup.open({
            items: {
              src: '#mfp_message',
              type: 'inline'
            }
          }, 0);
          generate_member_address();
        }
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
        
        $('html, body').animate({
          scrollTop: $("#summarynote").offset().top
        }, 500);
        
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
          shipping = result['cost'];
        }else if(result['result'] == 'r2'){
          $('#poptitle').text('Failed');
          var err_msg = result['message'];
          if(err_msg == null){
            err_msg = 'Sorry, an error occurred. Please try again in 10 minutes.';
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
          window.location.href = '/order/';
          shipping = 0;
        }
        $('#txt_shipping_fee').text("IDR " + format_number(shipping));
        $('#order_shipping_cost').val(shipping);
        calculate();
      }
    });
  };
  //End Function

  //Initial Setup
  id_product = $('#txt_id_product').val();
  subtotal = 0;
  discount = 0;
  shipping = 0;
  totalweight = 0;
  var totalobject = 0;
  var totalitem = 0;
  var state = "";
  get_session_order();
  get_cart();
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
    $('.warning').removeClass('warning');
    state = "add";
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
      
      shipping = 0;
      $('#txt_shipping_fee').text("IDR " + format_number(shipping));
      $('#order_shipping_cost').val(shipping);
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