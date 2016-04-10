<?php 
$dir = "../";
$body = "about";
$css = "main,about";
$js = "";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/get_about_contact.php");
require_once($dir."content/header.php");


?>  
  
<!--MAINCONTENT-->
<div id="maincontent">
	<div id="wrapabout">
  	<div class="content">
    	<h2 id="aboutinfo">
      	<img src="/images/aboutus/merrygo.gif" class="gif" />
      </h2>
			<?php echo get_about_contact(2);?>      
    </div>  
  </div>
</div>
<!--MAINCONTENT-->  
  
<?php 
require_once($dir."content/footer.php");
?>