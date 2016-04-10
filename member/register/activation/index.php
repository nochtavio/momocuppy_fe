<?php
$dir = "../../../";
$css = "main,simplebar,member,message";
$js = "simplebar,verification";
$body = "member";

require_once($dir . "core/conn/config.php");
require_once($dir . "core/conn/db.php");
require_once($dir . "lib/member/member.php");

$email = isset($_GET['email']) ? $_GET['email'] : "" ;

if($email == ""){
  header("Location: /about-us/");
	exit;
}else{
  $check_email = check_email($email);
  if(!$check_email){
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
      </div>
      <!--END NAVPAGE-->    


      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="wrapregister">
          <h5>Activate your account</h5>                              

          <!--start personal_detail-->
          <p class="successreg">Thank you for signing up at <strong>www.momocuppy.com</strong>! <br /><br />
          	A message with a confirmation link was sent to <strong><?php echo $email; ?></strong>. <br />Click on the link in the message to complete your registration.
          	<div class="wrapbtnact">
              <input type="hidden" name="resend_email" id="resend_email" value="<?php echo $email ?>" />
              <a id="btn_resend_verification" href="#" class="btnresend">
              	<span>Resend email</span>
              </a>
              
            	<a href="/" class="btnback">
              	<span>Back to shop</span>
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

<div id="mfp_message" class="mfp-hide white-popup-block mfp-alert">
  <h2>
      <img src="/images/layout/message/bunny.gif" />
  </h2>
  <h3 id="poptitle" class="titlemsg"></h3>
  <p id="popmessage" class="message"></p>
  <div class="wrapok">
      <div id="popok" class="okbtn">
          <span>ok</span>
      </div>      
  </div>  
</div>

<?php
require_once($dir . "content/footer.php");
?>