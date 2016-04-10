<?php

class model_dashboard_user extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function check_email($email) {
    $filter = array(
      'vemail' => $email,
      'deleted' => 0
    );

    $this->db->select('vemail');
    $query = $this->db->get_where('msuser', $filter);
    return $query;
  }

  function send_password($email) {
    $filter = array(
      'vemail' => $email
    );

    $this->db->select('vpassword');
    $query = $this->db->get_where('msuser', $filter);
    return $query;
  }

  function do_login($email, $password) {
    $filter = array(
      'vemail' => $email,
      'vpassword' => $password,
      'tactive' => 1,
      'deleted' => 0
    );

    $this->db->select('vemail, vpassword, ttipe');
    $query = $this->db->get_where('msuser', $filter);
    return $query;
  }

  function get_object($id = 0, $companyname = "", $tipe = -1, $tactive = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mu.id, mu.ttipe, mu.tactive, mu.vcompanyname, mu.vbrand, mu.vaddress, mu.vphone, mu.vfax, mu.vweb, mu.vpic, mu.vbidang, vyear, tweeklymeat, tweeklymeat2, vitem, vbuyername, vemail, vpassword, vbuyerphone');
    $this->db->from('msuser mu');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mu.id', $id);
    }
    if ($companyname !== "") {
      $this->db->like('mu.vcompanyname', $companyname);
    }
    //End Set Filter
    //Set Status
    if ($tipe > -1) {
      $this->db->where('mu.ttipe', $tipe);
    }
    if ($tactive > -1) {
      $this->db->where('mu.tactive', $tactive);
    }
    //End Set Status

    $this->db->where('mu.deleted', 0);

    //Set Order
    if ($order > 0) {
      if ($order === 1) {
        $this->db->order_by("mu.vcompanyname", "desc");
      }
    } else {
      $this->db->order_by("mu.vcompanyname", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }


    $query = $this->db->get();

    return $query;
  }

  function add_object($vcompanyname, $vbrand = "", $vaddress, $vphone, $vfax = "", $vweb = "", $vpic, $vbidang, $vyear = "", $tweeklymeat, $tweeklymeat2, $vitem, $vemail, $vbuyername, $vbuyerphone, $password) {
    $adminlevel = $this->session->userdata('adminlevel');
    if ($adminlevel === "1") {
      $data = array(
        'ttipe' => 4,
        'tactive' => 0,
        'vcompanyname' => $vcompanyname,
        'vbrand' => $vbrand,
        'vaddress' => $vaddress,
        'vphone' => $vphone,
        'vfax' => $vfax,
        'vweb' => $vweb,
        'vpic' => $vpic,
        'vbidang' => $vbidang,
        'vyear' => $vyear,
        'tweeklymeat' => $tweeklymeat,
        'tweeklymeat2' => $tweeklymeat2,
        'vitem' => $vitem,
        'vemail' => $vemail,
        'vbuyername' => $vbuyername,
        'vbuyerphone' => $vbuyerphone,
        'vpassword' => $password
      );

      $this->db->insert('msuser', $data);
    }
  }

  function add_object_($vcompanyname, $vbrand = "", $vaddress, $vphone, $vfax = "", $vweb = "", $vpic, $vbidang, $vyear = "", $tweeklymeat, $tweeklymeat2, $vitem, $vemail, $vbuyername, $vbuyerphone, $password) {
    $data = array(
      'ttipe' => 4,
      'tactive' => 0,
      'vcompanyname' => $vcompanyname,
      'vbrand' => $vbrand,
      'vaddress' => $vaddress,
      'vphone' => $vphone,
      'vfax' => $vfax,
      'vweb' => $vweb,
      'vpic' => $vpic,
      'vbidang' => $vbidang,
      'vyear' => $vyear,
      'tweeklymeat' => $tweeklymeat,
      'tweeklymeat2' => $tweeklymeat2,
      'vitem' => $vitem,
      'vemail' => $vemail,
      'vbuyername' => $vbuyername,
      'vbuyerphone' => $vbuyerphone,
      'vpassword' => $password
    );

    $this->db->insert('msuser', $data);
  }

  function edit_object($id, $ttipe, $vcompanyname, $vbrand = "", $vaddress, $vphone, $vfax = "", $vweb = "", $vpic, $vbidang, $vyear = "", $tweeklymeat, $tweeklymeat2, $vitem, $vbuyername, $vbuyerphone, $password) {
    $adminlevel = $this->session->userdata('adminlevel');
    if ($adminlevel === "1") {
      $data = array(
        'ttipe' => $ttipe,
        'vcompanyname' => $vcompanyname,
        'vbrand' => $vbrand,
        'vaddress' => $vaddress,
        'vphone' => $vphone,
        'vfax' => $vfax,
        'vweb' => $vweb,
        'vpic' => $vpic,
        'vbidang' => $vbidang,
        'vyear' => $vyear,
        'tweeklymeat' => $tweeklymeat,
        'tweeklymeat2' => $tweeklymeat2,
        'vitem' => $vitem,
        'vbuyername' => $vbuyername,
        'vbuyerphone' => $vbuyerphone,
        'vpassword' => $password
      );

      $this->db->where('id', $id);
      $this->db->update('msuser', $data);
    }
  }

  function edit_object2($id, $ttipe, $vcompanyname, $vbrand = "", $vaddress, $vphone, $vfax = "", $vweb = "", $vpic, $vbidang, $vyear = "", $tweeklymeat, $tweeklymeat2, $vitem, $vbuyername, $vbuyerphone) {
    $adminlevel = $this->session->userdata('adminlevel');
    if ($adminlevel === "1") {
      $data = array(
        'ttipe' => $ttipe,
        'vcompanyname' => $vcompanyname,
        'vbrand' => $vbrand,
        'vaddress' => $vaddress,
        'vphone' => $vphone,
        'vfax' => $vfax,
        'vweb' => $vweb,
        'vpic' => $vpic,
        'vbidang' => $vbidang,
        'vyear' => $vyear,
        'tweeklymeat' => $tweeklymeat,
        'tweeklymeat2' => $tweeklymeat2,
        'vitem' => $vitem,
        'vbuyername' => $vbuyername,
        'vbuyerphone' => $vbuyerphone
      );

      $this->db->where('id', $id);
      $this->db->update('msuser', $data);
    }
  }

  function get_last_id() {
    $this->db->select('mu.id');
    $this->db->from('msuser mu');
    $this->db->order_by("mu.id", "desc");
    $this->db->limit(1);
    $query = $this->db->get();

    return $query;
  }

  function remove_object($id) {
    $adminlevel = $this->session->userdata('adminlevel');
    if ($adminlevel === "1") {
      $data = array(
        'deleted' => 1
      );

      $this->db->where('id', $id);
      $this->db->update('msuser', $data);
    }
  }

  function get_active($id) {
    $this->db->select('mu.tactive, mu.vemail, mu.vpassword');
    $this->db->from('msuser mu');
    $this->db->where('mu.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_active($id, $tactive) {
    $data = array(
      'tactive' => $tactive
    );

    $this->db->where('id', $id);
    $this->db->update('msuser', $data);
  }

}

?>
