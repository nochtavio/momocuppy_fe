<?php

class model_type extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $type_name = "", $visible = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mt.*');
    $this->db->from('ms_type mt');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mt.id', $id);
    }
    if ($type_name !== "") {
      $this->db->like('mt.type_name', $type_name);
    }
    if ($visible > -1) {
      $this->db->where('mt.visible', $visible);
    }

    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mt.type_name", "desc");
      } else if ($order == 2) {
        $this->db->order_by("mt.position", "asc");
      } else if ($order == 3) {
        $this->db->order_by("mt.position", "desc");
      } else if ($order == 4) {
        $this->db->order_by("mt.cretime", "desc");
      } else if ($order == 5) {
        $this->db->order_by("mt.cretime", "asc");
      }
    } else {
      $this->db->order_by("mt.type_name", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function get_last_id() {
    $this->db->select('mt.id');
    $this->db->from('ms_type mt');
    $this->db->order_by("mt.id", "desc");
    $this->db->limit(1);
    $query = $this->db->get();

    return $query;
  }

  function add_object($type_name, $img, $position) {
    $data = array(
      'type_name' => $type_name,
      'img' => $img,
      'position' => $position,
      'visible' => 0,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('ms_type', $data);
  }

  function edit_object($id, $type_name, $position) {
    $data = array(
      'type_name' => $type_name,
      'position' => $position,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('ms_type', $data);
  }

  function get_visible($id) {
    $this->db->select('mt.visible');
    $this->db->from('ms_type mt');
    $this->db->where('mt.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_visible($id, $visible) {
    $data = array(
      'visible' => $visible
    );

    $this->db->where('id', $id);
    $this->db->update('ms_type', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('ms_type');
  }

}

?>
