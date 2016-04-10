<?php 
$title = "";
if(isset($_GET["act"]) && $_GET["act"]=="update"){
	$title = "edit shipping address";
}elseif(isset($_GET["act"]) && $_GET["act"]=="new"){
	$title = "add new shipping address";		
}else{
	echo "
	<div id=\"popaddress\" style=\"text-align:center;\">
		an error has occured
	</div>
	";
	exit;
}
?>
<div id="popaddress">
	<h3 class="title"><?php echo $title;?></h3>
  <form name="formaddr" class="personal formaddr" action="." method="post">
    <div class="row">
      <label for="firstname">First Name</label>
      <input type="text" name="firstname" id="firstname" autocomplete="off" value="Angeline"/>
      
      <label class="labellastname" for="lastname">Last Name</label>
      <input type="text" name="lastname" id="lastname" autocomplete="off" value="Kristiali"/>                
    </div>  
    
    <div class="row">
      <label for="email">Email</label>
      <input type="text" name="email" id="email" value="angeline@yahoo.com"/>
    </div>     
    
    <div class="row">
      <label for="phone">Phone</label>
      <input type="text" name="phone" id="phone" value="08123456789"/>
    </div>   
    
    <div class="row">
      <label for="streetname">Street Address</label>
      <input type="text" name="streetname" id="streetname" value="Kavling polri Blok A 10 no.257, Jelambar"/>
    </div>
    
    <div class="row">
      <label for="postalcode">Zip / Postal Code</label>
      <input type="text" name="postalcode" id="postalcode" value="12345"/>
    </div>   
    
    <div class="row">
      <label for="country">Country</label>
      <input type="text" name="country" id="country" value="Indonesia"/>
    </div>      
    
    <div class="row">
      <label for="city">City</label>
      <input type="text" name="city" id="city" value="Jakarta"/>
    </div>  
    
    <div class="row">
      <input class="saveaddr" type="image" src="/images/layout/member/btnsaveaddr.png" />
    </div>                             
                      
  </form>
</div>