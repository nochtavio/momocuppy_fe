$(document).ready(function(){
    //Function Get Object
    getObject = function(page)
    {
        $('#tablecontent').empty();
        $('#div-hidden').empty();
        $('#paging').empty();
        var pagesize = $('#pagesize').val();
        //Filter
        var title = $('#txt_title').val();
        var order = $('#sel_order').val();
        var show = $('#sel_show').val();
        //End Filter
        $.ajax({
            url: baseurl+'dashboard/pricelist/showObject',
            type:'POST',
            data:
            {
                page:page,
                size:pagesize,
                title:title,
                order:order,
                show:show
            },
            dataType: 'json',
            success: function(result){
                if(result['result'] === 's')
                {
                    //Set Paging
                    var no = 1;
                    var size = result['size'];
                    if(page > 1)
                    {
                        no = parseInt(1)+(parseInt(size)*(parseInt(page)-parseInt(1)));
                    }
                    
                    writePaging(result['totalpage'], page);
                    lastpage = result['totalpage'];
                    clearPagingClass(".page",result['totalpage'],page);
                    //End Set Paging
                    
                    for(var x=0;x<result['total'];x++)
                    {
                        //Set Icon
                        var show = "<a id='btn_show"+result['id'][x]+"' class='icon-minus-2'></a>";
                        if(result['show'][x] === "1")
                        {
                            show = "<a id='btn_show"+result['id'][x]+"' class='icon-checkmark'></a>";
                        }
                        //End Set Icon
                        
                        //Set Cretime & Modtime
                        var created = "";
                        var modified = "";
                        
                        created = "\
                            "+result['cretime'][x]+" <br/>\
                            <strong>Created By: </strong>"+result['creby'][x]+" <br/> <br/>\
                        ";
                        if(result['modby'][x] !== null)
                        {
                            modified = "\
                                "+result['modtime'][x]+" <br/>\
                                <strong>Modified By: </strong>"+result['modby'][x]+"\
                            ";
                        }
                        //End Set Cretime & Modtime
                        
                        $('#tablecontent').append("\
                        <tr>\
                            <td class='tdcenter'>"+(parseInt(no)+parseInt(x))+"</td>\
                            <td>"+result['title'][x]+"</td>\
                            <td class='tdcenter'>\
                                "+created+" <br/>\
                                "+modified+" <br/>\
                            </td>\
                            <td class='tdcenter'>"+show+"</td>\
                            <td class='tdcenter'>\
                                <a id='btn_edit"+result['id'][x]+"' class='icon-cog'></a> &nbsp;\
                                <a id='btn_remove"+result['id'][x]+"' class='icon-cancel-2'></a>\
                            </td>\
                        </tr>");
                        
                        //Set Object ID
                        $('#div-hidden').append("\
                            <input type='hidden' id='object"+x+"' value='"+result['id'][x]+"' />\
                        ");
                        totalobject++;
                        //End Set Object ID
                    }
                    
                    setShow();
                    setEdit();
                    setRemove();
                }
                else
                {
                    $('#tablecontent').append("\
                    <tr>\
                        <td colspan='5'><strong style='color:red;'>"+result['message']+"</strong></td>\
                    </tr>");
                }
            }
        });  
    };
    //End Function Get Object
    
    //Function Add Object
    addObject = function()
    {
        var name = $('#txt_addpricelistname').val();
        var group = $('#txt_addpricegroup').val();
        var unit = $('#txt_addpriceunit').val();
        var price1 = $('#txt_addpricelistprice1').val();
        var price2 = $('#txt_addpricelistprice2').val();
        var price3 = $('#txt_addpricelistprice3').val();
        var price4 = $('#txt_addpricelistprice4').val();
        $.ajax({
            url: baseurl+'dashboard/pricelist/checkField',
            type:'POST',
            data:
            {
                title:name,
                group:group,
                unit:unit,
                price1:price1,
                price2:price2,
                price3:price3,
                price4:price4
            },
            dataType: 'json',
            success: function(result){
                if(result['result'] === 's')
                {
                    $.ajaxFileUpload({
                        url             :baseurl+'dashboard/pricelist/addObject', 
                        secureuri       :false,
                        fileElementId   :'userfile',
                        dataType        :'json',
                        data            : 
                        {
                            title:name,
                            group:group,
                            unit:unit,
                            price1:price1,
                            price2:price2,
                            price3:price3,
                            price4:price4
                        },
                        success : function(result)
                        {
                            if(result['result'] === "s")
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
    
    //Function Edit Product
    editObject = function()
    {
        var id = $('#txteditid').val();
        var name = $('#txt_editpricelistname').val();
        var group = $('#txt_editpricegroup').val();
        var unit = $('#txt_editpriceunit').val();
        var price1 = $('#txt_editpricelistprice1').val();
        var price2 = $('#txt_editpricelistprice2').val();
        var price3 = $('#txt_editpricelistprice3').val();
        var price4 = $('#txt_editpricelistprice4').val();
        $.ajax({
            url: baseurl+'dashboard/pricelist/checkField',
            type:'POST',
            data:
            {
                title:name,
                group:group,
                unit:unit,
                price1:price1,
                price2:price2,
                price3:price3,
                price4:price4
            },
            dataType: 'json',
            success: function(result){
                if(result['result'] === "s")
                {
                    $.ajaxFileUpload({
                        url             :baseurl+'dashboard/pricelist/editObject', 
                        secureuri       :false,
                        fileElementId   :'editfile',
                        dataType        :'json',
                        data            : 
                        {
                            id:id,
                            title:name,
                            group:group,
                            unit:unit,
                            price1:price1,
                            price2:price2,
                            price3:price3,
                            price4:price4
                        },
                        success : function(result)
                        {
                            if(result['result'] === "s")
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
    //End Function Edit Product
    
    //Function Remove Product
    removeObject = function(id)
    {
        $.ajax({
            url: baseurl+'dashboard/pricelist/removeObject',
            type:'POST',
            data:
            {
                id:id
            },
            dataType: 'json',
            success: function(result){
                if(result['result'] === 's')
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
    //End Function Remove Product
    
    //Function Set Show
    setShow = function()
    {
        var id = [];
        for(var x=0;x<totalobject;x++)
        {
            id[x]=$('#object'+x).val();
        }

        $.each(id, function(x, val){
            $(document).off('click', '#btn_show'+val);
            $(document).on('click', '#btn_show'+val, function() {
                $.ajax({
                    url: baseurl+'dashboard/pricelist/setShow',
                    type:'POST',
                    data:
                    {
                        id:val
                    },
                    dataType: 'json',
                    success: function(result){
                        if(result['result'] === 's')
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
    //End Function Set Show
    
    //Function Set Edit Product
    setEdit = function()
    {
        var id = [];
        for(var x=0;x<totalobject;x++)
        {
            id[x]=$('#object'+x).val();
        }
        
        var d = new Date();
        var time = d.getTime();
        
        $.each(id, function(x, val){
            $(document).off('click', '#btn_edit'+val);
            $(document).on('click', '#btn_edit'+val, function() {
                $.ajax({
                    url: baseurl+'dashboard/pricelist/getObject',
                    type:'POST',
                    data:
                    {
                        id:val
                    },
                    dataType: 'json',
                    success: function(result){
                        if(result['result'] === 's')
                        {
                            $("#txteditid").val(val);
                            $("#txt_editpricelistname").val(result['title']);
                            $("#txt_editpricegroup").val(result['group']);
                            $("#txt_editpriceunit").val(result['unit']);
                            $("#txt_editpricelistprice1").val(result['vprice1']);
                            $("#txt_editpricelistprice2").val(result['vprice2']);
                            $("#txt_editpricelistprice3").val(result['vprice3']);
                            $("#txt_editpricelistprice4").val(result['vprice4']);
                            $("#img_editpricelist").attr("src",baseurl+"images/pricelist/"+result['img']+"?"+time);
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
    setRemove = function()
    {
        var id = [];
        for(var x=0;x<totalobject;x++)
        {
            id[x]=$('#object'+x).val();
        }
        
        $.each(id, function(x, val){
            $(document).off('click', '#btn_remove'+val);
            $(document).on('click', '#btn_remove'+val, function() {
                $("#txtremoveid").val(val);
                $('#modal_remove').modal('show');
            });
        });
    };
    //End Function Set Remove
    
    //Initial Setup
    page = 1;
    getObject(page);
    $('.ajaxloading-tr').hide();
    var lastpage = 0;
    var totalobject = 0;
    $('.modal_warning').hide();
    $(".img_product").fancybox({
        'transitionIn'	: 'elastic',
        'transitionOut'	: 'elastic'
    });
    //End Initial Setup
    
    //User Action
    $('#form_filter').bind('keypress', function(e) {
        //Show Ajax Loader
        $.ajaxSetup({
            beforeSend:function(){
                $('.ajaxloading-tr').show();
            },
            complete:function(){
                $('.ajaxloading-tr').hide();
            }
        }); 
        //End Show Ajax Loader
        if(e.keyCode===13){
            e.preventDefault();
            getObject(page);
        }
    });
    
    $('#btn_add').click(function(){
        $('#txt_addpricelistname').val("");
        $('#txt_addpricelistdesc').val("");
        $('#txt_addpricelistprice1').val("");
        $('#txt_addpricelistprice2').val("");
        $('#txt_addpricelistprice3').val("");
        $('#txt_addpricelistprice4').val("");
        $('#txt_addpricelistprice5').val("");
        $('#modal_add').modal('show');
        $('.modal_warning').hide();
    });
    
    $('#btn_search_').click(function(){
        //Show Ajax Loader
        $.ajaxSetup({
            beforeSend:function(){
                $('.ajaxloading-tr').show();
            },
            complete:function(){
                $('.ajaxloading-tr').hide();
            }
        }); 
        //End Show Ajax Loader
        getObject(1);
    });
    
    $("#sel_order").change(function() {
        //Show Ajax Loader
        $.ajaxSetup({
            beforeSend:function(){
                $('.ajaxloading-tr').show();
            },
            complete:function(){
                $('.ajaxloading-tr').hide();
            }
        }); 
        //End Show Ajax Loader
        
        getObject(1);
    });
    
    $("#sel_show").change(function() {
        //Show Ajax Loader
        $.ajaxSetup({
            beforeSend:function(){
                $('.ajaxloading-tr').show();
            },
            complete:function(){
                $('.ajaxloading-tr').hide();
            }
        }); 
        //End Show Ajax Loader
        
        getObject(1);
    });
    
    $('#upload_file').submit(function(e) {
        e.preventDefault();
        addObject();
    });
    
    $('#edit_file').submit(function(e) {
        e.preventDefault();
        editObject();
    });
    
    $('#btn_remove_').click(function(){
        removeObject($("#txtremoveid").val());
    });
    
    $(document).on('click', 'a.page', function() {
        //Show Ajax Loader
        $.ajaxSetup({
            beforeSend:function(){
                $('.ajaxloading-tr').show();
            },
            complete:function(){
                $('.ajaxloading-tr').hide();
            }
        }); 
        //End Show Ajax Loader
        
        page = $(this).html();
        getObject(page);
    });
    
    $(document).on('click', 'a.firstpage', function() {
        //Show Ajax Loader
        $.ajaxSetup({
            beforeSend:function(){
                $('.ajaxloading-tr').show();
            },
            complete:function(){
                $('.ajaxloading-tr').hide();
            }
        }); 
        //End Show Ajax Loader
        page = 1;
        getObject(page);
    });
    
    $(document).on('click', 'a.lastpage', function() {
        //Show Ajax Loader
        $.ajaxSetup({
            beforeSend:function(){
                $('.ajaxloading-tr').show();
            },
            complete:function(){
                $('.ajaxloading-tr').hide();
            }
        }); 
        //End Show Ajax Loader
        page = lastpage;
        getObject(page);
    });
    //End User Action
});