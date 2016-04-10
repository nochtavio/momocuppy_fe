<?php 
ob_flush();
$dir = "../../../";
require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/member/member.php");
require_once($dir."lib/member/order_history.php");

require_once($dir."member/chkuserlogin.php");
$idmember = get_memberid($email);

if($idmember=="" || !is_numeric($idmember)){
	echo "<div id=\"cartload\"><span style=\"float:left;width:100%;text-align:center;\">failed to load detail order</span></div>";
	exit;
}

if(isset($_GET["order_no"])){
	$orderno = $_GET["order_no"];
}else{
	echo "<div id=\"cartload\"><span style=\"float:left;width:100%;text-align:center;\">failed to load detail order</span></div>";
	exit;
}


$rowsum = order_history_summary($orderno);
if(!$rowsum){
	echo "<div id=\"cartload\"><span style=\"float:left;width:100%;text-align:center;\">failed to load detail order</span></div>";
	exit;	
}else{	
	$vardiscount = 0;
	if(isset($rowsum->discount) && $rowsum->discount <= 100){
		$vardiscount = $rowsum->discount;
	}
	

	
	$ship = 0;
	if(isset($rowsum->shipping_cost) && is_numeric($rowsum->shipping_cost)){
		$ship = $rowsum->shipping_cost;
	}		
	$type = $rowsum->type;
	$firstname = $rowsum->firstname;
	$lastname = $rowsum->lastname;	
	$city = $rowsum->city;		
	$country = $rowsum->country;			
	$zip_code = $rowsum->zip_code;	
	$phone = $rowsum->phone;
	$street_address = $rowsum->street_address;	
	
	//payment
	$status = $rowsum->status;
	switch($status){
		case 1 : $varinfo = "		
			<strong>-</strong><br />
		"; break;	
/*		case 2 : $varinfo = "		
			<strong>BANK TRANSFER</strong><br />
			Payment Date : ".date("d M Y",strtotime($rowsum->paid_date))."<br />
			Acc Name :<br />
			".$rowsum->paid_name."<br />
			Amount :<br />
			IDR ".number_format($rowsum->paid_nominal,0,"",".")."<br />			
			Transfer to : <br />
			".$rowsum->payment_name." - ".$rowsum->payment_account."	
		"; break;		*/
		case 2 : $varinfo = "		
			<strong>WAITING FOR CONFIRMATION</strong>
		"; break;				
		case 3 : $varinfo = "
			<strong>BANK TRANSFER</strong><br />
			Payment Date : ".date("d M Y",strtotime($rowsum->paid_date))."<br />
			Acc Name :<br />
			".$rowsum->paid_name."<br />
			Amount :<br />
			IDR ".number_format($rowsum->paid_nominal,0,"",".")."<br />			
			Transfer to : <br />
			".$rowsum->payment_name." - ".$rowsum->payment_account."	
		"; break;	
		case 4 : $varinfo = "
			<strong>BANK TRANSFER</strong><br />
			Payment Date : ".date("d M Y",strtotime($rowsum->paid_date))."<br />
			Acc Name :<br />
			".$rowsum->paid_name."<br />
			Amount :<br />
			IDR ".number_format($rowsum->paid_nominal,0,"",".")."<br />			
			Transfer to : <br />
			".$rowsum->payment_name." - ".$rowsum->payment_account."	
		"; break;				
		case 5 : $varinfo = "
			<strong>BANK TRANSFER</strong><br />
			Payment Date : ".date("d M Y",strtotime($rowsum->paid_date))."<br />
			Acc Name :<br />
			".$rowsum->paid_name."<br />
			Amount :<br />
			IDR ".number_format($rowsum->paid_nominal,0,"",".")."<br />			
			Transfer to : <br />
			".$rowsum->payment_name." - ".$rowsum->payment_account."	
		"; break;			
		case 6 : $varinfo = "		
			<strong>-</strong><br />
		"; break;	
		default : $varinfo = "		
			<strong>-</strong><br />
		"; break;					
	}
	
	if($type == 1){
		$varinfo = "REDEEMED ITEM";
	}
	
	//validasi track number
	if($rowsum->status != 6){																														
		if($rowsum->status != 1 && $rowsum->status != 2){
			$txtnoresi = "<strong>PREPARING DELIVERY</strong";
			if($rowsum->resi_no != ""){
				$txtnoresi = "<strong>SHIPPED</strong><br />
      Tracking Number :<br />
      ".$rowsum->resi_no."";
			}																					
		}else{
			$txtnoresi = "<strong>-</strong>";
		}
	}else{
		$txtnoresi = "<strong>ORDER CANCELED</strong>";
	}	
	
}

$dthistory = order_history_detail($idmember,$orderno);
if(!$dthistory){
	echo "<div id=\"cartload\"><span style=\"float:left;width:100%;text-align:center;\">failed to load detail order</span></div>";
	exit;	
}



?>

<div id="cartload">
	<h3 class="ordercode">ORDER #<?php echo $orderno;?></h3>
  <div class="cartdesc">
  	<span class="popupdetail">Order Summary</span>
  	<span class="popupqty">Qty</span>    
  	<span class="popupprice">Price</span>    
  	<span class="popuptotal">Total</span>    
  </div>
  
  <!--start itemload-->
  <ul id="itemload" class="simplebar">

    <?php 
		$totalorder = 0;
		if($dthistory){
			foreach($dthistory as $row){
				$subtotal = $row->price * $row->qty;
				
				if($type == 1){
					$varimg = order_history_redeem_thumbimg($row->id_product);					
				}else{
					$varimg = order_history_thumbimg($row->id_product);				
				}

				echo "
				<li>
					<div class=\"popupimg\">
						<img src=\"".$varimg."\" width=\"59\" height=\"99\"/>						
					</div>
					<div class=\"popupdesc\">
						<h3 class=\"titledesc\">".$row->product_name."</h3>
						<span class=\"extradesc\">Color: ".$row->color_name."</span>
					</div>      
					<div class=\"popupqty\">
						<span>".$row->qty."</span>
					</div>    
					<div class=\"popupprice\">
						<span>IDR ".number_format($row->price,0,"",".")."</span>
					</div>    
					<div class=\"popuptotal\">
						<span>IDR ".number_format($subtotal,0,"",".")."</span>
					</div>        
				</li>					
				";
				$totalorder = $totalorder + $subtotal;
			}			
		}
		
		$disc_price = $totalorder * ($vardiscount)/100;		
		$grandtotal = ($totalorder - $disc_price) + $ship;
		?>
    
              
  </ul>
  <!--end itemload-->  
 	 
 	<div class="popupsum">
  	<div class="row">
    	<span class="titlesum">SHIPPING COST</span>
    	<span class="price">IDR <?php echo number_format($ship,0,"",".")?></span>      
    </div>
    
  	<div class="row">
    	<span class="titlesum">DISCOUNT</span>
    	<span class="price">- IDR <?php echo number_format($disc_price,0,"",".")?></span>      
    </div>    
    
  	<div class="row">
    	<span class="titlesumtotal">TOTAL</span>
    	<span class="price">IDR <?php echo number_format($grandtotal,0,"",".")?></span>      
    </div>    
  </div>
  
  <div class="cartdesc">
  	<span class="popupaddress">Shipping Address</span>
  	<span class="popuppayment">Payment</span>    
  	<span class="popupstat">Status</span>    
  </div>  
  
  <div class="detailpayment">
   	<div class="popupaddress">
    	<strong><?php echo strtoupper($firstname." ".$lastname);?></strong><br />
      <?php echo $street_address;?><br />
      <?php echo strtoupper($city)." ".$zip_code;?><br />
      <?php echo strtoupper($country);?><br />
      <?php echo $phone;?>
    </div>
    
  	<div class="popuppayment">
    	
    	<?php 
			echo $varinfo;
			?>
      
      

    </div>    
  	<div class="popupstat">
	    <?php echo $txtnoresi;?>
    </div>     
  </div>
  
</div>