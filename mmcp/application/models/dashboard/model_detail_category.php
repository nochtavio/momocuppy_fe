<?php

class model_detail_category extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $id_category = 0, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('dc.*, mc.category_name, mp.product_name');
    $this->db->from('dt_category dc');
    $this->db->join('ms_category mc', 'mc.id = dc.id_category');
    $this->db->join('ms_product mp', 'mp.id = dc.id_product');

    //Set Filter
    if ($id > 0) {
      $this->db->where('dc.id', $id);
    }
    if ($id_category > 0) {
      $this->db->where('dc.id_category', $id_category);
    }
    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("dc.cretime", "asc");
      }
    } else {
      $this->db->order_by("dc.cretime", "desc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function add_object($id_category, $id_product) {
    $data = array(
      'id_category' => $id_category,
      'id_product' => $id_product,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('dt_category', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('dt_category');
  }

  //Function Add Ons
  function validate_product($id_category, $id_product) {
    $filter = array(
      'id_category' => $id_category,
      'id_product' => $id_product
    );

    $this->db->select('id');
    $query = $this->db->get_where('dt_category', $filter);
    return $query;
  }

  function generate_ms_category($type = 0) {
    $this->db->select('mc.*');
    $this->db->from('ms_category mc');
    if ($type > 0) {
      $this->db->where('type', $type);
    }
    $this->db->where('visible', 1);
    $query = $this->db->get();

    return $query;
  }

  function generate_dt_category($id_product = 0) {
    $this->db->select('dc.*');
    $this->db->from('dt_category dc');
    if ($id_product > 0) {
      $this->db->where('id_product', $id_product);
    }
    $query = $this->db->get();

    return $query;
  }

  function generate_ms_product() {
    $this->db->select('mp.*');
    $this->db->from('ms_product mp');
    $this->db->where('visible', 1);
    $query = $this->db->get();

    return $query;
  }

}

?>
