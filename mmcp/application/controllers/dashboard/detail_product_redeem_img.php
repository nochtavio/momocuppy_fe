<?php

class detail_product_redeem_img extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_product_redeem', '', TRUE);
    $this->load->model('dashboard/model_detail_product_redeem_img', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Product Redeem";
    $content['pagesize'] = 10;
    $content['id_product'] = $this->input->get('id', TRUE);
    //Get Product Name
    $query_product = $this->model_product_redeem->get_object($content['id_product'])->result();
    foreach ($query_product as $row) {
      $content['product_name'] = $row->product_name;
    }

    //JS
    $content['js'][0] = 'js/dashboard/private/detail_product_redeem_img.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/detail_product_redeem_img/modal_add', $content, TRUE);
    $content['modal'][1] = $this->load->view('dashboard/detail_product_redeem_img/modal_edit', '', TRUE);
    $content['modal'][2] = $this->load->view('dashboard/detail_product_redeem_img/modal_remove', '', TRUE);

    $data['content'] = $this->load->view('dashboard/detail_product_redeem_img/index', $content, TRUE);
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

      $visible = 0;
      if ($this->input->post('visible', TRUE)) {
        $visible = $this->input->post('visible', TRUE);
      }

      $order = 0;
      if ($this->input->post('order', TRUE)) {
        $order = $this->input->post('order', TRUE);
      }
      //End Filter

      $totalrow = $this->model_detail_product_redeem_img->get_object(0, $id_product, $visible, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_detail_product_redeem_img->get_object(0, $id_product, $visible, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['id_product'][$temp] = $id_product;
          $data['img'][$temp] = $row->img;
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
      $img = "";
      if ($this->input->post('img', TRUE)) {
        $img = $this->input->post('img', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";
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

      //Upload Image
      $lastid = $this->model_detail_product_redeem_img->get_last_id()->result();
      if ($lastid) {
        foreach ($lastid as $row) {
          $newid = $row->id + 1;
          $img = "product_redeem" . $newid . ".jpg";
        }
      } else {
        $img = "product_redeem1.jpg";
      }
      
      //Check Directory
      if (!is_dir('images/products/'.$id_product)){
        mkdir('./images/products/'.$id_product.'/', 0777, true);
      }
      
      $file_element_name = 'userfile';
      $config['upload_path'] = './images/products/'.$id_product.'/';
      $config['allowed_types'] = 'jpg';
      $config['max_size'] = 600;
      $config['file_name'] = $img;
      $config['overwrite'] = TRUE;

      $this->upload->initialize($config);
      $uplst = false;
      if (!$this->upload->do_upload($file_element_name)) {
        $uplst = false;
        $data['message'] = $this->upload->display_errors('', '');
      } else {
        $uplst = true;
        $this->upload->data();
      }
      @unlink($_FILES[$file_element_name]);
      //End Upload Image
      
      $saved_img = $id_product.'/'.$img;
      if ($uplst) {
        $data['result'] = "s";
        $this->model_detail_product_redeem_img->add_object($id_product, $saved_img);
      } else {
        $data['result'] = "f";
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
      
      $id_product = $this->model_detail_product_img->get_id_product($id)->row()->id_product;

      //Upload Image
      $img = "product_redeem" . $id . ".jpg";
      $file_element_name = 'editfile';
      $config['upload_path'] = './images/products/'.$id_product.'/';
      $config['allowed_types'] = 'jpg';
      $config['max_size'] = 600;
      $config['file_name'] = $img;
      $config['overwrite'] = TRUE;

      $this->upload->initialize($config);
      $uplst = 0; //0 Wrong Param; 1 Valid Image; 2 No Image Uploaded
      if (!$this->upload->do_upload($file_element_name)) {
        $data['message'] = $this->upload->display_errors('', '');
      } else {
        $uplst = 1;
        $this->upload->data();
      }
      @unlink($_FILES[$file_element_name]);
      //End Upload Image
      
      $saved_img = $id_product.'/'.$img;
      if ($uplst > 0) {
        $data['result'] = "s";
        $this->model_detail_product_redeem_img->edit_object($id, $saved_img);
      } else {
        $data['result'] = "f";
      }

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_detail_product_redeem_img->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['img'] = $row->img;
      }
      echo json_encode($data);
    }
  }

  function set_visible() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $query = $this->model_detail_product_redeem_img->get_visible($id)->result();
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
      $this->model_detail_product_redeem_img->set_visible($id, $visible);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      //Get Image File
      $query_product_img = $this->model_detail_product_redeem_img->get_img_file($id)->result();
      foreach ($query_product_img as $row) {
        $file = $row->img;
      }

      unlink('./images/products/' . $file);
      $data['result'] = "s";
      $this->model_detail_product_redeem_img->remove_object($id);

      echo json_encode($data);
    }
  }

}
