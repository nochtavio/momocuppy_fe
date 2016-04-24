<?php 



require_once($dir."lib/domain_check.php");



require_once($dir."lib/lib.php");



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml"><head>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />




<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon.png">



<title>Momocuppy | Home Decoration and Accessories</title>







<!--meta-->

<meta name="robots" content="index, follow" />

<meta name="description" content="Situs toko belanja online dekorasi rumah paling murah dan terlengkap di Indonesia. Menyediakan hadiah dan pernak pernik kebutuhan rumah tangga seperti gelas, pot bunga, kotak music dan papan tulis. Online Shop fashion accessories Jepang dan Korea style di Indonesia. Menyediakan gelang korea, gantungan kunci (keychain), pom-pom, kalung korea, bagcharm dengan konsep yang bertema dan harga terjangkau. Tempat Belanja yang aman, mudah, murah dan berkualitas." itemprop="description" />

<meta name="keywords" content="bisnis online,bisnis,usaha sampingan,bisnis online gratis,kerja online,bisnis sampingan,mug,mug coffee,mug murah,souvenir murah,souvenir gelas,mug unik,kado unik,gelas,souvenir pernikahan,souvenir pernikahan murah,souvenir pernikahan unik,souvenir unik,hello kitty,hello kity,hellokitty,jepang,japan,online shop,kado,kado ulang tahun,kado pernikahan,barang unik,hadiah ulang tahun,kado untuk sahabat,kado untuk pacar,kado buat pacar,boneka,hadiah,souvenir ulang tahun anak,souvenir ultah anak,cangkir,cangkir kopi,teko,gelas susu,kaleng tissue,kaleng kotak,kotak tissue,kotak tisu, kaleng souvenir,kotak musik,carousel,hadiah ulang tahun untuk pacar,kado ultah,pot bunga,bunga cantik,tanaman buah dalam pot,bunga,dekorasi rumah,hiasan kamar,hiasan dinding,dekorasi rumah minimalis,rangkaian bunga,pot bunga unik,bunga plastik,lavender,bunga mawar,dekorasi,dekorasi pernikahan,dekorasi kamar,dekorasi ulang tahun,home decor,home decoration,home living,home design,shabby chic,barang antik,vintage,vintage style,lace,desain kamar tidur,pastel,dekorasi rumah murah,pernak pernik rumah,

papan tulis murah,meja belajar,meja belajar anak,papan tulis,peralatan kantor,pulpen murah,papan tulis anak,alat tulis kantor,stationary,toko,toko online,toko online murah,toko alat tulis,alat tulis,pernak pernik,pernak pernik hello kitty,toko kado unik,pernak pernik unik,renda,aksesoris,aksesoris murah,fashion grosir,grosir aksesoris fashion,aksesoris wanita,aksesoris kalung,grosir aksesoris korea,toko aksesoris,grosir aksesoris wanita,gelang korea,gelang,grosir,grosir aksesoris,grosir fashion online,keychain,gantungan kunci,pom pom,bunny,sachi,fumi,kelinci,korean style,japan,jepang,custom bracelet,bracelet" itemprop="keywords" />



<!--end meta-->

<!--STYLE-->



<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>



<link href="/assets/css/animate.css" rel="stylesheet">



<link href="/assets/css/mfp.css" rel="stylesheet">







<?php 



//start css	



$arrcss = strtok($css,",");



while($arrcss) {



	echo "<link rel=\"stylesheet\" href=\"/assets/css/".$arrcss.".css\" type=\"text/css\" media=\"screen\" />\n";



	$arrcss = strtok(",");



}



//end css



?>



















</head>



<body id="<?php echo $body;?>">







<!--CONTAINER-->



<div id="container">



	<!--TOPCONTENT-->



  <div id="topcontent">  



    <div id="wrapnav">



	 		<!--MAINMENU-->	    



      <?php 


			require_once($dir . "lib/products/get_category.php");
			require_once($dir . "lib/products/get_products.php");
			require_once("mainmenu.php");



			require_once($dir."member/ticker-login.php");



			?>   



	 		<!--MAINMENU-->        



    </div>    



    <?php 



		require_once($dir."member/pop-login.php");



		?>    



  </div>



  <!--TOPCONTENT-->  