<?php 

require_once($dir."lib/domain_check.php");

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

<link href="/assets/css/animate.css" rel="stylesheet">

<link href="/assets/css/mfp.css" rel="stylesheet">



<?php 

//start css	

$arrcss = strtok($css,",");

while($arrcss) {

	echo "<link rel=\"stylesheet\" href=\"/assets/css/".$arrcss.".css\" type=\"text/css\" media=\"screen\" />\n";

	$arrcss = strtok(",");

}

//end css

?>









</head>

<body id="<?php echo $body;?>">



<!--CONTAINER-->

<div id="container">

	<!--TOPCONTENT-->

  <div id="topcontent">  

    <div id="wrapnav">

	 		<!--MAINMENU-->	    

      <?php 

			require_once("mainmenu.php");

			require_once($dir."member/ticker-login.php");

			?>   

	 		<!--MAINMENU-->        

    </div>    

    <?php 

		require_once($dir."member/pop-login.php");

		?>    

  </div>

  <!--TOPCONTENT-->  