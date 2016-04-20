<?php 

function get_wishlist($memberid, $rowspage, $p){

	$data = false;

	global $db;

			

	if(!isset($rowspage) || !is_numeric($rowspage)){

		$rowspage = 9;

	}

	

	if(!isset($page) || !is_numeric($page)){

		$page = 1;

	}	

	

	$rsfirst = $rowspage*($page-1);

		

	$strsql = "

		SELECT SQL_CALC_FOUND_ROWS wl.id,wl.id_product, mp.product_price, mp.product_name FROM ms_wishlist wl 

		LEFT JOIN ms_product mp ON mp.id = wl.id_product	

		WHERE wl.id_member = '".$db->escape($memberid)."'
		ORDER BY wl.id DESC

		LIMIT ".$db->escape($rsfirst).",	".$db->escape($rowspage)."		

	";

	$result = $db->get_results($strsql);

	

	$maxpage = 0;

	$found = $db->get_row("SELECT FOUND_ROWS() as maxpg");	

	if($found){

		$allrows = $found->maxpg;	

		$maxPage = ceil($allrows/$rowspage);				

	}

	

		

	if($result){	

		$data = array();

		$data["maxPage"] = $maxPage;

		$data["result"] = $result;

	}	

	return $data;

	

}



function remove_wishlist($memberid,$wishlistid){

	global $db;

	

	$strsql = "

		DELETE FROM ms_wishlist WHERE id_member = ".$db->escape($memberid)." AND id = ".$db->escape($wishlistid)."

	";



	$st = $db->query($strsql);

	if($st){

		return $st;

	}else{

		return false;

	}

	

}



function get_product_type($idproduct){

	global $db;

	

	

	$strsql = "

		SELECT mscat.type FROM ms_category mscat

		LEFT JOIN dt_category dc ON dc.id_category = mscat.id

		WHERE dc.id_product = ".$db->escape($idproduct)."

		GROUP BY mscat.type	

	";

	$row = $db->get_row($strsql);

	if($row){

		return $row->type;

	}else{

		return false;

	}

}

?>