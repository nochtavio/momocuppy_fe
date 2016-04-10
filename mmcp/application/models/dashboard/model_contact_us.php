<?php

class model_contact_us extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object() {
    $this->db->select('mcu.*');
    $this->db->from('ms_contact_us mcu');
    $this->db->where('mcu.type', 1);

    $query = $this->db->get();

    return $query;
  }

  function edit_object($content) {
    $data = array(
      'content' => $content,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', 1);
    $this->db->where('type', 1);
    $this->db->update('ms_contact_us', $data);
  }

}

?>
