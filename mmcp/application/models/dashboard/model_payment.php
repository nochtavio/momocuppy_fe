<?php

class model_payment extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $payment_name = "", $rek_no = "", $rek_name = "", $visible = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mp.*');
    $this->db->from('ms_payment mp');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mp.id', $id);
    }
    if ($payment_name !== "") {
      $this->db->like('mp.payment_name', $payment_name);
    }
    if ($rek_no !== "") {
      $this->db->like('mp.rek_no', $rek_no);
    }
    if ($rek_name !== "") {
      $this->db->like('mp.rek_name', $rek_name);
    }

    if ($visible > -1) {
      $this->db->where('mp.visible', $visible);
    }

    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mp.payment_name", "desc");
      } else if ($order == 2) {
        $this->db->order_by("mp.cretime", "desc");
      } else if ($order == 3) {
        $this->db->order_by("mp.cretime", "asc");
      }
    } else {
      $this->db->order_by("mp.payment_name", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function add_object($payment_name, $rek_no, $rek_name) {
    $data = array(
      'payment_name' => $payment_name,
      'rek_no' => $rek_no,
      'rek_name' => $rek_name,
      'visible' => 0,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('ms_payment', $data);
  }

  function edit_object($id, $payment_name, $rek_no, $rek_name) {
    $data = array(
      'payment_name' => $payment_name,
      'rek_no' => $rek_no,
      'rek_name' => $rek_name,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('ms_payment', $data);
  }

  function get_visible($id) {
    $this->db->select('mp.visible');
    $this->db->from('ms_payment mp');
    $this->db->where('mp.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_visible($id, $visible) {
    $data = array(
      'visible' => $visible
    );

    $this->db->where('id', $id);
    $this->db->update('ms_payment', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('ms_payment');
  }

}

?>
