<?php

class wishlist extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_member', '', TRUE);
    $this->load->model('dashboard/model_wishlist', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Member";
    $content['pagesize'] = 10;
    $content['id_member'] = $this->input->get('id', TRUE);
    //Get Username
    $query_product = $this->model_member->get_object($content['id_member'])->result();
    foreach ($query_product as $row) {
      $content['email'] = $row->email;
    }

    //JS
    $content['js'][0] = 'js/dashboard/private/wishlist.js';

    //Modal


    $data['content'] = $this->load->view('dashboard/wishlist/index', $content, TRUE);
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
      $id_member = $this->input->post('id_member', TRUE);

      $product_name = "";
      if ($this->input->post('product_name', TRUE)) {
        $product_name = $this->input->post('product_name', TRUE);
      }

      $order = 0;
      if ($this->input->post('order', TRUE)) {
        $order = $this->input->post('order', TRUE);
      }
      //End Filter

      $totalrow = $this->model_wishlist->get_object(0, $id_member, $product_name, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_wishlist->get_object(0, $id_member, $product_name, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['id_member'][$temp] = $id_member;
          $data['product_name'][$temp] = $row->product_name;
          $temp++;
        }
        $data['total'] = $temp;
        $data['size'] = $size;
      } else {
        $data['result'] = "f";
        $data['message'] = "No Wishlist";
      }
      echo json_encode($data);
    }
  }

  function export_excel(){
    $this->load->library("Excel");
    
    $get_wishlist = $this->model_wishlist->export_wishlist();
    
    $this->excel->to_excel($get_wishlist, 'Export_Wishlist_'.date('dMy'));
  }
}
