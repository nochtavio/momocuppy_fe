<?php 
$dir = "../../";
$css = "main,simplebar,member,datepicker";
$js = "simplebar,datepicker";
$body = "member";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."content/header.php");


/*warning validation*/

//firstname
if(isset($_SESSION["warning"]["firstname"]) && $_SESSION["warning"]["firstname"]!=""){
	$warningclass["firstname"] = "class=\"warning\"";	
	$msgwarning["firstname"] = "<span class=\"warningtext\">".$_SESSION["warning"]["firstname"]."</span>";
}else{
	$warningclass["firstname"] = "";
 	$msgwarning["firstname"]	= "";
}

//lastname
if(isset($_SESSION["warning"]["lastname"]) && $_SESSION["warning"]["lastname"]!=""){
	$warningclass["lastname"] = "class=\"warning\"";	
	$msgwarning["lastname"] = "<span class=\"warningtext\" style=\"left:102px;\">".$_SESSION["warning"]["lastname"]."</span>";
}else{
	$warningclass["lastname"] = "";
 	$msgwarning["lastname"]	= "";
}

//phone
if(isset($_SESSION["warning"]["phone"]) && $_SESSION["warning"]["phone"]!=""){
	$warningclass["phone"] = "class=\"warning\"";	
	$msgwarning["phone"] = "<span class=\"warningtext\">".$_SESSION["warning"]["phone"]."</span>";
}else{
	$warningclass["phone"] = "";
 	$msgwarning["phone"]	= "";
}

//email
if(isset($_SESSION["warning"]["email"]) && $_SESSION["warning"]["email"]!=""){
	$warningclass["email"] = "class=\"warning\"";	
	$msgwarning["email"] = "<span class=\"warningtext\">".$_SESSION["warning"]["email"]."</span>";
}else{
	$warningclass["email"] = "";
 	$msgwarning["email"]	= "";
}

//password
if(isset($_SESSION["warning"]["password"]) && $_SESSION["warning"]["password"]!=""){
	$warningclass["password"] = "class=\"warning\"";	
	$msgwarning["password"] = "<span class=\"warningtext\">".$_SESSION["warning"]["password"]."</span>";
}else{
	$warningclass["password"] = "";
 	$msgwarning["password"]	= "";
}

//confirm password
if(isset($_SESSION["warning"]["cpassword"]) && $_SESSION["warning"]["cpassword"]!=""){
	$warningclass["cpassword"] = "class=\"warning\"";	
	$msgwarning["cpassword"] = "<span class=\"warningtext\">".$_SESSION["warning"]["cpassword"]."</span>";
}else{
	$warningclass["cpassword"] = "";
 	$msgwarning["cpassword"]	= "";
}

//dob
if(isset($_SESSION["warning"]["dob"]) && $_SESSION["warning"]["dob"]!=""){
	$warningclass["dob"] = "warning";	
	$msgwarning["dob"] = "<span class=\"warningtext\">".$_SESSION["warning"]["dob"]."</span>";
}else{
	$warningclass["dob"] = "";
 	$msgwarning["dob"]	= "";
}

//streetname
if(isset($_SESSION["warning"]["streetname"]) && $_SESSION["warning"]["streetname"]!=""){
	$warningclass["streetname"] = "class=\"warning\"";	
	$msgwarning["streetname"] = "<span class=\"warningtext\">".$_SESSION["warning"]["streetname"]."</span>";
}else{
	$warningclass["streetname"] = "";
 	$msgwarning["streetname"]	= "";
}

//postalcode
if(isset($_SESSION["warning"]["postalcode"]) && $_SESSION["warning"]["postalcode"]!=""){
	$warningclass["postalcode"] = "class=\"warning\"";	
	$msgwarning["postalcode"] = "<span class=\"warningtext\">".$_SESSION["warning"]["postalcode"]."</span>";
}else{
	$warningclass["postalcode"] = "";
 	$msgwarning["postalcode"]	= "";
}

//country
if(isset($_SESSION["warning"]["country"]) && $_SESSION["warning"]["country"]!=""){
	$warningclass["country"] = "class=\"warning\"";	
	$msgwarning["country"] = "<span class=\"warningtext\">".$_SESSION["warning"]["country"]."</span>";
}else{
	$warningclass["country"] = "";
 	$msgwarning["country"]	= "";
}

//city
if(isset($_SESSION["warning"]["city"]) && $_SESSION["warning"]["city"]!=""){
	$warningclass["city"] = "class=\"warning\"";	
	$msgwarning["city"] = "<span class=\"warningtext\">".$_SESSION["warning"]["city"]."</span>";
}else{
	$warningclass["city"] = "";
 	$msgwarning["city"]	= "";
}


/*input session*/
(isset($_SESSION["inputdata"]["firstname"])) ? $firstname = $_SESSION["inputdata"]["firstname"] : $firstname = "";
(isset($_SESSION["inputdata"]["lastname"])) ? $lastname = $_SESSION["inputdata"]["lastname"] : $lastname = "";
(isset($_SESSION["inputdata"]["phone"])) ? $phone = $_SESSION["inputdata"]["phone"] : $phone = "";
(isset($_SESSION["inputdata"]["email"])) ? $email = $_SESSION["inputdata"]["email"] : $email = "";
(isset($_SESSION["inputdata"]["password"])) ? $password = $_SESSION["inputdata"]["password"] : $password = "";
(isset($_SESSION["inputdata"]["cpassword"])) ? $cpassword = $_SESSION["inputdata"]["cpassword"] : $cpassword = "";
(isset($_SESSION["inputdata"]["dob"])) ? $dob = $_SESSION["inputdata"]["dob"] : $dob = "";
(isset($_SESSION["inputdata"]["streetname"])) ? $streetname = $_SESSION["inputdata"]["streetname"] : $streetname = "";
(isset($_SESSION["inputdata"]["postalcode"])) ? $postalcode = $_SESSION["inputdata"]["postalcode"] : $postalcode = "";
(isset($_SESSION["inputdata"]["country"])) ? $country = $_SESSION["inputdata"]["country"] : $country = "";
(isset($_SESSION["inputdata"]["city"])) ? $city = $_SESSION["inputdata"]["city"] : $city = "";


?>  

<!--MAINCONTENT-->
<div id="maincontent">
	<div id="wrapmember">
  	<div class="content">
      <!--START NAVPAGE-->
      <div class="navpage">
        <a href="/about-us/"><span>Home</span></a>
        <span class="sep">|</span>
        <a href="/member/register/"><span>Register</span></a>               
      </div>
      <!--END NAVPAGE-->    
            
      
      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="wrapregister">
        	<h5>register</h5>                              
          
          <!--start personal_detail-->
          <form name="personal" method="post" action="regmember.php" class="personal">
            <div id="register">
              
              <h3 class="titleprofile">Personal Details</h3>                                      
              
              <div class="row50">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" autocomplete="off" <?php echo $warningclass["firstname"];?> value="<?php echo $firstname?>"/>
                <?php echo $msgwarning["firstname"];?>
              </div>
              
              <div class="row50">               
                <label class="labellastname" for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" autocomplete="off" <?php echo $warningclass["lastname"];?> value="<?php echo $lastname?>"/>         
                <?php echo $msgwarning["lastname"];?>                       
              </div>
              
              <div class="row">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" <?php echo $warningclass["phone"];?> value="<?php echo $phone?>"/>
                <?php echo $msgwarning["phone"];?>                  
              </div>              
              
              <div class="row">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" <?php echo $warningclass["email"];?> value="<?php echo $email?>"/>
                <?php echo $msgwarning["email"];?>                 
              </div>      
              
              
              <div class="row">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" <?php echo $warningclass["password"];?> value="<?php echo $password;?>"/>
              </div>                                     
              
              <div class="row">
                <label for="cpassword">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" <?php echo $warningclass["cpassword"];?> value="<?php echo $cpassword;?>"/>
                <?php echo $msgwarning["cpassword"];?>                 
              </div>                                                      
              
              <div class="row">
                <label for="dob">Date of Birth</label>
                <input type="text" name="dob" id="dob" class="datepicker <?php echo $warningclass["dob"];?>" <?php echo $warningclass["dob"];?> value="<?php echo $dob?>"/>
                <?php echo $msgwarning["dob"];?>                 
              </div>                 
            </div>
          	<!--end personal_detail-->    
          
          	<!--change pass--> 
						<div id="addrdetail">
            	<h3 class="titleprofile">Address Detail</h3>
              
              <div class="row">
              	<label for="streetname">Street Address</label>
                <input type="text" name="streetname" id="streetname" <?php echo $warningclass["streetname"];?> value="<?php echo $streetname?>"/>
                <?php echo $msgwarning["streetname"];?>                 
              </div> 
              
              <div class="row">
              	<label for="postalcode">Zip / Postal Code</label>
                <input type="text" name="postalcode" id="postalcode" <?php echo $warningclass["postalcode"];?> value="<?php echo $postalcode?>"/>
                <?php echo $msgwarning["postalcode"];?>                 
              </div>               

              <div class="row">
              	<label for="country">Country</label>
                <input type="text" name="country" id="country" <?php echo $warningclass["country"];?> value="<?php echo $country?>"/>
                <?php echo $msgwarning["country"];?>                 
              </div>      
              
              <div class="row">
              	<label for="city">City</label>
                <input type="text" name="city" id="city" <?php echo $warningclass["city"];?> value="<?php echo $city?>"/>
                <?php echo $msgwarning["city"];?>                 
              </div>                         
                                 
              
              <div class="row">
								<input class="register" name="submit" type="image" src="/images/layout/member/register.png" value="register" />
              </div>                         
	          </div>   
          </form>            
          <!--end change pass-->
          
          
        </div>        
      </div>
      <!--end summary_detail-->                
    </div>  	
  </div>
</div>
<!--MAINCONTENT-->  
  
<?php 

unset($_SESSION["warning"]);
unset($_SESSION["inputdata"]);
require_once($dir."content/footer.php");
?>