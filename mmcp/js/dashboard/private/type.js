$(document).ready(function () {
  //Function Get Object
  getObject = function (page)
  {
    $('#tablecontent').empty();
    $('#div-hidden').empty();
    $('#paging').empty();
    var pagesize = $('#pagesize').val();
    //Filter
    var type_name = $('#txt_type_name').val();
    var visible = $('#sel_visible').val();
    var order = $('#sel_order').val();
    //End Filter
    $.ajax({
      url: baseurl + 'dashboard/type/show_object',
      type: 'POST',
      data:
        {
          page: page,
          size: pagesize,
          type_name: type_name,
          visible: visible,
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
            //Set Detail
            var detail = "Created by <strong>" + result['creby'][x] + "</strong> <br/> on <strong>" + result['cretime'][x] + "</strong>";
            if (result['modby'][x] != null)
            {
              detail += "<br/><br/> Modified by <strong>" + result['modby'][x] + "</strong> <br/> on <strong>" + result['modtime'][x] + "</strong>";
            }
            //End Set Detail

            //Set Visible
            var visible = "<a id='btn_visible" + result['id'][x] + "' class='icon-minus-2'></a>";
            if (result['visible'][x] === "1")
            {
              visible = "<a id='btn_visible" + result['id'][x] + "' class='icon-checkmark'></a>";
            }
            //End Set Visible

            $('#tablecontent').append("\
            <tr>\
              <td class='tdcenter'>" + (parseInt(no) + parseInt(x)) + "</td>\
              <td class='tdcenter'>" + result['type_name'][x] + "</td>\
              <td class='tdcenter'>" + result['position'][x] + "</td>\
              <td class='tdcenter'>" + detail + "</td>\
              <td class='tdcenter'>" + visible + "</td>\
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

          setVisible();
          setEdit();
          setRemove();
        }
        else
        {
          $('#tablecontent').append("\
          <tr>\
            <td colspan='6'><strong style='color:red;'>" + result['message'] + "</strong></td>\
          </tr>");
        }
      }
    });
  };
  //End Function Get Object

  //Function Add Object
  addObject = function ()
  {
    var type_name = $('#txt_addtypename').val();
    var position = $('#txt_addposition').val();
    $.ajax({
      url: baseurl + 'dashboard/type/check_field',
      type: 'POST',
      data:
        {
          type_name: type_name,
          position: position
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] == 's')
        {
          var path = './images/type/';
          $.ajaxFileUpload({
            url: baseurl + 'dashboard/type/upload_image',
            secureuri: false,
            fileElementId: 'userfile',
            dataType: 'json',
            data:
              {
                element: 'userfile',
                path: path,
                type: 'img'
              },
            success: function (result)
            {
              if (result['result'] == "s")
              {
                $.ajax({
                  url: baseurl + 'dashboard/type/add_object',
                  type: 'POST',
                  data:
                    {
                      type_name: type_name,
                      position: position
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
    var type_name = $('#txt_edittypename').val();
    var position = $('#txt_editposition').val();
    var img = $('#txteditimg').val();
    $.ajax({
      url: baseurl + 'dashboard/type/check_field',
      type: 'POST',
      data:
        {
          type_name: type_name,
          position: position
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === "s")
        {
          $.ajax({
            url: baseurl + 'dashboard/type/edit_object',
            type: 'POST',
            data:
              {
                id: id,
                type_name: type_name,
                position: position
              },
            dataType: 'json',
            success: function (result) {
              if (result['result'] === "s")
              {
                var path = './images/type/';
                $.ajaxFileUpload({
                  url: baseurl + 'dashboard/type/update_image',
                  secureuri: false,
                  fileElementId: 'editfile',
                  dataType: 'json',
                  data:
                    {
                      element: 'editfile',
                      path: path,
                      img: img
                    },
                  success: function (result)
                  {
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
      url: baseurl + 'dashboard/type/remove_object',
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

  //Function Set Visible
  setVisible = function ()
  {
    var id = [];
    for (var x = 0; x < totalobject; x++)
    {
      id[x] = $('#object' + x).val();
    }

    $.each(id, function (x, val) {
      $(document).off('click', '#btn_visible' + val);
      $(document).on('click', '#btn_visible' + val, function () {
        $.ajax({
          url: baseurl + 'dashboard/type/set_visible',
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

    var d = new Date();
    var time = d.getTime();

    $.each(id, function (x, val) {
      $(document).off('click', '#btn_edit' + val);
      $(document).on('click', '#btn_edit' + val, function () {
        $.ajax({
          url: baseurl + 'dashboard/type/get_object',
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
              $("#txteditimg").val(result['img']);
              $("#txt_edittypename").val(result['type_name']);
              $("#txt_editposition").val(result['position']);
              $("#img_edit").attr("src", baseurl + "images/type/" + result['img'] + "?" + time);
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
  //End Initial Setup

  //User Action
  $('#btn_add').click(function () {
    $('#txt_addtypename').val("");
    $('#modal_add').modal('show');
    $('.modal_warning').hide();
  });

  $('#btn_search_').click(function () {
    ajaxLoader();
    getObject(1);
  });

  $("#sel_type").change(function () {
    ajaxLoader();
    getObject(1);
  });

  $("#sel_order").change(function () {
    ajaxLoader();
    getObject(1);
  });

  $("#sel_visible").change(function () {
    ajaxLoader();
    getObject(1);
  });

  $('#form_add').submit(function (e) {
    e.preventDefault();
    addObject();
  });

  $('#form_edit').submit(function (e) {
    e.preventDefault();
    editObject();
  });

  $('#btn_remove_').click(function () {
    removeObject($("#txtremoveid").val());
  });
  //End User Action
});