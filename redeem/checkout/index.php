<?php 
$body = "redeem";
$dir = "../../";
$css = "main,simplebar,redeem,member,popaddress,message";
$js = "simplebar,order-redeem";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/member/member.php");
require_once($dir."member/chkuserlogin.php");
require_once($dir."lib/redeem/get_redeem.php");
require_once($dir."lib/order/get_city.php");
require_once($dir."content/header.php");

if(isset($_GET["redeem_p"]) && is_numeric($_GET["redeem_p"])){
	$idredeem = $_GET["redeem_p"];
}else{
	header("location:/redeem/#maincontent");
	exit;
}

if(isset($_SESSION['after_success'])){
  unset($_SESSION['after_success']);
  header("location:/redeem/#maincontent");
	exit;
}

$detail = get_detailredeem($idredeem);
if($detail){
	if($detail->stock == 0){
		header("location:/redeem/#maincontent");
		exit;
	}
  if(isset($email)){
    $memberid = get_memberid($email);		
    $point = 0;		
    $memberpoint = false;		

    if(is_numeric($memberid)){
      $memberpoint = get_memberpoint($memberid);							
    }

    if($memberpoint >= 0 && is_numeric($memberid)){
      if($memberpoint >= $detail->product_point){
        $_SESSION['id_redeem'] = $idredeem;
        $_SESSION['courier'] = 'REG';
      }else{
        header("location:/redeem/detail/?redeem_p=".$idredeem."#maincontent");
        exit;
      }										
    }else{
      header("location:/redeem/#maincontent");
      exit;							
    }
  }else{
    header("location:/redeem/#maincontent");
    exit;							
  }
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
      </div>
      <!--END NAVPAGE-->    

      <!--start redeemcontent-->	
      <div class="wrapaddressbox">
        <h2>shipping address</h2>
        <div id="div-hidden"></div>
        <div id="box_address"></div>
        
        <div class="wrapaddnewaddr">
          <a id="btn_add" href="#" class="newaddr popaddress">
            <span>add new address</span>
          </a>
        </div>
        
        <div class="selboxaddr">
          <span>Choose a delivery address :</span>
          <div class="select-style">
            <select id="sel_address">

            </select>
          </div>
        </div>
        
        <ul class="order_rules">
          <li><span>It is not possible to ship items to an alternative address once items have been dispatched.</span></li>        
          <li><span>You will received an airway bill number to enable you to track your delivery status at www.jne.co.id.</span></li>
          <li><span>Your order will be delivered within 1-3 working days after payment (not including public holiday).</span></li>          
        </ul>
      
      	<div class="wrapbtnredeem">
          <form name="confirmchkout" action="<?php echo $dir . "mmcp/api/new_redeem/" ?>" class="confirmchkout" method="post">
            <input type="hidden" id="order_firstname" name="order_firstname" value="" />
            <input type="hidden" id="order_lastname" name="order_lastname" value="" />
            <input type="hidden" id="order_street_address" name="order_street_address" value="" />
            <input type="hidden" id="order_phone" name="order_phone" value="" />
            <input type="hidden" id="order_zip_code" name="order_zip_code" value="" />
            <input type="hidden" id="order_country" name="order_country" value="" />
            <input type="hidden" id="order_city" name="order_city" value="" />
            <input id="btn_checkout" type="image" src="/images/layout/redeem/redeemok.png" />
          </form>
        </div>
      </div>
      <!--end redeemcontent-->	   
    </div>  	
  </div>
</div>
<!--MAINCONTENT-->  

<div id="popaddress" class="mfp-hide">
  <h3 id="poptitle" class="title"></h3>
  <form name="formaddr" class="personal formaddr" action="." method="post">
    <div class="row">
      <label for="firstname">First Name</label>
      <input type="text" name="firstname" id="firstname" autocomplete="off" value=""/>

      <label class="labellastname" for="lastname">Last Name</label>
      <input type="text" name="lastname" id="lastname" autocomplete="off" value=""/>                
    </div>  

    <div class="row">
      <label for="phone">Phone</label>
      <input type="text" name="phone" id="phone" value=""/>
    </div>   

    <div class="row">
      <label for="streetname">Street Address</label>
      <input type="text" name="streetname" id="streetname" value=""/>
    </div>

    <div class="row">
      <label for="postalcode">Zip / Postal Code</label>
      <input type="text" name="postalcode" id="postalcode" value=""/>
    </div>   

    <div class="row">
      <label for="country">Country</label>
      <input type="text" name="country" id="country" value="Indonesia" readonly="readonly"/>
    </div>      

    <div class="row">
      <label for="city">City</label>
      <select class="select" name="city" id="city">
        <?php
          $data = get_city();

          if ($data["result"]) {
            foreach ($data["result"] as $row) {
              $city_id = $row->city_id;
              $city_name = $row->city_name;
              $type = $row->type;
              echo "
                <option value='".$city_id."'>".$city_name." [".$type."]</option>				
              ";
            }
          }
        ?>   
      </select>
    </div>  

    <div class="row">
      
      <input type="hidden" name="txt_id" id="txt_id" value=""/>
      <input id="btn_submit" class="saveaddr" type="image" src="/images/layout/member/btnsaveaddr.png" />
    </div>                             

  </form>
</div>

<div id="mfp_message" class="mfp-hide white-popup-block">
	<h2>
  	<img src="/images/layout/message/bunny.gif" />
  </h2>
  <h3 id="poptitle" class="titlemsg"></h3>
  <p id="popmessage" class="message"></p>
  <div class="wrapok">
    <div id="popok" class="okbtn">
      <span>ok</span>
    </div>      
  </div>  
</div>
  
<?php 
require_once($dir."content/footer.php");
?>