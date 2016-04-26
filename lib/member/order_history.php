<?php 



function order_history($memberid){
	global $db;
	
	$strsql = "
	SELECT 
		m.order_no, SUM(d.qty)  AS jumlah_item, m.cretime AS orderdate , m.discount,  SUM(d.price * d.qty) AS total_price,m.shipping_cost, m.status , m.resi_no
	FROM 
		ms_order m
	LEFT JOIN 
		dt_order d ON d.id_order = m.id
	WHERE 
		m.id_member = ".$db->escape($memberid)."
	GROUP BY 
		m.order_no, m.cretime, m.status, m.resi_no , m.discount	, m.shipping_cost
	ORDER BY m.cretime DESC
	LIMIT 0,200
	";
	$result = $db->get_results($strsql);
	
	if($result){
		return $result;
	}else{
		return false;
	}	
}


function order_history_summary($orderno){
	global $db;
	
	$strsql = "
		SELECT 
			firstname,lastname, street_address,
			city,country,zip_code,phone,payment_name, paid_date, paid_name,paid_nominal,
			payment_account,payment_account_name,discount,shipping_cost, status, resi_no, type,cretime,id_member
		FROM ms_order WHERE order_no = '".$db->escape($orderno)."'
		LIMIT 0,1		
	";
	$result = $db->get_row($strsql);
	if($result){
		 return $result;
	}else{
		return false;
	}	
}

function order_history_summary_id($orderid){
	global $db;
	
	$strsql = "
		SELECT 
			firstname,lastname, street_address,
			city,country,zip_code,phone,payment_name, paid_date, paid_name,paid_nominal,
			payment_account,payment_account_name,discount,shipping_cost, status, resi_no, type,cretime,id_member
		FROM ms_order WHERE id = '".$db->escape($orderid)."'
		LIMIT 0,1		
	";
	$result = $db->get_row($strsql);
	if($result){
		 return $result;
	}else{
		return false;
	}	
}

function order_history_detail($memberid,$ordercode){
	global $db;
	
	$getorderid = $db->get_row("SELECT id,type FROM ms_order WHERE order_no = '".$db->escape($ordercode)."'");
	if($getorderid){
		$orderid = $getorderid->id;
		$type = $getorderid->type;
		
		if($type == 1){
			$strsql = "
				SELECT 
					dto.id, dto.id_order, dto.id_dt_product,mp.id as id_product,mp.product_name, '' as color_name, dto.id_dt_product, dto.price, dto.qty, dto.weight 
				FROM dt_order dto 
				LEFT JOIN ms_product_redeem mp ON mp.id = dto.id_dt_product
				WHERE 
					id_order = ".$db->escape($orderid)."						
			";			
		}else{
			$strsql = "
				SELECT 
					dto.id, dto.id_order, dto.id_dt_product,dp.id_product,mp.product_name, mc.color_name, dto.id_dt_product, dto.price, dto.qty, dto.weight 
				FROM dt_order dto 
				LEFT JOIN dt_product dp ON dp.id = dto.id_dt_product
				LEFT JOIN ms_product mp ON mp.id = dp.id_product
				LEFT JOIN ms_color mc ON mc.id = dp.id_color
				WHERE 
					id_order = ".$db->escape($orderid)."						
			";		
		}
		
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

function order_history_detail_id($orderid){
	global $db;
	
	$getorderid = $db->get_row("SELECT id,type FROM ms_order WHERE id = '".$db->escape($orderid)."'");
	if($getorderid){
		$orderid = $getorderid->id;
		$type = $getorderid->type;
		
		if($type == 1){
			$strsql = "
				SELECT 
					dto.id, dto.id_order, dto.id_dt_product,mp.id as id_product,mp.product_name, '' as color_name, dto.id_dt_product, dto.price, dto.qty, dto.weight 
				FROM dt_order dto 
				LEFT JOIN ms_product_redeem mp ON mp.id = dto.id_dt_product
				WHERE 
					id_order = ".$db->escape($orderid)."						
			";			
		}else{
			$strsql = "
				SELECT 
					dto.id, dto.id_order, dto.id_dt_product,dp.id_product,mp.product_name, mc.color_name, dto.id_dt_product, dto.price, dto.qty, dto.weight 
				FROM dt_order dto 
				LEFT JOIN dt_product dp ON dp.id = dto.id_dt_product
				LEFT JOIN ms_product mp ON mp.id = dp.id_product
				LEFT JOIN ms_color mc ON mc.id = dp.id_color
				WHERE 
					id_order = ".$db->escape($orderid)."						
			";		
		}
		
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

function order_history_thumbimg($idproduct){
	global $db;
	
	$folder = "/mmcp/images/products/";
	$noimg = "/images/products/no-img-potrait.jpg";
	$strsql = "
		SELECT img FROM dt_product_img WHERE id_product = ".$db->escape($idproduct)." ORDER BY id ASC LIMIT 0,1
	";
	$img = $db->get_row($strsql);
	
	if($img){
		return $folder.$img->img;
	}else{
		return $noimg;
	}
}

function order_history_redeem_thumbimg($idproduct){
	global $db;
	
	$folder = "/mmcp/images/products/";
	
	$strsql = "
		SELECT img FROM dt_product_redeem_img WHERE id_product = ".$db->escape($idproduct)." ORDER BY id ASC LIMIT 0,1
	";
	$img = $db->get_row($strsql);
	
	if($img){
		return $folder.$img->img;
	}else{
		return $noimg;
	}
}


function get_product_type($idproduct){
	global $db;
	
	
	$strsql = "
		SELECT mscat.type FROM ms_category mscat
		LEFT JOIN dt_category dc ON dc.id_category = mscat.id
		WHERE dc.id_product = ".$db->escape($idproduct)."
		GROUP BY mscat.type	
		ORDER BY mscat.type DESC
	";
	$row = $db->get_row($strsql);
	if($row){
		return $row->type;
	}else{
		return false;
	}
}
?>