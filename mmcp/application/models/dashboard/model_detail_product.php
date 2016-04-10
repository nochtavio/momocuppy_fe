<?php

class model_detail_product extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $id_product = 0, $id_color = 0, $visible = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('dp.*, mc.color_name');
    $this->db->from('dt_product dp');
    $this->db->join('ms_color mc', 'mc.id = dp.id_color');
    $this->db->join('ms_product mp', 'mp.id = dp.id_product');

    //Set Filter
    if ($id > 0) {
      $this->db->where('dp.id', $id);
    }
    if ($id_product > 0) {
      $this->db->where('dp.id_product', $id_product);
    }
    if ($id_color > 0) {
      $this->db->where('dp.id_color', $id_color);
    }
    if ($visible > -1) {
      $this->db->where('dp.visible', $visible);
    }
    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("dp.cretime", "asc");
      } else if ($order == 2) {
        $this->db->order_by("dp.stock", "asc");
      } else if ($order == 3) {
        $this->db->order_by("dp.stock", "desc");
      }
    } else {
      $this->db->order_by("dp.cretime", "desc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function add_object($id_product, $id_color, $stock) {
    $data = array(
      'id_product' => $id_product,
      'id_color' => $id_color,
      'stock' => $stock,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('dt_product', $data);
  }

  function edit_object($id, $stock) {
    $data = array(
      'stock' => $stock,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('dt_product', $data);
  }

  function get_visible($id) {
    $this->db->select('dp.visible');
    $this->db->from('dt_product dp');
    $this->db->where('dp.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_visible($id, $visible) {
    $data = array(
      'visible' => $visible
    );

    $this->db->where('id', $id);
    $this->db->update('dt_product', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('dt_product');
  }

  //Function Add Ons
  function validate_color($id_product, $id_color) {
    $filter = array(
      'id_product' => $id_product,
      'id_color' => $id_color
    );

    $this->db->select('id');
    $query = $this->db->get_where('dt_product', $filter);
    return $query;
  }

  function generate_ms_color() {
    $this->db->select('mc.*');
    $this->db->from('ms_color mc');
    $this->db->where('visible', 1);
    $query = $this->db->get();

    return $query;
  }

}

?>
