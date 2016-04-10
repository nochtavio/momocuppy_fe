<?php 
function get_products_list($type,$cat,$rowspage,$page){		
	global $db;
	$data = NULL;
	
	if(!isset($type) || !is_numeric($type)){
		$type = 1;
	}	
	
	if(!isset($cat) || !is_numeric($cat)){
		$cat = 1;
	}				
		
	if(!isset($rowspage) || !is_numeric($rowspage)){
		$rowspage = 10;
	}
	
	if(!isset($page) || !is_numeric($page)){
		$page = 1;
	}	
	
	$rsfirst = $rowspage*($page-1);
	
	$strsql = "
		SELECT mp.id,mp.product_name, mp.product_price, mp.visible,mp.cretime,img.img
		FROM ms_product mp 
		INNER JOIN dt_category dc ON mp.id = dc.id_product
		LEFT JOIN ms_category mc ON mc.id = dc.id_category
		LEFT JOIN (SELECT DISTINCT img,id_product FROM dt_product_img GROUP BY id_product ORDER BY cretime DESC) img ON img.id_product = dc.id_product		
		WHERE mp.visible = 1
		AND mc.type = ".$db->escape($type)."
		AND mc.id = ".$db->escape($cat)."
		ORDER BY mp.publish_date DESC
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


function get_product_detail($id){
	global $db;
	
	if(isset($id) && is_numeric($id)){
		$strsql = "
		SELECT product_name, product_price, product_desc
		FROM ms_product mp
		WHERE mp.visible = 1 AND
		id = ".$db->escape($id)."
		";
		$row = $db->get_row($strsql);
		if($row){
			return $row;
		}else{
			return false;
		}
	}else{
		return false;
	}
}


function get_product_gallery($id){
}


function get_product_color_list($id){
	global $db;
	
	if(isset($id) && is_numeric($id)){
		$strsql = "
		SELECT dp.id_product,mc.id, mc.color_name FROM dt_product dp
		LEFT JOIN ms_color mc ON mc.id = dp.id_color
		WHERE dp.id_product = 4 AND dp.visible = 1 AND mc.visible = 1 
		AND dp.id_product = ".$db->escape($id)."
		";
		$result = $db->get_results($strsql);
		if($result){
			return $result;
		}else{
			return false;
		}
	}else{
		return false;
	}	
}

function product_next_prev($idproduct){
	global $db;
	$rownext = NULL;
	$rowprev = NULL;
	
	//select category by idproduct next
	$strsqlnext = "
	SELECT nextdata.id_product FROM (
		SELECT DISTINCT id_product 
		FROM dt_category dt 
		WHERE 
		id_category IN (SELECT id_category FROM dt_category dt WHERE id_product = ".$db->escape($idproduct).") 
	)nextdata
	WHERE id_product = 
	(
		SELECT MIN(id_product) AS id_product FROM (
			SELECT DISTINCT dt.id_product 
			FROM dt_category dt LEFT JOIN ms_product mp ON mp.id = dt.id_product
			WHERE 
			id_category IN (SELECT id_category FROM dt_category dt WHERE id_product = ".$db->escape($idproduct).") 
			AND mp.visible = 1
		)sub
		WHERE  id_product > ".$db->escape($idproduct)."
	)
	";
	$rownext = $db->get_row($strsqlnext);
	
	
	//select category by idproduct prev
	$strsqlprev = "
	SELECT nextdata.id_product FROM (
		SELECT DISTINCT id_product 
		FROM dt_category dt 
		WHERE 
		id_category IN (SELECT id_category FROM dt_category dt WHERE id_product = ".$db->escape($idproduct).") 
	)nextdata
	WHERE id_product = 
	(
		SELECT MAX(id_product) AS id_product FROM (
			SELECT DISTINCT dt.id_product 
			FROM dt_category dt LEFT JOIN ms_product mp ON mp.id = dt.id_product
			WHERE 
			id_category IN (SELECT id_category FROM dt_category dt WHERE id_product = ".$db->escape($idproduct).") 
			AND mp.visible = 1
		)sub
		WHERE  id_product < ".$db->escape($idproduct)."
	)
	";
	$rowprev = $db->get_row($strsqlprev);	
	
	if($rownext || $rowprev){
		$data = array();
		$data["prev"] = $rowprev;
		$data["next"] = $rownext;		
		return $data;
	}else{
		return false;
	}		
}


function get_related($idproduct,$type){
	global $db;

	
	if(!isset($idproduct) || !is_numeric($idproduct)){
		$idproduct = 0;
	}		
	
	if(!isset($type) || !is_numeric($type)){
		$type = 1;
	}			
	
	//get category by id
	$strsql = "
		SELECT mp.id,mc.type,mp.product_name, mp.product_price, mp.visible,mp.cretime,img.img
		FROM ms_product mp 
		INNER JOIN dt_category dc ON mp.id = dc.id_product
		LEFT JOIN ms_category mc ON mc.id = dc.id_category
		LEFT JOIN (SELECT DISTINCT img,id_product FROM dt_product_img GROUP BY id_product ORDER BY cretime DESC) img ON img.id_product = dc.id_product		
		WHERE mp.visible = 1
		AND mc.type = ".$db->escape($type)."	
		AND mc.id IN (SELECT id_category FROM dt_category WHERE id_product = ".$db->escape($idproduct).")
		AND mp.id != ".$db->escape($idproduct)."
		ORDER BY mp.publish_date DESC		
		LIMIT 0,5
	";	
	$result = $db->get_results($strsql);	
	if($result){
		return $result;
	}else{
		return false;
	}	
}

?>