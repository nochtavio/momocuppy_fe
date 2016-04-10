<?php

class payment extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_payment', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Payment";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/payment.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/payment/modal_add', '', TRUE);
    $content['modal'][1] = $this->load->view('dashboard/payment/modal_edit', '', TRUE);
    $content['modal'][2] = $this->load->view('dashboard/payment/modal_remove', '', TRUE);

    $data['content'] = $this->load->view('dashboard/payment/index', $content, TRUE);
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
      $payment_name = "";
      if ($this->input->post('payment_name', TRUE)) {
        $payment_name = $this->input->post('payment_name', TRUE);
      }
      $rek_no = "";
      if ($this->input->post('rek_no', TRUE)) {
        $rek_no = $this->input->post('rek_no', TRUE);
      }
      $rek_name = "";
      if ($this->input->post('rek_name', TRUE)) {
        $rek_name = $this->input->post('rek_name', TRUE);
      }
      $visible = 0;
      if ($this->input->post('visible', TRUE)) {
        $visible = $this->input->post('visible', TRUE);
      }
      $order = 0;
      if ($this->input->post('order', TRUE)) {
        $order = $this->input->post('order', TRUE);
      }
      //End Filter

      $totalrow = $this->model_payment->get_object(0, $payment_name, $rek_no, $rek_name, $visible, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_payment->get_object(0, $payment_name, $rek_no, $rek_name, $visible, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['payment_name'][$temp] = $row->payment_name;
          $data['rek_no'][$temp] = $row->rek_no;
          $data['rek_name'][$temp] = $row->rek_name;
          $data['visible'][$temp] = $row->visible;

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
        $data['message'] = "No Payment";
      }
      echo json_encode($data);
    }
  }

  function check_field() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $payment_name = "";
      if ($this->input->post('payment_name', TRUE)) {
        $payment_name = $this->input->post('payment_name', TRUE);
      }

      $rek_no = "";
      if ($this->input->post('rek_no', TRUE)) {
        $rek_no = $this->input->post('rek_no', TRUE);
      }

      $rek_name = "";
      if ($this->input->post('rek_name', TRUE)) {
        $rek_name = $this->input->post('rek_name', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";

      if ($payment_name === "") {
        $data['message'] .= "Payment name must be filled! <br/>";
      }

      if ($rek_no === "") {
        $data['message'] .= "Rek No must be filled! <br/>";
      }

      if ($rek_name === "") {
        $data['message'] .= "Rek Name must be filled! <br/>";
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
      $payment_name = "";
      if ($this->input->post('payment_name', TRUE)) {
        $payment_name = $this->input->post('payment_name', TRUE);
      }

      $rek_no = "";
      if ($this->input->post('rek_no', TRUE)) {
        $rek_no = $this->input->post('rek_no', TRUE);
      }

      $rek_name = "";
      if ($this->input->post('rek_name', TRUE)) {
        $rek_name = $this->input->post('rek_name', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_payment->add_object($payment_name, $rek_no, $rek_name);

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

      $payment_name = "";
      if ($this->input->post('payment_name', TRUE)) {
        $payment_name = $this->input->post('payment_name', TRUE);
      }

      $rek_no = "";
      if ($this->input->post('rek_no', TRUE)) {
        $rek_no = $this->input->post('rek_no', TRUE);
      }

      $rek_name = "";
      if ($this->input->post('rek_name', TRUE)) {
        $rek_name = $this->input->post('rek_name', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_payment->edit_object($id, $payment_name, $rek_no, $rek_name);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_payment->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['payment_name'] = $row->payment_name;
        $data['rek_no'] = $row->rek_no;
        $data['rek_name'] = $row->rek_name;
        $data['visible'] = $row->visible;
      }
      echo json_encode($data);
    }
  }

  function set_visible() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $query = $this->model_payment->get_visible($id)->result();
      foreach ($query as $row) {
        $visible = $row->visible;
      }
      if ($visible === "0") {
        $visible = "1";
      } else {
        $visible = "0";
      }

      $data['result'] = "s";
      $data['visible'] = $visible;
      $this->model_payment->set_visible($id, $visible);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $data['result'] = "s";
      $this->model_payment->remove_object($id);

      echo json_encode($data);
    }
  }

}
