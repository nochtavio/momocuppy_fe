<?php 
$body = "member";
$dir = "../";
$css = "main,simplebar,userprofile,datepicker";
$js = "simplebar,datepicker";
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
        	<li><a class="selected" href="#"><span>profile</span></a></li>
        	<li><a href="#"><span>my wishlist</span></a></li>                    
        	<li><a href="#"><span>address book</span></a></li>                    
        	<li><a href="#"><span>log out</span></a></li>                                        
        </ul>
      </div>
      
      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="shoppingbag">
        	<h5>edit profile</h5>                              
          
          <!--start personal_detail-->
          <div id="personal_detail">
          	<form name="personal" method="post" action="." class="personal">
            	<h3 class="titleprofile">Personal Details</h3>
              
              <div class="row">
              	<label for="email">Email</label>
								<span>angelina@yahoo.com</span>	
              </div>                            
              
              <div class="row">
              	<label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" autocomplete="off" value="Efendy"/>
                
              	<label class="labellastname" for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" autocomplete="off" value="Salim"/>                
              </div>
              
              <div class="row">
              	<label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" value="08123456789"/>
              </div>              
              
              <div class="row">
              	<label for="dob">Date of Birth</label>
                <input type="text" name="dob" id="dob" class="datepicker"/>
              </div> 
              
              <div class="row">
              	<label for="points">Recent points</label>
								<span>999</span>	
              </div>                                          
              
              <div class="row">
              	<label>&nbsp;</label>
								<input class="submit2" type="image" src="/images/layout/member/btnsave.png" />
              </div>              
            </form>
          </div>
          <!--end personal_detail-->    
          
          <!--change pass--> 
					<div id="change_password">
          	<form name="personal" method="post" action="." class="personal">
            	<h3 class="titleprofile">Change Password</h3>
              
              <div class="row">
              	<label for="oldpwd">Old Password</label>
                <input type="password" name="oldpwd" id="oldpwd" />
              </div>                                          
              
              <div class="row">
              	<label for="chpassword">New Password</label>
                <input type="password" name="firstname" id="chpassword" autocomplete="off" />
              </div>  
              <div class="row">              
              	<label class="confirmpwd" for="confirmpwd">Confirm Password</label>
                <input type="password" name="confirmpwd" id="confirmpwd" autocomplete="off" />                
              </div>
              
                                 
              
              <div class="row">
              	<label>&nbsp;</label>
								<input class="submit2" type="image" src="/images/layout/member/btnsave.png" />
              </div>              
            </form>
          </div>               
          <!--end change pass-->
          
          
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