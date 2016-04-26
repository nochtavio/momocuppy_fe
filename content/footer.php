  <!--FOOTER-->
  <div id="footer"></div>
  <!--FOOTER-->  
</div>
<!--CONTAINER-->

<script type="text/javascript" src="/assets/js/fontsmoothie.min.js" async></script>
<script type="text/javascript" src="/assets/js/jquery.min.js" ></script>
<script type="text/javascript" src="/assets/js/mfp.js" ></script>
<script type="text/javascript" src="/assets/js/bflogin.js" ></script>
<script type="text/javascript" src="/assets/js/mfp-message.js" ></script>
<script type="text/javascript">
  var base_url = "http://www.momocuppy.fe/mmcp/";
  var cur_url = "<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>";
  var format_number = function (num) {
    if (typeof (num) != 'string')
      num = num.toString();
    var reg = new RegExp('([0-9]+)([0-9]{3})');
    while (reg.test(num))
      num = num.replace(reg, '$1.$2');
    return num;
  };
  
  //Search
  var ajax_request;
  var total_search = 0;
  
  $("#txt_search").on("input", function() {
    if($("#txt_search").val().length > 2){
      if(typeof ajax_request !== 'undefined'){
        $('#searchlist').empty();
        ajax_request.abort();
      }
      ajax_request = $.ajax({
        url: base_url + 'api/get_object_search',
        type: 'POST',
        data:
          {
            keyword: $("#txt_search").val()
          },
        dataType: 'json',
        beforeSend : function (){
          $('#searchlist').empty();
          $('#div-hidden-search').empty();
        },
        success: function (result) {
          total_search = 0;
          if (result['result'] === 's') {
            $.each(result['content'], function (key, value) {
              var img = '/mmcp/images/products/' + value['img'];
              if(value['img'] == null){
                img = "/images/products/no-img-potrait.jpg";
              }
              $('#searchlist').append("\
                <li>\
                  <a href='/products/detail/?type="+value['type']+"&id_product="+value['id']+"'>\
                          <span class='img' style='width: 80px; height: 80px; position: relative;'><img id='search_img_" + value['id'] + "' src='" + img + "'/></span>\
                    <div class='desc'>\
                          <span class='itemname'>" + value['product_name'] + "</span>\
                      <span class='itemprice'>IDR " + format_number(value['product_price']) + "</span>\
                    </div>\
                  </a>\
                </li>\
              ");
              $('#div-hidden-search').append("\
                <input type='hidden' id='objectsearch" + total_search + "' value='" + value['id'] + "' />\
              ");
              total_search++;
            });
            set_search_resolution();
            $('#searchresult').show();
          } else {
            $('#searchresult').hide();
          }
        }
      });
    }else{
      $('#searchresult').hide();
    }
  });
  //End Search
  
  $(document).click(function() {
    if($("#searchresult").is(':visible')){
      total_search = 0;
      $('#div-hidden-search').empty();
      $('#searchresult').hide();
    }
  });
  
  var set_search_resolution = function(){
    var id = [];
    for (var x = 0; x < total_search; x++)
    {
      id[x] = $('#objectsearch' + x).val();
    }
    var temp_height = 0;
    var temp_width = 0;
    $.each(id, function (x, val) {
      setTimeout(function(){
        //Check Image Resolution
        temp_height = $('#search_img_'+val).height();
        temp_width = $('#search_img_'+val).width();
        if(temp_width <= temp_height){
          $('#search_img_'+val).addClass("img-portrait");
        }else{
          $('#search_img_'+val).addClass("img-landscape");
        }
        //End Check Image Resolution
      }, 250);
    });
  };
</script>

<?php 
//js
$varjs = strtok($js,",");
while($varjs) {
  echo "<script type=\"text/javascript\" src=\"/assets/js/".$varjs.".js\"></script>\n";
  $varjs = strtok(",");
}
//end js	
?>
</body>
</html>