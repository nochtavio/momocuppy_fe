<?php
    class voucher extends CI_Controller
    {
      function __construct() 
      {
        date_default_timezone_set('Asia/Jakarta');
        parent::__construct();
        $this->load->model('dashboard/model_admin', '', TRUE);
        $this->load->model('dashboard/model_voucher', '', TRUE);
      }
      
      function index()
      {
        //Data
        $content['page'] = "Voucher";
        $content['pagesize'] = 10;

        //JS
        $content['js'][0] = 'js/dashboard/private/voucher.js';

        //Modal
        $content['modal'][0] = $this->load->view('dashboard/voucher/modal_add', '', TRUE);
        $content['modal'][1] = $this->load->view('dashboard/voucher/modal_edit', '', TRUE);
        $content['modal'][2] = $this->load->view('dashboard/voucher/modal_remove', '', TRUE);
        
        $data['content'] = $this->load->view('dashboard/voucher/index', $content, TRUE);
        $this->load->view('dashboard/template_index', $data);
      }
      
      function show_object()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          //paging
          $page = 1;
          if($this->input->post('page', TRUE))
          {
            $page = $this->input->post('page', TRUE);
          }
          if($this->input->post('size', TRUE))
          {
            $size = $this->input->post('size', TRUE);
          }
          $limit = ($page-1)*$size;
          //end paging

          //Filter
          $voucher_name = "";
          if($this->input->post('voucher_name', TRUE))
          {
            $voucher_name = $this->input->post('voucher_name', TRUE);
          }
          $voucher_code = "";
          if($this->input->post('voucher_code', TRUE))
          {
            $voucher_code = $this->input->post('voucher_code', TRUE);
          }
          $type = 0;
          if($this->input->post('type', TRUE))
          {
            $type = $this->input->post('type', TRUE);
          }
          $active = 0;
          if($this->input->post('active', TRUE))
          {
            $active = $this->input->post('active', TRUE);
          }
          $order = 0;
          if($this->input->post('order', TRUE))
          {
            $order = $this->input->post('order', TRUE);
          }
          //End Filter
          
          $totalrow = $this->model_voucher->get_object(0, $voucher_name, $voucher_code, $type, $active, $order)->num_rows();

          //Set totalpaging
          $totalpage = ceil($totalrow/$size);
          $data['totalpage'] = $totalpage;
          //End Set totalpaging

          if($totalrow>0)
          {
            $query = $this->model_voucher->get_object(0, $voucher_name, $voucher_code, $type, $active, $order, $limit, $size)->result();
            $temp = 0;
            foreach ($query as $row)
            {
              $data['result'] = "s";

              $data['id'][$temp] = $row->id;
              $data['voucher_name'][$temp] = $row->voucher_name;
              $data['voucher_code'][$temp] = $row->voucher_code;
              $data['type'][$temp] = $row->type;
              $data['discount'][$temp] = $row->type == "1" ? $row->discount."%" : number_format($row->discount);
              $data['active'][$temp] = $row->active;
              
              $data['cretime'][$temp] = date_format(date_create($row->cretime), 'd F Y H:i:s');
              $data['creby'][$temp] = $row->creby;
              $data['modtime'][$temp] = date_format(date_create($row->modtime), 'd F Y H:i:s');
              $data['modby'][$temp] = $row->modby;
              $temp++;
            }
            $data['total'] = $temp;
            $data['size'] = $size;
          }
          else
          {
            $data['result'] = "f";
            $data['message'] = "No Voucher";
          }
          echo json_encode($data);
        }
      }
      
      function check_field()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          //Get Post Request
          $voucher_name = "";
          if($this->input->post('voucher_name', TRUE))
          {
            $voucher_name = $this->input->post('voucher_name', TRUE);
          }
          
          $voucher_code = "";
          if($this->input->post('voucher_code', TRUE))
          {
            $voucher_code = $this->input->post('voucher_code', TRUE);
          }
          
          $type = 0;
          if($this->input->post('type', TRUE))
          {
            $type = $this->input->post('type', TRUE);
          }
          
          $discount = "";
          if($this->input->post('discount', TRUE))
          {
            $discount = $this->input->post('discount', TRUE);
          }
          //End Get Post Request

          //Check Error
          $data['message'] = "";
          
          if($voucher_name === "")
          {
            $data['message'] .= "Voucher name must be filled! <br/>";
          }
          
          if($voucher_code === "")
          {
            $data['message'] .= "Voucher code must be filled! <br/>";
          }
          
          if($type === 0)
          {
            $data['message'] .= "Type must be choosen! <br/>";
          }
          
          if($discount === "")
          {
            $data['message'] .= "Discount must be filled! <br/>";
          }
          else if(!is_numeric($discount))
          {
            $data['message'] .= "Discount must be a number! <br/>";
          }
          //End Check Error

          if($data['message'] === "")
          {
            $data['result'] = "s";
          }
          else
          {
            $data['result'] = "f";
          }
          
          echo json_encode($data);
        }
      }

      function add_object()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          //Get Post Request
          $voucher_name = "";
          if($this->input->post('voucher_name', TRUE))
          {
            $voucher_name = $this->input->post('voucher_name', TRUE);
          }
          
          $voucher_code = "";
          if($this->input->post('voucher_code', TRUE))
          {
            $voucher_code = $this->input->post('voucher_code', TRUE);
          }
          
          $type = "";
          if($this->input->post('type', TRUE))
          {
            $type = $this->input->post('type', TRUE);
          }
          
          $discount = "";
          if($this->input->post('discount', TRUE))
          {
            $discount = $this->input->post('discount', TRUE);
          }
          //End Get Post Request
          
          $data['result'] = "s";
          $this->model_voucher->add_object($voucher_name, $voucher_code, $type, $discount);
          
          echo json_encode($data);
        }
      }
      
      function edit_object()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          //Get Post Request
          $id = "";
          if($this->input->post('id', TRUE))
          {
            $id = $this->input->post('id', TRUE);
          }
          
          $voucher_name = "";
          if($this->input->post('voucher_name', TRUE))
          {
            $voucher_name = $this->input->post('voucher_name', TRUE);
          }
          
          $voucher_code = "";
          if($this->input->post('voucher_code', TRUE))
          {
            $voucher_code = $this->input->post('voucher_code', TRUE);
          }
          
          $type = "";
          if($this->input->post('type', TRUE))
          {
            $type = $this->input->post('type', TRUE);
          }
          
          $discount = "";
          if($this->input->post('discount', TRUE))
          {
            $discount = $this->input->post('discount', TRUE);
          }
          //End Get Post Request
          
          $data['result'] = "s";
          $this->model_voucher->edit_object($id, $voucher_name, $voucher_code, $type, $discount);
          
          echo json_encode($data);
        }
      }

      function get_object()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          $id = $this->input->post('id', TRUE);
          $query = $this->model_voucher->get_object($id)->result();
          foreach ($query as $row)
          {
            $data['result'] = "s";
            
            $data['id'] = $row->id;
            $data['voucher_name'] = $row->voucher_name;
            $data['voucher_code'] = $row->voucher_code;
            $data['type'] = $row->type;
            $data['discount'] = $row->discount;
            $data['active'] = $row->active;
          }
          echo json_encode($data);
        }
      }

      function set_active()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          $id = $this->input->post('id', TRUE);

          $query = $this->model_voucher->get_active($id)->result();
          foreach ($query as $row)
          {
            $active = $row->active;
          }
          if($active === "0")
          {
            $active = "1";
          }
          else
          {
            $active = "0";
          }

          $data['result'] = "s";
          $data['active'] = $active;
          $this->model_voucher->set_active($id, $active);

          echo json_encode($data);
        }
      }

      function remove_object()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          $id = $this->input->post('id', TRUE);

          $data['result'] = "s";
          $this->model_voucher->remove_object($id);

          echo json_encode($data);
        }
      }
    }

