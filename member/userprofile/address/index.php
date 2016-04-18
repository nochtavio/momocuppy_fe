<?php 
ob_flush();
$dir = "../../../";
$body = "member";

$css = "main,scrollpane,member,popaddress,message";
$js = "mousewheel,scrollpane,popaddress,address";
$halmember = "address";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/order/get_city.php");

require_once($dir."lib/member/member.php");
require_once($dir."lib/member/address.php");
require_once($dir."member/chkuserlogin.php");

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
      </div>
      <!--END NAVPAGE-->    
      
      <h3 id="summary">Hi <?php echo get_membername($idmember);?>,</h3>
      
      <?php require_once("../submenu.php");?>
      
      <!--start summary_detail-->
      <div class="summary_detail">        
        <div id="shoppingbag">
        	<h5>address book</h5>                              
          <div id="div-hidden"></div>
          <ul id="box_address" class="addrbook">
          	     
          </ul>
					          
          <a id="btn_add" href="#" class="newaddr popaddress">
            <span>add new address</span>
          </a>       
        </div>        
      </div>
      <!--end summary_detail-->                
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