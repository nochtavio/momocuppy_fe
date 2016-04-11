<?php

class type extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_type', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Type";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/type.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/type/modal_add', '', TRUE);
    $content['modal'][1] = $this->load->view('dashboard/type/modal_edit', '', TRUE);
    $content['modal'][2] = $this->load->view('dashboard/type/modal_remove', '', TRUE);

    $data['content'] = $this->load->view('dashboard/type/index', $content, TRUE);
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
      $type_name = "";
      if ($this->input->post('type_name', TRUE)) {
        $type_name = $this->input->post('type_name', TRUE);
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

      $totalrow = $this->model_type->get_object(0, $type_name, $visible, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_type->get_object(0, $type_name, $visible, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['type_name'][$temp] = $row->type_name;
          $data['position'][$temp] = $row->position;
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
        $data['message'] = "No Type";
      }
      echo json_encode($data);
    }
  }

  function check_field() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $type_name = "";
      if ($this->input->post('type_name', TRUE)) {
        $type_name = $this->input->post('type_name', TRUE);
      }

      $position = "";
      if ($this->input->post('position', TRUE)) {
        $position = $this->input->post('position', TRUE);
      }
      //End Get Post Request
      //Check Error
      $data['message'] = "";

      if ($type_name === "") {
        $data['message'] .= "Type name must be filled! <br/>";
      }
      if ($position === "") {
        $data['message'] .= "Position must be filled! <br/>";
      } else if (!is_numeric($position)) {
        $data['message'] .= "Position must be a number! <br/>";
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

  function upload_image() {
    //Get Post
    $element = $this->input->post('element', TRUE);
    $path = $this->input->post('path', TRUE);
    //End Get Post
    //Set File Name
    $lastid = $this->model_type->get_last_id()->result();
    if ($lastid) {
      foreach ($lastid as $row) {
        $newid = $row->id + 1;
        $img = "type" . $newid . ".png";
      }
    } else {
      $img = "type" . "1.png";
    }
    //End Set File Name

    $file_element_name = $element;
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'png';
    $config['max_size'] = 1024;
    $config['file_name'] = $img;
    $config['overwrite'] = TRUE;
    $this->upload->initialize($config);

    if (!$this->upload->do_upload($file_element_name)) {
      $data['result'] = 'f';
      $data['message'] = $this->upload->display_errors('', '');
    } else {
      $data['result'] = 's';
      $this->upload->data();
    }
    @unlink($_FILES[$file_element_name]);

    echo json_encode($data);
  }

  function add_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Post Request
      $type_name = "";
      if ($this->input->post('type_name', TRUE)) {
        $type_name = $this->input->post('type_name', TRUE);
      }

      $position = "";
      if ($this->input->post('position', TRUE)) {
        $position = $this->input->post('position', TRUE);
      }

      $lastid = $this->model_type->get_last_id()->result();
      if ($lastid) {
        foreach ($lastid as $row) {
          $newid = $row->id + 1;
          $img = 'type' . $newid . ".png";
        }
      } else {
        $img = "type1.png";
      }

      $data['result'] = "s";
      $this->model_type->add_object($type_name, $img, $position);

      echo json_encode($data);
    }
  }

  function update_image() {
    //Get Post
    $element = $this->input->post('element', TRUE);
    $path = $this->input->post('path', TRUE);
    $img = $this->input->post('img', TRUE);
    //End Get Post

    $file_element_name = $element;
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'png';
    $config['max_size'] = 1024;
    $config['file_name'] = $img;
    $config['overwrite'] = TRUE;
    $this->upload->initialize($config);

    if (!$this->upload->do_upload($file_element_name)) {
      $data['message'] = $this->upload->display_errors('', '');
      if ($data['message'] === "You did not select a file to upload.") {
        $data['result'] = 's';
      } else {
        $data['result'] = 'f';
      }
    } else {
      $data['result'] = 's';
      $this->upload->data();
    }
    @unlink($_FILES[$file_element_name]);

    echo json_encode($data);
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

      $type_name = "";
      if ($this->input->post('type_name', TRUE)) {
        $type_name = $this->input->post('type_name', TRUE);
      }

      $position = "";
      if ($this->input->post('position', TRUE)) {
        $position = $this->input->post('position', TRUE);
      }
      //End Get Post Request

      $data['result'] = "s";
      $this->model_type->edit_object($id, $type_name, $position);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_type->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['type_name'] = $row->type_name;
        $data['img'] = $row->img;
        $data['position'] = $row->position;
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

      $query = $this->model_type->get_visible($id)->result();
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
      $this->model_type->set_visible($id, $visible);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_type->get_object($id)->result();
      foreach ($query as $row) {
        $img = $row->img;
      }
      unlink('./images/type/' . $img);
      $data['result'] = "s";
      $this->model_type->remove_object($id);

      echo json_encode($data);
    }
  }

}
