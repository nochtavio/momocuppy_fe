<?php 
$body = "order";
$dir = "../../";
$css = "main,order,datepicker,userprofile";
$js = "datepicker,track";
require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/member/member.php");
require_once($dir."lib/order/track.php");
require_once($dir."member/chkuserlogin.php");
require_once($dir."content/header.php");

$loginflag = false;
if(isset($email) && $email!=""){
	$memberid = get_memberid($email);
	if($memberid){
		$loginflag = true;		
	}
}
?>  
  
<!--MAINCONTENT-->
<div id="maincontent">
	<div id="wraporder">
  	<div class="content">
      <!--START NAVPAGE-->
      <div class="navpage">
        <span>Home</span>
        <span class="sep">|</span>
        <span>Order</span>      
        <span class="sep">|</span>
        <span>Tracking</span>              
      </div>
      <!--END NAVPAGE-->  
      
      
      <!--start wrapconfirm-->
      <div id="wrapconfirm">
      	<h5>Tracking</h5>
        
        <?php 
				if(isset($_SESSION["trackmsg"]["failupdate"])){
						echo "
						<div class=\"warnmsg warningdata\">
							<span>".$_SESSION["trackmsg"]["failupdate"]."</span>
						</div>																
						";	
					unset($_SESSION["trackmsg"]["failupdate"]);
				}					
				
				if(isset($_POST["submit_track"]) && $_POST["submit_track"]=="tracking"){
					$valid = true;
					//orderid
					if(isset($_POST["orderid"]) && $_POST["orderid"]!=""){
						$orderid = trim($_POST["orderid"]);
					}else{
						$valid = false;
					}						
					
					$status = 1;
					$resino = "-";
					if($valid == true && $memberid!=""){
						$track = track_order($memberid,$orderid);
						if($track){
							$status = $track->status;
							
			
							if($track->resi_no!=""){
								$resino = $track->resi_no;
							}
						}else{
							$_SESSION["trackmsg"]["failupdate"] = "Oops, something wrong. Please check your data";
							header("location:.#maincontent");
							exit;							
						}
						
						
						$varmessage = "";
						switch($status){
							case 1 : $varmessage = "<h3>Your order still on process.</h3>If you have any question, please contact us <a href=\"mailto:help@momocuppy.com\">help@momocuppy.com</a>"; break;
							case 2 : $varmessage = "<h3>Your order still on process.</h3>If you have any question, please contact us <a href=\"mailto:help@momocuppy.com\">help@momocuppy.com</a>"; break;
							case 3 : $varmessage = "<h3>Your order still on process.</h3>If you have any question, please contact us <a href=\"mailto:help@momocuppy.com\">help@momocuppy.com</a>"; break;
							case 4 : $varmessage = "<h3>Your order is already shipped!</h3>Your Tracking number is <strong>".$resino."</strong>. You can track your order here <a href=\"http://www.jne.co.id\" target=\"_blank\">www.jne.co.id</a>"; break;
							default : $varmessage = "<h3>Your order still on process.</h3><br />If you have any question, please contact us <a href=\"mailto:help@momocuppy.com\">help@momocuppy.com</a>"; break;
						}			
						
						$_SESSION["trackmsg"]["info"] = $varmessage;
						header("location: .#maincontent");			
						exit;
						
					}else{
						$_SESSION["trackmsg"]["failupdate"] = "Oops, something wrong. Please check your data";
						header("location:.#maincontent");
						exit;							
					}
					
					
					
				}
				?>        
        
        <form name="confirm" class="confirm" method="post" action=".">
          <div class="row">
            
            <?php 
						if($loginflag == false){
							echo "<div class=\"infologin\"><a href=\"#\" class=\"forcelogin\"><strong>LOGIN</strong></a> first to track your ORDER</div>";
						}else{
							echo "<label for=\"orderid\">Order ID</label><input type=\"text\" name=\"orderid\" id=\"orderid\" />";
						}
						?>
            
            
          </div>   
          <?php 
					if($loginflag == true){
						echo "
							<div class=\"row\">
								<input type=\"hidden\" value=\"tracking\" name=\"submit_track\"/>
								<input class=\"tracking\" type=\"image\" src=\"/images/layout/order/track.png\" />
							</div>          						
						";
					}
					?>                                       
        </form>
        
      
        

        <div class="track_result">
        	
          <div class="submsg">
          <?php 
					if(isset($_SESSION["trackmsg"]["info"])){
						echo $_SESSION["trackmsg"]["info"];
						unset($_SESSION["trackmsg"]);
					}
					?>
          
          </div>
        </div>
      </div>
      <!--end wrapconfirm-->  
      
      
      
      
      
 
      
               
          
    </div>  	
  </div>
</div>
<!--MAINCONTENT-->  
  
<?php 
require_once($dir."content/footer.php");
?>