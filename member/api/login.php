<?php 
$dir = "../../";
require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/lib.php");

//login API
if(isset($_POST["ajax_usn"]) && isset($_POST["ajax_pwd"])){
	$email = trim($_POST["ajax_usn"]);
	$password = trim($_POST["ajax_pwd"]);	
		
	$result = 0;
	
	$login = "SELECT email FROM ms_member WHERE email = '".$db->escape($email)."' AND password = '".sha1($password)."'";
	$resultlogin = $db->get_row($login);
	if($resultlogin){
		$result = 1;
		$_SESSION["authlogin"] = $resultlogin->email;
	}

	
	$data = array(
		'result' => $result
	);	
	
	echo json_encode($data);	
}
?>
