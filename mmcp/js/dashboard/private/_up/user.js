$(document).ready(function(){
    //Function Get Object
    getObject = function(page)
    {
        $('#tablecontent').empty();
        $('#div-hidden').empty();
        $('#paging').empty();
        var pagesize = $('#pagesize').val();
        //Filter
        var companyname = $('#txt_companyname').val();
        var tipe = $('#sel_type').val();
        var active = $('#sel_active').val();
        var order = $('#sel_order').val();
        //End Filter
        $.ajax({
            url: baseurl+'dashboard/user/showObject',
            type:'POST',
            data:
            {
                page:page,
                size:pagesize,
                companyname:companyname,
                tipe:tipe,
                active:active,
                order:order
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
                        var active = "<a id='btn_active"+result['id'][x]+"' class='icon-minus-2'></a>";
                        if(result['tactive'][x] === "1")
                        {
                            active = "<a id='btn_active"+result['id'][x]+"' class='icon-checkmark'></a>";
                        }
                        //End Set Icon
                        
                        //Set Tipe
                        var buyertype = "";
                        if(result['tipe'][x] === "1")
                        {
                            buyertype = "Wholesale";
                        }
                        else if(result['tipe'][x] === "2")
                        {
                            buyertype = "Distributor";
                        }
                        else if(result['tipe'][x] === "3")
                        {
                            buyertype = "Retail";
                        }
                        else if(result['tipe'][x] === "4")
                        {
                            buyertype = "Customer";
                        }
                        else
                        {
                            buyertype = "Not Set";
                        }
                        //End Set Tipe
                        
                        $('#tablecontent').append("\
                        <tr>\
                            <td class='tdcenter'>"+(parseInt(no)+parseInt(x))+"</td>\
                            <td class='tdcenter'>"+result['companyname'][x]+"</td>\
                            <td class='tdcenter'>"+result['address'][x]+"</td>\
                            <td class='tdcenter'>"+result['phone'][x]+"</td>\
                            <td class='tdcenter'>"+result['email'][x]+"</td>\
                            <td class='tdcenter'>"+buyertype+"</td>\
                            <td class='tdcenter'>"+active+"</td>\
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
                    
                    setActive();
                    setEdit();
                    setRemove();
                }
                else
                {
                    $('#tablecontent').append("\
                    <tr>\
                        <td colspan='8'><strong style='color:red;'>"+result['message']+"</strong></td>\
                    </tr>");
                }
            }
        });  
    };
    //End Function Get Object
    
    //Function Edit Object
    editObject = function()
    {
        var id = $('#txteditid').val();
        var companyname = $('#txt_editusercompanyname').val();
        var tipe = $('#sel_editusertype').val();
        var brand = $('#txt_edituserbrand').val();
        var address = $('#txt_edituseraddress').val();
        var phone = $('#txt_edituserphone').val();
        var fax = $('#txt_edituserfax').val();
        var web = $('#txt_edituserweb').val();
        var pic = $('#txt_edituserpic').val();
        var bidang = $('#txt_edituserbidang').val();
        var year = $('#txt_edituseryear').val();
        var weeklymeat = $('#txt_edituserweeklymeat').val();
        var weeklymeat2 = $('#txt_edituserweeklymeat2').val();
        var item = $('#txt_edituseritem').val();
        var buyername = $('#txt_edituserbuyername').val();
        var email = $('#txt_edituseremail').val();
        var buyerphone = $('#txt_edituserbuyerphone').val();
        var password = $('#txt_edituserpassword').val();
        var confpassword = $('#txt_editconfpassword').val();
        var isEditPassword = 0;
        if(password !== "")
        {
            isEditPassword = 1;
        }
        $.ajax({
            url: baseurl+'dashboard/user/checkField',
            type:'POST',
            data:
            {
                companyname:companyname,
                tipe:tipe,
                brand:brand,
                address:address,
                phone:phone,
                fax:fax,
                web:web,
                pic:pic,
                bidang:bidang,
                year:year,
                weeklymeat:weeklymeat,
                weeklymeat2:weeklymeat2,
                item:item,
                buyername:buyername,
                email:email,
                buyerphone:buyerphone,
                password:password,
                confpassword:confpassword,
                isEdit:1,
                isEditPassword:isEditPassword
            },
            dataType: 'json',
            success: function(result){
                if(result['result'] === "s")
                {
                    $.ajax({
                        url: baseurl+'dashboard/user/editObject',
                        type:'POST',
                        data:
                        {
                            id:id,
                            companyname:companyname,
                            tipe:tipe,
                            brand:brand,
                            address:address,
                            phone:phone,
                            fax:fax,
                            web:web,
                            pic:pic,
                            bidang:bidang,
                            year:year,
                            weeklymeat:weeklymeat,
                            weeklymeat2:weeklymeat2,
                            item:item,
                            buyername:buyername,
                            email:email,
                            buyerphone:buyerphone,
                            password:password,
                            isEditPassword:isEditPassword
                        },
                        dataType: 'json',
                        success: function(result){
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
    //End Function Edit Object
    
    //Function Remove Product
    removeObject = function(id)
    {
        $.ajax({
            url: baseurl+'dashboard/user/removeObject',
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
    
    //Function Set Active
    setActive = function()
    {
        var id = [];
        for(var x=0;x<totalobject;x++)
        {
            id[x]=$('#object'+x).val();
        }

        $.each(id, function(x, val){
            $(document).off('click', '#btn_active'+val);
            $(document).on('click', '#btn_active'+val, function() {
                $.ajax({
                    url: baseurl+'dashboard/user/setActive',
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
    //End Function Set Active
    
    //Function Set Edit Product
    setEdit = function()
    {
        var id = [];
        for(var x=0;x<totalobject;x++)
        {
            id[x]=$('#object'+x).val();
        }
        
        $.each(id, function(x, val){
            $(document).off('click', '#btn_edit'+val);
            $(document).on('click', '#btn_edit'+val, function() {
                $.ajax({
                    url: baseurl+'dashboard/user/getObject',
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
                            $('#txt_edituserpassword').val('');
                            $('#txt_editconfpassword').val('');
                            $("#txt_editusercompanyname").val(result['companyname']);
                            $("#sel_editusertype").val(result['tipe']);
                            $("#txt_edituserbrand").val(result['brand']);
                            $("#txt_edituseraddress").val(result['address']);
                            $("#txt_edituserphone").val(result['phone']);
                            $("#txt_edituserfax").val(result['fax']);
                            $("#txt_edituserweb").val(result['web']);
                            $("#txt_edituserpic").val(result['pic']);
                            $("#txt_edituserbidang").val(result['bidang']);
                            $("#txt_edituseryear").val(result['year']);
                            $("#txt_edituserweeklymeat").val(result['weeklymeat']);
                            $("#txt_edituserweeklymeat2").val(result['weeklymeat2']);
                            $("#txt_edituseritem").val(result['item']);
                            $("#txt_edituserbuyername").val(result['buyername']);
                            $("#txt_edituseremail").val(result['email']);
                            $("#txt_edituserbuyerphone").val(result['buyerphone']);
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
    
    $("#sel_type").change(function() {
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
    
    $("#sel_active").change(function() {
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