$(document).ready(function () {
  //Function Get Object
  getObject = function (page)
  {
    $('#tablecontent').empty();
    $('#div-hidden').empty();
    $('#paging').empty();
    var pagesize = $('#pagesize').val();
    //Filter
    var email = $('#txt_email').val();
    var street_address = $('#txt_street_address').val();
    var zip_code = $('#txt_zip_code').val();
    var country = $('#txt_country').val();
    var city = $('#txt_city').val();
    var order_no = $('#txt_order_no').val();
    var resi_no = $('#txt_resi_no').val();
    var status = $('#sel_status').val();
    var cretime_from_raw = $('#txt_cretime_from').data("DateTimePicker").date();
    var cretime_from = '';
    if(cretime_from_raw != null){
      cretime_from = cretime_from_raw.year()+'-'+(cretime_from_raw.month()+1)+'-'+cretime_from_raw.date();
    }
    var cretime_to_raw = $('#txt_cretime_to').data("DateTimePicker").date();
    var cretime_to = '';
    if(cretime_to_raw != null){
      cretime_to = cretime_to_raw.year()+'-'+(cretime_to_raw.month()+1)+'-'+cretime_to_raw.date();
    }
    var order = $('#sel_order').val();
    //End Filter
    $.ajax({
      url: baseurl + 'dashboard/order_redeem/show_object',
      type: 'POST',
      data:
        {
          page: page,
          size: pagesize,
          email: email,
          street_address: street_address,
          zip_code: zip_code,
          country: country,
          city: city,
          order_no:order_no,
          resi_no:resi_no,
          status:status,
          cretime_from: cretime_from,
          cretime_to: cretime_to,
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
            
            //Set Status Color
            var status_color = "#CC9933";
            if(result['status'][x] == "Approved")
            {
              status_color = "#3300FF";
            }
            else if(result['status'][x] == "Member Confirmed")
            {
              status_color = "#CC9933";
            }
            else if(result['status'][x] == "On Delivery")
            {
              status_color = "#CCCC00";
            }
            else if(result['status'][x] == "Delivered")
            {
              status_color = "#009900";
            }
            else if(result['status'][x] == "Canceled")
            {
              status_color = "#FF0000";
            }
            //End Set Status Color
            
            //Set Order Detail
            var order = "\
              <strong>Order No: </strong>" + result['order_no'][x] + " <br/>\
              <strong>Product Name: </strong>" + result['product_name'][x] + "\
            ";
            //End Set Order Detail

            $('#tablecontent').append("\
            <tr>\
              <td class='tdcenter'>" + (parseInt(no) + parseInt(x)) + "</td>\
              <td class='tdcenter'>" + result['email'][x] + "</td>\
              <td class='tdcenter'>" + detail + "</td>\
              <td>" + order + "</td>\
              <td class='tdcenter'><span style='font-weight:bold;color:"+status_color+"'>" + result['status'][x] + "</span></td>\
              <td class='tdcenter'>\
                <a id='btn_edit" + result['id'][x] + "' class='fa fa-pencil-square-o'></a> &nbsp;\
                <a id='btn_archive" + result['id'][x] + "' class='fa fa-archive'></a> &nbsp;\
              </td>\
            </tr>");

            //Set Object ID
            $('#div-hidden').append("\
              <input type='hidden' id='object" + x + "' value='" + result['id'][x] + "' />\
            ");
            totalobject++;
            //End Set Object ID
          }

          setArchive();
          setEdit();
          setDetail();
        }
        else
        {
          $('#tablecontent').append("\
          <tr>\
            <td colspan='9'><strong style='color:red;'>" + result['message'] + "</strong></td>\
          </tr>");
        }
      }
    });
  };
  //End Function Get Object
  
  //Function Get Order Detail
  getOrderDetail = function (order_id)
  {
    $('#tabledetailorder').empty();
    $.ajax({
      url: baseurl + 'dashboard/order_redeem/show_detail_order',
      type: 'POST',
      data:
        {
          page: 1,
          size: 100,
          order_id: order_id
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          for (var x = 0; x < result['total']; x++)
          {
            $('#tabledetailorder').append("\
            <tr>\
              <td class='tdcenter'>" + (parseInt(x) + 1) + "</td>\
              <td class='tdcenter'>[" + result['color_name'][x] + "] " + result['product_name'][x] + "</td>\
              <td class='tdcenter'>" + result['price'][x] + "</td>\
              <td class='tdcenter'>" + result['qty'][x] + "</td>\
              <td class='tdcenter'>" + result['subtotal'][x] + "</td>\
            </tr>");
          }
          $('#txt_detail_order_no').text(result['order_no'][0]);
          $('#txt_total_price').text(result['totalprice']);
          $('#txt_discount').text(result['discount'][0]+"%");
          $('#txt_shipping_cost').text(result['shipping_cost'][0]);
          $('#txt_grand_total').text(result['grandtotal']);
        }
        else
        {
          $('#tabledetailorder').append("\
          <tr>\
            <td colspan='5'><strong style='color:red;'>" + result['message'] + "</strong></td>\
          </tr>");
        }
      }
    });
  };
  //End Function Get Order Detail

  //Function Edit Object
  editObject = function ()
  {
    var id = $('#txteditid').val();
    var status = $('#sel_editstatus').val();
    var resi_no = $('#txt_editresino').val();
    $.ajax({
      url: baseurl + 'dashboard/order_redeem/edit_object',
      type: 'POST',
      data:
        {
          id: id,
          status: status,
          resi_no: resi_no
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
  };
  //End Function Edit Object

  //Function Remove Object
  archiveObject = function (id)
  {
    $.ajax({
      url: baseurl + 'dashboard/order_redeem/set_archive',
      type: 'POST',
      data:
        {
          id: id
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          getObject(page);
          $('#modal_remove').modal('hide');
        }
        else
        {
          alert("Error in connection");
        }
      }
    });
  };
  //End Function Remove Object

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
          url: baseurl + 'dashboard/order_redeem/get_object',
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
              $('#txt_editaddress').val(result['street_address']+', '+result['zip_code']+'\n'+result['country']+'\n'+result['city']);
              $("#sel_editstatus").val(result['status']);
              $("#txt_editresino").val(result['resi_no']);
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

  //Function Set Archive
  setArchive = function ()
  {
    var id = [];
    for (var x = 0; x < totalobject; x++)
    {
      id[x] = $('#object' + x).val();
    }

    $.each(id, function (x, val) {
      $(document).off('click', '#btn_archive' + val);
      $(document).on('click', '#btn_archive' + val, function () {
        $("#txtremoveid").val(val);
        $('#modal_remove').modal('show');
      });
    });
  };
  //End Function Set Archive
  
  //Function Set Detail
  setDetail = function ()
  {
    var id = [];
    for (var x = 0; x < totalobject; x++)
    {
      id[x] = $('#object' + x).val();
    }

    $.each(id, function (x, val) {
      $(document).off('click', '#btn_detail' + val);
      $(document).on('click', '#btn_detail' + val, function () {
        getOrderDetail(val);
        $('#modal_detail_order').modal('show');
      });
    });
  };
  //End Function Set Detail
  
  function post(path, parameters) {
    var form = $('<form></form>');

    form.attr("method", "post");
    form.attr("action", path);

    $.each(parameters, function(key, value) {
      var field = $('<input></input>');

      field.attr("type", "hidden");
      field.attr("name", key);
      field.attr("value", value);

      form.append(field);
    });

    // The form needs to be a part of the document in
    // order for us to be able to submit it.
    $(document.body).append(form);
    form.submit();
  }
  
  //Function Get Object
  exportExcel = function ()
  {
    //Filter
    var email = $('#txt_email').val();
    var street_address = $('#txt_street_address').val();
    var zip_code = $('#txt_zip_code').val();
    var country = $('#txt_country').val();
    var city = $('#txt_city').val();
    var order_no = $('#txt_order_no').val();
    var resi_no = $('#txt_resi_no').val();
    var status = $('#sel_status').val();
    var cretime_from_raw = $('#txt_cretime_from').data("DateTimePicker").date();
    var cretime_from = '';
    if(cretime_from_raw != null){
      cretime_from = cretime_from_raw.year()+'-'+(cretime_from_raw.month()+1)+'-'+cretime_from_raw.date();
    }
    var cretime_to_raw = $('#txt_cretime_to').data("DateTimePicker").date();
    var cretime_to = '';
    if(cretime_to_raw != null){
      cretime_to = cretime_to_raw.year()+'-'+(cretime_to_raw.month()+1)+'-'+cretime_to_raw.date();
    }
    var order = $('#sel_order').val();
    //End Filter
    
    post(baseurl + 'dashboard/order_redeem/export_excel', {
      email: email,
      street_address: street_address,
      zip_code: zip_code,
      country: country,
      city: city,
      order_no:order_no,
      resi_no:resi_no,
      status:status,
      cretime_from: cretime_from,
      cretime_to: cretime_to,
      order: order
      }
    );
  };

  //Initial Setup
  page = 1;
  lastpage = 0;
  $('.ajaxloading-tr').hide();
  var totalobject = 0;
  $('.modal_warning').hide();
  
  $('#txt_cretime_from').datetimepicker({
    format: "YYYY-MM-DD"
  });
  
  $('#txt_cretime_to').datetimepicker({
    format: "YYYY-MM-DD"
  });
  
  getObject(page);
  //End Initial Setup

  //User Action
  $('#btn_add').click(function () {
    $('#txt_addordername').val("");
    $('#txt_addordercode').val("");
    $('#txt_adddiscount').val("");
    $('#modal_add').modal('show');
    $('.modal_warning').hide();
  });

  $('#btn_search_').click(function () {
    ajaxLoader();
    getObject(1);
  });

  $("#sel_status").change(function () {
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
  
  $('#btn_remove_').click(function () {
    archiveObject($("#txtremoveid").val());
  });
  
  $('#btn_export').click(function(){
    exportExcel();
  });
  //End User Action
});