<?php

class main extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Dashboard";
    $content['adminlevel'] = $this->session->userdata('adminlevel');
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/admin.js';
    
    $query = $this->model_admin->check_website()->result();
    foreach ($query as $row) {
      $content['status'] = $row->status;
    }

    $data['content'] = $this->load->view('dashboard/main/index', $content, TRUE);
    $this->load->view('dashboard/template_index', $data);
  }

}
