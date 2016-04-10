<?php
$dir = "../";
require_once($dir . "core/conn/db.php");

function get_payment_list() {
  global $db;
  $data = NULL;

  $strsql = "
    SELECT id, payment_name, rek_no
    FROM ms_payment
    WHERE visible = 1
  ";
  $result = $db->get_results($strsql);

  if ($result) {
    $data = array();
    $data["result"] = $result;
  }
  return $data;
}

?>