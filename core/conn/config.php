<?php 



/*SESSION SET*/
ob_start();
session_start();

header('Content-Type: text/html; charset=utf-8');

/*INI SET*/

ini_set('display_errors', 1);



/*ERROR REPORTING*/

error_reporting(E_ALL);



/*DEFAULT TIME ZONE*/

date_default_timezone_set('Asia/Jakarta');

?>