  <!--FOOTER-->
  <div id="footer"></div>
  <!--FOOTER-->  
</div>
<!--CONTAINER-->
<script type="text/javascript" src="/assets/js/fontsmoothie.min.js" async></script>
<script type="text/javascript" src="/assets/js/jquery.min.js" ></script>
<script type="text/javascript" src="/assets/js/mfp.js" ></script>
<script type="text/javascript" src="/assets/js/bflogin.js" ></script>

<?php 
//js
$varjs = strtok($js,",");
while($varjs) {
	echo "<script type=\"text/javascript\" src=\"/assets/js/".$varjs.".js\"></script>\n";
	$varjs = strtok(",");
}
//end js	
?>



</body>
</html>