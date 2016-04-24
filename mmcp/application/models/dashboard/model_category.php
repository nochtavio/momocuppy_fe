<?php

class model_category extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $category_name = "", $type = -1, $visible = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mc.*, mt.type_name AS type_name');
    $this->db->from('ms_category mc');
    $this->db->join('ms_type mt', 'mt.id = mc.type');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mc.id', $id);
    }
    if ($category_name !== "") {
      $this->db->like('mc.category_name', $category_name);
    }
    if ($type > -1) {
      $this->db->where('mc.type', $type);
    }
    if ($visible > -1) {
      $this->db->where('mc.visible', $visible);
    }

    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mc.category_name", "desc");
      } else if ($order == 2) {
        $this->db->order_by("mc.position", "asc");
      } else if ($order == 3) {
        $this->db->order_by("mc.position", "desc");
      } else if ($order == 4) {
        $this->db->order_by("mc.cretime", "desc");
      } else if ($order == 5) {
        $this->db->order_by("mc.cretime", "asc");
      }
    } else {
      $this->db->order_by("mc.category_name", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function get_last_id() {
    $this->db->select('mc.id');
    $this->db->from('ms_category mc');
    $this->db->order_by("mc.id", "desc");
    $this->db->limit(1);
    $query = $this->db->get();

    return $query;
  }

  function add_object($type, $category_name, $img, $img_hover, $position) {
    $data = array(
      'type' => $type,
      'category_name' => $category_name,
      'img' => $img,
      'img_hover' => $img_hover,
      'position' => $position,
      'visible' => 1,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('ms_category', $data);
  }

  function edit_object($id, $type, $category_name, $position) {
    $data = array(
      'type' => $type,
      'category_name' => $category_name,
      'position' => $position,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('ms_category', $data);
  }

  function get_visible($id) {
    $this->db->select('mc.visible');
    $this->db->from('ms_category mc');
    $this->db->where('mc.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_visible($id, $visible) {
    $data = array(
      'visible' => $visible
    );

    $this->db->where('id', $id);
    $this->db->update('ms_category', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('ms_category');
  }

}

?>
