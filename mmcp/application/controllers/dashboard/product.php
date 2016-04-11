<?php

class product extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_product', '', TRUE);
    $this->load->model('dashboard/model_detail_category', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Product";
    $content['pagesize'] = 10;
    
    //Get Category
    $content['category'] = $this->model_detail_category->generate_ms_category()->result();

    //JS
    $content['js'][0] = 'js/dashboard/private/product.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/product/modal_add', $content, TRUE);
    $content['modal'][1] = $this->load->view('dashboard/product/modal_edit', $content, TRUE);
    $content['modal'][2] = $this->load->view('dashboard/product/modal_remove', '', TRUE);

    $data['content'] = $this->load->view('dashboard/product/index', $content, TRUE);
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

      $totalrow = $this->model_product->get_object(0, $product_name, $visible, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_product->get_object(0, $product_name, $visible, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['product_name'][$temp] = $row->product_name;
          $data['product_price'][$temp] = number_format($row->product_price);
          $data['product_weight'][$temp] = $row->product_weight;
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

      $product_price = "";
      if ($this->input->post('product_price', TRUE)) {
        $product_price = $this->input->post('product_price', TRUE);
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
      if ($product_price === "") {
        $data['message'] .= "Product Price name must be filled! <br/>";
      } else if (!is_numeric($product_price)) {
        $data['message'] .= "Product Price must be a number! <br/>";
      }
      if ($product_desc === "") {
        $data['message'] .= "Product Description must be filled! <br/>";
      }
      if ($product_weight === "") {
        $data['message'] .= "Product Weight name must be filled! <br/>";
      } else if (!is_numeric($product_weight)) {
        $data['message'] .= "Product Weight must be a number! <br/>";
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

      $product_price = "";
      if ($this->input->post('product_price', TRUE)) {
        $product_price = $this->input->post('product_price', TRUE);
      }

      $product_desc = "";
      if ($this->input->post('product_desc')) {
        $product_desc = $this->input->post('product_desc');
      }

      $product_weight = "";
      if ($this->input->post('product_weight', TRUE)) {
        $product_weight = $this->input->post('product_weight', TRUE);
      }

      $publish_date = NULL;
      if ($this->input->post('publish_date', TRUE)) {
        $publish_date = $this->input->post('publish_date', TRUE);
      }

      $category = array();
      if ($this->input->post('category', TRUE)) {
        $category = $this->input->post('category', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $data['id_product'] = $this->model_product->add_object($product_name, $product_price, $product_desc, $product_weight, $publish_date, $category);
      $this->session->set_flashdata('add_product_message', 'You have succesfully add product to database. Please add stock for each color now.');
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

      $product_price = "";
      if ($this->input->post('product_price', TRUE)) {
        $product_price = $this->input->post('product_price', TRUE);
      }

      $product_desc = "";
      if ($this->input->post('product_desc')) {
        $product_desc = $this->input->post('product_desc');
      }

      $product_weight = "";
      if ($this->input->post('product_weight', TRUE)) {
        $product_weight = $this->input->post('product_weight', TRUE);
      }

      $publish_date = NULL;
      if ($this->input->post('publish_date', TRUE)) {
        $publish_date = $this->input->post('publish_date', TRUE);
      }

      $category = array();
      if ($this->input->post('category', TRUE)) {
        $category = $this->input->post('category', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_product->edit_object($id, $product_name, $product_price, $product_desc, $product_weight, $publish_date, $category);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_product->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['product_name'] = $row->product_name;
        $data['product_price'] = $row->product_price;
        $data['product_desc'] = $row->product_desc;
        $data['product_weight'] = $row->product_weight;
        $data['publish_date'] = $row->publish_date != null ? date_format(date_create($row->publish_date), 'Y-m-d') : null;
        $data['visible'] = $row->visible;

        //Get Category
        $data['category'] = array();
        $query_category = $this->model_detail_category->generate_dt_category($row->id)->result();
        foreach ($query_category as $row) {
          $data['category'][] = $row->id_category;
        }
      }
      echo json_encode($data);
    }
  }

  function set_visible() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $query = $this->model_product->get_visible($id)->result();
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
      $this->model_product->set_visible($id, $visible);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $data['result'] = "s";
      $this->model_product->remove_object($id);

      echo json_encode($data);
    }
  }

}
