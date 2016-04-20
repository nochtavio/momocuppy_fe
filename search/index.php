<?php 
  ob_start();
  $body = "product";
  $dir = "../";
  $css = "main,product,simplebar,message,scrollpane,search";
  $js = "mousewheel,scrollpane,zoom.min";
  require_once($dir . "core/conn/config.php");
  require_once($dir . "core/conn/db.php");
  require_once($dir . "lib/products/get_category.php");
  require_once($dir . "lib/products/get_products.php");
  require_once($dir . "content/header.php");

  $type = 0;
  if (isset($_GET["type"]) && is_numeric($_GET["type"])) {
    $type = $_GET["type"];
  }

  $cat = 0;
  if (isset($_GET["cat"]) && is_numeric($_GET["cat"])) {
    $cat = $_GET["cat"];
  }

  $p = 1;
  if (isset($_GET["p"]) && is_numeric($_GET["p"])) {
    $p = $_GET["p"];
  }
  $rowspage = 9;
	
	$keywords = NULL;	
	if(isset($_GET["key"])){
		$keywords = trim(urldecode($_GET["key"]));
		if(strlen($keywords) < 3 || strlen($keywords) > 20){
			$keywords = NULL;
		}
	}
	


?>
<!--MAINCONTENT-->
<div id="maincontent">
    <div id="wrapproduct">
        <div class="content">


            <!--START MENU SEARCH-->
            <div class="wrapmenu">
              <ul class="type_search">
                <li class="first">Type <span class="arrow">V</span></li>
                <li><a href="/search/?key=<?php echo urlencode($keywords);?>" <?php echo is_selected($type,0,"class=\"selected\"","");?>>All</a></li>
                
                <?php 
								$rstype = get_producttype();
								foreach($rstype as $rowtype){
									echo "<li><a href=\"/search/?type=".$rowtype->id."&amp;key=".urlencode($keywords)."\" ".is_selected($type,$rowtype->id,"class=\"selected\"","").">".$rowtype->type_name."</a></li>";
								}
								?>
                
          
              </ul>
              
              <?php 
							if($type != 0){
								echo "<ul class=\"type_search cat_search\"><li class=\"first\">Category <span class=\"arrow\">V</span></li>";
								$data_menu = get_category_list($type, 200, 1);
								if ($data_menu["result"]) {
									echo "<li><a href=\"/search/?type=".$type."&amp;cat=0&amp;key=".urlencode($keywords)."\" ".is_selected($cat,0,"class=\"selected\"","").">All</a></li>";
									foreach ($data_menu["result"] as $row) {
										$idcat = $row->id;
										$namecat = $row->category_name;			
										
										echo "<li><a href=\"/search/?type=".$type."&amp;cat=".$idcat."&amp;key=".urlencode($keywords)."\" ".is_selected($cat,$idcat,"class=\"selected\"","").">".$namecat."</a></li>";							
									}
								}
								?>
                  
                             
                <?php
								echo "</ul>";
							}
							?>
            
            </div>                 
            <!--END MENU SEARCH-->

            <!--START PRODUCT ITEM-->
            <div class="wraplistitem searchpage">
            		<div class="searchitem">
                                	
                	<span>Search Result for : '<?php echo $keywords ?>'</span>
                </div>
                <ul class="productitem">
                    <?php
											if($keywords != NULL){
	                      $data = get_products_list($type, $cat, $rowspage, $p, $keywords);												
											}else{
												$data = false;
											}

                      $maxpage = 1;
                      if (isset($data["maxPage"])) {
                        $maxpage = $data["maxPage"];
                      }
											
										

                      if ($data["result"]) {
                        foreach ($data["result"] as $row) {
                          $id = $row->id;
                          $product_name = $row->product_name;
													
													if(strlen($product_name) > 22){
														$product_name = substr($product_name,0,19)."...";
													}
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

													list($width, $height) = getimagesize("..".$varimg);
													if ($width > $height) {
															// Landscape
														$varclass = "landscape";
													} else {
															// Portrait or Square
														$varclass = "potrait";															
													}
													
													//sale / not
													$varsale = "";													
													if($row->sale == 1){
														$varsale = "<span class=\"sale\"><img src=\"/images/layout/products/sale.png\" /></span>";
													}													
												
													if($stock == 0){
														echo "
														<li>
															<a class=\"linkproduct\" href=\"/products/detail/?type=" . $row->type . "&amp;id_product=" . $id . "\">
																<div class=\"listitem ".$varclass."\">
																	<img src=\"".$varimg."\"  />
																	
																</div>
																<span class=\"productname\">" . $product_name . "</span>
																<span class=\"productprice\">IDR " . number_format($product_price, 0, "", ".") . "</span>            
																" . $tickernew . "
																<div class=\"soldout\"><img src=\"/images/products/soldout.png\" /></div>
																" . $varsale . "																	
															</a>          
														</li> 						
														";												
													}else{
													
														echo "
														<li>
															<a class=\"linkproduct\" href=\"/products/detail/?type=" .  $row->type . "&amp;id_product=" . $id . "\">
																<div class=\"listitem ".$varclass."\">
																	<span><img src=\"".$varimg."\" /><span>
																</div>
																<span class=\"productname\">" . $product_name . "</span>
																<span class=\"productprice\">IDR " . number_format($product_price, 0, "", ".") . "</span>            
																" . $tickernew . "
																" . $varsale . "																	
															</a>          
														</li> 						
														";													
													
													}


                        }
                      } else {
												if($keywords == false){
													echo "Keywords must be more than 3 characters and less than 20 characters";
												}else{
	                        echo "No data found";													
												}
                      }
                    ?>

                </ul>             

                <?php
                  $url = "/search/?type=" . $type . "&cat=" . $cat . "&key=" .urlencode($keywords) . "";
                  $anchor = "#maincontent";
                  echo page($maxpage, $p, $url, $anchor);
                ?>        
            </div>      
            <!--END PRODUCT ITEM-->



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
<?php
	
  require_once($dir . "content/footer.php");	
	
	
?>