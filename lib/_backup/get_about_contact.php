<?php 
function get_about_contact($type){
	global $db;
	
	if(!isset($type) || !is_numeric($type) ){
		$type = 1;
	}
	
	$strsql = "
	SELECT content 
	FROM ms_contact_us 
	WHERE	type = ".$db->escape($type)."
	";
	
	$row = $db->get_row($strsql);
	if($row){
		return $row->content;
	}else{
		return "";
	}
}


?>
