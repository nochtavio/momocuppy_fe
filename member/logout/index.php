<?php 
$dir = "../../";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");

unset($_SESSION["authlogin"]);
header("location:/about-us/");
exit;

?>