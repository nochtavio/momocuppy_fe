<?php 
require_once($dir."lib/cart/cart.php");
$varclass = "";
$varclasssearch = "";
$loginstate = 0;
if (isset($_SESSION['email']) && isset($_SESSION['status_login'])) {
  //Validate Login
  if($_SESSION['status_login'] == sha1('momocuppy123' . $_SESSION['email'])){
    $loginstate = 1;
    $varclass = "class=\"afterlogin\"";
		$varclasssearch = "class=\"afterloginsearch\"";
  }
	
	$countcart = count_cart($_SESSION['email']);
}
?>
<div id="tickermenu" <?php echo $varclass;?>>
  <form name="search" action="/search/" method="get" id="frmsearch">
    <input id="txt_search" class="inputtxt search" type="text" name="key" placeholder="Search" autocomplete="off"/>
    <input class="submitsearch"  type="image" src="/images/layout/icons/magnifier.gif" value="submit_search"/>
  </form>
  <div id="account_info">       
    <?php 
      if($loginstate == 1){
        ?>
          <div class="row-logged">            
            <a href="/member/userprofile/order_history/" class="accountinfo">My Account</a>            
            <span>/</span>            
            <a href="/order/#maincontent" class="shopcart">              
              <span class="shopchartinfo"><img src="/images/layout/icons/shopcart.gif" width="24"></span>              
              <span class="shopcount">(<?php echo $countcart;?>)</span>            
            </a>          
          </div>          
          <div class="rowlogout">            
            <a id="mfp_logout" href="http://www.momocuppy.com/mmcp/api/member_logout">Log out</a>          
          </div>
        <?php
      }else{
        ?>
          <a href="#" class="accountinfo" id="mfp_login">Login</a>          
          <span>/</span>          
          <a href="/member/register/" class="accountinfo" id="mfp_register">Register</a>
        <?php
      }
    ?>
  </div>
  <div id="searchresult" <?php echo $varclasssearch;?>>
    <ul id="searchlist">

    	              
    </ul>
  </div>
</div>