<?php 
ob_start();
$body = "product";
$dir = "../../";
$css = "main,product";
$js = "";
$body = "product";
require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/products/get_category.php");
require_once($dir."content/header.php");

$type = 0;
if(isset($_GET["type"]) && is_numeric($_GET["type"])){
	$type = $_GET["type"];
}else{
	header("location:/");
	exit;
}
$p = 1;
if(isset($_GET["p"]) && is_numeric($_GET["p"])){
	$p = $_GET["p"];
}
$rowspage = 9;
?>  
  
<!--MAINCONTENT-->
<div id="maincontent">
	<div id="wrapproduct">
  	<div class="content">
    	<h2><img src="/images/products/maincategory/<?php echo $type;?>.png" /></h2>
      
      <ul class="listcategory" id="list_category">
      
      	<?php 			
				
				$data = get_category_list($type,$rowspage,$p);
				
				$maxpage = 1;
				if(isset($data["maxPage"])){
					$maxpage = $data["maxPage"];					
				}
				
				if($data["result"]){
					foreach($data["result"] as $row){
						$idcat = $row->id;
						$img = $row->img;
						$img_hover = $row->img_hover;
						echo "
						<li>
							<a href=\"/products/list/?type=".$type."&amp;cat=".$idcat."#maincontent\">
								<img class=\"no-slide\" src=\"/mmcp/images/category/".$img."\" width=\"269\" height=\"269\"/>       
								<img class=\"slide\" src=\"/mmcp/images/category/".$img_hover."\" width=\"269\" height=\"269\"/>
							</a>          
						</li>																						
						";
					}
				}			
				?>                          
      </ul>              
    </div>
      <?php 
			$url = "/products/category/?type=".$type."";
			$anchor = "#list_category";
			$totalpage = $maxpage;
			echo page($totalpage,$p,$url,$anchor);
			?>   
     
  </div>
</div>
<!--MAINCONTENT-->  
  
<?php 
require_once($dir."content/footer.php");
?>