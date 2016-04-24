<!DOCTYPE html>
<?php
if (!$this->session->userdata('admin')) {
  header('Location: ' . base_url());
}
if (!isset($id_newsletter)) {
  header('Location: ' . base_url());
}
?>
<html lang="en">
  <title>Momocuppy Newsletter Engine</title>
  <body>
    <h1>Momocuppy Newsletter Engine</h1>
    <h3>List of subscribers (<span id="total_subscribers">0</span>)</h3>
    <input type="hidden" id="id_newsletter" name="id_newsletter" value="<?php echo $id_newsletter; ?>" />
    
    <div id="email_container">
<!--      <p>anochtavio@gmail.com - <strong style="color:green;">DONE</strong></p>-->
    </div>
    
    <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/jquery-1.11.0.min.js'; ?>"></script>
    <script>
      var base_url = "http://www.momocuppy.com/mmcp/";
      
      $(document).ready(function(){
        $.ajax({
          url: base_url + 'dashboard/newsletter/get_subscriber',
          type: 'POST',
          data:
            {
              
            },
          dataType: 'json',
          beforeSend : function (){
            $('#email_container').append("\
              <strong style='color:blue;'>Loading . . .</strong></p>\
            ");
          },
          success: function (result) {
            $('#email_container').empty();
            if (result['result'] === 's')
            {
              var id = $('#id_newsletter').val();
              var promises = [];
              var index = 1;
              $('#total_subscribers').html(result['content'].length);
              $.each(result['content'], function (key, value) {
                var request=  $.ajax({
                  url: base_url + 'dashboard/newsletter/send_newsletter_',
                    type: 'POST',
                    data:
                      {
                        id: id,
                        email: value
                      },
                    dataType: 'json',
                    success: function (result) {
                      if (result['result'] === 's')
                      {
                        $('#email_container').append("\
                          <p>" + value + " - <strong style='color:green;'>DONE</strong></p>\
                        ");
                      }
                      else
                      {
                        alert("Error in connection. Please refresh");
                      }
                    }
                });
                promises.push( request);
              });
              
              $.when.apply(null, promises).done(function(){
                $('#email_container').append("\
                  <p><strong style='color:red;'>Successfully send newsletter to all subscribers!</strong></p>\
                ");
              });
            }
            else
            {
              $('#email_container').append("\
                <p><strong style='color:red;'>All subscribers already receive newsletter today.</strong></p>\
              ");
            }
          }
        });
      });
    </script>
  </body>
</html>