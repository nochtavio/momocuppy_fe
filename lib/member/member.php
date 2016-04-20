<?php 
//get memberid
function check_email($email){
  global $db;
  
  $check = $db->get_row("SELECT email FROM ms_member WHERE email = '".$db->escape($email)."' AND active = 0");
	if($check){
		return true;
	}else{
		return false;
	}
}

function activate_member($email, $hash){
  global $db;
  
  $check = $db->get_row("SELECT email FROM ms_member WHERE email = '".$db->escape($email)."' AND hash = '".$db->escape($hash)."' AND active = 0");
	if($check){
		$strsql = "
      UPDATE ms_member SET
        active = 1
      WHERE email = '".$db->escape($email)."'
    ";
    $st = $db->query($strsql);
    if($st){
      return true;
    }else{
      return false;
    }
	}else{
		return false;
	}
}
  
function get_memberid($email){
	global $db;
	
	$memberid = $db->get_row("SELECT id FROM ms_member WHERE email = '".$db->escape($email)."'");
	if($memberid){
		return $memberid->id;
	}else{
		return false;
	}
}

function get_membername($memberid){
	global $db;
	
	$name = $db->get_row("SELECT firstname FROM ms_member WHERE id = ".$db->escape($memberid)."");
	if($name){
		return $name->firstname;
	}else{
		return false;
	}	
}

function get_memberdata($memberid){
	global $db;
	
	$strsql = "
		SELECT 
			email,
			firstname,
			lastname,
			phone,
			dob
		FROM ms_member 
		WHERE id = ".$db->escape($memberid)."
		AND active = 1
		LIMIT 0,1		
	";
	$row = $db->get_row($strsql);
	if($row){
		return $row;		
	}else{
		return false;
	}
	
}

function update_memberdata($memberid,$email,$firstname,$lastname,$phone,$dob){
	global $db;
	
	$strsql = "
		UPDATE ms_member SET
			email = '".$db->escape($email)."',
			firstname = '".$db->escape($firstname)."',
			lastname = '".$db->escape($lastname)."',						
			phone = '".$db->escape($phone)."',
			dob = '".$db->escape($dob)."',
			modtime = NOW(),
			modby = '".$db->escape($email)."'
		WHERE id = ".$db->escape($memberid)."
	";
	$st = $db->query($strsql);
	if($st){
		return 1;
	}else{
		return 0;
	}
}

function get_memberpoint($memberid){
	global $db;
	
	$point = 0;
	$strsql = "
	SELECT point 
	FROM ms_point WHERE id_member = ".$db->escape($memberid)."
  AND cretime >= NOW() - INTERVAL 3 MONTH
	";
	$row = $db->get_row($strsql);
	if($row){
		$point = $row->point;
	}
	
	return $point;
}

function change_memberwpd($memberid,$oldpwd,$newpwd,$newpwdc){
	global $db;
	$key = "momocuppy123";
	$email = "SYSTEM";

	$result = 0;
	
	$chkpwd = $db->get_row("SELECT email, password as oldpwd FROM ms_member WHERE id = ".$db->escape($memberid)."");
	if($chkpwd){
		$currentpwd = $chkpwd->oldpwd;
		$email = $chkpwd->email;		
	}
	
	if($oldpwd=="" || sha1($key.$oldpwd) != $currentpwd){
		$result = 2; //current password salah
	}elseif($newpwd == "" || $newpwdc == "" || $newpwd != $newpwdc){
		$result = 3; //konfirmasi pwd salah
	}else{
		$updatepwd = "
			UPDATE ms_member SET 
			password = '".$db->escape(sha1($key.$newpwd))."',
			modtime = NOW(),
			modby = '".$db->escape($email)."'
			WHERE 
			id = ".$db->escape($memberid)."
		";
		$st = $db->query($updatepwd);
		if($st){
			$result = 1;
		}
	}
	
	return $result;
}


?>