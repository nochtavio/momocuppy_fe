<?php

class model_order_archive extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $type = 0, $email = "", $street_address = "", $zip_code = "", $country = "", $city = "", $order_no = "", $resi_no = "", $status = 0, $cretime_from = "", $cretime_to = "", $order = 0, $limit = 0, $size = 0) {
    if($type == 1){
      $this->db->select('mo.*, mm.email, mv.voucher_name, mpr.product_name');
    }else{
      $this->db->select('mo.*, mm.email, mv.voucher_name');
    }
    $this->db->from('ms_order mo');
    $this->db->join('ms_member mm', 'mm.id = mo.id_member');
    $this->db->join('ms_voucher mv', 'mv.voucher_code = mo.voucher_code', 'left');
    if($type == 1){
      $this->db->join('dt_order dor', 'dor.id_order = mo.id');
      $this->db->join('ms_product_redeem mpr', 'mpr.id = dor.id_dt_product');
    }

    //Set Filter
    if ($id > 0) {
      $this->db->where('mo.id', $id);
    }
    if ($email !== "") {
      $this->db->like('mm.email', $email);
    }
    if ($street_address != "") {
      $this->db->like('mo.street_address', $street_address);
    }
    if ($zip_code != "") {
      $this->db->like('mo.zip_code', $zip_code);
    }
    if ($country != "") {
      $this->db->like('mo.country', $country);
    }
    if ($city != "") {
      $this->db->like('mo.city', $city);
    }
    if ($order_no !== "") {
      $this->db->like('mo.order_no', $order_no);
    }
    if ($resi_no !== "") {
      $this->db->like('mo.resi_no', $resi_no);
    }
    if ($status > 0) {
      $this->db->like('mo.status', $status);
    }
    if ($cretime_from !== "" && $cretime_to !== ""){
      $this->db->where('mo.cretime >=', $cretime_from);
      $this->db->where('mo.cretime <=', $cretime_to.' 23:59:59');
    }
    $this->db->where('mo.type', $type);
    $this->db->where('mo.archive', 1);
    //End Set Filter
    
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mo.cretime", "asc");
      } else if ($order == 2) {
        $this->db->order_by("mm.email", "asc");
      } else if ($order == 3) {
        $this->db->order_by("mm.email", "desc");
      }
    } else {
      $this->db->order_by("mo.cretime", "desc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();
    
    return $query;
  }

  function get_archive($id) {
    $this->db->select('mo.archive');
    $this->db->from('ms_order mo');
    $this->db->where('mo.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_archive($id, $archive) {
    $data = array(
      'archive' => $archive
    );

    $this->db->where('id', $id);
    $this->db->update('ms_order', $data);
  }

  function get_detail_order($order_id = 0, $limit = 0, $size = 0) {
    //Check Order Type
    $this->db->select('mo.type');
    $this->db->from('ms_order mo');
    $this->db->where('mo.id', $order_id);
    $query_order_type = $this->db->get();
    //End Check Order Type
    
    if($query_order_type->row()->type == 0){
      //Get Detail Order
      $this->db->select('mo.order_no, mp.product_name, mc.color_name, dor.price, dor.qty, mo.discount, mo.shipping_cost');
      $this->db->from('dt_order dor');
      $this->db->join('ms_order mo', 'dor.id_order = mo.id');
      $this->db->join('dt_product dp', 'dor.id_dt_product = dp.id');
      $this->db->join('ms_product mp', 'dp.id_product = mp.id');
      $this->db->join('ms_color mc', 'dp.id_color = mc.id');

      //Set Filter
      if ($order_id > 0) {
        $this->db->where('mo.id', $order_id);
      }
      //End Set Filter

      if ($size > 0) {
        $this->db->limit($size, $limit);
      }
      $query = $this->db->get();
    }else{
      //Get Detail Redeem
      $this->db->select('mo.order_no, mpr.*');
      $this->db->from('dt_order dor');
      $this->db->join('ms_order mo', 'dor.id_order = mo.id');
      $this->db->join('ms_product_redeem mpr', 'dor.id_dt_product = mpr.id');

      //Set Filter
      if ($order_id > 0) {
        $this->db->where('mo.id', $order_id);
      }
      //End Set Filter

      if ($size > 0) {
        $this->db->limit($size, $limit);
      }
      $query = $this->db->get();
    }
    
    return $query;
  }

}

?>
