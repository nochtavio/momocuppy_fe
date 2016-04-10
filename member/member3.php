<?php 
$body = "member";
$dir = "../";
$css = "main,simplebar,member";
$js = "simplebar";
require_once($dir."content/header.php");
?>  

<!--MAINCONTENT-->
<div id="maincontent">
	<div id="wrapmember">
  	<div class="content">
      <!--START NAVPAGE-->
      <div class="navpage">
        <span>Home</span>
        <span class="sep">|</span>
        <span>My Account</span>               
      </div>
      <!--END NAVPAGE-->    
      
      <h3 id="summary">Hi Angel,</h3>
      
      <div class="submenuorder">
      	<ul class="order_menu">
        	<li><a href="#"><span>order history</span></a></li>
        	<li><a href="#"><span>profile</span></a></li>
        	<li><a class="selected"  href="#"><span>my wishlist</span></a></li>                    
        	<li><a href="#"><span>address book</span></a></li>                    
        	<li><a href="#"><span>log out</span></a></li>                                        
        </ul>
      </div>
      
      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="shoppingbag">
        	<h5>my wishlist</h5>                              
          
					<ul id="wishlist">
          	<li>
            	<img src="/images/redeem/cth/imgcth.jpg"  />
              <span class="wishlist_item">Circle Bird Cage</span>
              <span class="wishlist_price">IDR 90.000</span>              
              <a href="#" class="wishlist_cancel"><span>cancel</span></a>
            </li>
          	<li>
            	<img src="/images/redeem/cth/imgcth.jpg"  />
              <span class="wishlist_item">Circle Bird Cage</span>
              <span class="wishlist_price">IDR 90.000</span>              
              <a href="#" class="wishlist_cancel"><span>cancel</span></a>
            </li>
          	<li>
            	<img src="/images/redeem/cth/imgcth.jpg"  />
              <span class="wishlist_item">Circle Bird Cage</span>
              <span class="wishlist_price">IDR 90.000</span>              
              <a href="#" class="wishlist_cancel"><span>cancel</span></a>
            </li>                                    
          </ul>          
          <ul class="paging">
            <li><a href="#">« PREV |</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>                                        
            <li><a href="#">| NEXT »</a></li>          
          </ul>          
        </div>        
      </div>
      <!--end summary_detail-->                
    </div>  	
  </div>
</div>
<!--MAINCONTENT-->  
  
<?php 
require_once($dir."content/footer.php");
?>