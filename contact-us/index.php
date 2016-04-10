<?php 

$body = "contact";

$dir = "../";

$css = "main,contact,message";

$js = "contact-us";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/get_about_contact.php");
require_once($dir."content/header.php");


//Generate Verify Number
generate_verify();
?>  

  

<!--MAINCONTENT-->

<div id="maincontent">

	<div id="wrapcontact">

  	<div class="content">

      <!--START NAVPAGE-->

      <div class="navpage">

        <span>Home</span>

        <span class="sep">|</span>

        <span>Contact Us</span>      

      </div>

      <!--END NAVPAGE-->    

      

      <div id="contactinfo">

				<?php echo get_about_contact(1);?>  

      </div>

      

      

      <div id="contactform">

      	<form name="#" action="#" method="post">

        	<h2>send us a message</h2>

          <label for="name">Name</label>

          <input name="name" id="name" type="text" />



          <label for="email">Email</label>

          <input name="email" id="email" type="text" />          



          <label for="subject">Subject</label>

          <input name="subject" id="subject" type="text" />    

          

          <label for="message">Message</label>

          <textarea name="message" id="message" rows="5"></textarea>      

          

          <label for="verify" class="verify">Input (<?php echo $_SESSION["no1"]."+".$_SESSION["no2"] ?>)</label>
          <input type="hidden" id="no1" value="<?php echo $_SESSION["no1"]; ?>" />
          <input type="hidden" id="no2" value="<?php echo $_SESSION["no2"]; ?>" />
          <input name="verify" id="verify" type="text" />             

          

          <input id="submitmsg" class="submitmsg" type="image" src="/images/contactus/send.png"  />                      

        </form>

      </div>    

    </div>  	

  </div>

</div>

<!--MAINCONTENT-->  

<div id="mfp_message" class="mfp-hide white-popup-block mfp-alert">
  <h2 class="pop-up-img-success">
      <img src="/images/layout/message/bunny.gif" />
  </h2>
  <h2 class="pop-up-img-failed">
    <img src="/images/layout/message/decor.png" />
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

require_once($dir."content/footer.php");

?>