<?php
$dir = "../";

require_once($dir."core/conn/config.php");
require_once($dir."core/conn/db.php");
require_once($dir."lib/member/member.php");

$email = isset($_GET["email"]) ? $_GET["email"] : "";
$unsubscribe = unsubscribe($email);

echo 'You have successfully unsubscribe Momo Cuppy Newsletter';
