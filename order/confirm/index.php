<?php 
$body = "order";
$dir = "../../";
$css = "main,order,userprofile,datepicker";
$js = "datepicker,confirm_payment";
require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/order/confirm.php");
require_once($dir."member/chkuserlogin.php");
require_once($dir."content/header.php");
?>  
  
<!--MAINCONTENT-->
<div id="maincontent">
	<div id="wraporder">
  	<div class="content">
      <!--START NAVPAGE-->
      <div class="navpage">
        <span>Home</span>
        <span class="sep">|</span>
        <a href="/order/#maincontent"><span>Order</span></a>
        <span class="sep">|</span>
        <a href="/order/confirm/#maincontent"><span>Confirm Payment</span></a>
      </div>
      <!--END NAVPAGE-->  
      
      
      <!--start wrapconfirm-->
      <div id="wrapconfirm">
      	<h5>Confirm Payment</h5>
        
        <?php 
				if(isset($_SESSION["confirmmsg"])){
					if(isset($_SESSION["confirmmsg"]["success"])){
						echo "
						<div class=\"warnmsg\">
							<span>".$_SESSION["confirmmsg"]["success"]."</span>
						</div>																
						";
					}else{
						echo "
						<div class=\"warnmsg warningdata\">
							<span>".$_SESSION["confirmmsg"]["failupdate"]."</span>
						</div>																
						";							
					}
					unset($_SESSION["confirmmsg"]);
				}				
				
				//post result
				if(isset($_POST["confirmdata"])){
					$valid = true;
					
					//orderid
					if(isset($_POST["orderid"]) && $_POST["orderid"]!=""){
						$orderid = trim($_POST["orderid"]);
					}else{
						$valid = false;
					}		
					
					
					//dop
					if(isset($_POST["dop"]) && $_POST["dop"]!=""){
						$dop = trim($_POST["dop"]);
					}else{
						$valid = false;
					}		
					
					//amount
					if(isset($_POST["amount"]) && $_POST["amount"]!=""){
						$amount = trim($_POST["amount"]);
						
						if(!is_numeric($amount)){
							$valid = false;
						}
					}else{
						$valid = false;
					}							
					
					//bankaccname
					if(isset($_POST["bankaccname"]) && $_POST["bankaccname"]!=""){
						$bankaccname = trim($_POST["bankaccname"]);
					}else{
						$valid = false;
					}																	
					
					if($valid == true){
						$st = confirm_payment($orderid,$dop,$bankaccname,$amount);
						if($st){
							if(isset($email)){
								$_SESSION["confirmmsg"]["success"] = "Thank you! We will check your payment. Please check your summary <a href=\"/member/userprofile/order_history/#maincontent\">here</a>!";								
							}else{
								$_SESSION["confirmmsg"]["success"] = "Thank you! We will check your payment. Please check your summary by <strong>LOGIN</strong> to your account!";							
							}
							header("location:.#maincontent");
							exit;
						}else{
							$_SESSION["confirmmsg"]["failupdate"] = "Oops, something wrong. Please check your data";
							header("location:.#maincontent");
							exit;									
						}
					}else{						
						$_SESSION["confirmmsg"]["failupdate"] = "Oops, something wrong. Please check your data";
						header("location:.#maincontent");
						exit;								
					}
				}
				
				?>   
        <form name="confirm" class="confirm" method="post" action=".">
					<input type="hidden" name="confirmdata" value="confirmdata" />
          <div class="row">
            <label for="orderid">Order ID</label>
            <input type="text" name="orderid" id="orderid" />
          </div> 
          
          <div class="row">
	          <label>Bank</label>
            <span id="labelbank">Please insert your ORDER ID first</span>
						<!--	
            <div class="select-style select2">
             <select name="bank">
              	<?php 
/*								$paymentlist = get_paymentlist();
								if($paymentlist){
									foreach($paymentlist as $row){
										echo "<option value=\"".$row->id."\">".$row->payment_name."</option>";
									}
								}*/
								?>
              

              </select>

    
            </div> -->         
          </div>
          
          <div class="row">
            <label for="dop">Date of Payment</label>
            <input type="text" name="dop" id="dop" class="datepicker"/>
          </div> 
          
          <div class="row">
            <label for="amount">Amount</label>
            <input type="text" name="amount" id="amount" placeholder="in numeric, etc: 100000"/>
          </div>          
          
          <div class="row">
            <label for="bankaccname">Bank Account's Name</label>
            <input type="text" name="bankaccname" id="bankaccname" />
          </div>
                               
          <div class="row">
          	<input class="confirm" type="image" src="/images/layout/order/confirm.png" />
          </div>
          
        </form>
      </div>
      <!--end wrapconfirm-->  
      
      
      
      
      
 
      
               
          
    </div>  	
  </div>
</div>
<!--MAINCONTENT-->  
  
<?php 
require_once($dir."content/footer.php");
?>