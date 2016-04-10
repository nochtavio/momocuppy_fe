<?php
function get_city() {
  global $db;
  $data = NULL;

  $strsql = "
    SELECT *
    FROM ms_city
  ";
  $result = $db->get_results($strsql);

  if ($result) {
    $data = array();
    $data["result"] = $result;
  }
  return $data;
}

?>