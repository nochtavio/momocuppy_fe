<?php
$dir = "../../../../";
$css = "main,simplebar,member";
$js = "simplebar";
$body = "member";

require_once($dir . "core/conn/config.php");
require_once($dir . "core/conn/db.php");
require_once($dir . "lib/member/member.php");

$email = isset($_GET['email']) ? $_GET['email'] : "" ;
$hash = isset($_GET['hash']) ? $_GET['hash'] : "" ;

if($email == "" || $hash == ""){
  header("Location: /about-us/");
	exit;
}else{
  $activate_member = activate_member($email, $hash);
  if(!$activate_member){
    header("Location: /about-us/");
    exit;
  }
}

require_once($dir . "content/header.php");
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
        <span class="sep">|</span>
        <span>Activate Account</span>
        <span class="sep">|</span>
        <span>Success</span>        
      </div>
      <!--END NAVPAGE-->    


      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="wrapregister">
          <h5><img src="/images/layout/icons/success.png" width="20" style="margin-top:-5px;"/> Account Activated</h5>                              

          <!--start personal_detail-->
          <p class="successreg">
          	Thank you! <br /><br />Your account has been <strong>confirmed</strong>.
            <br />
            You can now order our product with your new activated account easily!         
          	<div class="wrapbtnact">
              <a id="btn_activate_login" href="#" class="btnresend">
              	<span>Login</span>
              </a>
              
            	<a href="/" class="btnback">
              	<span>Home</span>
              </a>              
            </div>
          </p>            
          <!--end change pass-->


        </div>        
      </div>
      <!--end summary_detail-->                
    </div>  	
  </div>
</div>
<!--MAINCONTENT-->  

<?php
require_once($dir . "content/footer.php");
?>