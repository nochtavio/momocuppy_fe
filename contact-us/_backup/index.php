<?php 

$body = "contact";

$dir = "../";

$css = "main,contact";

$js = "";

require_once($dir."core/conn/db.php");

require_once($dir."lib/get_about_contact.php");

require_once($dir."content/header.php");



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

          

          <label for="verify" class="verify">Input (5 + 8)</label>

          <input name="verify" id="verify" type="text" />             

          

          <input class="submitmsg" type="image" src="/images/contactus/submitbtn.png"  />                      

        </form>

      </div>    

    </div>  	

  </div>

</div>

<!--MAINCONTENT-->  

  

<?php 

require_once($dir."content/footer.php");

?>