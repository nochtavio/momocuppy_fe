<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
  $dir = "../";
  
  require_once($dir . "core/conn/config.php");
  require_once($dir . "core/conn/db.php");
  require_once($dir . "lib/newsletter/get_newsletter.php");
  
  //Get Detail Newsletter
  if(isset($_GET["id"]) && is_numeric($_GET["id"])){
    $id = $_GET["id"];
  }else{
    header("location:/");
    exit;
  }
  
  $data = get_newsletter($id);
  if ($data["result"]) {
    foreach ($data["result"] as $row) {
      $banner1 = $row->banner1;
      $link1 = $row->link1;
      $banner2 = $row->banner2;
      $link2 = $row->link2;
    }
  }else{
    header("location:/");
    exit;
  }
  //End Get Detail
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <!-- Facebook sharing information tags -->
        <meta property="og:title" content="*|MC:SUBJECT|*" />
        
        <title>Momocuppy Newsletter</title>
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
				/*@editable*/ 
				background:url(http://www.momocuppy.com/images/layout/mainbg.jpg) repeat center top;
				background-color:#FFF;
				background-attachment: fixed;				
			}

			/**
			* @tab Page
			* @section email border
			* @tip Set the border for your email.
			*/
			#templateContainer{
				/*@editable*/ border: none;
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
				/*@editable*/ /*background-color:#FFFFFF;*/
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
			
		</style>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
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
                                            <td class="headerContent" style="text-align:center;">
                                            

                                            	<!-- // Begin Module: Standard Header Image \\ -->
<!--                                            	<div style="font-family:Arial, Helvetica, sans-serif; font-size:12px;line-height:20px;margin-bottom:35px;">
                                              	Please do not reply to this email<br />
                                                If you are unable to see the message below, click <a href="#" target="_blank" style="color:#f05364;"><strong>here</strong></a>
                                              </div>-->
                                            	<!-- // End Module: Standard Header Image \\ -->
                                            
                                            </td>
                                        </tr>                                  
                                        <tr>
                                            <td class="headerContent" style="text-align:center;">
                                            
                                            	<!-- // Begin Module: Standard Header Image \\ -->
                                            	<img src="/images/layout/newsletter/blast/logo.png" style="max-width:600px;margin-bottom:10px;" id="headerImage campaign-icon" mc:label="header_image" mc:edit="header_image" mc:allowdesigner mc:allowtext />
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
                                                      <td valign="top" class="bodyContent" style="text-align:center;">
                                                      	<a href="<?php echo $link1 ?>" target="_blank" title="banner 1"><img src="http://www.momocuppy.com/mmcp/images/newsletter/<?php echo $banner1 ?>"/></a>
                                                        <a href="<?php echo $link2 ?>" target="_blank" title="banner 2"><img src="http://www.momocuppy.com/mmcp/images/newsletter/<?php echo $banner2 ?>"/></a>                                                        
                                                      </td>
                                                    </tr>
                                                    
                                                   
                                                    <tr>
                                                      <td valign="top" class="bodyContent" style="text-align:center;padding-top:0;padding-bottom:0;">
                                                      	<a href="http://www.momocuppy.com/contact-us/" target="_blank" title="banner 1" style="margin-right:10px;"><img src="/images/layout/newsletter/blast/follow.png"/></a>                                                      	<a href="https://www.facebook.com/Momo-Cuppy-Shop-466333336738898/?fref=ts" target="_blank" title="banner 1" style="margin-right:5px;"><img src="/images/layout/newsletter/blast/blastfb.png"/></a>                                                       
                                                      	<a href="https://www.instagram.com/momocuppy/" target="_blank" title="banner 1" style="margin:5px 5px 0 0;"><img src="/images/layout/newsletter/blast/blastig.png"/></a>                                                        
                                                      </td>
                                                    </tr>    
                                                    
                                                    <tr>
                                                    	<td>
                                                      	<div style="font-family:Arial, Helvetica, sans-serif;line-height:20px;text-align:center;">                                                         
                                                          <p style="font-size:11.5px;">
                                                          	Copyright &copy; <?php echo date("Y");?> Momocuppy, All rights reserved.
                                                            <br />
                                                            You’re receiving this email because you signed up for our newsletter while making a purchase at our store.
                                                            <br />
                                                            <a style="color:#eb5763;text-decoration:none;font-weight:bold;" href="http://www.momocuppy.com"><strong>www.momocuppy.com</strong></a>
                                                          </p>
                                                        </div>
                                                      </td>
                                                    </tr> 
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