<?php

class order_archive extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_order_archive', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Order Archive";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/order_archive.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/order_archive/modal_edit', '', TRUE);
    $content['modal'][1] = $this->load->view('dashboard/order_archive/modal_remove', '', TRUE);
    $content['modal'][2] = $this->load->view('dashboard/order_archive/modal_detail_order', '', TRUE);

    $data['content'] = $this->load->view('dashboard/order_archive/index', $content, TRUE);
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
      $order_no = "";
      if ($this->input->post('order_no', TRUE)) {
        $order_no = $this->input->post('order_no', TRUE);
      }
      $resi_no = "";
      if ($this->input->post('resi_no', TRUE)) {
        $resi_no = $this->input->post('resi_no', TRUE);
      }
      $status = 0;
      if ($this->input->post('status', TRUE)) {
        $status = $this->input->post('status', TRUE);
      }
      $order = 0;
      if ($this->input->post('order', TRUE)) {
        $order = $this->input->post('order', TRUE);
      }
      //End Filter

      $totalrow = $this->model_order_archive->get_object(0, $email, $street_address, $zip_code, $country, $city, $order_no, $resi_no, $status, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_order_archive->get_object(0, $email, $street_address, $zip_code, $country, $city, $order_no, $resi_no, $status, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['email'][$temp] = $row->email;
          $data['street_address'][$temp] = $row->street_address;
          $data['zip_code'][$temp] = $row->zip_code;
          $data['country'][$temp] = $row->country;
          $data['city'][$temp] = $row->city;
          $data['order_no'][$temp] = $row->order_no;
          $data['resi_no'][$temp] = ($row->resi_no == null) ? "(empty)" : $row->resi_no;
          $data['payment_name'][$temp] = $row->payment_name;
          $data['voucher_name'][$temp] = ($row->voucher_name == null) ? "(no voucher)" : $row->voucher_name;
          $data['voucher_code'][$temp] = ($row->voucher_code == null) ? "(no voucher)" : $row->voucher_code;
          $data['discount'][$temp] = ($row->discount == null) ? "" : $row->discount;
          $data['paid_date'][$temp] = ($row->paid_date == null) ? "(not confirmed)" : date_format(date_create($row->paid_date), 'd F Y H:i:s');
          $data['paid_name'][$temp] = ($row->paid_name == null) ? "" : $row->paid_name;
          $data['paid_nominal'][$temp] = ($row->paid_nominal == null) ? "" : number_format($row->paid_nominal);
          $data['status'][$temp] = $this->setStatus($row->status);
          $data['archive'][$temp] = $row->archive;

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
        $data['message'] = "No Archieved Order";
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

      $status = 0;
      if ($this->input->post('status', TRUE)) {
        $status = $this->input->post('status', TRUE);
      }

      $resi_no = "";
      if ($this->input->post('resi_no', TRUE)) {
        $resi_no = $this->input->post('resi_no', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_order_archive->edit_object($id, $status, $resi_no);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_order_archive->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['status'] = $row->status;
        $data['resi_no'] = $row->resi_no;
      }
      echo json_encode($data);
    }
  }

  function set_archive() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $query = $this->model_order_archive->get_archive($id)->result();
      foreach ($query as $row) {
        $archive = $row->archive;
      }
      if ($archive === "0") {
        $archive = "1";
      } else {
        $archive = "0";
      }

      $data['result'] = "s";
      $data['archive'] = $archive;
      $this->model_order_archive->set_archive($id, $archive);

      echo json_encode($data);
    }
  }

  //Function Addon
  function setStatus($status) {
    if ($status == 2) {
      $status = "Member Confirmed";
    } else if ($status == 3) {
      $status = "Approved";
    } else if ($status == 4) {
      $status = "On Delivery";
    } else if ($status == 5) {
      $status = "Delivered";
    } else if ($status == 6) {
      $status = "Canceled";
    } else {
      $status = "Waiting for Payment";
    }

    return $status;
  }

  //End Function Addon 
}
