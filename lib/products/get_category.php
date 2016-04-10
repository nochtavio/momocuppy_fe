<?php 

$dir = "../../";

require_once($dir."core/conn/db.php");



function get_category_list($type,$rowspage,$page){		

	global $db;

	$data = NULL;

		





	

	$rsfirst = $rowspage*($page-1);

	

	$strsql = "

		SELECT SQL_CALC_FOUND_ROWS id,category_name,img,img_hover

		FROM ms_category 

		WHERE visible = 1 AND type = ".$db->escape($type)."

		ORDER BY position ASC, cretime DESC	

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



?>