<?php

class model_subscriber extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $email = "", $active = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('me.*');
    $this->db->from('ms_subscriber me');

    //Set Filter
    if ($id > 0) {
      $this->db->where('me.id', $id);
    }
    if ($email !== "") {
      $this->db->like('me.email', $email);
    }

    if ($active > -1) {
      $this->db->where('me.active', $active);
    }

    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("me.email", "desc");
      } else if ($order == 2) {
        $this->db->order_by("me.cretime", "desc");
      } else if ($order == 3) {
        $this->db->order_by("me.cretime", "asc");
      }
    } else {
      $this->db->order_by("me.email", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function add_object($email) {
    $data = array(
      'email' => $email,
      'active' => 1,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => ($this->session->userdata('admin')) ? $this->session->userdata('admin') : 'SYSTEM'
    );

    $this->db->insert('ms_subscriber', $data);
  }

  function edit_object($id, $email) {
    $data = array(
      'email' => $email,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('ms_subscriber', $data);
  }

  function get_active($id) {
    $this->db->select('me.active');
    $this->db->from('ms_subscriber me');
    $this->db->where('me.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_active($id, $active) {
    $data = array(
      'active' => $active
    );

    $this->db->where('id', $id);
    $this->db->update('ms_subscriber', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('ms_subscriber');
  }

  function check_subscriber($email){
    $this->db->select('me.email');
    $this->db->from('ms_subscriber me');
    $this->db->where('me.email', $email);

    $query = $this->db->get();
    return $query;
  }

}

?>
