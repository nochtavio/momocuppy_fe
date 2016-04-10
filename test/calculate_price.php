<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <input type="text" id="price" name="price" value="" placeholder="Harga di jual"  />
  <input type="text" id="weight" name="weight" value="" placeholder="Berat dalam gram"  />
  <input type="text" id="interest" name="interest" value="" placeholder="Keuntungan dalam %" />
  <br/><br/>
  <input type="button" value="Calculate" id="btn_calculate" />
  <input type="text" readonly="readonly" name="calculated_price" id="calculated_price" placeholder="Hasil" />
  <script type="text/javascript" src="/assets/js/jquery.min.js" ></script>
  <script>
    $(document).ready(function(){
      var base_url = "http://www.momocuppy.com/mmcp/";
      
      var set_price = function () {
        var price = $('#price').val();
        var weight = $('#weight').val();
        var interest = $('#interest').val();
        $.ajax({
          url: base_url + 'api/set_price',
          type: 'POST',
          data:
            {
              price:price,
              weight:weight,
              interest:interest
            },
          dataType: 'json',
          beforeSend : function (){
          },
          success: function (result) {
            $('#calculated_price').val(result['calculated_price']);
          }
        });
      };
      
      $('#btn_calculate').click(function(){
        set_price();
      });
    });
  </script>
</html>