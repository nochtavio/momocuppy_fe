<?php

class model_order_archive extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $email = "", $street_address = "", $zip_code = "", $country = "", $city = "", $order_no = "", $resi_no = "", $status = 0, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mo.*, mm.email, mv.voucher_name');
    $this->db->from('ms_order mo');
    $this->db->join('ms_member mm', 'mm.id = mo.id_member');
    $this->db->join('ms_voucher mv', 'mv.voucher_code = mo.voucher_code', 'left');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mo.id', $id);
    }
    if ($email !== "") {
      $this->db->like('mm.email', $email);
    }
    if ($street_address != "") {
      $this->db->like('mo.street_address', $street_address);
    }
    if ($zip_code != "") {
      $this->db->like('mo.zip_code', $zip_code);
    }
    if ($country != "") {
      $this->db->like('mo.country', $country);
    }
    if ($city != "") {
      $this->db->like('mo.city', $city);
    }
    if ($order_no !== "") {
      $this->db->like('mo.order_no', $order_no);
    }
    if ($resi_no !== "") {
      $this->db->like('mo.resi_no', $resi_no);
    }
    if ($status > 0) {
      $this->db->like('mo.status', $status);
    }

    $this->db->where('mo.archive', 1);
    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mo.cretime", "asc");
      } else if ($order == 2) {
        $this->db->order_by("mm.email", "desc");
      } else if ($order == 3) {
        $this->db->order_by("mm.email", "asc");
      }
    } else {
      $this->db->order_by("mo.cretime", "desc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function get_archive($id) {
    $this->db->select('mo.archive');
    $this->db->from('ms_order mo');
    $this->db->where('mo.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_archive($id, $archive) {
    $data = array(
      'archive' => $archive
    );

    $this->db->where('id', $id);
    $this->db->update('ms_order', $data);
  }

  function get_detail_order($order_id = 0, $limit = 0, $size = 0) {
    $this->db->select('mo.order_no, mp.product_name, mc.color_name, dor.price, dor.qty, mv.discount, mo.shipping_cost');
    $this->db->from('dt_order dor');
    $this->db->join('ms_order mo', 'dor.id_order = mo.id');
    $this->db->join('dt_product dp', 'dor.id_dt_product = dp.id');
    $this->db->join('ms_product mp', 'dp.id_product = mp.id');
    $this->db->join('ms_color mc', 'dp.id_color = mc.id');
    $this->db->join('ms_voucher mv', 'mo.id_voucher = mv.id', 'left');

    //Set Filter
    if ($order_id > 0) {
      $this->db->where('mo.id', $order_id);
    }
    //End Set Filter

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

}

?>
