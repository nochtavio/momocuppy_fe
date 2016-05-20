$(document).ready(function () {
  //Function Edit Object
  editObject = function ()
  {
    var content = $('#txt_editcontent').code();
    $.ajax({
      url: baseurl + 'dashboard/about_us/check_field',
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
            url: baseurl + 'dashboard/about_us/edit_object',
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
  
  //Function Edit Image
  editImage = function()
  {
    $.ajaxFileUpload({
      url: baseurl + 'dashboard/about_us/edit_image',
      secureuri: false,
      fileElementId: 'editfile',
      dataType: 'json',
      data:
        {
          
        },
      success: function (result)
      {
        if (result['result'] === "s")
        {
          d = new Date();
          $("#img_aboutus").attr("src", "/mmcp/images/aboutus/headerintro.png?"+d.getTime());
          $('.modal_warning_').hide();
          $('.modal_success_').show();
          $('.modal_success_').html("Update Success");
        }
        else
        {
          $('.modal_success_').hide();
          $('.modal_warning_').show();
          $('.modal_warning_').html(result['message']);
        }
      }
    });
  };
  //End Function Edit Image

  //Function Set Edit Product
  getObject = function ()
  {
    $.ajax({
      url: baseurl + 'dashboard/about_us/get_object',
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
    btns: [['formatting'], ['bold', 'italic', 'underline'], ['link']],
    removeformatPasted: true
  });
  getObject();
  //End Initial Setup

  //User Action
  $('#form_edit').submit(function (e) {
    e.preventDefault();
    editObject();
  });
  
  $('#btn_change').click(function(e){
    e.preventDefault();
    editImage();
  });
  //End User Action
});