<?php 
$dir = "../";
$body = "about";
$css = "main,about,message";
$js = "mfp-confirm";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/get_about_contact.php");
require_once($dir."content/header.php");


?>  
  
<!--MAINCONTENT-->
<div id="maincontent">
	<div id="wrapabout">
  	<div class="content" style="min-height:600px;">
    	<h2 id="aboutinfo">
      	<img src="/images/aboutus/merrygo.gif" class="gif" />
      </h2>
      <p>
	      <a href="#mfp_message" id="message_popup">Click me</a>  
      </p>
    </div>  
  </div>
</div>

<div id="mfp_message" class="mfp-hide white-popup-block">
	<h2>
  	<img src="/images/layout/message/decor.png" />
  </h2>
  
  <h3 class="titlemsg">Oops..!</h3>
  
	<p class="message">
  	Are you sure you want to delete this item?    
  </p>
  
  <div class="wrapbtn">
    <div class="nobtn">
      <span>no</span>
    </div>
    
    <div class="yesbtn">
      <span>yes</span>
    </div>      
  </div>  
</div>
<!--MAINCONTENT-->  

 
<?php 
require_once($dir."content/footer.php");
?>