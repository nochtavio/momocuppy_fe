<?php

class model_member extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->library('custom_encrypt');
  }

  function get_object($id = 0, $firstname = "", $lastname = "", $email = "", $city = "", $cretime_from = "", $cretime_to = "", $active = -1, $order = 0, $limit = 0, $size = 0) {
    //Set Filter
    $filter_id = "";
    $filter_firstname = "";
    $filter_lastname = "";
    $filter_email = "";
    $filter_city = "";
    $filter_date = "";
    $filter_active = "";
    if ($id > 0) {
      $filter_id = "AND mm.id = " . $id . "";
    }
    if ($firstname !== "") {
      $filter_firstname = "AND mm.firstname LIKE '%" . $firstname . "%'";
    }
    if ($lastname !== "") {
      $filter_lastname = "AND mm.lastname LIKE '%" . $lastname . "%'";
    }
    if ($email !== "") {
      $filter_email = "AND mm.email LIKE '%" . $email . "%'";
    }
    if ($city !== "") {
      $filter_city = "AND mm.id IN (SELECT id_member AS id FROM dt_address da2 JOIN ms_city mc2 ON da2.city = mc2.city_id AND mc2.city_name = '" . $city . "') ";
    }
    if($cretime_from !== "" && $cretime_to !== ""){
      $filter_date = "AND (mm.cretime BETWEEN '".$cretime_from."' AND '".$cretime_to."')";
    }
    if ($active > -1) {
      $filter_active = "AND mm.active = " . $active . "";
    }
    //End Set Filter
    
    //Set Order
    $filter_order = "ORDER BY mm.firstname ASC";
    if ($order > 0) {
      if ($order == 1) {
        $filter_order = "ORDER BY mm.firstname DESC";
      } else if ($order == 2) {
        $filter_order = "ORDER BY mm.email ASC";
      } else if ($order == 3) {
        $filter_order = "ORDER BY mm.email DESC";
      } else if ($order == 4) {
        $filter_order = "ORDER BY point_member ASC";
      } else if ($order == 5) {
        $filter_order = "ORDER BY point_member DESC";
      } else if ($order == 6) {
        $filter_order = "ORDER BY total_order ASC";
      } else if ($order == 7) {
        $filter_order = "ORDER BY total_order DESC";
      } else if ($order == 8) {
        $filter_order = "ORDER BY cretime DESC";
      } else if ($order == 9) {
        $filter_order = "ORDER BY cretime ASC";
      }
    }
    //End Set Order

    $filter_limit = "";
    if ($size > 0) {
      $filter_limit = "LIMIT " . $limit . ", " . $size . "";
    }

    $query = "
      SELECT `mm`.*, 
      (
        SELECT SUM(mp.point) 
        FROM ms_point mp 
        WHERE mm.id = mp.id_member AND DATE_ADD(mp.cretime, INTERVAL 3 MONTH) > NOW()
      ) AS point_member,
      (
        SELECT COUNT(mo.id_member)
        FROM ms_order mo
        WHERE mm.id = mo.id_member AND mo.status > 2
      ) AS total_order,
      (
        SELECT mc.city_name
        FROM dt_address da
        JOIN ms_city mc ON da.city = mc.city_id
        WHERE mm.id = da.id_member
        LIMIT 0,1
      ) AS city
      FROM (`ms_member` mm)
      WHERE 1=1
      " . $filter_id . "
      " . $filter_firstname . "
      " . $filter_lastname . "
      " . $filter_email . "
      " . $filter_city . "
      " . $filter_date . "
      " . $filter_active . "
      " . $filter_order . "
      " . $filter_limit . "
    ";
    
    return $this->db->query($query);
  }

  function add_object($password, $firstname, $lastname, $phone, $email, $dob, $hash, $referral, $street_address, $zip_code, $country, $city) {
    //Encrypt Password
    $encrypted_password = $this->custom_encrypt->encrypt_string($password);

    $data = array(
      'password' => $encrypted_password,
      'firstname' => $firstname,
      'lastname' => $lastname,
      'phone' => $phone,
      'email' => $email,
      'dob' => $dob,
      'hash' => $hash,
      'referral' => $referral,
      'active' => 0,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => 'SYSTEM'
    );

    $this->db->insert('ms_member', $data);
    //Insert Detail Address
    $id_member = $this->db->insert_id();
    
    $data_address = array(
      'id_member' => $id_member,
      'firstname' => $firstname,
      'lastname' => $lastname,
      'street_address' => $street_address,
      'zip_code' => $zip_code,
      'phone' => $phone,
      'country' => $country,
      'city' => $city,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => 'SYSTEM'
    );
    
    $this->db->insert('dt_address', $data_address);
  }

  function edit_object($id, $firstname, $lastname, $phone) {
    $data = array(
      'firstname' => $firstname,
      'lastname' => $lastname,
      'phone' => $phone
    );

    $this->db->where('id', $id);
    $this->db->update('ms_member', $data);
  }

  function get_active($id) {
    $this->db->select('mm.active');
    $this->db->from('ms_member mm');
    $this->db->where('mm.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_active($id, $active) {
    $data = array(
      'active' => $active
    );

    $this->db->where('id', $id);
    $this->db->update('ms_member', $data);
  }

  //Addon Function
  function check_email($email, $active = -1) {
    if($active > -1){
      $filter = array(
        'email' => $email,
        'active' => $active
      );
    }else{
      $filter = array(
        'email' => $email
      );
    }
    
    $this->db->select('email');
    $query = $this->db->get_where('ms_member', $filter);
    return $query;
  }
  
  function check_first_time_buyer($id_member){
    $filter = array(
      'id_member' => $id_member
    );

    $this->db->select('id_member');
    $query = $this->db->get_where('ms_order', $filter);
    return $query;
  }
  
  function check_referral($id_member = 0, $referral = "") {
    $this->db->select('mm.referral');
    $this->db->from('ms_member mm');
    if($id_member > 0){
      $this->db->where('mm.id !=', $id_member);
    }
    $this->db->where('mm.referral', $referral);

    $query = $this->db->get();
    return $query;
  }

  function do_login($email, $password) {
    //Decode Password
    $this->db->select('mm.id, mm.password');
    $this->db->from('ms_member mm');
    $this->db->where('mm.email', $email);
    $get_password = $this->db->get()->row()->password;

    $encrypted_password = $this->custom_encrypt->encrypt_string($password);

    $valid = false;
    if ($get_password == $encrypted_password) {
      $valid = true;
    }

    return $valid;
  }
  
  function get_id($email){
    $this->db->select('mm.id');
    $this->db->from('ms_member mm');
    $this->db->where('mm.email', $email);
    
    $id = $this->db->get()->row()->id;
    
    return $id;
  }

  function validate_login($email, $status_login) {
    //Decode Status Login
    $encrypted_status_login = $this->custom_encrypt->encrypt_string($email);

    $valid = false;
    if ($status_login == $encrypted_status_login) {
      $valid = true;
    }

    return $valid;
  }
  
  function reset_password($email){
    $generated_password = random_string('alpha', 10);
    
    $data = array(
      'password' => $this->custom_encrypt->encrypt_string($generated_password)
    );

    $this->db->where('email', $email);
    $this->db->update('ms_member', $data);
    
    return $generated_password;
  }
  
  function statistic_member($from, $to){
    $query = "
      SELECT DATE_FORMAT(mc.crt_date,'%d %b %y') AS registered_date, COUNT(mm.id) AS total_member
      FROM ms_calendar mc
      LEFT JOIN ms_member mm ON DATE_FORMAT(mc.crt_date,'%d %b %y') = DATE_FORMAT(mm.cretime,'%d %b %y')
      WHERE mc.crt_date BETWEEN '".date('Y-m-d', strtotime($from))."' AND '".date('Y-m-d', strtotime($to))."'
      GROUP BY registered_date
      ORDER BY mc.crt_date ASC
    ";
    return $this->db->query($query);
  }
  
  function export_excel($id = 0, $firstname = "", $lastname = "", $email = "", $city = "", $cretime_from = "", $cretime_to = "", $active = -1, $order = 0, $limit = 0, $size = 0) {
    //Set Filter
    $filter_id = "";
    $filter_firstname = "";
    $filter_lastname = "";
    $filter_email = "";
    $filter_city = "";
    $filter_date = "";
    $filter_active = "";
    if ($id > 0) {
      $filter_id = "AND mm.id = " . $id . "";
    }
    if ($firstname !== "") {
      $filter_firstname = "AND mm.firstname LIKE '%" . $firstname . "%'";
    }
    if ($lastname !== "") {
      $filter_lastname = "AND mm.lastname LIKE '%" . $lastname . "%'";
    }
    if ($email !== "") {
      $filter_email = "AND mm.email LIKE '%" . $email . "%'";
    }
    if ($city !== "") {
      $filter_city = "AND mm.id IN (SELECT id_member AS id FROM dt_address da2 JOIN ms_city mc2 ON da2.city = mc2.city_id AND mc2.city_name = '" . $city . "') ";
    }
    if($cretime_from !== "" && $cretime_to !== ""){
      $filter_date = "AND (mm.cretime BETWEEN '".$cretime_from."' AND '".$cretime_to."')";
    }
    if ($active > -1) {
      $filter_active = "AND mm.active = " . $active . "";
    }
    //End Set Filter
    
    //Set Order
    $filter_order = "ORDER BY mm.firstname ASC";
    if ($order > 0) {
      if ($order == 1) {
        $filter_order = "ORDER BY mm.firstname DESC";
      } else if ($order == 2) {
        $filter_order = "ORDER BY mm.email ASC";
      } else if ($order == 3) {
        $filter_order = "ORDER BY mm.email DESC";
      } else if ($order == 4) {
        $filter_order = "ORDER BY point_member ASC";
      } else if ($order == 5) {
        $filter_order = "ORDER BY point_member DESC";
      } else if ($order == 6) {
        $filter_order = "ORDER BY total_order ASC";
      } else if ($order == 7) {
        $filter_order = "ORDER BY total_order DESC";
      } else if ($order == 8) {
        $filter_order = "ORDER BY cretime DESC";
      } else if ($order == 9) {
        $filter_order = "ORDER BY cretime ASC";
      }
    }
    //End Set Order

    $filter_limit = "";
    if ($size > 0) {
      $filter_limit = "LIMIT " . $limit . ", " . $size . "";
    }

    $query = "
      SELECT mm.firstname, mm.lastname, mm.phone, mm.email,
      (
        SELECT COUNT(mo.id_member)
        FROM ms_order mo
        WHERE mm.id = mo.id_member AND mo.status > 2
      ) AS total_order,
      (
        SELECT SUM(mp.point) 
        FROM ms_point mp 
        WHERE mm.id = mp.id_member AND DATE_ADD(mp.cretime, INTERVAL 3 MONTH) > NOW()
      ) AS total_point,
      (
        SELECT mc.city_name
        FROM dt_address da
        JOIN ms_city mc ON da.city = mc.city_id
        WHERE mm.id = da.id_member
        LIMIT 0,1
      ) AS city,
      mm.cretime
      FROM (`ms_member` mm)
      WHERE 1=1
      " . $filter_id . "
      " . $filter_firstname . "
      " . $filter_lastname . "
      " . $filter_email . "
      " . $filter_city . "
      " . $filter_date . "
      " . $filter_active . "
      " . $filter_order . "
      " . $filter_limit . "
    ";
    
    return $this->db->query($query);
  }

  //End Addon Function
}

?>
