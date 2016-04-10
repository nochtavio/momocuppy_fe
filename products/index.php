<?php
  ob_start();
  $body = "product";
  $dir = "../../";
  $css = "main,product,simplebar,message,scrollpane";
  $js = "mousewheel,scrollpane,product-list,zoom.min";
  require_once($dir . "core/conn/config.php");
  require_once($dir . "core/conn/db.php");
  require_once($dir . "lib/products/get_category.php");
  require_once($dir . "lib/products/get_products.php");
  require_once($dir . "content/header.php");


  $type = 0;
  if (isset($_GET["type"]) && is_numeric($_GET["type"])) {
    $type = $_GET["type"];
  }

  $cat = 1;
  if (isset($_GET["cat"]) && is_numeric($_GET["cat"])) {
    $cat = $_GET["cat"];
  }

  $p = 1;
  if (isset($_GET["p"]) && is_numeric($_GET["p"])) {
    $p = $_GET["p"];
  }
  $rowspage = 9;


  if ($type == 1) {
    $varmaincat = "Home Decor";
  } elseif ($type == 2) {
    $varmaincat = "Accessories";
  } else {
    $varmaincat = "";
  }
?>  

<!--MAINCONTENT-->
<div id="maincontent">
    <div id="wrapproduct">
        <div class="content">
            <!--START MENU CATEGORIES-->
            <ul class="categories">
                <li class="main"><a href="#" class="selected"><?php echo $varmaincat; ?></a></li>

                <?php
                  //fetch category list
                  $data_menu = get_category_list($type, 200, 1);
                  if ($data_menu["result"]) {
                    foreach ($data_menu["result"] as $row) {
                      $idcat = $row->id;
                      $namecat = $row->category_name;
                      echo "<li><a " . is_selected($idcat, $cat, "class=\"selected\"", "") . " href=\"/products/list/?type=" . $type . "&amp;cat=" . $idcat . "#wrapproduct\">" . $namecat . "</a></li>";
                    }
                  }
                  //end fetch category list
                ?>                       
            </ul>
            <!--END MENU CATEGORIES-->      

            <!--START PRODUCT ITEM-->
            <div class="wraplistitem">
                <ul class="productitem">
                    <?php
                      $data = get_products_list($type, $cat, $rowspage, $p);

                      $maxpage = 1;
                      if (isset($data["maxpage"])) {
                        $maxpage = $data["maxpage"];
                      }

                      if ($data["result"]) {
                        foreach ($data["result"] as $row) {
                          $id = $row->id;
                          $product_name = $row->product_name;
                          $product_price = $row->product_price;
                          $product_img = $row->img;
                          $cretime = $row->cretime;

                          $nowtime = strtotime(date("d M Y"));

                          $diff = $nowtime - strtotime($cretime);
                          $tickernew = "";
                          if ($diff <= 302400) {
                            $tickernew = "<span class=\"tickernew\"></span>";
                          }
													
													if(isset($product_img)){
														$varimg = "/mmcp/images/products/" . $product_img ;
													}else{
														$varimg = "/images/products/no-img-potrait.jpg";													
													}
													
													$stock = get_stock($id);

													list($width, $height) = getimagesize("../..".$varimg);
													if ($width > $height) {
															// Landscape
														$varclass = "landscape";
													} else {
															// Portrait or Square
														$varclass = "potrait";															
													}
												
													if($stock == 0){
														echo "
														<li>
															<a class=\"linkproduct\" href=\"#\">
																<div class=\"listitem ".$varclass."\">
																	<img src=\"".$varimg."\"  />
																	
																</div>
																<span class=\"productname\">" . $product_name . "</span>
																<span class=\"productprice\">IDR " . number_format($product_price, 0, "", ".") . "</span>            
																" . $tickernew . "
																<div class=\"soldout\"><img src=\"/images/products/soldout.png\" /></div>
															</a>          
														</li> 						
														";												
													}else{
													
														echo "
														<li>
															<a class=\"linkproduct\" href=\"/products/detail/?type=" . $type . "&amp;id_product=" . $id . "\">
																<div class=\"listitem ".$varclass."\">
																	<span><img src=\"".$varimg."\" /><span>
																</div>
																<span class=\"productname\">" . $product_name . "</span>
																<span class=\"productprice\">IDR " . number_format($product_price, 0, "", ".") . "</span>            
																" . $tickernew . "
															</a>          
														</li> 						
														";													
													
													}


                        }
                      } else {
                        echo "No data available right now for this category...";
                      }
                    ?>

                </ul>             

                <?php
                  $url = "/products/list/?type=" . $type . "&cat=" . $cat . "";
                  $anchor = "#maincontent";
                  echo page($maxpage, $p, $url, $anchor);
                ?>        
            </div>      
            <!--END PRODUCT ITEM-->

            <!--START SHOPPING BAG-->
            <div id="shoppingbag">
                <h3>Shopping Bag</h3>
                <div id="div-hidden"></div>
                <div id="shopbagtitle">
                    <span class="item">ITEM</span>
                    <span class="qty">QTY</span>
                    <span class="price">PRICE</span>                              
                </div>
                <ul id="shopbaglist" class="shopbaglist simplebar">

                </ul>
                <div id="shopbagsum">
                    <span class="title">TOTAL</span>
                    <span class="currency">IDR (Rp)</span>
                    <span id="txt_totalprice" class="totalprice"><strong>0</strong></span>                              
                </div>  
                <div class="wrapchkbtn">
                    <a href="/order/"><span>Check Out</span></a>
                </div>     
            </div>
            <!--END SHOPPING BAG-->      

            <!--start payment channel-->
            <div class="payment_channel">
                <img src="/images/layout/products/payment-list.png" />
            </div>

            <div class="shipping_list">
                <img src="/images/layout/products/shipping-list.png" />
            </div>      
            <!--end payment channel-->      
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