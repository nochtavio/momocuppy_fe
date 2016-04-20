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
      success: function (result) {
        totalobject = 0;
        var totalprice = 0;
        var product_name = "";
        if (result['result'] === 's')
        {
          $.each(result['content'], function (key, value) {
            product_name = (value['product_name'].length > 22) ? value['product_name'].substring(0, 22)+"..." : value['product_name'] ;
            $('#shopbaglist').append("\
              <li>\
                <div class='item'><a href='#' class='cancelprod' id='btn_remove" + value['id'] + "'>X</a> <span title='"+value['product_name']+"' class='title_item'>[" + value['color_name'] + "]" + product_name + "</span></div>\
                <div class='qty'> " + value['qty'] + "</div>\
                <div class='price'> " + format_number(value['product_price']) + "</div>\
              </li>\
            ");
            $('#div-hidden').append("\
              <input type='hidden' id='object" + totalobject + "' value='" + value['id'] + "' />\
            ");
            totalobject++;
            totalprice = parseInt(totalprice) + (parseInt(value['qty']) * parseInt(value['product_price']));
          });
          setRemove();
        }
        $('#txt_totalprice').text(format_number(totalprice));
        $('.shopbaglist').jScrollPane(); 
      }
    });
  };

  //Function Set Active
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
  //End Function Set Remove

  //End Function

  //Initial Setup
  var totalobject = 0;
  get_cart();
  //End Initial Setup

  //User Action
  $('#popok').click(function () {
    location.reload();
    $.magnificPopup.close();
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
  //End User Action
});