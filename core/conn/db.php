<?php

include_once "core.php";

include_once "mysql.php";

$db = new ezSQL_mysql('root','','momocuppy','127.0.0.1');

$db->query("SET NAMES 'utf8'");

$db->query("SET CHARACTER SET 'utf8'");

?>