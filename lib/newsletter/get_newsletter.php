<?php
function get_newsletter($id) {
  global $db;
  $data = NULL;

  $strsql = "
    SELECT *
    FROM ms_newsletter
    WHERE id = '".$db->escape($id)."'
  ";
  $result = $db->get_results($strsql);

  if ($result) {
    $data = array();
    $data["result"] = $result;
  }
  return $data;
}

?>