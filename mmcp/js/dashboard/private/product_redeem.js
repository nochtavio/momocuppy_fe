$(document).ready(function () {
  //Function Get Object
  getObject = function (page)
  {
    $('#tablecontent').empty();
    $('#div-hidden').empty();
    $('#paging').empty();
    var pagesize = $('#pagesize').val();
    //Filter
    var product_name = $('#txt_product_name').val();
    var visible = $('#sel_visible').val();
    var order = $('#sel_order').val();
    //End Filter
    $.ajax({
      url: baseurl + 'dashboard/product_redeem/show_object',
      type: 'POST',
      data:
        {
          page: page,
          size: pagesize,
          product_name: product_name,
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
            //Set Product Image
            var img = "<img src='"+baseurl+"images/products/no-img-potrait.jpg' height='150px' width='125px' />";
            if (result['img'][x] != null)
            {
              img = "<img src='"+baseurl+"images/products/"+result['img'][x]+"' height='150px' width='125px' />";
            }
            //End Set Product Image
            
            //Set Stock Color
            var stock_color = '';
            if(result['stock'][x] <= 3){
              stock_color = "style='background-color: #FD635F;color: white;'";
            }
            //End Set Stock Color
            
            //Set Detail
            var detail = "Created by <strong>" + result['creby'][x] + "</strong> <br/> on <strong>" + result['cretime'][x] + "</strong>";
            if (result['modby'][x] != null)
            {
              detail += "<br/><br/> Modified by <strong>" + result['modby'][x] + "</strong> <br/> on <strong>" + result['modtime'][x] + "</strong>";
            }
            //End Set Detail

            //Set Icon
            var visible = "<a id='btn_visible" + result['id'][x] + "' class='icon-minus-2'></a>";
            if (result['visible'][x] === "1")
            {
              visible = "<a id='btn_visible" + result['id'][x] + "' class='icon-checkmark'></a>";
            }
            //End Set Icon

            $('#tablecontent').append("\
            <tr>\
              <td class='tdcenter'>" + (parseInt(no) + parseInt(x)) + "</td>\
              <td class='tdcenter'>" + img + "</td>\
              <td class='tdcenter'>" + result['product_name'][x] + "</td>\
              <td class='tdcenter'>" + result['product_point'][x] + "</td>\
              <td class='tdcenter' "+stock_color+">" + result['stock'][x] + "</td>\
              <td class='tdcenter'>" + result['publish_date'][x] + "</td>\
              <td class='tdcenter'>" + detail + "</td>\
              <td class='tdcenter'>" + visible + "</td>\
              <td class='tdcenter'>\
                <a id='btn_edit" + result['id'][x] + "' class='fa fa-pencil-square-o'></a> &nbsp;\
                <a href='" + baseurl + "dashboard/detail_product_redeem_img/?id=" + result['id'][x] + "' class='fa fa-picture-o'></a> &nbsp;\
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
            <td colspan='7'><strong style='color:red;'>" + result['message'] + "</strong></td>\
          </tr>");
        }
      }
    });
  };
  //End Function Get Object

  //Function Add Object
  addObject = function ()
  {
    var product_name = $('#txt_addproductname').val();
    var product_point = $('#txt_addproductpoint').val();
    var product_desc = $('#txt_addproductdesc').trumbowyg('html');
    var publish_date_raw = $('#txt_addpublishdate').data("DateTimePicker").date();
    var publish_date = '';
    if(publish_date_raw != null){
      publish_date = publish_date_raw.year()+'-'+(publish_date_raw.month()+1)+'-'+publish_date_raw.date()+' '+publish_date_raw.hour()+':'+publish_date_raw.minute()+':'+publish_date_raw.second();
    }    
    var stock = $('#txt_addstock').val();
    var visible = 0;
    if ($('#chk_visible').prop('checked')) {
      visible = 1;
    }
    $.ajax({
      url: baseurl + 'dashboard/product_redeem/check_field',
      type: 'POST',
      data:
        {
          product_name: product_name,
          product_point: product_point,
          product_desc: product_desc,
          publish_date: publish_date,
          stock: stock
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          $.ajaxFileUpload({
            url: baseurl + 'dashboard/product_redeem/add_object',
            secureuri: false,
            fileElementId: 'userfile',
            dataType: 'json',
            data:
              {
                product_name: product_name,
                product_point: product_point,
                product_desc: product_desc,
                publish_date: publish_date,
                stock: stock,
                visible: visible
              },
            success: function (result)
            {
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
    var product_name = $('#txt_editproductname').val();
    var product_point = $('#txt_editproductpoint').val();
    var product_desc = $('#txt_editproductdesc').trumbowyg('html');
    var publish_date_raw = $('#txt_editpublishdate').data("DateTimePicker").date();
    var publish_date = '';
    if(publish_date_raw != null){
      publish_date = publish_date_raw.year()+'-'+(publish_date_raw.month()+1)+'-'+publish_date_raw.date()+' '+publish_date_raw.hour()+':'+publish_date_raw.minute()+':'+publish_date_raw.second();
    }
    var stock =  $('#txt_editstock').val();
    $.ajax({
      url: baseurl + 'dashboard/product_redeem/check_field',
      type: 'POST',
      data:
        {
          product_name: product_name,
          product_point: product_point,
          product_desc: product_desc,
          publish_date: publish_date,
          stock: stock
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === "s")
        {
          $.ajax({
            url: baseurl + 'dashboard/product_redeem/edit_object',
            type: 'POST',
            data:
              {
                id: id,
                product_name: product_name,
                product_point: product_point,
                product_desc: product_desc,
                publish_date: publish_date,
                stock: stock
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
      url: baseurl + 'dashboard/product_redeem/remove_object',
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
          url: baseurl + 'dashboard/product_redeem/set_visible',
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
          url: baseurl + 'dashboard/product_redeem/get_object',
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
              $("#txt_editproductname").val(result['product_name']);
              $("#txt_editproductpoint").val(result['product_point']);
              $('#txt_editproductdesc').trumbowyg('html', result['product_desc']);
              $('#txt_editpublishdate').data("DateTimePicker").date(result['publish_date']);
              $("#txt_editstock").val(result['stock']);
              
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
  $('#txt_addpublishdate').datetimepicker({
    format: "YYYY-MM-DD HH:mm:SS"
  });
  $('#txt_editpublishdate').datetimepicker({
    format: "YYYY-MM-DD HH:mm:SS"
  });
  $('#txt_addproductdesc').trumbowyg({
    btns: [['formatting'], ['bold', 'italic', 'underline']],
    removeformatPasted: true
  });
  
  $('#txt_editproductdesc').trumbowyg({
    btns: [['formatting'], ['bold', 'italic', 'underline']],
    removeformatPasted: true
  });
  //End Initial Setup

  //User Action
  $('#btn_add').click(function () {
    $('#txt_addproductname').val("");
    $('#txt_addproductpoint').val("");
    $('#txt_addpublishdate').val("");
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