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
  $("#txt_search").on("input", function() {
    if($("#txt_search").val().length > 3){
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
        },
        success: function (result) {
          if (result['result'] === 's') {
            $.each(result['content'], function (key, value) {
              var tipe = "Home Decor";
              if(value['type'] == "2"){
                tipe = "Accessories";
              }
              var img = '/mmcp/images/products/' + value['img'];
              if(value['img'] == null){
                img = "/images/products/no-img-potrait.jpg";
              }
              $('#searchlist').append("\
                <li>\
                  <a href='/products/detail/?type="+value['type']+"&id_product="+value['id']+"'>\
                          <span class='img'><img src='" + img + "' width='45' height='72'/></span>\
                    <div class='desc'>\
                          <span class='itemname'>" + value['product_name'] + "</span>\
                          <span class='itemcat'>Category : " + tipe + "</span>\
                      <span class='itemprice'>IDR " + format_number(value['product_price']) + "</span>\
                    </div>\
                  </a>\
                </li>\
              ");
            });
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