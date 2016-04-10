<?php

function get_about_contact($type) {
  global $db;

  if (!isset($type) || !is_numeric($type)) {
    $type = 1;
  }

  $strsql = "
    SELECT content 
    FROM ms_contact_us 
    WHERE	type = " . $db->escape($type) . "
  ";

  $row = $db->get_row($strsql);
  if ($row) {
    return $row->content;
  } else {
    return "";
  }
}

function generate_verify() {
  $no1 = rand(1, 10);
  $no2 = rand(1, 10);

  $_SESSION["no1"] = $no1;
  $_SESSION["no2"] = $no2;
}

?>
