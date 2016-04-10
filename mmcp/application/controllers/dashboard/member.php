<?php

class member extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_member', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Member";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/member.js';

    //Modal
    $content['modal'][1] = $this->load->view('dashboard/member/modal_edit', '', TRUE);

    $data['content'] = $this->load->view('dashboard/member/index', $content, TRUE);
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
      $firstname = "";
      if ($this->input->post('firstname', TRUE)) {
        $firstname = $this->input->post('firstname', TRUE);
      }
      $lastname = "";
      if ($this->input->post('lastname', TRUE)) {
        $lastname = $this->input->post('lastname', TRUE);
      }
      $email = "";
      if ($this->input->post('email', TRUE)) {
        $email = $this->input->post('email', TRUE);
      }
      $active = 0;
      if ($this->input->post('active', TRUE)) {
        $active = $this->input->post('active', TRUE);
      }
      $order = 0;
      if ($this->input->post('order', TRUE)) {
        $order = $this->input->post('order', TRUE);
      }
      //End Filter

      $totalrow = $this->model_member->get_object(0, $firstname, $lastname, $email, $active, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_member->get_object(0, $firstname, $lastname, $email, $active, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['firstname'][$temp] = $row->firstname;
          $data['lastname'][$temp] = $row->lastname;
          $data['phone'][$temp] = $row->phone;
          $data['email'][$temp] = $row->email;
          $data['point'][$temp] = (is_null($row->point_member)) ? 0 : $row->point_member;
          $data['active'][$temp] = $row->active;

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
        $data['message'] = "No Member";
      }
      echo json_encode($data);
    }
  }

  function check_field() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $firstname = "";
      if ($this->input->post('firstname', TRUE)) {
        $firstname = $this->input->post('firstname', TRUE);
      }

      $lastname = "";
      if ($this->input->post('lastname', TRUE)) {
        $lastname = $this->input->post('lastname', TRUE);
      }

      $phone = "";
      if ($this->input->post('phone', TRUE)) {
        $phone = $this->input->post('phone', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";

      if ($firstname === "") {
        $data['message'] .= "First Name must be filled! <br/>";
      }

      if ($lastname === "") {
        $data['message'] .= "Last Name must be filled! <br/>";
      }

      if ($phone === "") {
        $data['message'] .= "Phone must be filled! <br/>";
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

      $phone = "";
      if ($this->input->post('phone', TRUE)) {
        $phone = $this->input->post('phone', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_member->edit_object($id, $firstname, $lastname, $phone);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_member->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['firstname'] = $row->firstname;
        $data['lastname'] = $row->lastname;
        $data['phone'] = $row->phone;
        $data['email'] = $row->email;
        $data['active'] = $row->active;
      }
      echo json_encode($data);
    }
  }

  function set_active() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $query = $this->model_member->get_active($id)->result();
      foreach ($query as $row) {
        $active = $row->active;
      }
      if ($active === "0") {
        $active = "1";
      } else {
        $active = "0";
      }

      $data['result'] = "s";
      $data['active'] = $active;
      $this->model_member->set_active($id, $active);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $data['result'] = "s";
      $this->model_member->remove_object($id);

      echo json_encode($data);
    }
  }

}
