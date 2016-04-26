<?php 
ob_start();
$body = "order";
$dir = "../";
$css = "main,simplebar,order";
$js = "print";
require_once($dir . "core/conn/db.php");
require_once($dir . "lib/member/member.php");
require_once($dir . "lib/member/order_history.php");

//Maintain Session
session_start();

$order_no = $_SESSION["order_no"];
$memberid = get_memberid($_SESSION["email"]);
if(!$memberid){
	header("location:/order/");
	exit;
}




$list = order_history_summary($order_no);
if($list){
	$firstname = $list->firstname;
	$lastname = $list->lastname;
	$street_address = strtoupper($list->street_address);
	$city = strtoupper($list->city);
	$zip_code = $list->zip_code;
	$country = strtoupper($list->country);
	$payment_name = strtoupper($list->payment_name);
	$payment_account = strtoupper($list->payment_account);	
	$payment_account_name = strtoupper($list->payment_account_name);
  $discount  = $list->discount;
	$shipping_cost  = $list->shipping_cost;
	$cretime = $list->cretime;
	
	$id_member = $list->id_member;
}else{
	header("location:/order/");
	exit;		
}

if($id_member != $memberid){
	header("location:/order/");
	exit;	
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <!-- Facebook sharing information tags -->
        <meta property="og:title" content="*|MC:SUBJECT|*" />
        
        <title>INVOICE #<?php echo $order_no;?></title>
		<style type="text/css">
			@import url(https://fonts.googleapis.com/css?family=Lobster);
			/* Client-specific Styles */
			#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
			body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
			body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */

			/* Reset Styles */
			body{margin:0; padding:0;}
			img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
			table td{border-collapse:collapse;}
			#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}

			/* Template Styles */

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: COMMON PAGE ELEMENTS /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Page
			* @section background color
			* @tip Set the background color for your email. You may want to choose one that matches your company's branding.
			* @theme page
			*/
			body, #backgroundTable{
				/*@editable*/ background-color:#FAFAFA;
			}

			/**
			* @tab Page
			* @section email border
			* @tip Set the border for your email.
			*/
			#templateContainer{
				/*@editable*/ border: 1px solid #DDDDDD;
			}

			/**
			* @tab Page
			* @section heading 1
			* @tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
			* @style heading 1
			*/
			h1, .h1{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:34px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Page
			* @section heading 2
			* @tip Set the styling for all second-level headings in your emails.
			* @style heading 2
			*/
			h2, .h2{
				/*@editable*/ color:#f05464;
				display:block;
				/*@editable*/ font-family:Lobster;
				/*@editable*/ font-size:30px;
				/*@editable*/ font-weight:700;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Page
			* @section heading 3
			* @tip Set the styling for all third-level headings in your emails.
			* @style heading 3
			*/
			h3, .h3{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:26px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Page
			* @section heading 4
			* @tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
			* @style heading 4
			*/
			h4, .h4{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:22px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: HEADER /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Header
			* @section header style
			* @tip Set the background color and border for your email's header area.
			* @theme header
			*/
			#templateHeader{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border-bottom:0;
			}

			/**
			* @tab Header
			* @section header text
			* @tip Set the styling for your email's header text. Choose a size and color that is easy to read.
			*/
			.headerContent{
				/*@editable*/ color:#202020;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:34px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				/*@editable*/ padding:0;
				/*@editable*/ text-align:left;
				/*@editable*/ vertical-align:middle;
			}
			.headerContent img{
				margin:10px 0 0 20px;
			}
			
			/**
			* @tab Header
			* @section header link
			* @tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
			*/
			.headerContent a:link, .headerContent a:visited, /* Yahoo! Mail Override */ .headerContent a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			#headerImage{
				height:auto;
				max-width:600px !important;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: MAIN BODY /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Body
			* @section body style
			* @tip Set the background color for your email's body area.
			*/
			#templateContainer, .bodyContent{
				/*@editable*/ background-color:#FFFFFF;
			}

			/**
			* @tab Body
			* @section body text
			* @tip Set the styling for your email's main content text. Choose a size and color that is easy to read.
			* @theme main
			*/
			.bodyContent div{
				/*@editable*/ color:#505050;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:14px;
				/*@editable*/ line-height:150%;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Body
			* @section body link
			* @tip Set the styling for your email's main content links. Choose a color that helps them stand out from your text.
			*/
			.bodyContent div a:link, .bodyContent div a:visited, /* Yahoo! Mail Override */ .bodyContent div a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			/**
			* @tab Body
			* @section data table style
			* @tip Set the background color and border for your email's data table.
			*/
			.templateDataTable{
				/*@editable*/ background-color:#fbe0e6;
				/*@editable*/ border-radius:5px;
			}
			
			/**
			* @tab Body
			* @section data table heading text
			* @tip Set the styling for your email's data table text. Choose a size and color that is easy to read.
			*/
			.dataTableHeading{
				/*@editable*/ background-color:#fbe0e6;
				border-radius:5px;
				/*@editable*/ color:#f05b6b;
				/*@editable*/ font-family:Helvetica;
				/*@editable*/ font-size:14px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				overflow:hidden;
				/*@editable*/ text-align:left;
			}
		
			/**
			* @tab Body
			* @section data table heading link
			* @tip Set the styling for your email's data table links. Choose a color that helps them stand out from your text.
			*/
			.dataTableHeading a:link, .dataTableHeading a:visited, /* Yahoo! Mail Override */ .dataTableHeading a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#f596a1;
				/*@editable*/ font-weight:bold;
				/*@editable*/ text-decoration:none;
			}
			
			/**
			* @tab Body
			* @section data table text
			* @tip Set the styling for your email's data table text. Choose a size and color that is easy to read.
			*/
			.dataTableContent{
				/*@editable*/ border-top:2px solid #fff;
				/*@editable*/ color:#202020;
				/*@editable*/ font-family:Helvetica;
				/*@editable*/ font-size:12px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				/*@editable*/ text-align:left;
			}
		
			/**
			* @tab Body
			* @section data table link
			* @tip Set the styling for your email's data table links. Choose a color that helps them stand out from your text.
			*/
			.dataTableContent a:link, .dataTableContent a:visited, /* Yahoo! Mail Override */ .dataTableContent a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#202020;
				/*@editable*/ font-weight:bold;
				/*@editable*/ text-decoration:underline;
			}

			/**
			* @tab Body
			* @section button style
			* @tip Set the styling for your email's button. Choose a style that draws attention.
			*/
			.templateButton{
				-moz-border-radius:3px;
				-webkit-border-radius:3px;
				/*@editable*/ background-color:#336699;
				/*@editable*/ border:0;
				border-collapse:separate !important;
				border-radius:3px;
			}

			/**
			* @tab Body
			* @section button style
			* @tip Set the styling for your email's button. Choose a style that draws attention.
			*/
			.templateButton, .templateButton a:link, .templateButton a:visited, /* Yahoo! Mail Override */ .templateButton a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#FFFFFF;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:15px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ letter-spacing:-.5px;
				/*@editable*/ line-height:100%;
				text-align:center;
				text-decoration:none;
			}

			.bodyContent img{
				display:inline;
				height:auto;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: FOOTER /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Footer
			* @section footer style
			* @tip Set the background color and top border for your email's footer area.
			* @theme footer
			*/
			#templateFooter{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border-top:0;
			}

			/**
			* @tab Footer
			* @section footer text
			* @tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
			* @theme footer
			*/
			.footerContent div{
				/*@editable*/ color:#707070;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:12px;
				/*@editable*/ line-height:125%;
				/*@editable*/ text-align:center;
			}

			/**
			* @tab Footer
			* @section footer link
			* @tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
			*/
			.footerContent div a:link, .footerContent div a:visited, /* Yahoo! Mail Override */ .footerContent div a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			.footerContent img{
				display:inline;
			}

			/**
			* @tab Footer
			* @section utility bar style
			* @tip Set the background color and border for your email's footer utility bar.
			* @theme footer
			*/
			#utility{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border:0;
			}

			/**
			* @tab Footer
			* @section utility bar style
			* @tip Set the background color and border for your email's footer utility bar.
			*/
			#utility div{
				/*@editable*/ text-align:center;
			}

			#monkeyRewards img{
				max-width:190px;
			}
			.wrapimg{
				float:left;
				height:65px;
				width:65px;
				position:relative;
				overflow:hidden;
			}
			img.landscape{
				position: absolute;
				left: 50%;
				top: 50%;
				height: 100%;
				width: auto;
				-webkit-transform: translate(-50%,-50%);
				-ms-transform: translate(-50%,-50%);
				transform: translate(-50%,-50% );	
				z-index:1;			
			}
			img.potrait{			
				position: absolute;
				left: 50%;
				top: 50%;
				width: 100%;
				height: auto;
				-webkit-transform: translate(-50%,-50%);
				-ms-transform: translate(-50%,-50%);
				transform: translate(-50%,-50% );	
				z-index:1;						
			}
		</style>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" onload="window.print()">
    	<center>
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
            	<tr>
                	<td align="center" valign="top" style="padding-top:20px;">
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Header \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader">
                                        <tr>
                                            <td class="headerContent">
                                            
                                            	<!-- // Begin Module: Standard Header Image \\ -->
                                            	<img src="http://www.momocuppy.com/images/layout/newsletter/logo.jpg" style="max-width:600px;" id="headerImage campaign-icon" mc:label="header_image" mc:edit="header_image" mc:allowdesigner mc:allowtext />
                                            	<!-- // End Module: Standard Header Image \\ -->
                                            
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Header \\ -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Body \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                    	<tr>
                                            <td valign="top">
                                
                                                <!-- // Begin Module: Standard Content \\ -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top" class="bodyContent">
                                                            <div mc:edit="std_content00">
                                                                <h2 class="h2">Invoice #<?php echo $order_no?></h2>
                                                                <div style="float:left;width:50%;text-align:left;">
                                                                	<h5 style="font-size:20px;margin:20px 0 10px 0;"><strong>Invoiced to :</strong></h5>
                                                                  <strong><?php echo strtoupper($firstname);?> <?php echo strtoupper($lastname);?></strong><br />
                                                                  <?php echo $street_address;?> <br />
                                                                  <?php echo $city?> <?php echo $zip_code?><br />
                                                                  <?php echo $country?>
                                                                  
                                                                </div>
                                                                <div style="float:left;width:50%;text-align:right;">
                                                                	<h5 style="font-size:20px;margin:20px 0 10px 0;"><strong>Pay to :</strong></h5>
                                                                  <strong>MOMOCUPPY</strong><br />
                                                                  <?php echo $payment_name?><br /><?php echo $payment_account_name?><br /><?php echo $payment_account?>
                                                                </div>                                                                
                                                                
                                                            </div>
														</td>
                                                    </tr>
                                                    <tr>
                                                    	<td valign="top" style="padding-top:0; padding-bottom:0;">
                                                          <table border="0" cellpadding="10" cellspacing="0" width="100%" class="templateDataTable">
                                                              <tr>
                                                                  <th scope="col" valign="top" width="10%" class="dataTableHeading" mc:edit="data_table_heading00">
                                                                    Picture
                                                                  </th>
                                                                  <th scope="col" valign="top" width="20%" class="dataTableHeading" mc:edit="data_table_heading01">
                                                                    Name
                                                                  </th>
                                                                  <th scope="col" valign="top" width="20%" class="dataTableHeading" mc:edit="data_table_heading02">
                                                                    Color
                                                                  </th>
                                                                  <th scope="col" valign="top" width="15%" class="dataTableHeading" mc:edit="data_table_heading02">
                                                                    Price
                                                                  </th>  
                                                                  <th scope="col" valign="top" width="10%" class="dataTableHeading" mc:edit="data_table_heading02">
                                                                    Qty
                                                                  </th>  
                                                                  <th scope="col" valign="top" width="15%" class="dataTableHeading" mc:edit="data_table_heading02">
                                                                    Amount
                                                                  </th>                                                                                                                                                                                                     
                                                              </tr>
                                                              
                                                              
                                                              <?php 
																															$detail = order_history_detail($memberid,$order_no);
																															if($detail){
																																$totalamount = 0;
																																foreach($detail as $row){
																																	$varimg = "";
																																	$img = order_history_thumbimg($row->id_product);
																																	if($img){
																																		$varimg = $img;
																																	}
																																	
																																	
																																	//landscape / potrait
																																	list($width, $height) = getimagesize("..".$varimg);
																																	
																																	if ($width > $height) {
																																	
																																			// Landscape
																																	
																																		$varclass = "landscape";
																																	
																																	} else {
																																	
																																			// Portrait or Square
																																	
																																		$varclass = "potrait";															
																																	
																																	}					
																																	//end ladnscape / potrait																																	
																																	
																																	$vcolor = "-";
																																	if($row->color_name){
																																		$vcolor = "[".$row->color_name."] ";
																																	}
																																	
																																	$totalamount = $totalamount + ($row->qty * $row->price);
																																	?>
 																																	<tr mc:repeatable>
                                                                    <td valign="top" class="dataTableContent" mc:edit="data_table_content00">
                                                                    	<span class="wrapimg">
                                                                      	<img src="http://www.momocuppy.com<?php echo $varimg;?>" width="51" class="<?php echo $varclass;?>"/>
                                                                      </span>
                                                                    </td>
                                                                    <td valign="center" class="dataTableContent" mc:edit="data_table_content01">
                                                                      <?php echo strtoupper($row->product_name);?>
                                                                    </td>
                                                                    <td valign="center" class="dataTableContent" mc:edit="data_table_content01">
                                                                      <?php echo $vcolor ?>
                                                                    </td>
                                                                    <td valign="center" class="dataTableContent" mc:edit="data_table_content02">
                                                                      IDR <?php echo number_format($row->price);?>
                                                                    </td>
                                                                    <td valign="center" class="dataTableContent" mc:edit="data_table_content02">
                                                                      <?php echo $row->qty;?>
                                                                    </td>
                                                                    <td valign="center" class="dataTableContent" mc:edit="data_table_content02">
                                                                      IDR <?php echo number_format($row->qty * $row->price);?>
                                                                    </td>                                                                                                                                    
                                                                  
                                                              		</tr>                                                                  
                                                                  <?php
																																}
																															}
																															?>
                                                             
                                                              

                                                          </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" class="bodyContent">
                                                            <div mc:edit="std_content01">
                                                              <div style="clear:both;float:right;">
                                                              	<span style="float:left;font-weight:bold;text-align:right;width:170px;">Order Date :	</span>
                                                              	<span style="float:left;width:150px;text-align:right;"><?php echo date("d M Y",strtotime($cretime));?></span>                                                            
                                                              </div> 
                                                                                                                          
                                                              <div style="clear:both;float:right;">
                                                              	<span style="float:left;font-weight:bold;text-align:right;width:150px;">Item Total :	</span>
                                                              	<span style="float:left;width:150px;text-align:right;">IDR <?php echo number_format($totalamount);?></span>                                                              
                                                              </div>
                                                              <?php 
                                                                if($discount !== null){
                                                                  ?>
                                                                  <div style="clear:both;float:right;">
                                                                    <span style="float:left;font-weight:bold;text-align:right;width:170px;">Discount :	</span>
                                                                    <span style="float:left;width:150px;text-align:right;">IDR <?php echo number_format($totalamount * (1 - (($discount == null) ? 0 : $discount / 100)));?></span>                                                            
                                                                  </div>  
                                                                  <?php
                                                                }
                                                              ?>
                                                              <div style="clear:both;float:right;">
                                                              	<span style="float:left;font-weight:bold;text-align:right;width:170px;">Shipping &amp; Handling :	</span>
                                                              	<span style="float:left;width:150px;text-align:right;">IDR <?php echo number_format($shipping_cost);?></span>                                                            
                                                              </div>  
                                                              <div style="clear:both;float:right;">
                                                              	<span style="float:left;font-weight:bold;text-align:right;width:170px;">Total :	</span>
                                                              	<span style="float:left;width:150px;text-align:right;"><strong>IDR <?php echo number_format(($totalamount * (1 - (($discount == null) ? 0 : $discount / 100))) + $shipping_cost);?></strong></span>                                                            
                                                              </div>                                                                                                                                                                                    
                                                              
                                                            </div>
														</td>
                                                    </tr>
                                                    
                                                    
                                                   
                                                    <!--start payment info-->
																										    
                                                    
                                                     
                                                    <!--end payment info-->                                               
                                                    
                                                </table>
                                                <!-- // End Module: Standard Content \\ -->
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Body \\ -->
                                </td>
                            </tr>
                        	
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>