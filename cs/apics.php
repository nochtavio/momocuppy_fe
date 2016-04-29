<?php 
$dir = "../";
$body = "comingsoon";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/lib.php");

function isValidEmail($email){ 
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}


//check already subscriber / not
$strsql = "SELECT id FROM ms_subscriber WHERE email LIKE '".$_POST["email"]."'";
$row = $db->get_row($strsql);
$subscribed = false;
if($row){
	$subscribed = true;
}


if(!isset($_POST["email"]) || $_POST["email"]==""){
	$rs = array(
			"result"  => "f",
			"message"  => "Please input your email address"
	);	
	echo json_encode($rs);	
	exit;
}elseif(!isValidEmail(trim($_POST["email"]))){
	$rs = array(
			"result"  => "f",
			"message"  => "Please input email address with the right format"
	);	
	echo json_encode($rs);	
	exit;	
}elseif($subscribed == true){
	$rs = array(
			"result"  => "f",
			"message"  => "Your email already subscribed to www.momocuppy.com"
	);	
	echo json_encode($rs);	
	exit;		
}else{
	
	$id = get_newid("ms_subscriber","id");
	//insert
	$strsql = "INSERT INTO ms_subscriber(id,email,active,cretime,creby) VALUES (
		".$db->escape($id).",
		'".$db->escape(trim($_POST["email"]))."',		
		1,				
		NOW(),
		'SYSTEM'
	)";
	
	$exec = $db->query($strsql);
	if($exec){
		$rs = array(
			"result"  => "t",
			"message"  => "Thank you! Be notified and you'll be one of the first to know 
when the site is ready"
		);				
	}else{
		$rs = array(
			"result"  => "f",
			"message"  => "Something goes wrong, please try again later"
		);		
	}
	
	echo json_encode($rs);
}
?>