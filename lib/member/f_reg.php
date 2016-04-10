<?php 
$dir = "../../";
require_once($dir . "core/conn/db.php");

function regacc($fname,$lname,$phone,$email,$pwd,$dob,$streetname,$postalcode,$country,$city){
	global $db;
	
	if(isset($fname) && isset($lname) && isset($phone) && isset($email) && isset($pwd) && isset($dob) && isset($streetname) && isset($postalcode) && isset($country) && isset($city)){
		$id = get_newid("ms_member","id");
		$strsql = "
			INSERT INTO ms_member(id,password,firstname,lastname,phone,email,hash,referral,active,cretime,creby) 
			VALUES
			(
				".$db->escape($id).",
				'".$db->escape(sha1($pwd))."',						
				'".$db->escape($fname)."',				
				'".$db->escape($lname)."',												
				'".$db->escape($phone)."',								
				'".$db->escape($email)."',												
				'abc',
				'',
				0,
				NOW(),								
				'".$db->escape($email)."'					
			)
		";

		$register = $db->query($strsql);
		if($register){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}	
}

?>