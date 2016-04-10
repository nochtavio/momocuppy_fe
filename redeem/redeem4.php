<?php 
$body = "redeem";
$dir = "../";
$css = "main,simplebar,redeem";
$js = "simplebar";
require_once($dir."content/header.php");
?>  
  
<!--MAINCONTENT-->
<div id="maincontent">
	<div id="wrapredeem">
  	<div class="content">
      <!--START NAVPAGE-->
      <div class="navpage">
        <span>Home</span>
        <span class="sep">|</span>
        <span>Redeem</span>             
      </div>
      <!--END NAVPAGE-->    

      <!--start redeemcontent-->	
      <div class="order_result">
      	<img src="/images/layout/order/thanks.png"  class="bannerthx"/>
        <h3 class="thanksheader">Your order has been successfully placed!</h3>
        <div class="final_summary">
        	<span class="sum_title">order id</span>
        	<span class="sum_data">987654321</span>                  	 
        </div>
        <div class="row">
          <p>Thank you for redeem this item, <br />your redemption will be processed in our system.</p>
        	<a href="#" class="btnprint"><img src="/images/layout/order/btnprint.png" /></a>
        </div>
      </div>
      <!--end redeemcontent-->	      
      
      
          
    </div>  	
  </div>
</div>
<!--MAINCONTENT-->  
  
<?php 
require_once($dir."content/footer.php");
?>