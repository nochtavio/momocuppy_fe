$(document).ready(function () {
  //Function Get Object
  getObject = function (page)
  {
    $('#tablecontent').empty();
    $('#div-hidden').empty();
    $('#paging').empty();
    var pagesize = $('#pagesize').val();
    //Filter
    var voucher_name = $('#txt_voucher_name').val();
    var voucher_code = $('#txt_voucher_code').val();
    var active = $('#sel_active').val();
    var order = $('#sel_order').val();
    //End Filter
    $.ajax({
      url: baseurl + 'dashboard/voucher/show_object',
      type: 'POST',
      data:
        {
          page: page,
          size: pagesize,
          voucher_name: voucher_name,
          voucher_code: voucher_code,
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
              <td class='tdcenter'>" + result['voucher_name'][x] + "</td>\
              <td class='tdcenter'>" + result['voucher_code'][x] + "</td>\
              <td class='tdcenter'>" + result['discount'][x] + "</td>\
              <td class='tdcenter'>" + result['expired_date'][x] + "</td>\
              <td class='tdcenter'>" + detail + "</td>\
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
            <td colspan='8'><strong style='color:red;'>" + result['message'] + "</strong></td>\
          </tr>");
        }
      }
    });
  };
  //End Function Get Object

  //Function Add Object
  addObject = function ()
  {
    var voucher_name = $('#txt_addvouchername').val();
    var voucher_code = $('#txt_addvouchercode').val();
    var discount = $('#txt_adddiscount').val();
    var expired_date = $('#txt_addexpireddate').val();
    $.ajax({
      url: baseurl + 'dashboard/voucher/check_field',
      type: 'POST',
      data:
        {
          voucher_name: voucher_name,
          voucher_code: voucher_code,
          discount: discount
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          $.ajax({
            url: baseurl + 'dashboard/voucher/add_object',
            type: 'POST',
            data:
              {
                voucher_name: voucher_name,
                voucher_code: voucher_code,
                discount: discount,
                expired_date:expired_date
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
    var voucher_name = $('#txt_editvouchername').val();
    var voucher_code = $('#txt_editvouchercode').val();
    var discount = $('#txt_editdiscount').val();
    var expired_date_raw = $('#txt_editexpireddate').data("DateTimePicker").date();
    var expired_date = '';
    if(expired_date_raw != null){
      expired_date = expired_date_raw.year()+'-'+(expired_date_raw.month()+1)+'-'+expired_date_raw.date()+' '+expired_date_raw.hour()+':'+expired_date_raw.minute()+':'+expired_date_raw.second();
    }
    $.ajax({
      url: baseurl + 'dashboard/voucher/check_field',
      type: 'POST',
      data:
        {
          voucher_name: voucher_name,
          voucher_code: voucher_code,
          discount: discount
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === "s")
        {
          $.ajax({
            url: baseurl + 'dashboard/voucher/edit_object',
            type: 'POST',
            data:
              {
                id: id,
                voucher_name: voucher_name,
                voucher_code: voucher_code,
                discount: discount,
                expired_date:expired_date
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
      url: baseurl + 'dashboard/voucher/remove_object',
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
          url: baseurl + 'dashboard/voucher/set_active',
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
          url: baseurl + 'dashboard/voucher/get_object',
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
              $("#txt_editvouchername").val(result['voucher_name']);
              $("#txt_editvouchercode").val(result['voucher_code']);
              $("#txt_editdiscount").val(result['discount']);
              $('#txt_editexpireddate').data("DateTimePicker").date(result['expired_date']);
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
  
  $('#txt_addexpireddate').datetimepicker({
    format: "YYYY-MM-DD HH:mm:SS"
  });
  
  $('#txt_editexpireddate').datetimepicker({
    format: "YYYY-MM-DD HH:mm:SS"
  });
  //End Initial Setup

  //User Action
  $('#btn_add').click(function () {
    $('#txt_addvouchername').val("");
    $('#txt_addvouchercode').val("");
    $('#txt_adddiscount').val("");
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

  $("#sel_active").change(function () {
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