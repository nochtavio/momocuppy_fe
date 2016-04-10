<?php 
$dir = "../../";
require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/lib.php");
require_once($dir."lib/member/f_reg.php");


if(isset($_POST["submit"]) && trim($_POST["submit"])=="register"){
	$validate = true;
	
	//first name
	if(trim($_POST["firstname"]) == ""){
		$_SESSION["warning"]["firstname"] = "must be filled";
		$validate = false;
	}elseif(preg_match('/[^a-z_\-0-9]/i', $_POST["firstname"])){
		$_SESSION["warning"]["firstname"] = "invalid input";
		$validate = false;		
	}
	
	//last name	
	if(trim($_POST["lastname"]) == ""){
		$_SESSION["warning"]["lastname"] = "must be filled";
		$validate = false;
	}elseif(preg_match('/[^a-z_\-0-9]/i', $_POST["lastname"])){
		$_SESSION["warning"]["lastname"] = "invalid input";
		$validate = false;		
	}	
	
	
	//phone	
	if(trim($_POST["phone"]) == ""){
		$_SESSION["warning"]["phone"] = "must be filled";
		$validate = false;
	}elseif(!is_numeric($_POST["phone"])){
		$_SESSION["warning"]["phone"] = "invalid phone";
		$validate = false;		
	}
	
	//Email	
	$checkemail = "SELECT email FROM ms_member WHERE email = '".$db->escape($_POST["email"])."'";
	$rowcheck = $db->get_row($checkemail);
	if(trim($_POST["email"]) == ""){
		$_SESSION["warning"]["email"] = "must be filled";
		$validate = false;
	}elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
		$_SESSION["warning"]["email"] = "invalid email";		
		$validate = false;
	}elseif($rowcheck){
		$_SESSION["warning"]["email"] = "email already registered";		
		$validate = false;		
	}
	
	//Password
	if(trim($_POST["password"]) == ""){
		$_SESSION["warning"]["password"] = "must be filled";
		$validate = false;
	}elseif(preg_match('/[^a-z_\-0-9]/i', $_POST["password"])){
		$_SESSION["warning"]["password"] = "invalid format password";
		$validate = false;		
	}	
	
	//Confirm Password
	if(trim($_POST["cpassword"]) == ""){
		$_SESSION["warning"]["cpassword"] = "must be filled";
		$validate = false;
	}elseif(preg_match('/[^a-z_\-0-9]/i', $_POST["password"])){
		$_SESSION["warning"]["cpassword"] = "invalid format password";
		$validate = false;		
	}elseif($_POST["cpassword"] != $_POST["password"]){
		$_SESSION["warning"]["cpassword"] = "password not match";
		$validate = false;				
	}
	
	//dob
	if(trim($_POST["dob"]) == ""){
		$_SESSION["warning"]["dob"] = "must be filled";
		$validate = false;
	}	
	
	//streetname
	if(trim($_POST["streetname"]) == ""){
		$_SESSION["warning"]["streetname"] = "must be filled";
		$validate = false;
	}	
	
	//postal code
	if(trim($_POST["postalcode"]) == ""){
		$_SESSION["warning"]["postalcode"] = "must be filled";
		$validate = false;
	}elseif(!is_numeric($_POST["postalcode"])){
		$_SESSION["warning"]["postalcode"] = "invalid postal code";
		$validate = false;		
	}
	
	//country
	if(trim($_POST["country"]) == ""){
		$_SESSION["warning"]["country"] = "must be filled";
		$validate = false;
	}	
	
	//city
	if(trim($_POST["city"]) == ""){
		$_SESSION["warning"]["city"] = "must be filled";
		$validate = false;
	}			

	
		
	
	if($validate == false){
		
		$_SESSION["inputdata"]["firstname"] = $_POST["firstname"];
		$_SESSION["inputdata"]["lastname"] = $_POST["lastname"];
		$_SESSION["inputdata"]["phone"] = $_POST["phone"];
		$_SESSION["inputdata"]["email"] = $_POST["email"];				
		$_SESSION["inputdata"]["password"] = $_POST["password"];
		$_SESSION["inputdata"]["cpassword"] = $_POST["cpassword"];											
		$_SESSION["inputdata"]["dob"] = $_POST["dob"];						
		$_SESSION["inputdata"]["streetname"] = $_POST["streetname"];						
		$_SESSION["inputdata"]["postalcode"] = $_POST["postalcode"];					
		$_SESSION["inputdata"]["country"] = $_POST["country"];									
		$_SESSION["inputdata"]["city"] = $_POST["city"];											
		
								
		header("location:.#maincontent");
		exit;
	}else{
					
		$register = regacc(trim($_POST["firstname"]),trim($_POST["lastname"]),trim($_POST["phone"]),trim($_POST["email"]),trim($_POST["password"]),trim($_POST["dob"]),trim($_POST["streetname"]),trim($_POST["postalcode"]),trim($_POST["country"]),trim($_POST["city"]));	
		if($register == true){
			header("location:.?result=true#maincontent");
		}else{
			header("location:.?result=false#maincontent");		
		}
		exit;
	}
}
?>