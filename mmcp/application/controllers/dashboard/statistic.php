<?php

class statistic extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_statistic', '', TRUE);
  }

  function index() {
    redirect('/mmcp/statistic/member/');
    die();
  }
  
  function member() {
    //Data
    $content['page'] = "Statistic Member";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/statistic_member.js';

    $data['content'] = $this->load->view('dashboard/statistic/member', $content, TRUE);
    $this->load->view('dashboard/template_index', $data);
  }
  
  function statistic_member() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Filter
      $from = "";
      if ($this->input->post('from', TRUE)) {
        $from = $this->input->post('from', TRUE);
      }
      $to = "";
      if ($this->input->post('to', TRUE)) {
        $to = $this->input->post('to', TRUE);
      }
      //End Filter
      $get_object = $this->model_statistic->statistic_member($from, $to);

      if ($get_object->num_rows() > 0) {
        $temp = 0;
        foreach ($get_object->result() as $row) {
          $data['result'] = "s";

          $data['registered_date'][$temp] = $row->registered_date;
          $data['total_member'][$temp] = $row->total_member;
          $temp++;
        }
        $data['total'] = $temp;
      } else {
        $data['result'] = "f";
        $data['message'] = "No Result";
      }
      echo json_encode($data);
    }
  }
  
  function product() {
    //Data
    $content['page'] = "Statistic Product";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/statistic_product.js';

    $data['content'] = $this->load->view('dashboard/statistic/product', $content, TRUE);
    $this->load->view('dashboard/template_index', $data);
  }
  
  function statistic_product() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Filter
      $from = "";
      if ($this->input->post('from', TRUE)) {
        $from = $this->input->post('from', TRUE);
      }
      $to = "";
      if ($this->input->post('to', TRUE)) {
        $to = $this->input->post('to', TRUE);
      }
      $product_name = "";
      if ($this->input->post('product_name', TRUE)) {
        $product_name = $this->input->post('product_name', TRUE);
      }
      //End Filter
      $get_object = $this->model_statistic->statistic_product($from, $to, $product_name);

      if ($get_object->num_rows() > 0) {
        $temp = 0;
        foreach ($get_object->result() as $row) {
          $data['result'] = "s";

          $data['product_name'][$temp] = $row->product_name;
          $data['total_order'][$temp] = $row->total_order;
          $temp++;
        }
        $data['total'] = $temp;
      } else {
        $data['result'] = "f";
        $data['message'] = "No Result";
      }
      echo json_encode($data);
    }
  }
  
  function order() {
    //Data
    $content['page'] = "Statistic Order";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/statistic_order.js';

    $data['content'] = $this->load->view('dashboard/statistic/order', $content, TRUE);
    $this->load->view('dashboard/template_index', $data);
  }
  
  function statistic_order() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Filter
      $from = "";
      if ($this->input->post('from', TRUE)) {
        $from = $this->input->post('from', TRUE);
      }
      $to = "";
      if ($this->input->post('to', TRUE)) {
        $to = $this->input->post('to', TRUE);
      }
      $email = "";
      if ($this->input->post('email', TRUE)) {
        $email = $this->input->post('email', TRUE);
      }
      //End Filter
      $get_object = $this->model_statistic->statistic_order($from, $to, $email);

      if ($get_object->num_rows() > 0) {
        $temp = 0;
        foreach ($get_object->result() as $row) {
          $data['result'] = "s";

          $data['order_date'][$temp] = $row->order_date;
          $data['total_order'][$temp] = $row->total_order;
          $temp++;
        }
        $data['total'] = $temp;
      } else {
        $data['result'] = "f";
        $data['message'] = "No Result";
      }
      echo json_encode($data);
    }
  }
  
  function category() {
    //Data
    $content['page'] = "Statistic Category";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/statistic_category.js';

    $data['content'] = $this->load->view('dashboard/statistic/category', $content, TRUE);
    $this->load->view('dashboard/template_index', $data);
  }
  
  function statistic_category() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Filter
      $from = "";
      if ($this->input->post('from', TRUE)) {
        $from = $this->input->post('from', TRUE);
      }
      $to = "";
      if ($this->input->post('to', TRUE)) {
        $to = $this->input->post('to', TRUE);
      }
      //End Filter
      $get_object = $this->model_statistic->statistic_category($from, $to);

      if ($get_object->num_rows() > 0) {
        $temp = 0;
        foreach ($get_object->result() as $row) {
          $data['result'] = "s";

          $data['category_name'][$temp] = $row->category_name;
          $data['total_order'][$temp] = $row->total_order;
          $temp++;
        }
        $data['total'] = $temp;
      } else {
        $data['result'] = "f";
        $data['message'] = "No Result";
      }
      echo json_encode($data);
    }
  }
  
  function shipping_cost() {
    //Data
    $content['page'] = "Statistic Shipping Cost";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/statistic_shipping_cost.js';

    $data['content'] = $this->load->view('dashboard/statistic/shipping_cost', $content, TRUE);
    $this->load->view('dashboard/template_index', $data);
  }
  
  function statistic_shipping_cost() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Filter
      $from = "";
      if ($this->input->post('from', TRUE)) {
        $from = $this->input->post('from', TRUE);
      }
      $to = "";
      if ($this->input->post('to', TRUE)) {
        $to = $this->input->post('to', TRUE);
      }
      //End Filter
      $get_object = $this->model_statistic->statistic_shipping_cost($from, $to);

      if ($get_object->num_rows() > 0) {
        $temp = 0;
        foreach ($get_object->result() as $row) {
          $data['result'] = "s";

          $data['order_date'][$temp] = $row->order_date;
          $data['total_cost'][$temp] = $row->total_cost;
          $temp++;
        }
        $data['total'] = $temp;
      } else {
        $data['result'] = "f";
        $data['message'] = "No Result";
      }
      echo json_encode($data);
    }
  }
  
  function export_excel(){
    $this->load->library("Excel");
    
    //Filter
    $page = "";
    if ($this->input->post('page', TRUE)) {
      $page = $this->input->post('page', TRUE);
    }
    $from = "";
    if ($this->input->post('from', TRUE)) {
      $from = $this->input->post('from', TRUE);
    }
    $to = "";
    if ($this->input->post('to', TRUE)) {
      $to = $this->input->post('to', TRUE);
    }
    $product_name = "";
    if ($this->input->post('product_name', TRUE)) {
      $product_name = $this->input->post('product_name', TRUE);
    }
    $email = "";
    if ($this->input->post('email', TRUE)) {
      $email = $this->input->post('email', TRUE);
    }
    //End Filter
    
    if($page == 'member'){
      $get_object = $this->model_statistic->statistic_member($from, $to);
    }else if($page == 'category'){
      $get_object = $this->model_statistic->statistic_category($from, $to);
    }else if($page == 'product'){
      $get_object = $this->model_statistic->statistic_product($from, $to, $product_name);
    }else if($page == 'order'){
      $get_object = $this->model_statistic->statistic_order($from, $to, $email);
    }else if($page == 'shipping_cost'){
      $get_object = $this->model_statistic->statistic_shipping_cost($from, $to);
    }
    
    $this->excel->to_excel($get_object, 'Export_Statistic_'.$page.'_'.date('dMy'));
  }
}
