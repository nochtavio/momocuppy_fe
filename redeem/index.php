<?php 
$body = "redeem";
$dir = "../";
$css = "main,simplebar,redeem";
$js = "simplebar";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/member/member.php");
require_once($dir."lib/redeem/get_redeem.php");
require_once($dir."content/header.php");
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
      </div>
      <!--END NAVPAGE-->    

      <!--start redeemcontent-->	
      <div id="redeemcontent">
      	<h3>Redeem your points!</h3>
        <span class="subtitle">You can redeem your points to get our special products*</span>
        <ul class="listredeem">
        
        	<?php 
					$redeem = get_redeemlist();
					if($redeem){
						foreach($redeem as $row){
							//get thumb
							$thumb = get_redeem_thumbimg($row->id);
							if($thumb){
								$thumbimg = $thumb;
							}else{
								$thumbimg = "/images/redeem/no-image.jpg";
							}
							
							list($width, $height) = getimagesize("..".$thumbimg);
							if ($width > $height) {
									// Landscape
								$varclass = "landscape";
							} else {
									// Portrait or Square
								$varclass = "potrait";															
							}									
                                                          
							
							echo "
							<li>
								<div class=\"img\">
									<img class=\"".$varclass."\" src=\"".$thumbimg."\"  />								
								</div>
								<span class=\"redeem_title\">".$row->product_name."</span>
								<span class=\"redeem_points\">".$row->product_point." Points</span>
								<a href=\"detail/?redeem_p=".$row->id."#maincontent\" class=\"redeembtn\"><span>redeem</span></a>
							</li>							
							";
						}
					}
					
					?>
                   
        </ul>
        <span class="extranote"><!--* Valid from 2 - 31 August 2015, while stock last.--></span>
      </div>
      <!--end redeemcontent-->	      
      
      
          
    </div>  	
  </div>
</div>
<!--MAINCONTENT-->  
  
<?php 
require_once($dir."content/footer.php");
?>