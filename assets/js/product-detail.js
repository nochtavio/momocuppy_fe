$(document).ready(function(){
  //Function
  var format_number = function (num) {
    if (typeof (num) != 'string')
      num = num.toString();
    var reg = new RegExp('([0-9]+)([0-9]{3})');
    while (reg.test(num))
      num = num.replace(reg, '$1.$2');
    return num;
  };
  
  var add_to_cart = function(){
    //Set Parameter
    var id_dt_product = $('#txt_id_dt_product').val();
    var qty = $('#txt_qty').val();
    //End Set Parameter
    
    $.ajax({
      url: base_url + 'api/set_cart',
      type: 'POST',
      data:
        {
          id_dt_product: id_dt_product,
          qty: qty
        },
      dataType: 'json',
      success: function (result) {
        if(result['result'] == 'r1'){
          $('#poptitle').text('Success');
          $('#popmessage').text(result['result_message']);
          get_cart();
        }else{
          $('#poptitle').text('Failed');
          $('#popmessage').text(result['result_message']);
        }
      }
    });
  };
  
  var get_cart = function(){
    $('#shopbaglist').empty();
    $('#div-hidden').empty();
    
    $.ajax({
      url: base_url + 'api/get_cart',
      type: 'POST',
      data:
        {
        },
      dataType: 'json',
      success: function (result) {
        totalobject = 0;
        var totalprice = 0;
        var product_name = "";
        if (result['result'] === 's')
        {
          $.each( result['content'], function( key, value ) {
            var temp = "["+value['color_name']+"] "+value['product_name'];
            product_name = (temp.length > 22) ? temp.substring(0, 22)+"..." : "["+value['color_name']+"] "+value['product_name'] ;
            $('#shopbaglist').append("\
              <li>\
                <div class='item'><a href='#' class='cancelprod' id='btn_remove" + value['id'] + "'>X</a><span title='"+value['product_name']+"' class='title_item'>"+product_name+"</span></div>\
                <div class='qty'> "+value['qty']+"</div>\
                <div class='price'> "+format_number(value['product_price'])+"</div>\
              </li>\
            ");
            $('#div-hidden').append("\
              <input type='hidden' id='object" + totalobject + "' value='" + value['id'] + "' />\
            ");
            totalobject++;
            totalprice = parseInt(totalprice) + (parseInt(value['qty'])*parseInt(value['product_price']));
          });
          setRemove();
        }
        $('#txt_totalprice').text(format_number(totalprice));
        $('.shopbaglist').jScrollPane(); 
      }
    });
  };
  
  setRemove = function ()
  {
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
  
  var add_to_wishlist = function(){
    $.ajax({
      url: base_url + 'api/add_wishlist',
      type: 'POST',
      data:
        {
          id_product: id_product
        },
      dataType: 'json',
      success: function (result) {
        if(result['result'] == 'r1'){
          $('#poptitle').text('Success');
          $('#popmessage').text(result['result_message']);
          get_cart();
        }else{
          $('#poptitle').text('Failed');
          $('#popmessage').text(result['result_message']);
        }
      }
    });
  };
  
  //End Function
  
  //Initial Setup
  id_product = $('#txt_id_product').val();
  var totalobject = 0;
  get_cart();
  //End Initial Setup
  
  //User Action
  $('#addtocart_prod').click(function(event){
    event.preventDefault();
    $.magnificPopup.open({
      items: {
        src: '#mfp_message',
        type: 'inline'
      }
    }, 0);
    add_to_cart();
  });
  
  $('#addtowishlist_prod').click(function(event){
    event.preventDefault();
    $.magnificPopup.open({
      items: {
        src: '#mfp_message',
        type: 'inline'
      }
    }, 0);
    add_to_wishlist();
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
          $.magnificPopup.close();
          $.magnificPopup.open({
            items: {
              src: '.mfp-alert',
              type: 'inline'
            },
            callbacks: {
              open: function () {
                $('#poptitle').text('Success');
                $('#popmessage').text('Item has been removed.');
              }
            }
          }, 0);
          get_cart();
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
    location.reload();
    $.magnificPopup.close();
  });
  
  $('#popok').click(function(){
    location.reload();
    $.magnificPopup.close();
  });
  //End User Action
});