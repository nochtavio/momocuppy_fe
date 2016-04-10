<?php

class detail_product extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_product', '', TRUE);
    $this->load->model('dashboard/model_detail_product', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Product";
    $content['pagesize'] = 10;
    $content['id_product'] = $this->input->get('id', TRUE);
    
    //Get Flash Data
    if($this->session->flashdata('add_product_message')){
      $content['add_product_message'] = $this->session->flashdata('add_product_message');
    }
    
    //Get Product Name
    $query_product = $this->model_product->get_object($content['id_product'])->result();
    foreach ($query_product as $row) {
      $content['product_name'] = $row->product_name;
    }

    //Get Colors
    $query_color = $this->model_detail_product->generate_ms_color()->result();
    $content['color_total'] = 0;
    foreach ($query_color as $row) {
      $content['color_id'][$content['color_total']] = $row->id;
      $content['color_name'][$content['color_total']] = $row->color_name;
      $content['color_code'][$content['color_total']] = $row->color_code;
      $content['color_total'] ++;
    }

    //JS
    $content['js'][0] = 'js/dashboard/private/detail_product.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/detail_product/modal_add', $content, TRUE);
    $content['modal'][1] = $this->load->view('dashboard/detail_product/modal_edit', '', TRUE);
    $content['modal'][2] = $this->load->view('dashboard/detail_product/modal_remove', '', TRUE);

    $data['content'] = $this->load->view('dashboard/detail_product/index', $content, TRUE);
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
      $id_product = $this->input->post('id_product', TRUE);

      $id_color = "";
      if ($this->input->post('id_color', TRUE)) {
        $id_color = $this->input->post('id_color', TRUE);
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

      $totalrow = $this->model_detail_product->get_object(0, $id_product, $id_color, $visible, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_detail_product->get_object(0, $id_product, $id_color, $visible, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['id_product'][$temp] = $id_product;
          $data['id_color'][$temp] = $row->id_color;
          $data['color_name'][$temp] = $row->color_name;
          $data['stock'][$temp] = $row->stock;
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
        $data['message'] = "No Data";
      }
      echo json_encode($data);
    }
  }

  function check_field() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $id_product = "";
      if ($this->input->post('id_product', TRUE)) {
        $id_product = $this->input->post('id_product', TRUE);
      }

      $id_color = "";
      if ($this->input->post('id_color', TRUE)) {
        $id_color = $this->input->post('id_color', TRUE);
      }

      $stock = "";
      if ($this->input->post('stock', TRUE)) {
        $stock = $this->input->post('stock', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";
      if ($id_product != "" && $this->model_detail_product->validate_color($id_product, $id_color)->num_rows() > 0) {
        $data['message'] .= "Color is already used for this product! <br/>";
      } //check duplicate color if id product is filled

      if ($stock === "") {
        $data['message'] .= "Stock must be filled! <br/>";
      } else if (!is_numeric($stock)) {
        $data['message'] .= "Stock must be a number! <br/>";
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
      $id_product = $this->input->post('id_product', TRUE);

      $id_color = "";
      if ($this->input->post('id_color', TRUE)) {
        $id_color = $this->input->post('id_color', TRUE);
      }

      $stock = "";
      if ($this->input->post('stock', TRUE)) {
        $stock = $this->input->post('stock', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_detail_product->add_object($id_product, $id_color, $stock);

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

      $stock = "";
      if ($this->input->post('stock', TRUE)) {
        $stock = $this->input->post('stock', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_detail_product->edit_object($id, $stock);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_detail_product->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['color_name'] = $row->color_name;
        $data['stock'] = $row->stock;
      }
      echo json_encode($data);
    }
  }

  function set_visible() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $query = $this->model_detail_product->get_visible($id)->result();
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
      $this->model_detail_product->set_visible($id, $visible);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $data['result'] = "s";
      $this->model_detail_product->remove_object($id);

      echo json_encode($data);
    }
  }

}
