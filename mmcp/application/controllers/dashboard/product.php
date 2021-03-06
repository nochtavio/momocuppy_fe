<?php

class product extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_product', '', TRUE);
    $this->load->model('dashboard/model_detail_product_img', '', TRUE);
    $this->load->model('dashboard/model_detail_product', '', TRUE);
    $this->load->model('dashboard/model_detail_category', '', TRUE);
    $this->load->model('dashboard/model_type', '', TRUE);
    $this->load->model('dashboard/model_color', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Product";
    $content['pagesize'] = 10;
    
    //Get Category
    $content['category'] = $this->model_detail_category->generate_ms_category()->result();
    //Get Type
    $content['fetch_type'] = $this->model_type->get_object(0, "", 1, 0)->result();
    
    //Get Color
    $content['fetch_color'] = $this->model_color->get_object(0, "", 1, 0)->result();

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
      $type = 0;
      if ($this->input->post('type', TRUE)) {
        $type = $this->input->post('type', TRUE);
      }
      $category = 0;
      if ($this->input->post('category', TRUE)) {
        $category = $this->input->post('category', TRUE);
      }
      $color = 0;
      if ($this->input->post('color', TRUE)) {
        $color = $this->input->post('color', TRUE);
      }
      $sale = 0;
      if ($this->input->post('sale', TRUE)) {
        $sale = $this->input->post('sale', TRUE);
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

      $totalrow = $this->model_product->get_object(0, $product_name, $type, $category, $color, $sale, $visible, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_product->get_object(0, $product_name, $type, $category, $color, $sale, $visible, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['img'][$temp] = $row->img;
          
          $category = $this->model_detail_category->generate_dt_category($row->id);
          $temp_category = "";
          $temp_type = "";
          if($category->num_rows() > 0){
            foreach ($category->result() as $cat) {
              if (strpos($temp_category, $cat->category_name) === false) {
                $temp_category = $temp_category.$cat->category_name.', ';
              }
              if (strpos($temp_type, $cat->type_name) === false) {
                $temp_type = $temp_type.$cat->type_name.', ';
              }
            }
            $data['category'][$temp] = substr($temp_category, 0, -2);
            $data['type'][$temp] = substr($temp_type, 0, -2);
          }else{
            $data['category'][$temp] = '-';
            $data['type'][$temp] = '-';
          }
          
          $color = $this->model_detail_product->get_object(0, $row->id);
          $temp_color = "";
          if($color->num_rows() > 0){
            foreach ($color->result() as $col) {
              $temp_color = $temp_color.$col->color_name.', ';
            }
            $data['color'][$temp] = substr($temp_color, 0, -2);
          }else{
            $data['color'][$temp] = '-';
          }
          
          $data['product_name'][$temp] = $row->product_name;
          $data['product_price'][$temp] = number_format($row->product_price);
          $data['stock'][$temp] = number_format($row->stock);
          $data['product_weight'][$temp] = $row->product_weight;
          $data['position'][$temp] = $row->position;
          $data['publish_date'][$temp] = $row->publish_date != null ? date_format(date_create($row->publish_date), 'd F Y') : 'Not Set';
          $data['sale'][$temp] = $row->sale;
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
        $data['message'] = "No Products";
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
      
      $position = "";
      if ($this->input->post('position', TRUE)) {
        $position = $this->input->post('position', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";
      if ($product_name === "") {
        $data['message'] .= "Product name must be filled! <br/>";
      } else if(strlen($product_name) > 22){
        $data['message'] .= "Product name length is more than 22 characters! <br/>";
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
      if ($position === "") {
        $data['message'] .= "Product Position name must be filled! <br/>";
      } else if (!is_numeric($position)) {
        $data['message'] .= "Product Position must be a number! <br/>";
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
      
      $position = "";
      if ($this->input->post('position', TRUE)) {
        $position = $this->input->post('position', TRUE);
      }

      $category = array();
      if ($this->input->post('category', TRUE)) {
        $category = $this->input->post('category', TRUE);
      }
      
      $visible = 0;
      if ($this->input->post('visible', TRUE)) {
        $visible = $this->input->post('visible', TRUE);
      }
      
      $sale = 0;
      if ($this->input->post('sale', TRUE)) {
        $sale = $this->input->post('sale', TRUE);
      }
      //End Get Post Request
      
      //Check Image Validation
      $lastid = $this->model_detail_product_img->get_last_id()->result();
      if ($lastid) {
        foreach ($lastid as $row) {
          $newid = $row->id + 1;
          $img = "product" . $newid . ".jpg";
        }
      } else {
        $img = "product1.jpg";
      }
      
      $check_element = 'userfile';
      $config['upload_path'] = './images/products/';
      $config['allowed_types'] = 'jpg';
      $config['max_size'] = 600;
      $config['file_name'] = $img;
      $config['overwrite'] = TRUE;

      $this->upload->initialize($config);
      $uplst = false;
      if (!$this->upload->do_upload($check_element)) {
        $uplst = false;
        $data['message'] = $this->upload->display_errors('', '');
      } else {
        $uplst = true;
      }
      //End Check Image Validation
      
      if($uplst){
        $data['result'] = "s";
        $data['id_product'] = $this->model_product->add_object($product_name, $product_price, $product_desc, $product_weight, $publish_date, $position, $category, $visible, $sale);

        //Upload Image

        //Check Directory
        if (!is_dir('images/products/'.$data['id_product'])){
          mkdir('./images/products/'.$data['id_product'].'/', 0777, true);
        }

        $file_element_name = 'userfile';
        $config['upload_path'] = './images/products/'.$data['id_product'].'/';
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

        $saved_img = $data['id_product'].'/'.$img;
        if ($uplst) {
          $data['result'] = "s";
          $this->model_detail_product_img->add_object($data['id_product'], $saved_img);
        } else {
          $data['result'] = "f";
        }
        //End Upload Image

        $this->session->set_flashdata('add_product_message', 'You have succesfully add product to database. Please add stock for each color now.');
      }else{
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
      
      $position = "";
      if ($this->input->post('position', TRUE)) {
        $position = $this->input->post('position', TRUE);
      }

      $category = array();
      if ($this->input->post('category', TRUE)) {
        $category = $this->input->post('category', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_product->edit_object($id, $product_name, $product_price, $product_desc, $product_weight, $publish_date, $position, $category);

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
        $data['publish_date'] = $row->publish_date != null ? date_format(date_create($row->publish_date), 'Y-m-d H:i:s') : null;
        $data['position'] = $row->position;
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
  
  function set_sale() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $query = $this->model_product->get_sale($id)->result();
      foreach ($query as $row) {
        $sale = $row->sale;
      }
      if ($sale === "0") {
        $sale = "1";
      } else {
        $sale = "0";
      }

      $data['result'] = "s";
      $data['sale'] = $sale;
      $this->model_product->set_sale($id, $sale);

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
