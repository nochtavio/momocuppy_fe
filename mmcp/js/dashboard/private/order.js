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
    var order = $('#sel_order').val();
    //End Filter
    $.ajax({
      url: baseurl + 'dashboard/order/show_object',
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
            
            //Set Voucher
            var voucher_title = "";
            if(result['voucher_code'][x] != "(no voucher)")
            {
              voucher_title = "<a href='#' style='font-size:12px' title='" + result['voucher_name'][x] + "'>[?]</a>";
            }
            //End Set Voucher
            
            //Set Paid Information
            var paid = result['paid_date'][x];
            if(result['paid_date'][x] != "(not confirmed)")
            {
              paid = "\
                <strong>Account Name: </strong><span style='font-weight:bold;color:#009900'>"+result['paid_name'][x]+"</span> <br/>\
                <strong>Transfered Date: </strong><span style='font-weight:bold;color:#009900'>"+result['paid_date'][x]+"</span> <br/>\
                <strong>Transfered Amount: </strong><span style='font-weight:bold;color:#009900'>"+result['paid_nominal'][x]+"</span> <br/>\
                ";
            }
            //End Set Paid Information
            
            //Set Order Detail
            var order = "\
              <strong>Order No: </strong><a id='btn_detail" + result['id'][x] + "'>" + result['order_no'][x] + "</a> <br/>\
              <strong>Payment: </strong>" + result['payment_name'][x] + " <br/>\
              <span style='float:left'><strong>Voucher: </strong>" + result['voucher_code'][x] +" "+ voucher_title + " </span><br/>\
              <strong>Address: </strong>" + address + " <br/>\
              <strong>No Resi: </strong>" + result['resi_no'][x] + " <br/> <br/>\
              <strong>Payment Information: </strong> <br/> \
              "+paid+"\
            ";
            //End Set Order Detail

            $('#tablecontent').append("\
            <tr>\
              <td class='tdcenter'>" + (parseInt(no) + parseInt(x)) + "</td>\
              <td class='tdcenter'>" + result['email'][x] + "</td>\
              <td>" + order + "</td>\
              <td class='tdcenter'><span style='font-weight:bold;color:"+status_color+"'>" + result['status'][x] + "</span></td>\
              <td class='tdcenter'>" + detail + "</td>\
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
      url: baseurl + 'dashboard/order/show_detail_order',
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
      url: baseurl + 'dashboard/order/edit_object',
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
      url: baseurl + 'dashboard/order/set_archive',
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
          url: baseurl + 'dashboard/order/get_object',
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
  //End User Action
});