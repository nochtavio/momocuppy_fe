<?php

class model_city extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $city_id = 0, $city_name = "", $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mc.*');
    $this->db->from('ms_city mc');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mc.id', $id);
    }
    if ($city_id > 0) {
      $this->db->where('mc.city_id', $city_id);
    }
    if ($city_name !== "") {
      $this->db->like('mc.city_name', $city_name);
    }
    //End Set Filter
    
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mc.city_name", "desc");
      } else if ($order == 2) {
        $this->db->order_by("mc.cretime", "desc");
      } else if ($order == 3) {
        $this->db->order_by("mc.cretime", "asc");
      }
    } else {
      $this->db->order_by("mc.city_name", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function add_object($city_id, $city_name, $type) {
    $data = array(
      'city_id' => $city_id,
      'city_name' => $city_name,
      'type' => $type,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => 'SYSTEM'
    );
    $this->db->insert('ms_city', $data);
  }
}

?>
