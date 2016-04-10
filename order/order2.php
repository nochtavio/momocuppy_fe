<?php
$body = "order";
$dir = "../";
$css = "main,simplebar,order,member,popaddress,message,scrollpane";
$js = "mousewheel,scrollpane,popaddress,order2";
require_once($dir . "core/conn/db.php");
require_once($dir . "lib/order/get_payment.php");
require_once($dir . "lib/order/get_city.php");

//Maintain Session
session_start();
if (!isset($_SESSION["order_page"]) || $_SESSION["order_page"] !== "order1") {
  header("location:/order/index.php");
  exit();
} else {
  //$_SESSION["order_page"] = "order2";
}

require_once($dir . "content/header.php");
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
        <span>Shopping Bag</span>              
      </div>
      <!--END NAVPAGE-->    

      <h3  id="summary_order">shopping bag summary</h3>

      <div class="submenuorder">
        <ul class="order_menu">
          <li><a href="/order/#maincontent"><span>summary</span></a></li>
          <li><a class="selected" href="/order/order2.php#maincontent"><span>shipping address</span></a></li>
          <li><a href="#"><span>done</span></a></li>                    
        </ul>
      </div>

      <!--START wrapaddressbox-->
      <form name="confirmchkout" action="<?php echo $dir . "mmcp/api/new_order/" ?>" class="confirmchkout" method="post">
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

        </div>

        <!--start rightorderbox-->
        <div class="rightorderbox">
          <div id="shoppingbag_confirm">
            <h3>Shopping Bag</h3>
            <ul id="shopbaglist" class="shopbaglist shopbaglist_confirm simplebar">

            </ul>                                
          </div>   

          <div id="summarynote" class="summarynote">
            <div class="row">
              <span class="note_title">Total (kg)</span>
              <span class="note_sep">:</span>
              <span id="txt_weight" class="note_data">0 KG</span>
            </div>
            <div class="row">
              <span class="note_title">subtotal</span>
              <span class="note_sep">:</span>
              <span id="txt_sub_total" class="note_data">IDR 0</span>
            </div>
            <div class="row">
              <span class="note_title">discount</span>
              <span class="note_sep">:</span>
              <span id="txt_discount" class="note_data">IDR 0</span>
            </div>
            <div class="row">
              <span class="note_title">shipping fee</span>
              <span class="note_sep">:</span>
              <span id="txt_shipping_fee" class="note_data">IDR 0</span>
            </div>
            <div class="row">
              <span class="note_title">Purchase Point</span>
              <span class="note_sep">:</span>
              <span id="txt_point" class="note_data">9</span>
            </div>          
            <div class="row">
              <span class="note_title"><strong>grand total</strong></span>
              <span class="note_sep">:</span>
              <span id="txt_grand_total" class="note_data">IDR 0</span>
            </div>                                                  
          </div>              
        </div>
        <!--end rightorderbox-->        
        <h5 class="paymethod">How would you like to pay for your order?</h5>
        <?php
        $data = get_payment_list();
        
        if ($data["result"]) {
          foreach ($data["result"] as $row) {
            $id = $row->id;
            $payment_name = $row->payment_name;
            $rek_no = $row->rek_no;
            echo "
              <div class='row_paymethod'>
                <input type='radio' name='paymethod' value='".$id."' id='paymethod".$id."'><label for='paymethod".$id."'></label><span>".$payment_name."</span>          
              </div>					
            ";
          }
        }
        ?>      

        <div class="rowinput">
          <input type="hidden" id="order_firstname" name="order_firstname" value="" />
          <input type="hidden" id="order_lastname" name="order_lastname" value="" />
          <input type="hidden" id="order_street_address" name="order_street_address" value="" />
          <input type="hidden" id="order_phone" name="order_phone" value="" />
          <input type="hidden" id="order_zip_code" name="order_zip_code" value="" />
          <input type="hidden" id="order_country" name="order_country" value="" />
          <input type="hidden" id="order_city" name="order_city" value="" />
          <input type="hidden" id="order_payment_name" name="order_payment_name" value="" />
          <input type="hidden" id="order_payment_account" name="order_payment_account" value="" />
          <input type="hidden" id="order_payment_account_name" name="order_payment_account_name" value="" />
          <input type="hidden" id="order_voucher_code" name="order_voucher_code" value="" />
          <input type="hidden" id="order_discount" name="order_discount" value="0" />
          <input type="hidden" id="order_referral" name="order_referral" value="" />
          <input id="btn_checkout" type="image" src="/images/layout/order/btnchkout.png" />
        </div>  
      </form>
      <!--END wrapaddressbox-->
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
require_once($dir . "content/footer.php");
?>