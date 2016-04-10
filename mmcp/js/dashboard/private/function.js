$(document).ready(function () {
  baseurl = $('#base').val();
  //Function Login User
  goLogin = function ()
  {
    var username = $('#txt_username').val();
    var password = $('#txt_password').val();
    $.ajax({
      url: baseurl + 'dashboard/index/login',
      type: 'POST',
      data:
        {
          username: username,
          password: password
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's')
        {
          window.location.href = baseurl + "dashboard/main/";
        }
        else
        {
          $('#dashboardlogin-warning').text(result['message']);
        }
      }
    });
  };
  //End Function Login User

  //Function Logout Member
  goLogout = function ()
  {
    $.post(baseurl + 'dashboard/index/logout',
      {
      },
      function (data)
      {
        if (data)
        {
          window.location.href = baseurl + "dashboard/";
        }
      },
      'json');
  };
  //End Function Logout Member

  //Function AJAX Loader
  ajaxLoader = function ()
  {
    //Show Ajax Loader
    $.ajaxSetup({
      beforeSend: function () {
        $('.ajaxloading-tr').show();
      },
      complete: function () {
        $('.ajaxloading-tr').hide();
      }
    });
    //End Show Ajax Loader
  };
  //End Function AJAX Loader

  //Function Write Paging
  writePaging = function (totalpage, page)
  {
    if (totalpage > 1)
    {
      var initial = 0;
      if (parseInt(page) - parseInt(4) > 1)
      {
        initial = parseInt(page) - parseInt(5);
      }
      else
      {
        initial = 0;
      }
      var total = 0;
      if (parseInt(page) + parseInt(4) <= totalpage)
      {
        total = parseInt(page) + parseInt(4);
      }
      else
      {
        total = parseInt(totalpage);
      }
      $('#paging').append("<li><a class='firstpage'>&laquo;</a></li>");
      for (var y = initial; y < total; y++)
      {
        $('#paging').append("<li class='page" + (y + 1) + "'><a class='page'>" + (y + 1) + "</a></li>");
      }
      $('#paging').append("<li><a class='lastpage'>&raquo;</a></li>");
    }
  };

  $(document).on('click', 'a.page', function () {
    ajaxLoader();
    page = $(this).html();
    getObject(page);
  });

  $(document).on('click', 'a.firstpage', function () {
    ajaxLoader();
    page = 1;
    getObject(page);
  });

  $(document).on('click', 'a.lastpage', function () {
    ajaxLoader();
    page = lastpage;
    getObject(page);
  });
  //End Function Write Paging

  //Function Clear Paging Class
  clearPagingClass = function (css, total, page)
  {
    for (var x = 0; x <= total; x++)
    {
      $(css + (x + 1)).removeClass("active");
    }
    $(css + page).addClass("active");
  };
  //End Function Clear Paging Class

  //User Action
  $('#btn_login_').click(function () {
    goLogin();
  });

  $('#btn_logout_').click(function () {
    goLogout();
  });

  $('.container').bind('keypress', function (e) {
    if (e.keyCode === 13) {
      goLogin();
    }
  });

  $('.form_filter').bind('keypress', function (e) {
    ajaxLoader();
    if (e.keyCode === 13) {
      e.preventDefault();
      getObject(page);
    }
  });
  //End User Action
});

