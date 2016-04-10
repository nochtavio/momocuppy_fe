<?php 
$body = "member";
$dir = "../";
$css = "main,simplebar,member,datepicker";
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
        <span>Register</span>               
      </div>
      <!--END NAVPAGE-->    
            
      
      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="wrapregister">
        	<h5>register</h5>                              
          
          <!--start personal_detail-->
          <div id="register">
          	<form name="personal" method="post" action="." class="personal">
            	<h3 class="titleprofile">Personal Details</h3>                                      
              
              <div class="row">
              	<label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" autocomplete="off" />
                
              	<label class="labellastname" for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" autocomplete="off" />                
              </div>
              
              <div class="row">
              	<label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" />
              </div>              
              
              <div class="row">
              	<label for="email">Email</label>
                <input type="text" name="email" id="email" />
              </div>      
              
              
              <div class="row">
              	<label for="password">Password</label>
                <input type="password" name="password" id="password" />
              </div>                                     
              
              <div class="row">
              	<label for="cpassword">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" />
              </div>                                                      
              
              <div class="row">
              	<label for="dob">Date of Birth</label>
                <input type="text" name="dob" id="dob" class="datepicker"/>
              </div>                 
            </form>
          </div>
          <!--end personal_detail-->    
          
          <!--change pass--> 
					<div id="addrdetail">
          	<form name="personal" method="post" action="." class="personal">
            	<h3 class="titleprofile">Address Detail</h3>
              
              <div class="row">
              	<label for="streetname">Street Address</label>
                <input type="text" name="streetname" id="streetname" />
              </div> 
              
              <div class="row">
              	<label for="postalcode">Zip / Postal Code</label>
                <input type="text" name="postalcode" id="postalcode" />
              </div>               

              <div class="row">
              	<label for="country">Country</label>
                <input type="text" name="country" id="country" />
              </div>      
              
              <div class="row">
              	<label for="city">City</label>
                <input type="text" name="city" id="city" />
              </div>                         
                                 
              
              <div class="row">
								<input class="register" type="image" src="/images/layout/member/register.png" />
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