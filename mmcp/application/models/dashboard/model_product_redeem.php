<?php

class model_product_redeem extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $product_name = "", $visible = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mpr.*');
    $this->db->from('ms_product_redeem mpr');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mpr.id', $id);
    }
    if ($product_name !== "") {
      $this->db->like('mpr.product_name', $product_name);
    }

    if ($visible > -1) {
      $this->db->where('mpr.visible', $visible);
    }

    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mpr.product_name", "desc");
      } else if ($order == 2) {
        $this->db->order_by("mpr.cretime", "desc");
      } else if ($order == 3) {
        $this->db->order_by("mpr.cretime", "asc");
      }
    } else {
      $this->db->order_by("mpr.product_name", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function add_object($product_name, $product_point, $product_desc, $publish_date) {
    $data = array(
      'product_name' => $product_name,
      'product_point' => $product_point,
      'product_desc' => $product_desc,
      'publish_date' => $publish_date,
      'visible' => 0,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('ms_product_redeem', $data);
  }

  function edit_object($id, $product_name, $product_point, $product_desc, $publish_date) {
    $data = array(
      'product_name' => $product_name,
      'product_point' => $product_point,
      'product_desc' => $product_desc,
      'publish_date' => $publish_date,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('ms_product_redeem', $data);
  }

  function get_visible($id) {
    $this->db->select('mpr.visible');
    $this->db->from('ms_product_redeem mpr');
    $this->db->where('mpr.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_visible($id, $visible) {
    $data = array(
      'visible' => $visible
    );

    $this->db->where('id', $id);
    $this->db->update('ms_product_redeem', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('ms_product_redeem');

    $this->db->where('id_product', $id);
    $this->db->delete('dt_product_redeem_img');
  }

}

?>
