$(document).ready(function(){
  //Function
  var generate_member_address = function () {
    $('#box_address').empty();
    $('#div-hidden').empty();
    $.ajax({
      url: base_url + 'api/generate_member_address',
      type: 'POST',
      data:
        {},
      dataType: 'json',
      success: function (result) {
        totalobject = 0;
        if (result['result'] === 's')
        {
          var border = 0;
          var class_border = "";
          $.each(result['content'], function (key, value) {
            if(border % 2 == 0){
              class_border = "";
            }else{
              class_border = "noborder";
            }
            $('#box_address').append("\
              <li class='address-item "+class_border+"'>\
                <span class='addr_name'>My Address #"+(totalobject+1)+"</span>\
                <span class='name'>" + value['firstname'] + " " + value['lastname'] + "</span>\
                <span class='addr'>\
                  " + value['street_address'] + "<br />\
                  " + value['city_name'] + " " + value['zip_code'] + "<br />\
                  " + value['country'] + "\
                </span>\
                \
                <span class='phone'>" + value['phone'] + "</span>\
                <a id='btn_edit" + value['id'] + "' href='#' class='editaddr popaddress'>edit</a>\
              </li>\
            ");
            $('#div-hidden').append("\
              <input type='hidden' id='object" + totalobject + "' value='" + value['id'] + "' />\
            ");
            totalobject++;
            border++;
          });
          set_edit();
          $('#box_address').simplebar();
					
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
      $(document).on('click', '#btn_edit' + val, function (event) {
        event.preventDefault();
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
        $.magnificPopup.close();
        $.magnificPopup.open({
          items: {
            src: '#mfp_message',
            type: 'inline'
          },
          callbacks: {
            close: function () {
              location.reload();
            }
          }
        }, 0);
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
        $.magnificPopup.close();
        $.magnificPopup.open({
          items: {
            src: '#mfp_message',
            type: 'inline'
          },
          callbacks: {
            close: function () {
              location.reload();
            }
          }
        }, 0);
      }
    });
  };
  //End Function
  
  //Initial Setup
  var totalobject = 0;
  var state = "";
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

  $(document).on('click', '#btn_add', function (event) {
    event.preventDefault();
    $('#poptitle').text("Add Address");
    $('#firstname').val("");
    $('#lastname').val("");
    $('#phone').val("");
    $('#streetname').val("");
    $('#postalcode').val("");
    $('#city').val("");
    $('#txt_id').val("");
    state = "add";
    $.magnificPopup.open({
      items: {
        src: '#popaddress',
        type: 'inline'
      }
    }, 0);
  });
  
  $('#popok').click(function(){
    $.magnificPopup.close();
  });
  //End User Action
});