<?php 



function get_redeemlist(){

	global $db;

	

	$strsql = "

		SELECT

			mr.id,

			mr.product_name,

			mr.product_point

		FROM ms_product_redeem mr 

		WHERE mr.visible = 1 AND NOW() > IFNULL(mr.publish_date,0)	

	";

	$result = $db->get_results($strsql);

	if($result){

		return $result;

	}else{

		return false;

	}

}



function get_detailredeem($redeemid){

	global $db;

	

	$strsql = "

		SELECT

			mr.id,

			mr.product_name,

			mr.product_desc,			

			mr.product_point

		FROM ms_product_redeem mr 

		WHERE mr.visible = 1 AND NOW() > IFNULL(mr.publish_date,0)	

		AND mr.id = ".$db->escape($redeemid)."

	";

	$result = $db->get_row($strsql);

	if($result){

		return $result;

	}else{

		return false;

	}

}





function get_redeem_thumbimg($idproduct){

	global $db;

	

	$folder = "/mmcp/images/products/";

	

	$strsql = "

		SELECT img FROM dt_product_redeem_img WHERE id_product = ".$db->escape($idproduct)." ORDER BY id ASC LIMIT 0,1

	";

	$img = $db->get_row($strsql);

	

	if($img){

		return $folder.$img->img;

	}else{

		return false;

	}

}



?>