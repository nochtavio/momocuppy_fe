<?php 
$dir = "../";
$body = "comingsoon";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/lib.php");



?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon.png">
<title>Momocuppy</title>

<!--STYLE-->
<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
<link href="/assets/css/main.css" rel="stylesheet">
<link href="/assets/css/comingsoon.css" rel="stylesheet">


</head>
<body id="<?php echo $body;?>">

<!--CONTAINER-->
<div id="container">
	<!--TOPCONTENT-->
  <div id="topcontent">  
    <div id="wrapnav">
	 		<!--MAINMENU-->	  
      <div class="wraplogocs">  
      <img src="/images/layout/coming-soon/logo.png"  />
      </div>
	 		<!--MAINMENU-->        
    </div>    
  </div>
  <!--TOPCONTENT-->    
<!--MAINCONTENT-->
<div id="maincontent">
	<div id="wrapcs">
  	<div class="content">
			<h3 class="title_ready">Be ready, we are launching soon !</h3>
      <h5 class="infocs">
      	Be notified and you'll be one of the first to know <br /> when the site is ready
      </h5>
      
      <div id="wrapsubscribe">
        <form id="subscribe" name="subscribe" method="post">
          <input class="txt" type="text" name="email_subscribe" placeholder="email address"/>
          <input class="submit" type="image" src="/images/layout/coming-soon/btnsubscribe.png" />
        </form>
      </div>
      
    </div>  
  </div>
</div>
<!--MAINCONTENT-->  
 <!--FOOTER-->

  <div id="footer"></div>

  <!--FOOTER-->  

</div>

<!--CONTAINER-->

<script type="text/javascript" src="/assets/js/fontsmoothie.min.js" async></script>
<script type="text/javascript" src="/assets/js/jquery.min.js" ></script>





</body>

</html>