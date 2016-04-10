<?php

class email extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_email', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Email";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/email.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/email/modal_add', '', TRUE);
    $content['modal'][1] = $this->load->view('dashboard/email/modal_edit', '', TRUE);
    $content['modal'][2] = $this->load->view('dashboard/email/modal_remove', '', TRUE);

    $data['content'] = $this->load->view('dashboard/email/index', $content, TRUE);
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

      $totalrow = $this->model_email->get_object(0, $email, $active, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_email->get_object(0, $email, $active, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['email'][$temp] = $row->email;
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
        $data['message'] = "No Email";
      }
      echo json_encode($data);
    }
  }

  function check_field() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $email = "";
      if ($this->input->post('email', TRUE)) {
        $email = $this->input->post('email', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";

      if ($email === "") {
        $data['message'] .= "Email must be filled! <br/>";
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

  function add_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $email = "";
      if ($this->input->post('email', TRUE)) {
        $email = $this->input->post('email', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_email->add_object($email);

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

      $email = "";
      if ($this->input->post('email', TRUE)) {
        $email = $this->input->post('email', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_email->edit_object($id, $email);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_email->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
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

      $query = $this->model_email->get_active($id)->result();
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
      $this->model_email->set_active($id, $active);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $data['result'] = "s";
      $this->model_email->remove_object($id);

      echo json_encode($data);
    }
  }

}
