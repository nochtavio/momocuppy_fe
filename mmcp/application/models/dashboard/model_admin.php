<?php

class model_admin extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->library('custom_encrypt');
  }

  function check_admin($username) {
    $filter = array(
      'username' => $username,
      'active' => 1
    );

    $this->db->select('username');
    $query = $this->db->get_where('ms_admin', $filter);
    return $query;
  }

  function do_login($username, $password) {
    //Decode Password
    $this->db->select('ma.password');
    $this->db->from('ms_admin ma');
    $this->db->where('ma.username', $username);
    $get_password = $this->db->get()->row()->password;

    $encrypted_password = $this->custom_encrypt->encrypt_string($password);

    $valid = false;
    if ($get_password == $encrypted_password) {
      $valid = true;
    }

    return $valid;
  }

  function get_object($id = 0, $username = "", $active = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('ma.id, ma.username, ma.active');
    $this->db->from('ms_admin ma');

    //Set Filter
    if ($id > 0) {
      $this->db->where('ma.id', $id);
    }
    if ($username !== "") {
      $this->db->like('ma.username', $username);
    }

    if ($active > -1) {
      $this->db->where('ma.active', $active);
    }

    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("ma.username", "desc");
      }
    } else {
      $this->db->order_by("ma.username", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function add_object($username, $password) {
    //Encrypt Password
    $encrypted_password = $this->custom_encrypt->encrypt_string($password);

    $data = array(
      'username' => $username,
      'password' => $encrypted_password,
      'active' => 0
    );

    $this->db->insert('ms_admin', $data);
  }

  function edit_object($id, $password) {
    //Encrypt Password
    $encrypted_password = $this->custom_encrypt->encrypt_string($password);

    $data = array(
      'password' => $encrypted_password
    );

    $this->db->where('id', $id);
    $this->db->update('ms_admin', $data);
  }

  function get_active($id) {
    $this->db->select('ma.active');
    $this->db->from('ms_admin ma');
    $this->db->where('ma.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_active($id, $active) {
    $data = array(
      'active' => $active
    );

    $this->db->where('id', $id);
    $this->db->update('ms_admin', $data);
  }

}

?>
