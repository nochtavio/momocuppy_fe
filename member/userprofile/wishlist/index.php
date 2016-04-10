<?php 
ob_flush();
$dir = "../../../";
$body = "member";
$css = "main,member,wishlist,message";
$js = "wishlist";
$halmember = "wishlist";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."content/header.php");

require_once($dir."lib/member/member.php");
require_once($dir."lib/member/wishlist.php");
require_once($dir."lib/member/order_history.php");
require_once($dir."member/chkuserlogin.php");


$idmember = get_memberid($email);
if($idmember=="" || !is_numeric($idmember)){
	header("Location: /about-us/");
	exit;
}

$p = 1;
if (isset($_GET["p"]) && is_numeric($_GET["p"])) {
	$p = $_GET["p"];
}
$rowspage = 9;  

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
      </div>
      <!--END NAVPAGE-->    
      
      <h3 id="summary">Hi <?php echo get_membername($idmember);?>,</h3>
      
      <?php require_once("../submenu.php");?>
      
      
      <?php 
			//process delete wishlist
			if(isset($_GET["job"]) && $_GET["job"]=="delete" && isset($_GET["p"]) && is_numeric($_GET["p"]) && isset($_GET["wlid"]) && is_numeric($_GET["wlid"]) ){
				$p = $_GET["p"];
				$wlid = $_GET["wlid"];
				
				$st = remove_wishlist($idmember,$wlid);
				if($st){
					header("location:/member/userprofile/wishlist/?content=wishlist&p=".$p."#maincontent");
					exit;
				}else{
					header("location:/member/userprofile/wishlist/?content=wishlist#maincontent");
					exit;					
				}
			}
			?>
      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="shoppingbag">
        	<h5>my wishlist</h5>                              
          
					<ul id="wishlist">
          	<?php 
						$rswishlist = get_wishlist($idmember,$rowspage,$p);
						if($rswishlist["result"]){
							foreach($rswishlist["result"] as $row){
								$idwishlist = $row->id;
								$product_name = $row->product_name;
								$product_price = $row->product_price;
								$product_id = $row->id_product;
								$product_img = order_history_thumbimg($row->id_product);
								
								$product_type = get_product_type($product_id);
								
								$varlink = "/products/detail/?type=".$product_type."&id_product=".$product_id."";
								
								echo "
									<li>
										<a href=\"".$varlink."\" class=\"linkwishlist\">
											<img src=\"".$product_img."\"  width=\"186\" height=\"258\"/>
											<span class=\"wishlist_item\">".$product_name."</span>
											<span class=\"wishlist_price\">IDR " . number_format($product_price, 0, "", ".") . "</span>              
										</a>           
										<a href=\"#mfp_message\" class=\"wishlist_cancel\" data-deletewl=\"?job=delete&amp;wlid=".$idwishlist."&amp;p=".$p."\"><span>cancel</span></a>
									</li>								
								";
							}
							
					
						}else{
							echo "
								<p>
								<br /><br />
								<center>You don't have any wishlist at the moment</center>
								<br />
								</p>";
						}
						$maxpage = 1;
						if (isset($rswishlist["maxpage"])) {
							$maxpage = $rswishlist["maxpage"];
						}								
						?>
          
                               
          </ul>          

          
          <?php 
					$url = "/member/userprofile/wishlist/?content=wishlist";
					$anchor = "#maincontent";
					echo page($maxpage, $p, $url, $anchor);					
					?>       
        </div>        
      </div>
      <!--end summary_detail-->                
    </div>  	
      
    
  </div>
</div>

<div id="mfp_message" class="mfp-hide white-popup-block">
  <h2>
    <img src="/images/layout/message/decor.png" />
  </h2>
  
  <h3 class="titlemsg">Oops..!</h3>
  
  <p class="message">
    Remove this item from your wishlist?    
  </p>
  
  <div class="wrapbtn">
    <div class="nobtn">
      <span>no</span>
    </div>
    
    <div class="yesbtn">
      <span>yes</span>
    </div>      
  </div>  
</div>
<!--MAINCONTENT-->  


  
<?php 
require_once($dir."content/footer.php");
?>