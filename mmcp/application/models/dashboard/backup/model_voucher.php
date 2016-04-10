<?php

class model_voucher extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $voucher_name = "", $voucher_code = "", $type = -1, $active = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mv.*');
    $this->db->from('ms_voucher mv');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mv.id', $id);
    }
    if ($voucher_name !== "") {
      $this->db->like('mv.voucher_name', $voucher_name);
    }
    if ($voucher_code !== "") {
      $this->db->like('mv.voucher_code', $voucher_code);
    }
    if ($type > 0) {
      $this->db->where('mv.type', $type);
    }

    if ($active > -1) {
      $this->db->where('mv.active', $active);
    }

    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mv.voucher_name", "desc");
      } else if ($order == 2) {
        $this->db->order_by("mv.cretime", "desc");
      } else if ($order == 3) {
        $this->db->order_by("mv.cretime", "asc");
      }
    } else {
      $this->db->order_by("mv.voucher_name", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function add_object($voucher_name, $voucher_code, $type, $discount) {
    $data = array(
      'voucher_name' => $voucher_name,
      'voucher_code' => $voucher_code,
      'type' => $type,
      'discount' => $discount,
      'active' => 0,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('ms_voucher', $data);
  }

  function edit_object($id, $voucher_name, $voucher_code, $type, $discount) {
    $data = array(
      'voucher_name' => $voucher_name,
      'voucher_code' => $voucher_code,
      'type' => $type,
      'discount' => $discount,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('ms_voucher', $data);
  }

  function get_active($id) {
    $this->db->select('mv.active');
    $this->db->from('ms_voucher mv');
    $this->db->where('mv.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_active($id, $active) {
    $data = array(
      'active' => $active
    );

    $this->db->where('id', $id);
    $this->db->update('ms_voucher', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('ms_voucher');
  }

}

?>
