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
    var type = $('#sel_type').val();
    var color = $('#sel_color').val();
    var sale = $('#sel_sale').val();
    var visible = $('#sel_visible').val();
    var order = $('#sel_order').val();
    //End Filter
    $.ajax({
      url: baseurl + 'dashboard/product/show_object',
      type: 'POST',
      data:
        {
          page: page,
          size: pagesize,
          product_name: product_name,
          type: type,
          color: color,
          sale: sale,
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
            
            //Set Detail
            var detail = "Created by <strong>" + result['creby'][x] + "</strong> <br/> on <strong>" + result['cretime'][x] + "</strong>";
            if (result['modby'][x] != null)
            {
              detail += "<br/><br/> Modified by <strong>" + result['modby'][x] + "</strong> <br/> on <strong>" + result['modtime'][x] + "</strong>";
            }
            //End Set Detail

            //Set Icon
            var sale = "<a id='btn_sale" + result['id'][x] + "' class='icon-minus-2'></a>";
            if (result['sale'][x] === "1")
            {
              sale = "<a id='btn_sale" + result['id'][x] + "' class='icon-checkmark'></a>";
            }
            
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
              <td class='tdcenter'>" + result['category'][x] + "</td>\
              <td class='tdcenter'>" + result['color'][x] + "</td>\
              <td class='tdcenter'>" + result['product_price'][x] + "</td>\
              <td class='tdcenter'>" + result['stock'][x] + "</td>\
              <td class='tdcenter'>" + result['publish_date'][x] + "</td>\
              <td class='tdcenter'>" + result['position'][x] + "</td>\
              <td class='tdcenter'>" + detail + "</td>\
              <td class='tdcenter'>" + sale + "</td>\
              <td class='tdcenter'>" + visible + "</td>\
              <td class='tdcenter'>\
                <a id='btn_edit" + result['id'][x] + "' class='fa fa-pencil-square-o'></a> &nbsp;\
                <a href='" + baseurl + "dashboard/detail_product/?id=" + result['id'][x] + "' class='fa fa-folder-open'></a> &nbsp;\
                <a href='" + baseurl + "dashboard/detail_product_img/?id=" + result['id'][x] + "' class='fa fa-picture-o'></a> &nbsp;\
              </td>\
            </tr>");

            //Set Object ID
            $('#div-hidden').append("\
              <input type='hidden' id='object" + x + "' value='" + result['id'][x] + "' />\
            ");
            totalobject++;
            //End Set Object ID
          }
          
          setSale();
          setVisible();
          setEdit();
          setRemove();
        }
        else
        {
          $('#tablecontent').append("\
          <tr>\
            <td colspan='11'><strong style='color:red;'>" + result['message'] + "</strong></td>\
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
    var product_price = $('#txt_addproductprice').val();
    var product_desc = $('#txt_addproductdesc').trumbowyg('html');
    var product_weight = $('#txt_addproductweight').val();
    var publish_date_raw = $('#txt_addpublishdate').data("DateTimePicker").date();
    var publish_date = '';
    if(publish_date_raw != null){
      publish_date = publish_date_raw.year()+'-'+(publish_date_raw.month()+1)+'-'+publish_date_raw.date()+' '+publish_date_raw.hour()+':'+publish_date_raw.minute()+':'+publish_date_raw.second();
    }    
    var position = $('#txt_addposition').val();
    var category = $('#sel_addcategory').val();
    $.ajax({
      url: baseurl + 'dashboard/product/check_field',
      type: 'POST',
      data:
        {
          product_name: product_name,
          product_price: product_price,
          product_desc: product_desc,
          product_weight: product_weight,
          publish_date: publish_date,
          position: position
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          $.ajax({
            url: baseurl + 'dashboard/product/add_object',
            type: 'POST',
            data:
              {
                product_name: product_name,
                product_price: product_price,
                product_desc: product_desc,
                product_weight: product_weight,
                publish_date: publish_date,
                position: position,
                category: category
              },
            dataType: 'json',
            success: function (result) {
              if (result['result'] === "s")
              {
                document.location.href = '/mmcp/dashboard/detail_product/?id='+result['id_product'];
                //$('#modal_add').modal('hide');
                //getObject(1);
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
    var product_price = $('#txt_editproductprice').val();
    var product_desc = $('#txt_editproductdesc').trumbowyg('html');
    var product_weight = $('#txt_editproductweight').val();
    var publish_date_raw = $('#txt_editpublishdate').data("DateTimePicker").date();
    var publish_date = '';
    if(publish_date_raw != null){
      publish_date = publish_date_raw.year()+'-'+(publish_date_raw.month()+1)+'-'+publish_date_raw.date()+' '+publish_date_raw.hour()+':'+publish_date_raw.minute()+':'+publish_date_raw.second();
    }
    var position = $('#txt_editposition').val();
    var category = $('#sel_editcategory').val();
    $.ajax({
      url: baseurl + 'dashboard/product/check_field',
      type: 'POST',
      data:
        {
          product_name: product_name,
          product_price: product_price,
          product_desc: product_desc,
          publish_date: publish_date,
          product_weight: product_weight,
          position: position
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === "s")
        {
          $.ajax({
            url: baseurl + 'dashboard/product/edit_object',
            type: 'POST',
            data:
              {
                id: id,
                product_name: product_name,
                product_price: product_price,
                product_desc: product_desc,
                publish_date: publish_date,
                product_weight: product_weight,
                position: position,
                category: category
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
      url: baseurl + 'dashboard/product/remove_object',
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

  //Function Set Sale
  setSale = function ()
  {
    var id = [];
    for (var x = 0; x < totalobject; x++)
    {
      id[x] = $('#object' + x).val();
    }

    $.each(id, function (x, val) {
      $(document).off('click', '#btn_sale' + val);
      $(document).on('click', '#btn_sale' + val, function () {
        $.ajax({
          url: baseurl + 'dashboard/product/set_sale',
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
  //End Function Set Sale

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
          url: baseurl + 'dashboard/product/set_visible',
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
          url: baseurl + 'dashboard/product/get_object',
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
              $("#txt_editproductprice").val(result['product_price']);
              $('#txt_editproductdesc').trumbowyg('html', result['product_desc']);
              $("#txt_editproductweight").val(result['product_weight']);
              $('#txt_editpublishdate').data("DateTimePicker").date(result['publish_date']);
              $("#txt_editposition").val(result['position']);
              $('option', $('#sel_editcategory')).each(function(element) {
                  $(this).removeAttr('selected').prop('selected', false);
              });
              $('#sel_editcategory').multiselect('refresh');
              $('#sel_editcategory').multiselect('select', result['category']);
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
  
  $('#sel_addcategory').multiselect({
    enableFiltering: true,
    buttonClass: 'btn btn-default',
    maxHeight: 400
  });
  
  $('#sel_editcategory').multiselect({
    enableFiltering: true,
    buttonClass: 'btn btn-default',
    maxHeight: 400
  });
  
  $('#txt_addpublishdate').datetimepicker({
    format: "YYYY-MM-DD HH:mm:SS"
  });
  
  $('#txt_editpublishdate').datetimepicker({
    format: "YYYY-MM-DD HH:mm:SS"
  });
  
  $('#txt_addproductdesc').trumbowyg({
    btns: [['formatting'], ['bold', 'italic', 'underline']]
  });
  
  $('#txt_editproductdesc').trumbowyg({
    btns: [['formatting'], ['bold', 'italic', 'underline']]
  });
  //End Initial Setup

  //User Action
  $('#btn_add').click(function () {
    $('#txt_addproductname').val("");
    $('#txt_addproductprice').val("");
    $('#txt_addpublishdate').val("");
    $('#txt_addproductweight').val("");
    $('option', $('#sel_addcategory')).each(function(element) {
        $(this).removeAttr('selected').prop('selected', false);
    });
    $('#sel_addcategory').multiselect('refresh');
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
  
  $("#sel_type").change(function () {
    ajaxLoader();
    getObject(1);
  });
  
  $("#sel_color").change(function () {
    ajaxLoader();
    getObject(1);
  });
  
  $("#sel_sale").change(function () {
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