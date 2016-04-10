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
      <div class="wrapaddressbox">
        <h2>shipping address</h2>
        
        <div class="box_address">
          <h3>angeline kristiali</h3>          
          <span class="address_detail">
            Kavling polri Blok A 10 no.257, Jelambar <br> Jakarta 11460 <br> Indonesia
          </span>
          <span class="phone_number">08123456789</span>
          <a href="#" class="btnedit">edit</a>
        </div>
        
        <div class="wrapaddnewaddr">
          <a href="#" class="newaddr">
            <span>add new address</span>
          </a>
        </div>
        
        <div class="selboxaddr">
          <span>Choose a delivery address :</span>
          <div class="select-style">
            <select>
              <option value="volvo">Volvo</option>
              <option value="saab">Saab</option>
              <option value="mercedes">Mercedes</option>
              <option value="audi">Audi</option>
            </select>
          </div>
        </div>
        
        <ul class="order_rules">
          <li><span>It is not possible to ship items to an alternative address once items have been dispatched.</span></li>        
          <li><span>You will received an airway bill number to enable you to track your delivery status at www.jne.co.id.</span></li>
          <li><span>Your order will be delivered within 1-3 working days after payment (not including public holiday).</span></li>          
        </ul>
      
      	<div class="wrapbtnredeem">
        	<a href="#"><img src="/images/layout/redeem/redeemok.png" /></a>
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