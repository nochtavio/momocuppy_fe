<?php

class admin extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Admin";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/admin.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/admin/modal_add', '', TRUE);
    $content['modal'][1] = $this->load->view('dashboard/admin/modal_edit', '', TRUE);
    $content['modal'][2] = $this->load->view('dashboard/admin/modal_remove', '', TRUE);

    $data['content'] = $this->load->view('dashboard/admin/index', $content, TRUE);
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
      $username = "";
      if ($this->input->post('username', TRUE)) {
        $username = $this->input->post('username', TRUE);
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

      $totalrow = $this->model_admin->get_object(0, $username, $active, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_admin->get_object(0, $username, $active, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['username'][$temp] = $row->username;
          $data['active'][$temp] = $row->active;
          $temp++;
        }
        $data['total'] = $temp;
        $data['size'] = $size;
      } else {
        $data['result'] = "f";
        $data['message'] = "No Admin";
      }
      echo json_encode($data);
    }
  }

  function check_field() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $username = "";
      if ($this->input->post('username', TRUE)) {
        $username = $this->input->post('username', TRUE);
      }

      $password = "";
      if ($this->input->post('password', TRUE)) {
        $password = $this->input->post('password', TRUE);
      }

      $confpassword = "";
      if ($this->input->post('confpassword', TRUE)) {
        $confpassword = $this->input->post('confpassword', TRUE);
      }

      $isEdit = 0;
      if ($this->input->post('isEdit', TRUE)) {
        $isEdit = $this->input->post('isEdit', TRUE);
      }

      $isEditPassword = 0;
      if ($this->input->post('isEditPassword', TRUE)) {
        $isEditPassword = $this->input->post('isEditPassword', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";
      if ($username === "") {
        $data['message'] .= "Username must be filled! <br/>";
      }
      if ($isEdit === 0) {
        $checkusername = $this->model_admin->check_admin($username)->num_rows();
        if ($checkusername > 0) {
          $data['message'] .= "Username is already used! <br/>";
        }
      }
      if ($isEditPassword === "1") {
        if ($password === "") {
          $data['message'] .= "Password must be filled! <br/>";
        }
        if ($confpassword === "") {
          $data['message'] .= "Confirmation Password must be filled! <br/>";
        }
        if ($password !== $confpassword) {
          $data['message'] .= "Password and Confirmation Password are not match! <br/>";
        }
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
      $username = "";
      if ($this->input->post('username', TRUE)) {
        $username = $this->input->post('username', TRUE);
      }

      $password = "";
      if ($this->input->post('password', TRUE)) {
        $password = $this->input->post('password', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_admin->add_object($username, $password);

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

      $password = "";
      if ($this->input->post('password', TRUE)) {
        $password = $this->input->post('password', TRUE);
      }

      $isEditPassword = 0;
      if ($this->input->post('isEditPassword', TRUE)) {
        $isEditPassword = $this->input->post('isEditPassword', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      if ($isEditPassword === 0) {
        $this->model_admin->edit_object2($id);
      } else {
        $this->model_admin->edit_object($id, $password);
      }

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_admin->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['username'] = $row->username;
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

      $query = $this->model_admin->get_active($id)->result();
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
      $this->model_admin->set_active($id, $active);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $data['result'] = "s";
      $this->model_admin->remove_object($id);

      echo json_encode($data);
    }
  }

}
