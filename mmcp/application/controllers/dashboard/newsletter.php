<?php

class newsletter extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->model('dashboard/model_newsletter', '', TRUE);
  }

  function index() {
    //Data
    $content['page'] = "Newsletter";
    $content['pagesize'] = 10;

    //JS
    $content['js'][0] = 'js/dashboard/private/newsletter.js';

    //Modal
    $content['modal'][0] = $this->load->view('dashboard/newsletter/modal_add', '', TRUE);
    $content['modal'][1] = $this->load->view('dashboard/newsletter/modal_edit', '', TRUE);
    $content['modal'][2] = $this->load->view('dashboard/newsletter/modal_remove', '', TRUE);

    $data['content'] = $this->load->view('dashboard/newsletter/index', $content, TRUE);
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
      $title = "";
      if ($this->input->post('title', TRUE)) {
        $title = $this->input->post('title', TRUE);
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

      $totalrow = $this->model_newsletter->get_object(0, $title, $visible, $order)->num_rows();

      //Set totalpaging
      $totalpage = ceil($totalrow / $size);
      $data['totalpage'] = $totalpage;
      //End Set totalpaging

      if ($totalrow > 0) {
        $query = $this->model_newsletter->get_object(0, $title, $visible, $order, $limit, $size)->result();
        $temp = 0;
        foreach ($query as $row) {
          $data['result'] = "s";

          $data['id'][$temp] = $row->id;
          $data['title'][$temp] = $row->title;
          $data['banner1'][$temp] = $row->banner1;
          $data['link1'][$temp] = $row->banner1;
          $data['banner2'][$temp] = $row->banner2;
          $data['link2'][$temp] = $row->link2;
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
      $title = "";
      if ($this->input->post('title', TRUE)) {
        $title = $this->input->post('title', TRUE);
      }
      
      $link1 = "";
      if ($this->input->post('link1', TRUE)) {
        $link1 = $this->input->post('link1', TRUE);
      }

      $link2 = "";
      if ($this->input->post('link2', TRUE)) {
        $link2 = $this->input->post('link2', TRUE);
      }
      //End Get Post Request
      
      //Check Error
      $data['message'] = "";
      
      if ($title === "") {
        $data['message'] .= "Title must be filled! <br/>";
      }
      if ($link1 === "") {
        $data['message'] .= "Link 1 must be filled! <br/>";
      }
      if ($link2 === "") {
        $data['message'] .= "Link 2 must be filled! <br/>";
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
    $type = $this->input->post('type', TRUE);
    //End Post
    
    $lastid = $this->model_newsletter->get_last_id();
    $id = ($lastid->result()) ? $lastid->row()->id + 1 : 1 ;
    $img = $type . ".jpg";
    
    //Check Directory
    if (!is_dir('images/newsletter/'.$id)){
      mkdir('./images/newsletter/'.$id.'/', 0777, true);
    }
    
    $file_element_name = $element;
    $config['upload_path'] = './images/newsletter/'.$id.'/';
    $config['allowed_types'] = 'jpg';
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
      $title = "";
      if ($this->input->post('title', TRUE)) {
        $title = $this->input->post('title', TRUE);
      }
      
      $link1 = "";
      if ($this->input->post('link1', TRUE)) {
        $link1 = $this->input->post('link1', TRUE);
      }

      $link2 = "";
      if ($this->input->post('link2', TRUE)) {
        $link2 = $this->input->post('link2', TRUE);
      }
      //End Get Post Request
      
      $lastid = $this->model_newsletter->get_last_id();
      $id = ($lastid->result()) ? $lastid->row()->id + 1 : 1 ;
      $banner1 = $id.'/banner1.jpg';
      $banner2 = $id.'/banner2.jpg';

      $data['result'] = "s";
      $this->model_newsletter->add_object($title, $banner1, $link1, $banner2, $link2);

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
    $config['allowed_types'] = 'jpg';
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
      
      $title = "";
      if ($this->input->post('title', TRUE)) {
        $title = $this->input->post('title', TRUE);
      }

      $link1 = "";
      if ($this->input->post('link1', TRUE)) {
        $link1 = $this->input->post('link1', TRUE);
      }

      $link2 = "";
      if ($this->input->post('link2', TRUE)) {
        $link2 = $this->input->post('link2', TRUE);
      }
      
      $banner1 = $id.'/banner1.jpg';
      $banner2 = $id.'/banner2.jpg';
      //End Get Post Request

      $data['result'] = "s";
      $this->model_newsletter->edit_object($id, $title, $banner1, $link1, $banner2, $link2);

      echo json_encode($data);
    }
  }

  function get_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      $query = $this->model_newsletter->get_object($id)->result();
      foreach ($query as $row) {
        $data['result'] = "s";

        $data['id'] = $row->id;
        $data['title'] = $row->title;
        $data['banner1'] = $row->banner1;
        $data['link1'] = $row->link1;
        $data['banner2'] = $row->banner2;
        $data['link2'] = $row->link2;
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

      $query = $this->model_newsletter->get_visible($id)->result();
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
      $this->model_newsletter->set_visible($id, $visible);

      echo json_encode($data);
    }
  }

  function remove_object() {
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $id = $this->input->post('id', TRUE);
      unlink('./images/newsletter/' . $id . '/banner1.jpg');
      unlink('./images/newsletter/' . $id . '/banner2.jpg');
      $data['result'] = "s";
      $this->model_newsletter->remove_object($id);

      echo json_encode($data);
    }
  }
  
  function send_newsletter(){
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $data['id_newsletter'] = $this->input->get('id', TRUE);
      $this->load->view('dashboard/newsletter/send_newsletter', $data);
    }
  }
  
  function get_subscriber(){
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      $email = array();
      $query_subscriber = $this->model_newsletter->get_subcsribers()->result();
      foreach ($query_subscriber as $row) {
        
        //Check if subscriber is not receive yet new newsletter
        $valid = TRUE;
        $last_send = ($row->last_send != NULL) ? strtotime(date($row->last_send)) : NULL ;
        if($last_send != NULL){
          if($last_send < strtotime('-1 day')) {
            $valid = TRUE;
          }else{
            $valid = TRUE;
          }
        }else{
          $valid = TRUE;
        }
        
        if($valid){
          array_push($email, $row->email);
        }
      }
      if(count($email) > 0){
        $data['result'] = 's';
        $data['content'] = $email;
      }else{
        $data['result'] = 'f';
      }
      echo json_encode($data);
    }
  }
  
  function send_newsletter_(){
    $admin = $this->session->userdata('admin');
    $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
    if ($checkadmin > 0) {
      //Get Parameter
      $id_newsletter = $this->input->post('id', TRUE);
      $email = $this->input->post('email', TRUE);
      //End Get Parameter
      
      $query_newsletter = $this->model_newsletter->get_object($id_newsletter)->result();
      if($query_newsletter){
        foreach ($query_newsletter as $row) {
          $title = $row->title;
          $banner1 = $row->banner1;
          $link1 = $row->link1;
          $banner2 = $row->banner2;
          $link2 = $row->link2;
        }
        //SEND MAIL VERIFICATION
        $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'mail.momocuppy.com',
          'smtp_port' => 587,
          'smtp_user' => 'momocuppy@momocuppy.com', // change it to yours
          'smtp_pass' => 'momocuppy2015', // change it to yours				
          'mailtype' => 'html',
          'charset' => 'iso-8859-1',
          'wordwrap' => TRUE
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('momocuppy@momocuppy.com', 'Momo Cuppy'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->subject("[Momo Cuppy] ".$title);

        //Data Message
        $data_message['title'] = $title;
        $data_message['id'] = $id_newsletter;
        $data_message['banner1'] = $banner1;
        $data_message['link1'] = $link1;
        $data_message['banner2'] = $banner2;
        $data_message['link2'] = $link2;
        $data_message['email'] = $email;
        $message = $this->load->view('email/newsletter', $data_message, TRUE);
        $this->email->message($message);
        if ($this->email->send()) {
          $data['result'] = "s";
          $data['email'] = $email;
          $this->model_newsletter->update_subscriber($email);
        } else {
          $data['result'] = "f";
          $data['message'] = show_error($this->email->print_debugger());
        }
      }else{
        $data['result'] = "f";
        $data['message'] = "Newsletter is not exist";
      }
      
      echo json_encode($data);
    }
  }
}
