<?php

  ob_start();

  $body = "product";

  $dir = "../../";

  $css = "main,product,gallery,message,scrollpane";

  $js = "mousewheel,scrollpane,gallery,product-detail,redeem,zoom.min";

  require_once($dir . "core/conn/config.php");

  require_once($dir . "core/conn/db.php");

  require_once($dir . "lib/products/get_products.php");

  require_once($dir . "content/header.php");



  $id_product = 0;

  if (isset($_GET["id_product"]) && is_numeric($_GET["id_product"])) {

    $id_product = $_GET["id_product"];

  }

  $type = 1;

  if (isset($_GET["type"]) && is_numeric($_GET["type"])) {

    $type = $_GET["type"];

  }

	

	$stockdetail = get_stock($id_product);

	$varnostock = "";
	if($stockdetail == 0){
		//header("location:/products/list/?type=".$type."");
		//exit;
		$varnostock = "<div class=\"outofstock\">Sorry, this product is currently unavailable.</div>";
	}



	

?>  



<input type="hidden" id="txt_id_product" value="<?php echo $id_product; ?>" />

<!--MAINCONTENT-->

<div id="maincontent">

    <div id="wrapdetail">

        <div class="content"> 

            <!--GALLERY-->

            <div id="gallery">

                <div class="simpleLens-gallery-container" id="demo-1">

                

                

                		<?php 

										$first = get_prodimg_first($id_product);

										if($first){

											echo "

											<div class=\"simpleLens-container\">

													<div class=\"simpleLens-big-image-container\">

															<a class=\"simpleLens-lens-image\" img-lens=\"/mmcp/images/products/".$first->img."\">

																	<img src=\"/mmcp/images/products/".$first->img."\" class=\"simpleLens-big-image\">

															</a>

													</div>

											</div>											

											";

										}else{
											echo "

											<div class=\"simpleLens-container\">

													<div class=\"simpleLens-big-image-container\">

																<img src=\"/images/products/no-img-potrait.jpg\" class=\"simpleLens-big-image\">

													</div>

											</div>											

											";										
										}

										?>



                    <div class="simpleLens-thumbnails-container">

												

                        <?php 

												$prodimg = get_prodimg($id_product);

												if($prodimg){

													foreach($prodimg as $row){

														

														list($width, $height) = getimagesize("../../mmcp/images/products/" . $row->img."");

														if ($width > $height) {

																// Landscape

															$varclass = "landscape";

														} else {

																// Portrait or Square

															$varclass = "potrait";															

														}															

														

														echo "

															<a href=\"#\" class=\"simpleLens-thumbnail-wrapper\" img-lens=\"/mmcp/images/products/".$row->img."\" big-img=\"/mmcp/images/products/".$row->img."\">

															<img class=\"".$varclass."\" src=\"/mmcp/images/products/".$row->img."\"  >

															</a>

														";

													}

												}

												?>

                        

                                  

                    </div>

                    

                </div>      

            </div>      

            <!--END GALLERY-->



            <!--PRODINFO-->

            <div id="prodinfo">



                <?php

                  //get product detail

                  $detail = get_product_detail($id_product);

                  if ($detail) {

                    $product_name = $detail->product_name;

                    $product_desc = $detail->product_desc;

                    $product_price = "IDR " . number_format($detail->product_price, 0, "", ".");



                    echo "

										<h2 class=\"title\">" . $product_name . "</h2>

										<div class=\"desc\">

											

                " . $product_desc . "

              

										</div>	

										<span class=\"tagprice\">" . $product_price . "</span>				

										";

                  } else {

                    header("location:/products/?type=" . $type . "");

                    exit;

                  }

                ?>









                <!--form detail-->

                <form name="detail-order" id="detail-order" action="#" method="post">





                    <?php

                      //get color list

                      $result = get_product_color_list($id_product);

                      if ($result) {

                        echo "

            <div class=\"row-form\">

              <span>Color</span>								

              <select id=\"txt_id_dt_product\" name=\"color\">";

                        foreach ($result as $row) {

                          $idcolor = $row->id;

                          $colorname = $row->color_name;

                          echo "<option value=\"" . $idcolor . "\">" . $colorname . "</option>";

                        }

                        echo "</select> </div>";

                      }

                    ?>                      



										<?php 
										if(strlen($varnostock) <= 0){
											?>
                      <div class="row-form"> 
  
                          <span>Quantity</span>
  
                          <select id="txt_qty" name="qty">
  
                              <?php
  
                                for ($i = 1; $i <= 10; $i++) {
  
                                  echo "<option value=\"" . $i . "\">" . $i . "</option>";
  
                                }
  
                              ?>
  
  
  
                          </select>  
  
                      </div>                       
											<?php
										}
										?>

 

                    

                    <?php 

										$email = isset($_SESSION['email']) ? $_SESSION['email'] : "";

										if($email != ""){

											$varaddcart = "<a href=\"#addtocart\" id=\"addtocart_prod\">add to cart</a>";

											$varcheckout = "<a href=\"/order/#maincontent\" id=\"checkout_prod\">check out</a>";

											$varwish = "<a href=\"#wishlist\" id=\"addtowishlist_prod\">add to wishlist</a>";

										}else{

											$varaddcart = "<a href=\"#\" class=\"forcelogin\">add to cart</a>";

											$varcheckout = "<a href=\"#\" id=\"checkout_prod\" class=\"forcelogin\">check out</a>";

											$varwish = "<a href=\"#\" class=\"forcelogin\">add to wishlist</a>";											

										}

										

										?>



                    <div class="row-form">

                        
                        
                        <?php 
												if(strlen($varnostock) > 0){
													echo $varnostock;
												}else{
													echo "<div class=\"wraporder\">".$varaddcart."<span class=\"sep\">|</span>".$varcheckout."</div>";
												}
												?>

                        

                        <div class="wrapwishlist">

                            <?php echo $varwish;?>

                        </div>

                    </div>                 

                </form>

                <!--form detail-->        



                <div id="shoppingbag" class="prod_detail_shopbag">

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

            </div>

            <!--PRODINFO-->

            <div class="prodnav">

                <?php

                  $prod_nav = product_next_prev($id_product);



                  if ($prod_nav["prev"]) {

                    $idprev = $prod_nav["prev"]->id_product;

                    echo "<a href=\"/products/detail/?id_product=" . $idprev . "#wrapdetail\" class=\"prevbtn\"><span>prev</span></a>";

                  }



                  if ($prod_nav["next"]) {

                    $idnext = $prod_nav["next"]->id_product;

                    echo "<a href=\"/products/detail/?id_product=" . $idnext . "#wrapdetail\" class=\"nextbtn\"><span>next</span></a>";

                  }

                ?>             

            </div>







            <?php

              $related = get_related($id_product, $type);

              if ($related) {

												echo "

									<h2 class=\"prodrelated\">You may also like</h2>

				

									<div class=\"wraplistitem listitemrelated\">

										<ul class=\"productitem related_product\">						

									";





                foreach ($related as $rowrelated) {

                  $cretime = $rowrelated->cretime;

                  $nowtime = strtotime(date("d M Y"));

                  $diff = $nowtime - strtotime($cretime);

                  $tickernew = "";

                  if ($diff <= 302400) {

                    $tickernew = "<span class=\"tickernew\"></span>";

                  }

									

									$stock = get_stock($rowrelated->id);

									if(isset($rowrelated->img)){
										$varimg = "/mmcp/images/products/" . $rowrelated->img ;
									}else{
										$varimg = "/images/products/no-img-potrait.jpg";													
									}

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

											<a class=\"linkproduct\" href=\"/products/detail/?type=" . $rowrelated->type . "&amp;id_product=" . $rowrelated->id . "\">

												<div class=\"listitem ".$varclass."\">

													<img src=\"". $varimg ."\"  width=\"188\"/>

												</div>

												<span class=\"productname\">" . $rowrelated->product_name . "</span>

												<span class=\"productprice\">IDR " . number_format($rowrelated->product_price, 0, "", ".") . "</span>            

												" . $tickernew . "

												<div class=\"soldout\"><img src=\"/images/products/soldout.png\" /></div>											

											</a>          

										</li>														

										";										

									}else{

									

										echo "

										<li>

											<a class=\"linkproduct\" href=\"/products/detail/?type=" . $rowrelated->type . "&amp;id_product=" . $rowrelated->id . "\">

											<div class=\"listitem ".$varclass."\">

												<span><img src=\"". $varimg ."\"  width=\"188\"/></span>

											</div>

											<span class=\"productname\">" . $rowrelated->product_name . "</span>

											<span class=\"productprice\">IDR " . number_format($rowrelated->product_price, 0, "", ".") . "</span>            

											" . $tickernew . "

											</a>          

										</li>														

										";									

									}

									



                }

                echo "</ul></div>						

        ";

              }

            ?>                                         



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

        <div class="nobtn" id="nobtn">

          <span>no</span>

        </div>       

      

        <div class="yesbtn" id="yesbtn">

          <span>yes</span>

        </div>  

        

   

      </div>  

    </div>



    <?php

      require_once($dir . "content/footer.php");

    ?>