<?php
ob_start();
$dir = "../";
require_once($dir . "core/conn/config.php");
require_once($dir . "core/conn/db.php");

function test_cron(){
  global $db;

  $strsql = "
    INSERT INTO `test_cron` (`cretime`) VALUES (NOW())
  ";
  $result = $db->query($strsql);

  if($result){
    return $result;
  }else{
    return false;
  }	
}

echo test_cron();
exit;
?>