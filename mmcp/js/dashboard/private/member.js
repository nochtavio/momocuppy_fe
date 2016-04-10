$(document).ready(function () {
  //Function Get Object
  getObject = function (page)
  {
    $('#tablecontent').empty();
    $('#div-hidden').empty();
    $('#paging').empty();
    var pagesize = $('#pagesize').val();
    //Filter
    var firstname = $('#txt_firstname').val();
    var lastname = $('#txt_lastname').val();
    var email = $('#txt_email').val();
    var active = $('#sel_active').val();
    var order = $('#sel_order').val();
    //End Filter
    $.ajax({
      url: baseurl + 'dashboard/member/show_object',
      type: 'POST',
      data:
        {
          page: page,
          size: pagesize,
          firstname: firstname,
          lastname: lastname,
          email: email,
          active: active,
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
            //Set Account Information
            var account_information = "\
              <strong>" + result['firstname'][x] + " " + result['lastname'][x] + "</strong> <br/>\
              " + result['phone'][x] + " <br/>\
            ";
            //End Set Account Information

            //Set Detail
            var detail = "Created by <strong>" + result['creby'][x] + "</strong> <br/> on <strong>" + result['cretime'][x] + "</strong>";
            if (result['modby'][x] != null)
            {
              detail += "<br/><br/> Modified by <strong>" + result['modby'][x] + "</strong> <br/> on <strong>" + result['modtime'][x] + "</strong>";
            }
            //End Set Detail

            //Set Active
            var active = "<a id='btn_active" + result['id'][x] + "' class='icon-minus-2'></a>";
            if (result['active'][x] === "1")
            {
              active = "<a id='btn_active" + result['id'][x] + "' class='icon-checkmark'></a>";
            }
            //End Set Active

            $('#tablecontent').append("\
            <tr>\
              <td class='tdcenter'>" + (parseInt(no) + parseInt(x)) + "</td>\
              <td class='tdcenter'>" + result['email'][x] + "</td>\
              <td class='tdcenter'>" + account_information + "</td>\
              <td class='tdcenter'>" + result['point'][x] + "</td>\
              <td class='tdcenter'>" + detail + "</td>\
              <td class='tdcenter'>" + active + "</td>\
              <td class='tdcenter'>\
                <a id='btn_edit" + result['id'][x] + "' class='fa fa-pencil-square-o'></a> &nbsp;\
                <a href='" + baseurl + "dashboard/detail_address/?id=" + result['id'][x] + "' class='fa fa-folder-open'></a> &nbsp;\
                <a href='" + baseurl + "dashboard/wishlist/?id=" + result['id'][x] + "' class='fa fa-folder-open'></a> &nbsp;\
              </td>\
            </tr>");

            //Set Object ID
            $('#div-hidden').append("\
              <input type='hidden' id='object" + x + "' value='" + result['id'][x] + "' />\
            ");
            totalobject++;
            //End Set Object ID
          }

          setActive();
          setEdit();
        }
        else
        {
          $('#tablecontent').append("\
          <tr>\
            <td colspan='7'><strong style='color:red;'>" + result['message'] + "</strong></td>\
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
    var phone = $('#txt_editphone').val();
    $.ajax({
      url: baseurl + 'dashboard/member/check_field',
      type: 'POST',
      data:
        {
          firstname: firstname,
          lastname: lastname,
          phone: phone
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === "s")
        {
          $.ajax({
            url: baseurl + 'dashboard/member/edit_object',
            type: 'POST',
            data:
              {
                id: id,
                firstname: firstname,
                lastname: lastname,
                phone: phone
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

  //Function Set Visible
  setActive = function ()
  {
    var id = [];
    for (var x = 0; x < totalobject; x++)
    {
      id[x] = $('#object' + x).val();
    }

    $.each(id, function (x, val) {
      $(document).off('click', '#btn_active' + val);
      $(document).on('click', '#btn_active' + val, function () {
        $.ajax({
          url: baseurl + 'dashboard/member/set_active',
          type: 'POST',
          data:
            {
              id: val
            },
          dataType: 'json',
          success: function (result) {
            if (result['result'] === 's')
            {
              getObject(page);
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
  //End Function Set Visible

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
          url: baseurl + 'dashboard/member/get_object',
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
              $("#txt_editphone").val(result['phone']);
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
  $('#txt_addmembercode').pickAColor();
  $('#txt_editmembercode').pickAColor();
  //End Initial Setup

  //User Action
  $("#sel_order").change(function () {
    ajaxLoader();
    getObject(1);
  });

  $("#sel_active").change(function () {
    ajaxLoader();
    getObject(1);
  });

  $('#form_edit').submit(function (e) {
    e.preventDefault();
    editObject();
  });

  $('#btn_add').click(function () {
    $('#txt_addmembername').val("");
    $('#txt_addmembercode').val("");
    $('#modal_add').modal('show');
    $('.modal_warning').hide();
  });

  $('#btn_search_').click(function () {
    ajaxLoader();
    getObject(1);
  });
  //End User Action
});