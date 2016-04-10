<?php

class model_detail_product_redeem_img extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $id_product = 0, $visible = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('dpi.*');
    $this->db->from('dt_product_redeem_img dpi');
    $this->db->join('ms_product_redeem mpr', 'mpr.id = dpi.id_product');

    //Set Filter
    if ($id > 0) {
      $this->db->where('dpi.id', $id);
    }
    if ($id_product > 0) {
      $this->db->where('dpi.id_product', $id_product);
    }
    if ($visible > -1) {
      $this->db->where('dpi.visible', $visible);
    }
    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("dpi.cretime", "asc");
      }
    } else {
      $this->db->order_by("dpi.cretime", "desc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function get_last_id() {
    $this->db->select('dpi.id');
    $this->db->from('dt_product_redeem_img dpi');
    $this->db->order_by("dpi.id", "desc");
    $this->db->limit(1);
    $query = $this->db->get();

    return $query;
  }

  function add_object($id_product, $img) {
    $data = array(
      'id_product' => $id_product,
      'img' => $img,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('dt_product_redeem_img', $data);
  }

  function edit_object($id, $img) {
    $data = array(
      'img' => $img,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('dt_product_redeem_img', $data);
  }

  function get_visible($id) {
    $this->db->select('dpi.visible');
    $this->db->from('dt_product_redeem_img dpi');
    $this->db->where('dpi.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_visible($id, $visible) {
    $data = array(
      'visible' => $visible
    );

    $this->db->where('id', $id);
    $this->db->update('dt_product_redeem_img', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('dt_product_redeem_img');
  }

  //Addon Function
  function get_img_file($id) {
    $this->db->select('dpi.img');
    $this->db->from('dt_product_redeem_img dpi');
    $this->db->where('dpi.id', $id);

    $query = $this->db->get();
    return $query;
  }
  
  function get_id_product($id) {
    $this->db->select('dpi.id_product');
    $this->db->from('dt_product_img dpi');
    $this->db->where("dpi.id", $id);
    
    $query = $this->db->get();
    return $query;
  }
  //End Addon Function
}

?>
