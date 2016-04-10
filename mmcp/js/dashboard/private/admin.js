$(document).ready(function () {
  //Function Get Object
  getObject = function (page)
  {
    $('#tablecontent').empty();
    $('#div-hidden').empty();
    $('#paging').empty();
    var pagesize = $('#pagesize').val();
    //Filter
    var username = $('#txt_username').val();
    var active = $('#sel_active').val();
    var order = $('#sel_order').val();
    //End Filter
    $.ajax({
      url: baseurl + 'dashboard/admin/show_object',
      type: 'POST',
      data:
        {
          page: page,
          size: pagesize,
          username: username,
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
            //Set Icon
            var active = "<a id='btn_active" + result['id'][x] + "' class='icon-minus-2'></a>";
            if (result['active'][x] === "1")
            {
              active = "<a id='btn_active" + result['id'][x] + "' class='icon-checkmark'></a>";
            }
            //End Set Icon

            $('#tablecontent').append("\
              <tr>\
                <td class='tdcenter'>" + (parseInt(no) + parseInt(x)) + "</td>\
                <td class='tdcenter'>" + result['username'][x] + "</td>\
                <td class='tdcenter'>" + active + "</td>\
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

          setActive();
          setEdit();
          setRemove();
        }
        else
        {
          $('#tablecontent').append("\
          <tr>\
            <td colspan='5'><strong style='color:red;'>" + result['message'] + "</strong></td>\
          </tr>");
        }
      }
    });
  };
  //End Function Get Object

  //Function Add Object
  addObject = function ()
  {
    var username = $('#txt_addadminusername').val();
    var password = $('#txt_addadminpassword').val();
    var confpassword = $('#txt_addconfpassword').val();
    var level = $('#sel_adminlevel').val();
    $.ajax({
      url: baseurl + 'dashboard/admin/check_field',
      type: 'POST',
      data:
        {
          username: username,
          password: password,
          confpassword: confpassword,
          isEditPassword: 1
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          $.ajax({
            url: baseurl + 'dashboard/admin/add_object',
            type: 'POST',
            data:
              {
                username: username,
                password: password,
                level: level
              },
            dataType: 'json',
            success: function (result) {
              if (result['result'] === "s")
              {
                $('#modal_add').modal('hide');
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
  //End Function Add Object

  //Function Edit Object
  editObject = function ()
  {
    var id = $('#txteditid').val();
    var username = $('#txt_editadminusername').val();
    var password = $('#txt_editadminpassword').val();
    var confpassword = $('#txt_editconfpassword').val();
    var level = $('#sel_editadminlevel').val();
    var isEditPassword = 0;
    if (password !== "")
    {
      isEditPassword = 1;
    }
    $.ajax({
      url: baseurl + 'dashboard/admin/check_field',
      type: 'POST',
      data:
        {
          username: username,
          password: password,
          confpassword: confpassword,
          isEdit: 1,
          isEditPassword: isEditPassword
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === "s")
        {
          $.ajax({
            url: baseurl + 'dashboard/admin/edit_object',
            type: 'POST',
            data:
              {
                id: id,
                password: password,
                level: level,
                isEditPassword: isEditPassword
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

  //Function Remove Object
  removeObject = function (id)
  {
    $.ajax({
      url: baseurl + 'dashboard/admin/remove_object',
      type: 'POST',
      data:
        {
          id: id
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          $('#modal_remove').modal('hide');
          getObject(1);
        }
        else
        {
          alert("Error in connection");
        }
      }
    });
  };
  //End Function Remove Object

  //Function Set Active
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
          url: baseurl + 'dashboard/admin/set_active',
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
  //End Function Set Active

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
          url: baseurl + 'dashboard/admin/get_object',
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
              $("#txt_editadminusername").val(result['username']);
              $("#sel_editadminlevel").val(result['level']);
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

  //Function Set Remove
  setRemove = function ()
  {
    var id = [];
    for (var x = 0; x < totalobject; x++)
    {
      id[x] = $('#object' + x).val();
    }

    $.each(id, function (x, val) {
      $(document).off('click', '#btn_remove' + val);
      $(document).on('click', '#btn_remove' + val, function () {
        $("#txtremoveid").val(val);
        $('#modal_remove').modal('show');
      });
    });
  };
  //End Function Set Remove

  //Initial Setup
  page = 1;
  lastpage = 0;
  getObject(page);
  $('.ajaxloading-tr').hide();
  var totalobject = 0;
  $('.modal_warning').hide();
  $(".img_product").fancybox({
    'transitionIn': 'elastic',
    'transitionOut': 'elastic'
  });
  //End Initial Setup

  //User Action
  $('#btn_add').click(function () {
    $('#txt_addadminusername').val("");
    $('#txt_addadminpassword').val("");
    $('#txt_addconfpassword').val("");
    $('#sel_adminlevel').val("1");
    $('#modal_add').modal('show');
    $('.modal_warning').hide();
  });

  $('#btn_search_').click(function () {
    ajaxLoader();
    getObject(1);
  });

  $("#sel_order").change(function () {
    ajaxLoader();
    getObject(1);
  });

  $("#sel_level").change(function () {
    ajaxLoader();
    getObject(1);
  });

  $("#sel_active").change(function () {
    ajaxLoader();
    getObject(1);
  });

  $('#upload_file').submit(function (e) {
    e.preventDefault();
    addObject();
  });

  $('#edit_file').submit(function (e) {
    e.preventDefault();
    editObject();
  });

  $('#btn_remove_').click(function () {
    removeObject($("#txtremoveid").val());
  });
  //End User Action
});