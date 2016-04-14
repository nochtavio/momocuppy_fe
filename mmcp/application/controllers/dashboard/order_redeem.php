<?php

class order_redeem extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_order', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Order Redeem";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/order_redeem.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/order_redeem/modal_edit', '', TRUE);
    $content['modal'][1] = $this->load->view('dashboard/order_redeem/modal_remove', '', TRUE);
    $content['modal'][2] = $this->load->view('dashboard/order_redeem/modal_detail_order', '', TRUE);

    $data['content'] = $this->load->view('dashboard/order_redeem/index', $content, TRUE);
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
      $cretime_from = "";
      if ($this->input->post('cretime_from', TRUE)) {
        $cretime_from = $this->input->post('cretime_from', TRUE);
      }
      $cretime_to = "";
      if ($this->input->post('cretime_to', TRUE)) {
        $cretime_to = $this->input->post('cretime_to', TRUE);
      }
      $order = 0;
      if ($this->input->post('order', TRUE)) {
        $order = $this->input->post('order', TRUE);
      }
      //End Filter

      $totalrow = $this->model_order->get_object(0, 1, $email, $street_address, $zip_code, $country, $city, $order_no, $resi_no, $status, $cretime_from, $cretime_to, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_order->get_object(0, 1, $email, $street_address, $zip_code, $country, $city, $order_no, $resi_no, $status, $cretime_from, $cretime_to, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['product_name'][$temp] = $row->product_name;
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
        $data['message'] = "No Order";
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
      $this->model_order->edit_redeem($id, $status, $resi_no);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_order->get_object($id, 1)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['street_address'] = $row->street_address;
        $data['zip_code'] = $row->zip_code;
        $data['country'] = $row->country;
        $data['city'] = $row->city;
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

      $query = $this->model_order->get_archive($id)->result();
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
      $this->model_order->set_archive($id, $archive);

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

  function show_detail_order() {
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
      $order_id = 0;
      if ($this->input->post('order_id', TRUE)) {
        $order_id = $this->input->post('order_id', TRUE);
      }
      //End Filter

      $totalrow = $this->model_order->get_detail_order($order_id)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_order->get_detail_order($order_id, $limit, $size)->result();
        $temp = 0;
        $totalprice = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['order_no'][$temp] = $row->order_no;
          $data['product_name'][$temp] = $row->product_name;
          $data['color_name'][$temp] = $row->color_name;
          $data['price'][$temp] = number_format($row->price);
          $data['qty'][$temp] = number_format($row->qty);
          $data['subtotal'][$temp] = number_format($row->price * $row->qty);
          $data['discount'][$temp] = ($row->discount == null) ? 0 : $row->discount;
          $data['shipping_cost'][$temp] = number_format($row->shipping_cost);
          $totalprice += $row->price * $row->qty;
          $temp++;
        }
        $data['totalprice'] = number_format($totalprice);
        $data['grandtotal'] = number_format(($totalprice + $row->shipping_cost) * (1 - (($row->discount == null) ? 0 : $row->discount / 100)));
        $data['total'] = $temp;
        $data['size'] = $size;
      } else {
        $data['result'] = "f";
        $data['message'] = "No Data";
      }
      echo json_encode($data);
    }
  }
  
  function export_excel(){
    $this->load->library("Excel");
    
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
    $cretime_from = "";
    if ($this->input->post('cretime_from', TRUE)) {
      $cretime_from = $this->input->post('cretime_from', TRUE);
    }
    $cretime_to = "";
    if ($this->input->post('cretime_to', TRUE)) {
      $cretime_to = $this->input->post('cretime_to', TRUE);
    }
    $order = 0;
    if ($this->input->post('order', TRUE)) {
      $order = $this->input->post('order', TRUE);
    }
    //End Filter
    
    $query = $this->model_order->get_object(0, 1, $email, $street_address, $zip_code, $country, $city, $order_no, $resi_no, $status, $cretime_from, $cretime_to, $order)->result();
    $temp = 0;
    $data = array();
    foreach ($query as $row) {
      $data[$temp]['email'] = $row->email;
      $data[$temp]['ordered_date'] = date_format(date_create($row->cretime), 'd F Y H:i:s');
      $data[$temp]['order_id'] = $row->order_no;
      $data[$temp]['product_name'] = $row->product_name;
      $temp++;
    }
    $this->excel->to_excel_array($data, 'Order_Redeem_Excel_'.date('dMy'));
  }
  //End Function Addon 
}
