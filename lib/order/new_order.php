<?php
$dir = "../";
require_once($dir . "core/conn/db.php");
session_start();

$id_member = (isset($_POST['id_member']) ? $_POST['id_member'] : "");
$street_address = (isset($_POST['street_address']) ? $_POST['street_address'] : "");
$zip_code = (isset($_POST['zip_code']) ? $_POST['zip_code'] : "");
$country = (isset($_POST['country']) ? $_POST['country'] : "");
$city = (isset($_POST['city']) ? $_POST['city'] : "");
$payment_name = (isset($_POST['payment_name']) ? $_POST['payment_name'] : "");
$payment_account = (isset($_POST['payment_account']) ? $_POST['payment_account'] : "");
$shipping_cost = (isset($_POST['shipping_cost']) ? $_POST['shipping_cost'] : "");
$voucher_code = (isset($_POST['voucher_code']) ? $_POST['voucher_code'] : "");
$discount = (isset($_POST['discount']) ? $_POST['discount'] : "");
$referral = (isset($_POST['referral']) ? $_POST['referral'] : "");

function validate_post(){
  global $id_member, $street_address, $zip_code, $country, $city, $payment_name, $payment_account, $shipping_cost, $voucher_code, $discount, $referral;
  
  if($id_member == "" || $street_address == "" || $zip_code == "" || $country == "" || $city == "" || $payment_name == "" || $payment_account == "" || $shipping_cost == ""){
    $_SESSION["order_error_message"] = "Missing Parameter";
    header("location:/order/index.php");
    exit();
  }
  
  //Check ID Member is exist
  
}

function new_order() {
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