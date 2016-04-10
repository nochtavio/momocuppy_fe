<div id="wrapformlogin" class="mfp-hide white-popup-block">  
  <form name="login" id="formlogin" method="post">
    <h3>i am a registered customer</h3>
    <div class="row">
      <label for="mfp_email">Email Address</label>
      <input type="text" name="mfp_email" id="mfp_email" autocomplete="off" />
    </div>
    <div class="row row2">
      <label for="mfp_pwd">Password</label>
      <input type="password" name="mfp_pwd" id="mfp_pwd"  autocomplete="off" />
      <span id="forgotpwd">Forgot Password</span>
    </div>     
    <div class="row2">
      <input id="mfp_submit" type="image" class="mfp_submit" src="/images/layout/mainmenu/login/signin.png" />
    </div> 
    <div class="row2">
      <span class="extranote">* Make purchase faster using previously saved details</span>        
    </div>
    <div class="row2">
    	<span id="loading">Please wait a moment..</span>
      <span id="warning_login">&nbsp;</span>   
    </div>
  </form>  
  <div id="mfp_register">
    <h3>i am a new customer</h3>
    <a class="linkregis" href="/member/register/"><img src="/images/layout/mainmenu/login/register.png" /></a>
    <span class="extranote">* Your order confirmation email will be sent to this device</span>
  </div>
  
  
  <!--FORGOT PASSWORD-->
  <div id="wrapforgot" class="hide">
    <form id="forgotpass" method="post" action="." name="forgotpass">
      <h2>Forgot your password?</h2>
      <span>
        We will email your password.
        <br />
        Put your email here.
      </span>
      <span class="forgotloading" style="margin: 10px 0 -5px 0px;display: none;">Loading ...</span>
      <input type="text" id="txt_forgot_email" name="txt_forgot_email" placeholder="Your email"/>  
      
      <input class="submit" id="mfp_forgot_password" type="image" src="/images/layout/mainmenu/login/btnsendforgotpass.png"  />     	
    </form>
    <span class="closeforgot"><img src="/images/layout/mainmenu/login/closeforgot.png" /></span>
  </div>
  <!--FORGOT PASSWORD-->  
</div>