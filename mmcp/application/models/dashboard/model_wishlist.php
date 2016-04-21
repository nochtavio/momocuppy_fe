<?php

class model_wishlist extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $id_member = 0, $product_name = "", $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mw.*, mm.email, mp.product_name');
    $this->db->from('ms_wishlist mw');
    $this->db->join('ms_member mm', 'mm.id = mw.id_member');
    $this->db->join('ms_product mp', 'mp.id = mw.id_product');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mw.id', $id);
    }
    if ($id_member > 0) {
      $this->db->where('mw.id_member', $id_member);
    }
    if ($product_name != "") {
      $this->db->like('mp.product_name', $product_name);
    }
    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mp.product_name", "asc");
      }
    } else {
      $this->db->order_by("mp.product_name", "desc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }
  
  function add_object($id_member, $id_product) {
    $data = array(
      'id_member' => $id_member,
      'id_product' => $id_product
    );

    $this->db->insert('ms_wishlist', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('ms_wishlist');
  }
  
  //Addon Function
  function check_wishlist($id_member, $id_product) {
    $filter = array(
      'id_member' => $id_member,
      'id_product' => $id_product,
    );

    $this->db->select('id');
    $query = $this->db->get_where('ms_wishlist', $filter);
    return $query;
  }
  
  function export_wishlist(){
    $query = "
      SELECT mp.product_name, COUNT(mw.id_product) AS total_wishlist
      FROM ms_product mp
      JOIN ms_wishlist mw ON mp.id = mw.id_product
      GROUP BY mp.product_name
    ";
    return $this->db->query($query);
  }
}

?>
