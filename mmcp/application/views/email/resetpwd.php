<?php
$email = (isset($email) ? $email : "" );
$password = (isset($password) ? $password : "" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <!-- Facebook sharing information tags -->
        <meta property="og:title" content="*|MC:SUBJECT|*" />
        
        <title>Verify Register</title>
		<style type="text/css">
			@import url(https://fonts.googleapis.com/css?family=Lobster);
			
			#outlook a{padding:0;} 
			body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} 
			body{-webkit-text-size-adjust:none;} 

			
			body{margin:0; padding:0;}
			img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
			table td{border-collapse:collapse;}
			#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}

			

			

			
			body, #backgroundTable{
				 background-color:#FAFAFA;
			}

			
			#templateContainer{
				 border: 1px solid #DDDDDD;
			}

			
			h1, .h1{
				 color:#202020;
				display:block;
				 font-family:Arial;
				 font-size:34px;
				 font-weight:bold;
				 line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				 text-align:left;
			}

			
			h2, .h2{
				 color:#f05464;
				display:block;
				 font-family:Lobster;
				 font-size:30px;
				 font-weight:700;
				 line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				 text-align:left;
			}

			
			h3, .h3{
				 color:#202020;
				display:block;
				 font-family:Arial;
				 font-size:26px;
				 font-weight:bold;
				 line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				 text-align:left;
			}

			
			h4, .h4{
				 color:#202020;
				display:block;
				 font-family:Arial;
				 font-size:22px;
				 font-weight:bold;
				 line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				 text-align:left;
			}

			

			
			#templateHeader{
				 background-color:#FFFFFF;
				 border-bottom:0;
			}

			
			.headerContent{
				 color:#202020;
				 font-family:Arial;
				 font-size:34px;
				 font-weight:bold;
				 line-height:100%;
				 padding:0;
				 text-align:left;
				 vertical-align:middle;
			}
			.headerContent img{
				margin:10px 0 0 20px;
			}
			
			
			.headerContent a:link, .headerContent a:visited,  .headerContent a .yshortcuts {
				 color:#336699;
				 font-weight:normal;
				 text-decoration:underline;
			}

			#headerImage{
				height:auto;
				max-width:600px !important;
			}

			

			
			#templateContainer, .bodyContent{
				 background-color:#FFFFFF;
			}

			
			.bodyContent div{
				 color:#505050;
				 font-family:Arial;
				 font-size:14px;
				 line-height:150%;
				 text-align:left;
			}

			
			.bodyContent div a:link, .bodyContent div a:visited,  .bodyContent div a .yshortcuts {
				 color:#336699;
				 font-weight:normal;
				 text-decoration:underline;
			}

			
			.templateDataTable{
				 background-color:#fbe0e6;
				 border-radius:5px;
			}
			
			
			.dataTableHeading{
				 background-color:#fbe0e6;
				border-radius:5px;
				 color:#f05b6b;
				 font-family:Helvetica;
				 font-size:14px;
				 font-weight:bold;
				 line-height:100%;
				overflow:hidden;
				 text-align:left;
			}
		
			
			.dataTableHeading a:link, .dataTableHeading a:visited,  .dataTableHeading a .yshortcuts {
				 color:#f596a1;
				 font-weight:bold;
				 text-decoration:none;
			}
			
			
			.dataTableContent{
				 border-top:2px solid #fff;
				 color:#202020;
				 font-family:Helvetica;
				 font-size:12px;
				 font-weight:bold;
				 line-height:100%;
				 text-align:left;
			}
		
			
			.dataTableContent a:link, .dataTableContent a:visited,  .dataTableContent a .yshortcuts {
				 color:#202020;
				 font-weight:bold;
				 text-decoration:underline;
			}

			
			.templateButton{
				-moz-border-radius:3px;
				-webkit-border-radius:3px;
				 background-color:#336699;
				 border:0;
				border-collapse:separate !important;
				border-radius:3px;
			}

			
			.templateButton, .templateButton a:link, .templateButton a:visited,  .templateButton a .yshortcuts {
				 color:#FFFFFF;
				 font-family:Arial;
				 font-size:15px;
				 font-weight:bold;
				 letter-spacing:-.5px;
				 line-height:100%;
				text-align:center;
				text-decoration:none;
			}

			.bodyContent img{
				display:inline;
				height:auto;
			}

			

			
			#templateFooter{
				 background-color:#FFFFFF;
				 border-top:0;
			}

			
			.footerContent div{
				 color:#707070;
				 font-family:Arial;
				 font-size:12px;
				 line-height:125%;
				 text-align:center;
			}

			
			.footerContent div a:link, .footerContent div a:visited,  .footerContent div a .yshortcuts {
				 color:#336699;
				 font-weight:normal;
				 text-decoration:underline;
			}

			.footerContent img{
				display:inline;
			}

			
			#utility{
				 background-color:#FFFFFF;
				 border:0;
			}

			
			#utility div{
				 text-align:center;
			}

			#monkeyRewards img{
				max-width:190px;
			}
			
		</style>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width:100% !important;-webkit-text-size-adjust:none;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;background-color:#FAFAFA;" >
    	<center>
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable" style="height:100% !important;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;width:100% !important;background-color:#FAFAFA;" >
            	<tr>
                	<td align="center" valign="top" style="padding-top:20px;border-collapse:collapse;" >
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer" style="border-width:1px;border-style:solid;border-color:#DDDDDD;background-color:#FFFFFF;" >
                        	<tr>
                            	<td align="center" valign="top" style="border-collapse:collapse;" >
                                    <!-- // Begin Template Header  -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader" style="background-color:#FFFFFF;border-bottom-width:0;" >
                                        <tr>
                                            <td class="headerContent" style="border-collapse:collapse;color:#202020;font-family:Arial;font-size:34px;font-weight:bold;line-height:100%;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:left;vertical-align:middle;" >
                                            
                                            	<!-- // Begin Module: Standard Header Image  -->
                                            	<img src="http://www.momocuppy.com/images/layout/newsletter/logo.jpg"  id="headerImage campaign-icon" mc:label="header_image" mc:edit="header_image" mc:allowdesigner mc:allowtext style="max-width:600px;border-width:0;height:auto;line-height:100%;outline-style:none;text-decoration:none;margin-top:10px;margin-bottom:0;margin-right:0;margin-left:20px;" />
                                            	<!-- // End Module: Standard Header Image  -->
                                            
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Header  -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top" style="border-collapse:collapse;" >
                                    <!-- // Begin Template Body  -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                    	<tr>
                                            <td valign="top" style="border-collapse:collapse;" >
                                
                                                <!-- // Begin Module: Standard Content  -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">

                                                    <tr>
                                                      <td valign="top" class="bodyContent" style="border-collapse:collapse;background-color:#FFFFFF;" >
                                                      	<img src="http://www.momocuppy.com/images/layout/newsletter/resetpwdheader.jpg" style="float:left;border-width:0;line-height:100%;outline-style:none;text-decoration:none;display:inline;height:auto;" />
                                                        <a href="http://www.momocuppy.com/contact-us/" target="_blank" style="float:right;" ><img src="http://www.momocuppy.com/images/layout/newsletter/linksocialresetpwd.jpg" style="border-width:0;line-height:100%;outline-style:none;text-decoration:none;display:inline;height:auto;" /></a>                                                        
                                                      </td>
                                                    </tr>

                                                    
                                                   
                                                    <!--start payment info-->
																										<tr>
                                                    	<td valign="top" style="padding-top:0;padding-bottom:0;border-collapse:collapse;" >
                                                          <table border="0" cellpadding="10" cellspacing="0" width="100%" class="templateDataTable" style="background-color:#fbe0e6;border-radius:5px;" >


 
                                                              <tr mc:repeatable>
                                                                  <td valign="top" class="dataTableContent" mc:edit="data_table_content00" style="font-weight:normal;line-height:120%;border-collapse:collapse;border-top-width:2px;border-top-style:solid;border-top-color:#fff;color:#202020;font-family:Helvetica;font-size:12px;text-align:left;" >
                                                                  	<p style="font-size:14px;line-height:20px;" >
                                                                    	We have successfully reset your password. Please find your new log in details below.
                                                                      <br /><br />
                                                                      Email Address : <strong><?php echo $email; ?></strong><br /><br />
                                                                      Password : <strong><?php echo $password; ?></strong>
                                                                      <br /><br />
                                                                      Be sure to update your password. Once you've done so, you can get back to shopping.
                                                                      <br /><br />
                                                                      Kind regards,<br />
                                                                      Momocuppy Team                                                                      
                                                                    </p>                                                                  
                                                                  </td>
                                                                                                                                                                                                    
                                                              </tr>
                                                          </table>
                                                        </td>
                                                    </tr>    
                                                    
                                                    <tr>
                                                    	<td style="border-collapse:collapse;" >
                                                      	<div style="font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:150%;" >                                                         
                                                          <p style="font-size:14px;" >
                                                          	Copyright &copy; <?php echo date("Y");?> Momocuppy, All rights reserved.
                                                            <br />
                                                            <a  href="http://www.momocuppy.com" style="color:#eb5763;text-decoration:none;font-weight:bold;" >www.momocuppy.com</a>
                                                          </p>
                                                        </div>
                                                      </td>
                                                    </tr> 
                                                    <!--end payment info-->                                               
                                                    
                                                </table>
                                                <!-- // End Module: Standard Content  -->
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Body  -->
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