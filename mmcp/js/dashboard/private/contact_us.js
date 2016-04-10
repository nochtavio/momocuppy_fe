$(document).ready(function () {
  //Function Edit Object
  editObject = function ()
  {
    var content = $('#txt_editcontent').code();
    $.ajax({
      url: baseurl + 'dashboard/contact_us/check_field',
      type: 'POST',
      data:
        {
          content: content
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === "s")
        {
          $.ajax({
            url: baseurl + 'dashboard/contact_us/edit_object',
            type: 'POST',
            data:
              {
                content: content
              },
            dataType: 'json',
            success: function (result) {
              if (result['result'] === "s")
              {
                $('.modal_warning').hide();
                $('.modal_success').show();
                $('.modal_success').html("Update Success");
                getObject();
              }
              else
              {
                $('.modal_success').hide();
                $('.modal_warning').show();
                $('.modal_warning').html(result['message']);
              }
            }
          });
        }
        else
        {
          $('.modal_success').hide();
          $('.modal_warning').show();
          $('.modal_warning').html(result['message']);
        }
      }
    });
  };
  //End Function Edit Object

  //Function Set Edit Product
  getObject = function ()
  {
    $.ajax({
    url: baseurl + 'dashboard/contact_us/get_object',
    type: 'POST',
    data:
      {
        
      },
    dataType: 'json',
    success: function (result) {
      if (result['result'] === 's')
      {
        $('#txt_editcontent').trumbowyg('html', result['content']);
      }
      else
      {
        alert("Error in connection");
      }
    }
  });
  };
  //End Function Set Edit Product

  //Initial Setup
  $('#txt_editcontent').trumbowyg({
    btns: [['formatting'], ['bold', 'italic', 'underline']]
  });
  getObject();
  //End Initial Setup

  //User Action
  $('#form_edit').submit(function (e) {
    e.preventDefault();
    editObject();
  });
  //End User Action
});