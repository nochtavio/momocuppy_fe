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
      <div id="redeemcontent">
      	<h3>Redeem your points!</h3>
       	<div class="redeem_pic">
        	<img src="/images/redeem/cth/cth_detail.jpg" />
        </div>
        <div class="redeem_detail">
        	<span class="pointtitle">recent points</span>
          <span class="detail_point">87 Points</span>
          <span class="detail_name">Circle Bird Cage</span>
          <p class="detail_desc">Size : 25 x 30cm <br /> Material : Rattan</p>
          <span class="detail_cost">80 Points</span>
          <a href="#" class="detail_redeembtn"><span>redeem now</span></a>
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