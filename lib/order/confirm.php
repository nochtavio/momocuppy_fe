<?php
function get_paymentlist(){
	global $db;
	
	$strsql = "
	SELECT 
		id,payment_name
	FROM ms_payment 
	WHERE visible = 1
	";
	$result = $db->get_results($strsql);
	if($result){
		return $result;
	}else{
		return false;
	}
}

function confirm_payment($orderid,$dop,$bankaccname,$amount){
	global $db;
	
	$checkorderid = "SELECT id FROM ms_order WHERE order_no = ".$db->escape(trim($orderid))." AND (status = 1 or status = 2)";
	$rscheck = $db->get_row($checkorderid);
	if($rscheck){
		$strupdate = "
			UPDATE ms_order SET paid_date = '".$db->escape($dop)."', paid_name = '".$db->escape($bankaccname)."', paid_nominal = ".$db->escape($amount).", status = 2 WHERE id = ".$db->escape($rscheck->id)."
		";
		$update = $db->query($strupdate);
		if($update){
			return 1;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
?>