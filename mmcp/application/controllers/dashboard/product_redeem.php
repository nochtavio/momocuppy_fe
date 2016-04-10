<?php

class product_redeem extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_product_redeem', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Product Redeem";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/product_redeem.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/product_redeem/modal_add', $content, TRUE);
    $content['modal'][1] = $this->load->view('dashboard/product_redeem/modal_edit', $content, TRUE);
    $content['modal'][2] = $this->load->view('dashboard/product_redeem/modal_remove', '', TRUE);

    $data['content'] = $this->load->view('dashboard/product_redeem/index', $content, TRUE);
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
      $product_name = "";
      if ($this->input->post('product_name', TRUE)) {
        $product_name = $this->input->post('product_name', TRUE);
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

      $totalrow = $this->model_product_redeem->get_object(0, $product_name, $visible, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_product_redeem->get_object(0, $product_name, $visible, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['product_name'][$temp] = $row->product_name;
          $data['product_point'][$temp] = $row->product_point;
          $data['publish_date'][$temp] = $row->publish_date != null ? date_format(date_create($row->publish_date), 'd F Y') : 'Not Set';
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
        $data['message'] = "No Product Type";
      }
      echo json_encode($data);
    }
  }

  function check_field() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $product_name = "";
      if ($this->input->post('product_name', TRUE)) {
        $product_name = $this->input->post('product_name', TRUE);
      }

      $product_point = "";
      if ($this->input->post('product_point', TRUE)) {
        $product_point = $this->input->post('product_point', TRUE);
      }

      $product_desc = "";
      if ($this->input->post('product_desc', TRUE)) {
        $product_desc = $this->input->post('product_desc', TRUE);
      }

      $product_weight = "";
      if ($this->input->post('product_weight', TRUE)) {
        $product_weight = $this->input->post('product_weight', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";
      if ($product_name === "") {
        $data['message'] .= "Product Type name must be filled! <br/>";
      }
      if ($product_point === "") {
        $data['message'] .= "Product Price name must be filled! <br/>";
      } else if (!is_numeric($product_point)) {
        $data['message'] .= "Product Point must be a number! <br/>";
      }
      if ($product_desc === "") {
        $data['message'] .= "Product Description must be filled! <br/>";
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
      $product_name = "";
      if ($this->input->post('product_name', TRUE)) {
        $product_name = $this->input->post('product_name', TRUE);
      }

      $product_point = "";
      if ($this->input->post('product_point', TRUE)) {
        $product_point = $this->input->post('product_point', TRUE);
      }

      $product_desc = "";
      if ($this->input->post('product_desc')) {
        $product_desc = $this->input->post('product_desc');
      }

      $publish_date = NULL;
      if ($this->input->post('publish_date', TRUE)) {
        $publish_date = $this->input->post('publish_date', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_product_redeem->add_object($product_name, $product_point, $product_desc, $publish_date);

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

      $product_name = "";
      if ($this->input->post('product_name', TRUE)) {
        $product_name = $this->input->post('product_name', TRUE);
      }

      $product_point = "";
      if ($this->input->post('product_point', TRUE)) {
        $product_point = $this->input->post('product_point', TRUE);
      }

      $product_desc = "";
      if ($this->input->post('product_desc')) {
        $product_desc = $this->input->post('product_desc');
      }

      $publish_date = NULL;
      if ($this->input->post('publish_date', TRUE)) {
        $publish_date = $this->input->post('publish_date', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_product_redeem->edit_object($id, $product_name, $product_point, $product_desc, $publish_date);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_product_redeem->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['product_name'] = $row->product_name;
        $data['product_point'] = $row->product_point;
        $data['product_desc'] = $row->product_desc;
        $data['publish_date'] = $row->publish_date != null ? date_format(date_create($row->publish_date), 'Y-m-d') : null;
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

      $query = $this->model_product_redeem->get_visible($id)->result();
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
      $this->model_product_redeem->set_visible($id, $visible);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $data['result'] = "s";
      $this->model_product_redeem->remove_object($id);

      echo json_encode($data);
    }
  }

}
