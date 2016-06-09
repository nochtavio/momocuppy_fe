<?php

class color extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_color', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Color";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/color.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/color/modal_add', '', TRUE);
    $content['modal'][1] = $this->load->view('dashboard/color/modal_edit', '', TRUE);
    $content['modal'][2] = $this->load->view('dashboard/color/modal_remove', '', TRUE);

    $data['content'] = $this->load->view('dashboard/color/index', $content, TRUE);
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
      $color_name = "";
      if ($this->input->post('color_name', TRUE)) {
        $color_name = $this->input->post('color_name', TRUE);
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

      $totalrow = $this->model_color->get_object(0, $color_name, $visible, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_color->get_object(0, $color_name, $visible, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['color_name'][$temp] = $row->color_name;
          $data['color_code'][$temp] = $row->color_code;
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
        $data['message'] = "No Color";
      }
      echo json_encode($data);
    }
  }

  function check_field() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $color_name = "";
      if ($this->input->post('color_name', TRUE)) {
        $color_name = $this->input->post('color_name', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";

      if ($color_name === "") {
        $data['message'] .= "Color name must be filled! <br/>";
      }else{
		$check_color = $this->model_color->get_object(0, $color_name, -1, 0)->num_rows();
		if($check_color > 0){
			$data['message'] .= "Color name is already existed! <br/>";
		}
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
      $color_name = "";
      if ($this->input->post('color_name', TRUE)) {
        $color_name = $this->input->post('color_name', TRUE);
      }

      $color_code = "";
//      if ($this->input->post('color_code', TRUE)) {
//        $color_code = $this->input->post('color_code', TRUE);
//      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_color->add_object($color_name, $color_code);

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

      $color_name = "";
      if ($this->input->post('color_name', TRUE)) {
        $color_name = $this->input->post('color_name', TRUE);
      }

      $color_code = "";
//      if ($this->input->post('color_code', TRUE)) {
//        $color_code = $this->input->post('color_code', TRUE);
//      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_color->edit_object($id, $color_name, $color_code);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_color->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['color_name'] = $row->color_name;
        $data['color_code'] = $row->color_code;
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

      $query = $this->model_color->get_visible($id)->result();
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
      $this->model_color->set_visible($id, $visible);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);

      $data['result'] = "s";
      $this->model_color->remove_object($id);

      echo json_encode($data);
    }
  }

}
