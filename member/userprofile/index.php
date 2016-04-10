<?php 
$body = "member";
$dir = "../../";
$css = "main,simplebar,userprofile,datepicker";
$js = "simplebar,datepicker,userprofile";

$halmember = "profile";
require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/member/member.php");
require_once($dir."member/chkuserlogin.php");

$idmember = get_memberid($email);
if($idmember=="" || !is_numeric($idmember)){
	header("Location: /about-us/");
	exit;
}

//update pwd
if(isset($_POST["updatedatapwd"])){
  $oldpwd = isset($_POST["oldpwd"]) ? $_POST["oldpwd"] : "";
  $newpwd = isset($_POST["newpwd"]) ? $_POST["newpwd"] : "";				
  $confirmpwd = isset($_POST["confirmpwd"]) ? $_POST["confirmpwd"] : "";				

  //update pwd
  $st = change_memberwpd($idmember,$oldpwd,$newpwd,$confirmpwd);																	
  if($st == 1){
    $_SESSION["msgpwd"] = "Your password has beed updated!";
    $_SESSION["warnclass"] = "";
  }elseif($st == 2){
    $_SESSION["msgpwd"] = "Your current password is incorrect";								
    $_SESSION["warnclass"] = "warningdata";																
  }elseif($st == 3){
    $_SESSION["msgpwd"] = "Please confirm your new password";								
    $_SESSION["warnclass"] = "warningdata";								
  }
  header("location:.#maincontent");
  exit;
}

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
        <span class="sep">|</span>
        <span>Profile</span>                        
      </div>
      <!--END NAVPAGE-->    
      
     <h3 id="summary">Hi <?php echo get_membername($idmember);?>,</h3>
      
      <?php require_once("submenu.php");?>
      
      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="shoppingbag">
        	<h5>edit profile</h5>                              
          
          <!--start personal_detail-->
          <div id="personal_detail">
          
          	<?php 
						$memberdata = get_memberdata($idmember);
						

						
						if($memberdata){
							$email = $memberdata->email;
							$fisrtname = $memberdata->firstname;
							$lastname = $memberdata->lastname;		
							$phone = $memberdata->phone;		
							$dob = date("Y-m-d",strtotime($memberdata->dob));		
						}
						
						
						
						//post result
						if(isset($_POST["updatedata"])){
							$valid = true;							
							
							//firstname
							if(isset($_POST["firstname"]) && $_POST["firstname"]!=""){
								$firstname = trim($_POST["firstname"]);
							}else{
								$valid = false;
								//$_SESSION["warning"]["firstname"] = "warning";
							}
							
							//lastname
							if(isset($_POST["lastname"]) && $_POST["lastname"]!=""){
								$lastname = trim($_POST["lastname"]);
							}else{
								$valid = false;
								//$_SESSION["warning"]["lastname"] = "warning";
							}				
							
							//phone
							if(isset($_POST["phone"]) && $_POST["phone"]!="" && is_numeric($_POST["phone"])){
								$phone = trim($_POST["phone"]);
							}else{
								$valid = false;
								//$_SESSION["warning"]["phone"] = "warning";
							}				
							
							//dob
							if(isset($_POST["dob"]) && $_POST["dob"]!=""){
								$dob = trim($_POST["dob"]);
							}else{
								$valid = false;
								//$_SESSION["warning"]["dob"] = "warning";
							}															
							
							
							if($valid == true){
								$st = update_memberdata($idmember,$email,$firstname,$lastname,$phone,$dob);
								if($st){
									$_SESSION["updatemsg"]["success"] = "Your profile has been updated!";
									header("location:.#maincontent");
									exit;
								}else{
									$_SESSION["updatemsg"]["failupdate"] = "Oops, something wrong. Please try again";
									header("location:.#maincontent");
									exit;									
								}
							}else{
								$_SESSION["updatemsg"]["failupdate"] = "Oops, something wrong. Please check your data";
								header("location:.#maincontent");
								exit;								
							}
										
						}
						//end post result
						
						
						
						if(isset($_SESSION["updatemsg"])){
							if(isset($_SESSION["updatemsg"]["success"])){
								echo "
								<div class=\"warnmsg\">
									<span>".$_SESSION["updatemsg"]["success"]."</span>
								</div>																
								";
							}else{
								echo "
								<div class=\"warnmsg warningdata\">
									<span>".$_SESSION["updatemsg"]["failupdate"]."</span>
								</div>																
								";							
							}
							unset($_SESSION["updatemsg"]);
						}
						?>

          	<form name="personal" method="post" action="." class="personal">
            	<h3 class="titleprofile">Personal Details</h3>
              
              <div class="row">
              	<label for="email">Email</label>
								<span><?php echo $email;?></span>	
                <input type="hidden" name="updatedata" value="update" />
              </div>                            
              
              <div class="row">
              	<label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" autocomplete="off" value="<?php echo $fisrtname;?>"/>
                
              	<label class="labellastname" for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" autocomplete="off" value="<?php echo $lastname;?>"/>                
              </div>
              
              <div class="row">
              	<label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" value="<?php echo $phone;?>"/>
              </div>              
              
              <div class="row">
              	<label for="dob">Date of Birth</label>
                <input type="text" name="dob" id="dob" class="datepicker" value="<?php echo $dob;?>"/>
              </div> 
              
              <div class="row">
              	<label for="points">Recent points</label>
								<span><?php echo get_memberpoint($idmember);?></span>	
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
          
         		<?php
						if(isset($_SESSION["msgpwd"])){
							echo "
								<div class=\"warnmsg ".$_SESSION["warnclass"]."\">
									<span>".$_SESSION["msgpwd"]."</span>
								</div> 							
							";
							unset($_SESSION["msgpwd"]);
							unset($_SESSION["warnclass"]);
						}
						?>                        
                    
          	<form name="personal" method="post" action="." class="personal">
            	<h3 class="titleprofile">Change Password</h3>
              
              <div class="row">
              	<label for="oldpwd">Old Password</label>
                <input type="hidden" name="updatedatapwd" value="updatepwd" />                
                <input type="password" name="oldpwd" id="oldpwd" />
              </div>                                          
              
              <div class="row">
              	<label for="chpassword">New Password</label>
                <input type="password" name="newpwd" id="chpassword" autocomplete="off" />
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