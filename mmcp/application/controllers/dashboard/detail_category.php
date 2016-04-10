<?php

class detail_category extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_category', '', TRUE);
    $this->load->model('dashboard/model_detail_category', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Category";
    $content['pagesize'] = 10;
    $content['id_category'] = $this->input->get('id', TRUE);
    //Get Category Name
    $query_main_category = $this->model_category->get_object($content['id_category'])->result();
    foreach ($query_main_category as $row) {
      $content['main_category_name'] = $row->category_name;
    }

    //Get Category
    $query_category = $this->model_detail_category->generate_ms_category()->result();
    $content['category_total'] = 0;
    foreach ($query_category as $row) {
      $content['category_id'][$content['category_total']] = $row->id;
      $content['category_name'][$content['category_total']] = $row->category_name;
      $content['category_total'] ++;
    }

    //Get Product
    $query_product = $this->model_detail_category->generate_ms_product()->result();
    $content['product_total'] = 0;
    foreach ($query_product as $row) {
      $content['product_id'][$content['product_total']] = $row->id;
      $content['product_name'][$content['product_total']] = $row->product_name;
      $content['product_total'] ++;
    }

    //JS
    $content['js'][0] = 'js/dashboard/private/detail_category.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/detail_category/modal_add', $content, TRUE);
    $content['modal'][2] = $this->load->view('dashboard/detail_category/modal_remove', '', TRUE);

    $data['content'] = $this->load->view('dashboard/detail_category/index', $content, TRUE);
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
      $id_category = "";
      if ($this->input->post('id_category', TRUE)) {
        $id_category = $this->input->post('id_category', TRUE);
      }

      $order = 0;
      if ($this->input->post('order', TRUE)) {
        $order = $this->input->post('order', TRUE);
      }
      //End Filter)
      $totalrow = $this->model_detail_category->get_object(0, $id_category, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_detail_category->get_object(0, $id_category, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['id_category'][$temp] = $row->id_category;
          $data['id_product'][$temp] = $row->id_product;
          $data['category_name'][$temp] = $row->category_name;
          $data['product_name'][$temp] = $row->product_name;

          $data['cretime'][$temp] = date_format(date_create($row->cretime), 'd F Y H:i:s');
          $data['creby'][$temp] = $row->creby;
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
      $id_category = 0;
      if ($this->input->post('id_category', TRUE)) {
        $id_category = $this->input->post('id_category', TRUE);
      }

      $id_product = 0;
      if ($this->input->post('id_product', TRUE)) {
        $id_product = $this->input->post('id_product', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";

      if ($id_category == 0) {
        $data['message'] .= "Category must be choosen! <br/>";
      }

      if ($id_product == 0) {
        $data['message'] .= "Product must be choosen! <br/>";
      }

      if ($this->model_detail_category->validate_product($id_category, $id_product)->num_rows() > 0) {
        $data['message'] .= "Product is already exist on that category <br/>";
      } //check duplicate product
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
      $id_category = 0;
      if ($this->input->post('id_category', TRUE)) {
        $id_category = $this->input->post('id_category', TRUE);
      }

      $id_product = 0;
      if ($this->input->post('id_product', TRUE)) {
        $id_product = $this->input->post('id_product', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_detail_category->add_object($id_category, $id_product);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $data['result'] = "s";
      $this->model_detail_category->remove_object($id);

      echo json_encode($data);
    }
  }

}
