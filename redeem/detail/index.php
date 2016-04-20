<?php 
$body = "redeem";
$dir = "../../";
$css = "main,simplebar,redeem";
$js = "simplebar,redeem";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/member/member.php");
require_once($dir."member/chkuserlogin.php");
require_once($dir."lib/redeem/get_redeem.php");
require_once($dir."content/header.php");

if(isset($_GET["redeem_p"]) && is_numeric($_GET["redeem_p"])){
	$idredeem = $_GET["redeem_p"];
}else{
	header("location:/redeem/#maincontent");
	exit;
}


?>  
  
<!--MAINCONTENT-->
<div id="maincontent">
	<div id="wrapredeem">
  	<div class="content">
      <!--START NAVPAGE-->
      <div class="navpage">
        <span>Home</span>
        <span class="sep">|</span>
        <span>Redeem</span>      
        <span class="sep">|</span>
        <span>Redeem Details</span>                 
      </div>
      <!--END NAVPAGE-->    

      <!--start redeemcontent-->	
      <div id="redeemcontent">
      	<h3>Redeem your points!</h3>
        
        <?php 
				$vartbncheckout = "";
				$detail = get_detailredeem($idredeem);
				if($detail){
					if(isset($email)){

						
						$memberid = get_memberid($email);		

						$point = 0;		
						$memberpoint = false;		
								
						if(is_numeric($memberid)){
							$memberpoint = get_memberpoint($memberid);							
						}

								
						if(is_numeric($memberid)){
							$info_point = "";
							if($memberpoint < $detail->product_point){
								$info_point = "(You don't have enough points)";
							}
							$point = $memberpoint;
							$varpoint = "<span class=\"detail_point\">".$point." Points</span> <span>".$info_point."</span>";		
							
							$vartbncheckout = "";
							if($memberpoint >= $detail->product_point){
								if($detail->stock != 0){
									$vartbncheckout = "<a href=\"/redeem/checkout/?redeem_p=".$idredeem."\" class=\"detail_redeembtn\"><span>redeem now</span></a>";																			
								}else{
									$vartbncheckout = "<div class=\"outofstock\">Sorry, this product is currently unavailable.</div>";																			
								}								
							}

						}else{
							$varpoint = "<p class=\"logininfo\">You must <a class=\"forcelogin\" href=\"#\" ><strong>LOGIN</strong></a> first to redeem this <strong>ITEM</strong></p>";							
						}
					}else{
						$varpoint = "<p class=\"logininfo\">You must <a class=\"forcelogin\" href=\"#\" ><strong>LOGIN</strong></a> first to redeem this <strong>ITEM</strong></p>";							
					}					
					
					
					//get thumb
					$thumb = get_redeem_thumbimg($idredeem);
					if($thumb){
						$thumbimg = $thumb;
					}else{
						$thumbimg = "/images/redeem/no-image.jpg";
					}					
					
					echo "
					<div class=\"redeem_pic\">
						<img src=\"".$thumbimg."\" width=\"310\"/>
					</div>
					<div class=\"redeem_detail\">
						<span class=\"pointtitle\">recent points</span>
						".$varpoint."
						<span class=\"detail_name\">".$detail->product_name."</span>
						<p class=\"detail_desc\">".$detail->product_desc."</p>
						<span class=\"detail_cost\">".$detail->product_point." Points</span>
						".$vartbncheckout."
					</div>					
					";
				}else{
					header("location:/redeem/#maincontent");
					exit;					
				}
				?>

      </div>
      <!--end redeemcontent-->	      
      
      
          
    </div>  	
  </div>
</div>
<!--MAINCONTENT-->  
  
<?php 
require_once($dir."content/footer.php");
?>