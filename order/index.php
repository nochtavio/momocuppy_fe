<?php

$body = "order";
$dir = "../";
$css = "main,simplebar,order,message,scrollpane";
$js = "mousewheel,scrollpane,order";
//Maintain Session

require_once($dir . "core/conn/config.php");
require_once($dir . "core/conn/db.php");
require_once($dir . "content/header.php");

unset($_SESSION['order_no']);
unset($_SESSION['grand_total']);
unset($_SESSION['point']);
unset($_SESSION['payment_name']);
unset($_SESSION['payment_account']);
unset($_SESSION['payment_account_name']);
unset($_SESSION["order_page"]);

$_SESSION["order_page"] = "order1";
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

          <li><a class="selected" href="/order/#maincontent"><span>summary</span></a></li>

          <li><a href="/order/order2.php#maincontent"><span>shipping address</span></a></li>

          <li><a href="#"><span>done</span></a></li>                    

        </ul>

      </div>

      

      <!--start summary_detail-->

      <div class="summary_detail">

        <span class="infobag">Your shopping bag contains <span id="txt_total_products"></span> product(s)</span>

        <ul class="titlesummary">

          <li class="order_item">item</li>

          <li class="order_item">description</li>          

          <li class="order_item">quantity</li>          

          <li class="order_item">color</li>          

          <li class="order_item">price</li>          

          <li class="order_item">remove</li>          

          <li class="order_item">weight/volume</li>          

          <li class="order_item">total</li>          

        </ul>



        <div id="shoppingbag">

          <div id="div-hidden"></div>

          <ul id="shopbaglist" class="shopbaglist simplebar">

          </ul>                            

        </div>        

      </div>

      <!--end summary_detail-->      



      <div class="wrapinfoorder cartelement">

        <form name="voucher_claim" class="voucher_claim" method="post" action=".">



		  <div class="row">
	          <label>voucher code</label>          
    	      <input type="text" class="txt" id="vouchercode" name="vouchercode"/>          
	          <input id="add_voucher" type="button" class="submit" value="add"/>                
          </div>			
          
          <div class="row">
              <label>referral code</label>          
              <input type="text" class="txt" id="referralcode" name="referralcode"/>                    
	          <input id="add_referral" type="button" class="submit" value="add"/>                
          </div>                  

        </form>



        <div class="summarynote">

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

      

      <div class="wrapshipping cartelement">

        <h3 class="shipping_header">shipping options</h3>

        <form name="checkout" action="./confirm/" class="checkout">

          <div class="row">

            <input type="radio" name="radshipping" value="REG" id="radshipping1" checked="checked"/><label for="radshipping1"></label><span>JNE</span>          

          </div>

          <div class="row">

            <input type="radio" name="radshipping" value="YES" id="radshipping2"/><label for="radshipping2"></label><span>JNE Express / YES</span>          

          </div>

        </form>

        <ul class="order_note">

          <li class="important">

            <span class="bull">&bull;</span>

            <span> Order is unable be modified once it has been completed</span>

          </li>

          <li>

            <span class="bull">&bull;</span>

            <span> Please note that your item(s) will be secured once you received the confimation</span>

        </ul>

      </div>  



      <!--start buttoncheckout-->    

      <div class="wrapbtnchkout cartelement">

        <a href="/" class="btnback"><img src="/images/layout/order/btnback.png" /></a>

        <span class="sepbtn"></span>

        <a href="/order/order2.php#summary" class="btnchkout"><img src="/images/layout/order/btnchkout.png" /></a>        

      </div>

      <!--end buttoncheckout-->          



    </div>  	

  </div>

</div>

<!--MAINCONTENT-->  

<div id="mfp_message" class="mfp-hide white-popup-block mfp-alert">
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

<div id="mfp_message" class="mfp-hide white-popup-block mfp-question">
	<h2>
  	<img src="/images/layout/message/decor.png" />
  </h2>
  
  <h3 class="titlemsg">Oops..!</h3>
  
  <input type="hidden" id="txt_remove_id" />
	<p class="message">
  	Are you sure you want to remove this item?    
  </p>
  
  <div class="wrapbtn">    
    <div class="yesbtn" id="yesbtn">
      <span>yes</span>
    </div>   
    <div class="nobtn" id="nobtn">
      <span>no</span>
    </div>         
  </div>  
</div>


<?php

require_once($dir . "content/footer.php");

?>