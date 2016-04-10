<?php

class about_us extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_about_us', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "About Us";

    //JS
    $content['js'][0] = 'js/dashboard/private/about_us.js';

    $data['content'] = $this->load->view('dashboard/about_us/index', $content, TRUE);
    $this->load->view('dashboard/template_index', $data);
  }

  function check_field() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $content = "";
      if ($this->input->post('content', TRUE)) {
        $content = $this->input->post('content', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";

      if ($content === "") {
        $data['message'] .= "Content must be filled! <br/>";
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
      $content = "";
      if ($this->input->post('content')) {
        $content = $this->input->post('content');
      }

      //End Get Post Request

      $data['result'] = "s";
      $this->model_about_us->edit_object($content);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $query = $this->model_about_us->get_object()->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['content'] = $row->content;
        $data['modtime'] = $row->modtime;
        $data['modby'] = $row->modby;
      }
      echo json_encode($data);
    }
  }

}
