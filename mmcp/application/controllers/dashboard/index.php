<?php

class index extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
  }

  //Dashboard Function
  function login() {
    $username = $this->input->post('username', TRUE);
    $password = $this->input->post('password', TRUE);

    $data['message'] = '';

    if ($username === '' || $password === '') {
      $data['message'] = "Username/Password must be filled!";
    }

    if ($data['message'] === '') {
      $checkadmin = $this->model_admin->check_admin($username)->num_rows();
      if ($checkadmin > 0) {
        $validate_login = $this->model_admin->do_login($username, $password);
        if ($validate_login) {
          $data['result'] = 's';
          $session_data = array(
            'admin' => $username
          );
          $this->session->set_userdata($session_data);
        } else {
          $data['result'] = 'f';
          $data['message'] = 'Password is invalid!';
        }
      } else {
        $data['result'] = 'f';
        $data['message'] = 'Username is not exists or active!';
      }
    } else {
      $data['result'] = 'f';
    }

    echo json_encode($data);
  }

  function logout() {
    $this->session->sess_destroy();
    echo json_encode(true);
  }

  //End Dashboard Function
  //Dashboard View
  function index() {
    $this->load->view('dashboard/index', '');
  }

  //End Dashboard View
}
