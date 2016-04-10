$(document).ready(function () {
  //Function Get Object
  getObject = function (page)
  {
    $('#tablecontent').empty();
    $('#div-hidden').empty();
    $('#paging').empty();
    var pagesize = $('#pagesize').val();
    var id_member = $('#id_member').val();
    //Filter
    var street_address = $('#txt_street_address').val();
    var zip_code = $('#txt_zip_code').val();
    var country = $('#txt_country').val();
    var city = $('#txt_city').val();
    var order = $('#sel_order').val();
    //End Filter
    $.ajax({
      url: baseurl + 'dashboard/detail_address/show_object',
      type: 'POST',
      data:
        {
          page: page,
          size: pagesize,
          id_member: id_member,
          street_address: street_address,
          zip_code: zip_code,
          country: country,
          city: city,
          order: order
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          //Set Paging
          var no = 1;
          var size = result['size'];
          if (page > 1)
          {
            no = parseInt(1) + (parseInt(size) * (parseInt(page) - parseInt(1)));
          }

          writePaging(result['totalpage'], page);
          lastpage = result['totalpage'];
          clearPagingClass(".page", result['totalpage'], page);
          //End Set Paging

          for (var x = 0; x < result['total']; x++)
          {
            //Set Address
            var address = result['street_address'][x] + ", " + result['zip_code'][x] + "<br/>" + result['country'][x] + "<br/>" + result['city'][x] + "";
            //End Set Address

            //Set Detail
            var detail = "Created by <strong>" + result['creby'][x] + "</strong> <br/> on <strong>" + result['cretime'][x] + "</strong>";
            if (result['modby'][x] != null)
            {
              detail += "<br/><br/> Modified by <strong>" + result['modby'][x] + "</strong> <br/> on <strong>" + result['modtime'][x] + "</strong>";
            }
            //End Set Detail

            $('#tablecontent').append("\
            <tr>\
              <td class='tdcenter'>" + (parseInt(no) + parseInt(x)) + "</td>\
              <td class='tdcenter'>" + address + "</td>\
              <td class='tdcenter'>\
                <a id='btn_edit" + result['id'][x] + "' class='fa fa-pencil-square-o'></a> &nbsp;\
              </td>\
            </tr>");

            //Set Object ID
            $('#div-hidden').append("\
              <input type='hidden' id='object" + x + "' value='" + result['id'][x] + "' />\
            ");
            totalobject++;
            //End Set Object ID
          }

          setEdit();
        }
        else
        {
          $('#tablecontent').append("\
          <tr>\
            <td colspan='3'><strong style='color:red;'>" + result['message'] + "</strong></td>\
          </tr>");
        }
      }
    });
  };
  //End Function Get Object

  //Function Edit Object
  editObject = function ()
  {
    var id = $('#txteditid').val();
    var firstname = $('#txt_editfirstname').val();
    var lastname = $('#txt_editlastname').val();
    var street_address = $('#txt_editstreetaddress').val();
    var zip_code = $('#txt_editzipcode').val();
    var phone = $('#txt_editphone').val();
    var country = $('#txt_editcountry').val();
    var city = $('#txt_editcity').val();
    $.ajax({
      url: baseurl + 'dashboard/detail_address/check_field',
      type: 'POST',
      data:
        {
          firstname: firstname,
          lastname: lastname,
          street_address: street_address,
          zip_code: zip_code,
          phone: phone,
          country: country,
          city: city
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === "s")
        {
          $.ajax({
            url: baseurl + 'dashboard/detail_address/edit_object',
            type: 'POST',
            data:
              {
                id: id,
                firstname: firstname,
                lastname: lastname,
                street_address: street_address,
                zip_code: zip_code,
                phone: phone,
                country: country,
                city: city
              },
            dataType: 'json',
            success: function (result) {
              if (result['result'] === "s")
              {
                $('#modal_edit').modal('hide');
                getObject(1);
              }
              else
              {
                $('.modal_warning').show();
                $('.modal_warning').html(result['message']);
              }
            }
          });
        }
        else
        {
          $('.modal_warning').show();
          $('.modal_warning').html(result['message']);
        }
      }
    });
  };
  //End Function Edit Object

  //Function Set Edit Product
  setEdit = function ()
  {
    var id = [];
    for (var x = 0; x < totalobject; x++)
    {
      id[x] = $('#object' + x).val();
    }

    $.each(id, function (x, val) {
      $(document).off('click', '#btn_edit' + val);
      $(document).on('click', '#btn_edit' + val, function () {
        $.ajax({
          url: baseurl + 'dashboard/detail_address/get_object',
          type: 'POST',
          data:
            {
              id: val
            },
          dataType: 'json',
          success: function (result) {
            if (result['result'] === 's')
            {
              $("#txteditid").val(val);
              $("#txt_editfirstname").val(result['firstname']);
              $("#txt_editlastname").val(result['lastname']);
              $("#txt_editstreetaddress").val(result['street_address']);
              $("#txt_editzipcode").val(result['zip_code']);
              $("#txt_editphone").val(result['phone']);
              $("#txt_editcountry").val(result['country']);
              $("#txt_editcity").val(result['city']);
              $('.modal_warning').hide();
              $('#modal_edit').modal('show');
            }
            else
            {
              alert("Error in connection");
            }
          }
        });
      });
    });
  };
  //End Function Set Edit Product

  //Initial Setup
  page = 1;
  lastpage = 0;
  getObject(page);
  $('.ajaxloading-tr').hide();
  var totalobject = 0;
  $('.modal_warning').hide();
  //End Initial Setup

  //User Action

  $('#btn_search_').click(function () {
    ajaxLoader();
    getObject(1);
  });

  $("#sel_order").change(function () {
    ajaxLoader();
    getObject(1);
  });

  $('#form_edit').submit(function (e) {
    e.preventDefault();
    editObject();
  });
  //End User Action
});