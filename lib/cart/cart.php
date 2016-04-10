<?php 
function count_cart($email){
	global $db;
	
	$memberid = $db->get_row("SELECT id FROM ms_member WHERE email = '".$db->escape($email)."'");
	if($memberid){
		$memberid_cart = $memberid->id;
	}else{
		$memberid_cart = 0;
	}	
	
	$strsql = "	
	SELECT IFNULL(SUM(cart.qty),0) as jumlah FROM ms_cart cart 
	LEFT JOIN dt_product dt on dt.id = cart.id_dt_product
	WHERE cart.id_member = ".$db->escape($memberid_cart)."
	";
	$row = $db->get_row($strsql);
	if($row){
		return $row->jumlah;
	}else{
		return 0;
	}
}
?>