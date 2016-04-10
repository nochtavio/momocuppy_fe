<?php 
$body = "member";
$dir = "../";
$css = "main,simplebar,member,popaddress";
$js = "simplebar,popaddress";
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
        	<li><a href="#"><span>my wishlist</span></a></li>                    
        	<li><a class="selected"  href="#"><span>address book</span></a></li>                    
        	<li><a href="#"><span>log out</span></a></li>                                        
        </ul>
      </div>
      
      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="shoppingbag">
        	<h5>address book</h5>                              
          
          <ul class="addrbook simplebar">
          	<li>
            	<span class="addr_name">My Address</span>
            	<span class="name">Angeline Kristiali</span>            
              <span class="addr">
              	Kavling polri Blok A 10 no.257, Jelambar<br />
                Jakarta 12345<br />
                Indonesia
              </span>
              
							<span class="phone">08123456789</span>              
							<a href="/member/pop-address.php?act=update" class="editaddr popaddress">edit</a>
            </li>
            
          	<li class="noborder">
            	<span class="addr_name">My Address</span>
            	<span class="name">Angeline Kristiali</span>            
              <span class="addr">
              	Kavling polri Blok A 10 no.257, Jelambar<br />
                Jakarta 12345<br />
                Indonesia
              </span>
              
							<span class="phone">08123456789</span>              
							<a href="/member/pop-address.php?act=update" class="editaddr popaddress">edit</a>
            </li>
            
          	<li>
            	<span class="addr_name">My Address</span>
            	<span class="name">Angeline Kristiali</span>            
              <span class="addr">
              	Kavling polri Blok A 10 no.257, Jelambar<br />
                Jakarta 12345<br />
                Indonesia
              </span>
              
							<span class="phone">08123456789</span>              
							<a href="/member/pop-address.php?act=update" class="editaddr popaddress">edit</a>
            </li>      
            
            <li class="noborder">
            	<span class="addr_name">My Address</span>
            	<span class="name">Angeline Kristiali</span>            
              <span class="addr">
              	Kavling polri Blok A 10 no.257, Jelambar<br />
                Jakarta 12345<br />
                Indonesia
              </span>
              
							<span class="phone">08123456789</span>              
							<a href="/member/pop-address.php?act=update" class="editaddr popaddress">edit</a>
            </li>    
            
            <li>
            	<span class="addr_name">My Address</span>
            	<span class="name">Angeline Kristiali</span>            
              <span class="addr">
              	Kavling polri Blok A 10 no.257, Jelambar<br />
                Jakarta 12345<br />
                Indonesia
              </span>
              
							<span class="phone">08123456789</span>              
							<a href="/member/pop-address.php?act=update" class="editaddr popaddress">edit</a>
            </li>
            
            <li class="noborder">
            	<span class="addr_name">My Address</span>
            	<span class="name">Angeline Kristiali</span>            
              <span class="addr">
              	Kavling polri Blok A 10 no.257, Jelambar<br />
                Jakarta 12345<br />
                Indonesia
              </span>
              
							<span class="phone">08123456789</span>              
							<a href="/member/pop-address.php?act=update" class="editaddr popaddress">edit</a>
            </li>
            
            <li>
            	<span class="addr_name">My Address</span>
            	<span class="name">Angeline Kristiali</span>            
              <span class="addr">
              	Kavling polri Blok A 10 no.257, Jelambar<br />
                Jakarta 12345<br />
                Indonesia
              </span>
              
							<span class="phone">08123456789</span>              
							<a href="/member/pop-address.php?act=update" class="editaddr popaddress">edit</a>
            </li>
                          
          </ul>
					          
          <a href="/member/pop-address.php?act=new" class="newaddr popaddress">
            <span>add new address</span>
          </a>       
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