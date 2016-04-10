<?php
ob_start();
$body = "product";
$dir = "../../";
$css = "main,product,simplebar,gallery";
$js = "simplebar,zoom.min,gallery,product-detail";
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
?>  

<!--MAINCONTENT-->
<div id="maincontent">
  <div id="wrapdetail">
    <div class="content"> 
      <!--GALLERY-->
      <div id="gallery">
        <div class="simpleLens-gallery-container" id="demo-1">
          <div class="simpleLens-container">
            <div class="simpleLens-big-image-container">
              <a class="simpleLens-lens-image" img-lens="/images/products/cth/1l.jpg">
                <img src="/images/products/cth/1.jpg" class="simpleLens-big-image">
              </a>
            </div>
          </div>

          <div class="simpleLens-thumbnails-container">
            <a href="#" class="simpleLens-thumbnail-wrapper" img-lens="/images/products/cth/1l.jpg" big-img="/images/products/cth/1.jpg">
              <img src="/images/products/cth/1.jpg" width="119" height="192">
            </a>

            <a href="#" class="simpleLens-thumbnail-wrapper" img-lens="/images/products/cth/2l.jpg" big-img="/images/products/cth/2.jpg">
              <img src="/images/products/cth/2.jpg" width="119" height="192">
            </a>

            <a href="#" class="simpleLens-thumbnail-wrapper" img-lens="/images/products/cth/1l.jpg" big-img="/images/products/cth/1.jpg">
              <img src="/images/products/cth/1.jpg" width="119" height="192">
            </a>

            <a href="#" class="simpleLens-thumbnail-wrapper" img-lens="/images/products/cth/2l.jpg" big-img="/images/products/cth/2.jpg">
              <img src="/images/products/cth/2.jpg" width="119" height="192">
            </a>              
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
              <p>
                " . $product_desc . "
              </p>
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

          <div class="row-form">
            <div class="wraporder">
              <a href="#addtocart" id="addtocart_prod">add to cart</a>
              <span class="sep">|</span>
              <a href="#checkout" id="checkout_prod">check out</a>
            </div>
            <div class="wrapwishlist">
              <a href="#wishlist">add to wishlist</a>
            </div>
          </div>                 
        </form>
        <!--form detail-->        

        <div id="shoppingbag" class="prod_detail_shopbag">
          <h3>Shopping Bag</h3>
          <div id="div-hidden">
            
          </div>
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
            <a href="#"><span>Check Out</span></a>
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
            <ul class=\"productitem\">						
          ";


        foreach ($related as $rowrelated) {
          $cretime = $rowrelated->cretime;
          $nowtime = strtotime(date("d M Y"));
          $diff = $nowtime - strtotime($cretime);
          $tickernew = "";
          if ($diff <= 302400) {
            $tickernew = "<span class=\"tickernew\"></span>";
          }
          echo "
          <li>
            <a class=\"linkproduct\" href=\"/products/detail/?type=" . $rowrelated->type . "&amp;id_product=" . $rowrelated->id . "\">
            <div class=\"listitem\">
              <span><img src=\"/mmcp/images/products/" . $rowrelated->img . "\" height=\"312\" width=\"188\"/></span>
            </div>
            <span class=\"productname\">" . $rowrelated->product_name . "</span>
            <span class=\"productprice\">IDR " . number_format($rowrelated->product_price, 0, "", ".") . "</span>            
            " . $tickernew . "
            </a>          
          </li>														
          ";
        }
        echo "</ul></div>						
        ";
      }
      ?>                                         

    </div>
  </div>
  <!--MAINCONTENT-->  

  <?php
  require_once($dir . "content/footer.php");
  ?>