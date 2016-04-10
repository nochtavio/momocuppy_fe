<?php 
ob_flush();
$dir = "../../../";
$body = "member";
$css = "main,scrollpane,member,cartload";
$js = "scrollpane,member,cart-load";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/member/member.php");
require_once($dir."lib/member/order_history.php");

require_once($dir."member/chkuserlogin.php");
$halmember = "history";

$idmember = get_memberid($email);

if($idmember=="" || !is_numeric($idmember)){
	header("Location: /about-us/");
	exit;
}

require_once($dir."content/header.php");




?>  
  
<!--MAINCONTENT-->
<div id="maincontent">
	<div id="wrapmember">
  	<div class="content">
      <!--START NAVPAGE-->
      <div class="navpage">
        <span>Home</span>
        <span class="sep">|</span>
        <span>My Account</span>        
        <span class="sep">|</span>
        <span>Order History</span>                   
      </div>
      <!--END NAVPAGE-->    
      
      <h3 id="summary">Hi <?php echo get_membername($idmember);?>,</h3>
      
      <?php require_once("../submenu.php");?>
      
      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="shoppingbag">
        	<h5>order history</h5>                              
          <ul class="history_title" >
          	<li class="recentorder">Recent Order</li>
          	<li class="item">Item(s)</li>            
          	<li class="date">Date</li>            
          	<li class="total">Total</li>            
          	<li class="payment">Payment</li>            
          	<li class="delivery">Delivery</li>            
          </ul>
          
          <div id="history">
            <ul class="orderhistory simplebar">
            
            	<?php 
							$order_history = order_history($idmember);
							if($order_history){
								foreach($order_history as $row){
									
									switch($row->status){
										 case 1 : $varstatus = "<strong>Waiting for payment</strong>"; //<span class=\"paymentstat\"><strong>Confirmed</strong><br />via Bank Transfer</span> 
										 break;
										 case 2 : $varstatus = "<strong style=\"color:#f00;\">Waiting for Confirmation</strong>";
										 break;										 
										 case 3 : $varstatus = "<strong style=\"color:#85ae95;\">Confirmed</strong><br /><span style=\"color:#85ae95;font-size:12px;width:100%;text-align:center;\">via Bank Transfer</span>";
										 break;										 
										 case 4 : $varstatus = "<strong style=\"color:#85ae95;\">Confirmed</strong><br /><span style=\"color:#85ae95;font-size:12px;width:100%;text-align:center;\">via Bank Transfer</span>";
										 break;										 
										 case 5 : $varstatus = "<strong style=\"color:#85ae95;\">Confirmed</strong><br /><span style=\"color:#85ae95;font-size:12px;width:100%;text-align:center;\">via Bank Transfer</span>";
										 break;										 
										 case 6 : $varstatus = "<strong style=\"color:#f00\">CANCELED</strong><br /><span style=\"color:#f00;font-size:12px;\">the order has been canceled</span>"; 										 										 
										 break;										 
										 default :$varstatus = "<strong>Waiting for payment</strong>";
									}
									
									//validasi track number
									if($row->status != 6){																														
										if($row->status != 1 && $row->status != 2){
											$txtnoresi = "<strong>On Progress</strong><br /><span style=\"color:#f9a378;font-size:12px;width:100%;text-align:center;\">preparing items...</span>";
											if($row->resi_no != ""){
												$txtnoresi = "<strong style=\"color:#85ae95;\">Delivered</strong><br /><span style=\"color:#85ae95;font-size:12px;width:100%;text-align:center;\">Tracking Number :</span><br /><span style=\"color:#85ae95;font-size:12px;width:100%;text-align:center;\">".$row->resi_no."</span>";
											}																					
										}else{
											$txtnoresi = "<strong>-</strong>";
										}
									}else{
										$txtnoresi = "<strong style=\"color:#f00\">CANCELED</strong><br /><span style=\"color:#f00;font-size:12px;\">the order has been canceled</span>";
									}
									
									$chars = "";
									if($row->jumlah_item > 1){
										$chars = "s";										
									}
									
									$vardiscount = 0;
									if(isset($row->discount) && $row->discount <= 100){
										$vardiscount = $row->discount;
									}
									
									$ship = 0;
									if(isset($row->shipping_cost) && is_numeric($row->shipping_cost)){
										$ship = $row->shipping_cost;
									}									
									
									$discprice = 0;
									$discprice = $row->total_price * ($vardiscount/100);
									$grandtotal = ($row->total_price - $discprice) + $ship;
									
									echo "
									<li>
										<span class=\"orderdata\">".$row->order_no." <br /> <a class=\"cart-popup\" href=\"cart-load.php?order_no=".$row->order_no."\">view details</a></span>
										<span class=\"itemdata\">".$row->jumlah_item." item".$chars."</span>                
										<span class=\"datedata\">".date("d M Y",strtotime($row->orderdate))."</span>                                
										<span class=\"pricedata\">IDR ".number_format($grandtotal,0,"",".")."</span>                                                
										<span class=\"paymentstat\">".$varstatus."</span>                                                                
										<span class=\"deliverystat\">".$txtnoresi."</span>
									</li>									
									";
								}
							}
							?>
                                                                                                                                                                                                                                                                             
            </ul>          
          </div>
          
        </div>        
      </div>
      <!--end summary_detail-->                
    </div>  	
  </div>
</div>
<!--MAINCONTENT-->  
  
<?php 
require_once($dir."content/footer.php");
?>