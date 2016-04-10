<?php

class detail_address extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_member', '', TRUE);
    $this->load->model('dashboard/model_detail_address', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Member";
    $content['pagesize'] = 10;
    $content['id_member'] = $this->input->get('id', TRUE);
    //Get Username
    $query_product = $this->model_member->get_object($content['id_member'])->result();
    foreach ($query_product as $row) {
      $content['email'] = $row->email;
    }

    //JS
    $content['js'][0] = 'js/dashboard/private/detail_address.js';

    //Modal
    $content['modal'][1] = $this->load->view('dashboard/detail_address/modal_edit', $content, TRUE);

    $data['content'] = $this->load->view('dashboard/detail_address/index', $content, TRUE);
    $this->load->view('dashboard/template_index', $data);
  }

  function show_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //paging
      $page = 1;
      if ($this->input->post('page', TRUE)) {
        $page = $this->input->post('page', TRUE);
      }
      if ($this->input->post('size', TRUE)) {
        $size = $this->input->post('size', TRUE);
      }
      $limit = ($page - 1) * $size;
      //end paging
      //Filter
      $id_member = $this->input->post('id_member', TRUE);

      $street_address = "";
      if ($this->input->post('street_address', TRUE)) {
        $street_address = $this->input->post('street_address', TRUE);
      }

      $zip_code = "";
      if ($this->input->post('zip_code', TRUE)) {
        $zip_code = $this->input->post('zip_code', TRUE);
      }

      $country = "";
      if ($this->input->post('country', TRUE)) {
        $country = $this->input->post('country', TRUE);
      }

      $city = "";
      if ($this->input->post('city', TRUE)) {
        $city = $this->input->post('city', TRUE);
      }

      $order = 0;
      if ($this->input->post('order', TRUE)) {
        $order = $this->input->post('order', TRUE);
      }
      //End Filter

      $totalrow = $this->model_detail_address->get_object(0, $id_member, $street_address, $zip_code, $country, $city, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_detail_address->get_object(0, $id_member, $street_address, $zip_code, $country, $city, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['id_member'][$temp] = $id_member;
          $data['firstname'][$temp] = $row->firstname;
          $data['lastname'][$temp] = $row->lastname;
          $data['street_address'][$temp] = $row->street_address;
          $data['zip_code'][$temp] = $row->zip_code;
          $data['phone'][$temp] = $row->phone;
          $data['country'][$temp] = $row->country;
          $data['city'][$temp] = $row->city;

          $data['cretime'][$temp] = date_format(date_create($row->cretime), 'd F Y H:i:s');
          $data['creby'][$temp] = $row->creby;
          $data['modtime'][$temp] = date_format(date_create($row->modtime), 'd F Y H:i:s');
          $data['modby'][$temp] = $row->modby;
          $temp++;
        }
        $data['total'] = $temp;
        $data['size'] = $size;
      } else {
        $data['result'] = "f";
        $data['message'] = "No Address";
      }
      echo json_encode($data);
    }
  }

  function check_field() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $id = "";
      if ($this->input->post('id', TRUE)) {
        $id = $this->input->post('id', TRUE);
      }
      
      $firstname = "";
      if ($this->input->post('firstname', TRUE)) {
        $firstname = $this->input->post('firstname', TRUE);
      }
      
      $lastname = "";
      if ($this->input->post('lastname', TRUE)) {
        $lastname = $this->input->post('lastname', TRUE);
      }
      
      $street_address = "";
      if ($this->input->post('street_address', TRUE)) {
        $street_address = $this->input->post('street_address', TRUE);
      }

      $zip_code = "";
      if ($this->input->post('zip_code', TRUE)) {
        $zip_code = $this->input->post('zip_code', TRUE);
      }
      
      $phone = "";
      if ($this->input->post('phone', TRUE)) {
        $phone = $this->input->post('phone', TRUE);
      }

      $country = "";
      if ($this->input->post('country', TRUE)) {
        $country = $this->input->post('country', TRUE);
      }

      $city = "";
      if ($this->input->post('city', TRUE)) {
        $city = $this->input->post('city', TRUE);
      }
      //End Get Post Request
      
      //Check Error
      $data['message'] = "";
      if ($firstname === "") {
        $data['message'] .= "Firstname must be filled! <br/>";
      }
      if ($lastname === "") {
        $data['message'] .= "Lastname must be filled! <br/>";
      }
      if ($street_address === "") {
        $data['message'] .= "Street Address must be filled! <br/>";
      }
      if ($zip_code === "") {
        $data['message'] .= "Zip Code must be filled! <br/>";
      }
      if ($phone === "") {
        $data['message'] .= "Phone must be filled! <br/>";
      }
      if ($country === "") {
        $data['message'] .= "Country must be filled! <br/>";
      }
      if ($city === "") {
        $data['message'] .= "City must be filled! <br/>";
      }
      //End Check Error

      if ($data['message'] === "") {
        $data['result'] = "s";
      } else {
        $data['result'] = "f";
      }

      echo json_encode($data);
    }
  }

  function edit_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $id = "";
      if ($this->input->post('id', TRUE)) {
        $id = $this->input->post('id', TRUE);
      }
      
      $firstname = "";
      if ($this->input->post('firstname', TRUE)) {
        $firstname = $this->input->post('firstname', TRUE);
      }
      
      $lastname = "";
      if ($this->input->post('lastname', TRUE)) {
        $lastname = $this->input->post('lastname', TRUE);
      }
      
      $street_address = "";
      if ($this->input->post('street_address', TRUE)) {
        $street_address = $this->input->post('street_address', TRUE);
      }

      $zip_code = "";
      if ($this->input->post('zip_code', TRUE)) {
        $zip_code = $this->input->post('zip_code', TRUE);
      }
      
      $phone = "";
      if ($this->input->post('phone', TRUE)) {
        $phone = $this->input->post('phone', TRUE);
      }

      $country = "";
      if ($this->input->post('country', TRUE)) {
        $country = $this->input->post('country', TRUE);
      }

      $city = "";
      if ($this->input->post('city', TRUE)) {
        $city = $this->input->post('city', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_detail_address->edit_object($id, $firstname, $lastname, $street_address, $zip_code, $phone, $country, $city);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_detail_address->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['firstname'] = $row->firstname;
        $data['lastname'] = $row->lastname;
        $data['street_address'] = $row->street_address;
        $data['zip_code'] = $row->zip_code;
        $data['phone'] = $row->phone;
        $data['country'] = $row->country;
        $data['city'] = $row->city;
      }
      echo json_encode($data);
    }
  }

}
