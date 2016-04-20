<ul id="mainmenu">
  <li id="home">
    <a href="/">
      <span>Home</span>
    </a>
  </li>
  <li class="separator"><span>&bull;</span></li>
  <li id="aboutus">
    <a href="/about-us/" <?php echo is_selected($body,"about","class=\"selected\"","");?>>
      <span>About us</span>
    </a>
  </li>  
  <li class="separator"><span>&bull;</span></li>
  <li id="products">
<!--    <a href="#" <?php echo is_selected($body,"product","class=\"selected\"","");?>>
      <span>Products</span>
    </a>-->
    <div <?php echo is_selected($body,"product","class=\"hoverparent selected\"","class=\"hoverparent\"");?>>
      <span>Products</span>
    </div>
    <ul class="submenu">
    	<?php 
			$rstype = get_producttype();
			foreach($rstype as $rowtype){
				echo "<li class=\"childmenu\"><a href=\"/products/category/?type=".$rowtype->id."\"><span>".$rowtype->type_name."</span></a></li>";
			}			
			?>
                      
    </ul>
  </li>
  <li id="logo">
    <a href="/" class="logolink" title="MomoCuppy"><img src="/images/layout/logo.png" /></a>
  </li>
  <li id="order">
    <a href="/order/" <?php echo is_selected($body,"order","class=\"selected\"","");?>>
      <span>Order</span>
    </a>
    <ul class="submenu submenuorder">
      <li class="childmenu"><a href="/order/"><span>Shopping Bag</span></a></li>
      <li class="childmenu"><a href="/order/confirm/"><span>Confirm Payment</span></a></li>
      <li class="childmenu last"><a href="/order/track/"><span>Tracking</span></a></li>                        
    </ul>          
  </li>  
  <li class="separator"><span>&bull;</span></li>    
  <li id="redemption">
    <a href="/redeem/" <?php echo is_selected($body,"redeem","class=\"selected\"","");?>>
      <span>Redemption</span>
    </a>
  </li>    
  <li class="separator"><span>&bull;</span></li>    
  <li id="contactus">
    <a href="/contact-us/" <?php echo is_selected($body,"contact","class=\"selected\"","");?>>
      <span>Contact Us</span>
    </a>
  </li>                      
</ul>