<?php

class model_newsletter extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $title="", $visible = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mn.*');
    $this->db->from('ms_newsletter mn');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mn.id', $id);
    }
    if ($title !== "") {
      $this->db->like('mn.title', $title);
    }
    if ($visible > -1) {
      $this->db->where('mn.visible', $visible);
    }
    //End Set Filter
    
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mn.cretime", "asc");
      }
    } else {
      $this->db->order_by("mn.cretime", "desc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function get_last_id() {
    $this->db->select('mn.id');
    $this->db->from('ms_newsletter mn');
    $this->db->order_by("mn.id", "desc");
    $this->db->limit(1);
    $query = $this->db->get();

    return $query;
  }

  function add_object($title, $banner1, $link1, $banner2, $link2) {
    $data = array(
      'title' => $title,
      'banner1' => $banner1,
      'link1' => $link1,
      'banner2' => $banner2,
      'link2' => $link2,
      'visible' => 1,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('ms_newsletter', $data);
  }

  function edit_object($id, $title, $banner1, $link1, $banner2, $link2) {
    $data = array(
      'title' => $title,
      'banner1' => $banner1,
      'link1' => $link1,
      'banner2' => $banner2,
      'link2' => $link2,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('ms_newsletter', $data);
  }

  function get_visible($id) {
    $this->db->select('mn.visible');
    $this->db->from('ms_newsletter mn');
    $this->db->where('mn.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_visible($id, $visible) {
    $data = array(
      'visible' => $visible
    );

    $this->db->where('id', $id);
    $this->db->update('ms_newsletter', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('ms_newsletter');
  }
  
  //Addon Function
  function get_subcsribers(){
    $this->db->select('mc.*');
    $this->db->from('ms_subscriber mc');
    $this->db->where('mc.active', 1);
    
    $query = $this->db->get();
    return $query;
  }
  
  function update_subscriber($email){
    $data = array(
      'last_send' => date('Y-m-d H:i:s')
    );

    $this->db->where('email', $email);
    $this->db->update('ms_subscriber', $data);
  }
  //End Addon Function
}

?>
