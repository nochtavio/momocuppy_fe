<?php

class model_color extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $color_name = "", $visible = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mc.*');
    $this->db->from('ms_color mc');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mc.id', $id);
    }
    if ($color_name !== "") {
      $this->db->like('mc.color_name', $color_name);
    }

    if ($visible > -1) {
      $this->db->where('mc.visible', $visible);
    }

    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mc.color_name", "desc");
      } else if ($order == 2) {
        $this->db->order_by("mc.cretime", "desc");
      } else if ($order == 3) {
        $this->db->order_by("mc.cretime", "asc");
      }
    } else {
      $this->db->order_by("mc.color_name", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function add_object($color_name, $color_code) {
    $data = array(
      'color_name' => $color_name,
      'color_code' => $color_code,
      'visible' => 1,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('ms_color', $data);
  }

  function edit_object($id, $color_name, $color_code) {
    $data = array(
      'color_name' => $color_name,
      'color_code' => $color_code,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('ms_color', $data);
  }

  function get_visible($id) {
    $this->db->select('mc.visible');
    $this->db->from('ms_color mc');
    $this->db->where('mc.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_visible($id, $visible) {
    $data = array(
      'visible' => $visible
    );

    $this->db->where('id', $id);
    $this->db->update('ms_color', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('ms_color');
  }

}

?>
