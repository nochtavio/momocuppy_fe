<?php

class model_detail_address extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $id_member = 0, $street_address = "", $zip_code = "", $country = "", $city = "", $order = 0, $limit = 0, $size = 0) {
    $this->db->select('da.*, mm.email, mc.city_name');
    $this->db->from('dt_address da');
    $this->db->join('ms_member mm', 'mm.id = da.id_member');
    $this->db->join('ms_city mc', 'mc.city_id = da.city');

    //Set Filter
    if ($id > 0) {
      $this->db->where('da.id', $id);
    }
    if ($id_member > 0) {
      $this->db->where('da.id_member', $id_member);
    }
    if ($street_address != "") {
      $this->db->like('da.street_address', $street_address);
    }
    if ($zip_code != "") {
      $this->db->like('da.zip_code', $zip_code);
    }
    if ($country != "") {
      $this->db->like('da.country', $country);
    }
    if ($city != "") {
      $this->db->like('mc.city_name', $city);
    }
    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("da.cretime", "asc");
      }
    } else {
      $this->db->order_by("da.cretime", "desc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }
  
  function add_object($id_member, $firstname, $lastname, $street_address, $zip_code, $phone, $country, $city) {
    $data = array(
      'id_member' => $id_member,
      'firstname' => $firstname,
      'lastname' => $lastname,
      'street_address' => $street_address,
      'zip_code' => $zip_code,
      'phone' => $phone,
      'country' => $country,
      'city' => $city,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('dt_address', $data);
  }
  
  function edit_object($id, $firstname, $lastname, $street_address, $zip_code, $phone, $country, $city) {
    $data = array(
      'firstname' => $firstname,
      'lastname' => $lastname,
      'street_address' => $street_address,
      'zip_code' => $zip_code,
      'phone' => $phone,
      'country' => $country,
      'city' => $city,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('dt_address', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('dt_address');
  }

}

?>
