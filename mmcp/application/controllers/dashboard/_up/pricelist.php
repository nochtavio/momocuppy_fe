<?php
    class pricelist extends CI_Controller
    {
      function __construct() 
      {
        date_default_timezone_set('Asia/Jakarta');
        parent::__construct();
        $this->load->model('dashboard/model_dashboard_admin', '', TRUE);
        $this->load->model('dashboard/model_dashboard_pricelist', '', TRUE);
      }
      
      function checkField()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_dashboard_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          //Get Post Request
          $vtitle = "";
          if($this->input->post('title', TRUE))
          {
            $vtitle = $this->input->post('title', TRUE);
          }
          
          $vgroup = "";
          if($this->input->post('group', TRUE))
          {
            $vgroup = $this->input->post('group', TRUE);
          }
          
          $vunit = "";
          if($this->input->post('unit', TRUE))
          {
            $vunit = $this->input->post('unit', TRUE);
          }
          
          $vprice1 = "";
          if($this->input->post('price1', TRUE))
          {
            $vprice1 = $this->input->post('price1', TRUE);
          }
          
          $vprice2 = "";
          if($this->input->post('price2', TRUE))
          {
            $vprice2 = $this->input->post('price2', TRUE);
          }
          
          $vprice3 = "";
          if($this->input->post('price3', TRUE))
          {
            $vprice3 = $this->input->post('price3', TRUE);
          }
          
          $vprice4 = "";
          if($this->input->post('price4', TRUE))
          {
            $vprice4 = $this->input->post('price4', TRUE);
          }
          //End Get Post Request

          //Check Error
          $data['message'] = "";
          if($vtitle === "")
          {
            $data['message'] .= "Name must be filled! <br/>";
          }
          if($vgroup === "")
          {
            $data['message'] .= "Group must be filled! <br/>";
          }
          if($vunit === "")
          {
            $data['message'] .= "Unit must be filled! <br/>";
          }
//          if($vprice1 === "")
//          {
//            $data['message'] .= "Category 1 Price must be filled! <br/>";
//          }
//          if($vprice2 === "")
//          {
//            $data['message'] .= "Category 2 Price must be filled! <br/>";
//          }
//          if($vprice3 === "")
//          {
//            $data['message'] .= "Category 3 Price must be filled! <br/>";
//          }
//          if($vprice4 === "")
//          {
//            $data['message'] .= "Category 4 Price must be filled! <br/>";
//          }
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

      function addObject()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_dashboard_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          $creby = $this->session->userdata('adminname');
          
          //Get Post Request
          $vtitle = "";
          if($this->input->post('title', TRUE))
          {
            $vtitle = $this->input->post('title', TRUE);
          }
          
          $vgroup = "";
          if($this->input->post('group', TRUE))
          {
            $vgroup = $this->input->post('group', TRUE);
          }
          
          $vunit = "";
          if($this->input->post('unit', TRUE))
          {
            $vunit = $this->input->post('unit', TRUE);
          }
          
          $vprice1 = "";
          if($this->input->post('price1', TRUE))
          {
            $vprice1 = $this->input->post('price1', TRUE);
          }
          
          $vprice2 = "";
          if($this->input->post('price2', TRUE))
          {
            $vprice2 = $this->input->post('price2', TRUE);
          }
          
          $vprice3 = "";
          if($this->input->post('price3', TRUE))
          {
            $vprice3 = $this->input->post('price3', TRUE);
          }
          
          $vprice4 = "";
          if($this->input->post('price4', TRUE))
          {
            $vprice4 = $this->input->post('price4', TRUE);
          }
          //End Get Post Request
          
          //Upload Image
          $lastid = $this->model_dashboard_pricelist->get_last_id()->result();
          if($lastid)
          {
            foreach ($lastid as $row)
            {
              $newid = $row->id+1;
              $vimg = "pricelist".$newid.".jpg";
            }
          }
          else
          {
            $vimg = "pricelist0.jpg";
          }
          
          $file_element_name = 'userfile';
          $config['upload_path'] = './images/pricelist/';
          $config['allowed_types'] = 'jpg';
          $config['max_size'] = 1024;
          $config['file_name'] = $vimg;
          $config['overwrite'] = TRUE;

          $this->upload->initialize($config);
          $uplst = false;
          if (!$this->upload->do_upload($file_element_name))
          {
            $uplst = false;
            $data['message'] = $this->upload->display_errors('', '');
          }
          else
          {
            $uplst = true;
            $this->upload->data();
          }
          @unlink($_FILES[$file_element_name]);
          //End Upload Image

          if($uplst)
          {
            $data['result'] = "s";
            $this->model_dashboard_pricelist->add_object($vtitle, $vgroup, $vunit, $vimg, $vprice1, $vprice2, $vprice3, $vprice4, $creby);
          }
          else
          {
            $data['result'] = "f";
          }
          
          echo json_encode($data);
        }
      }
      
      function editObject()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_dashboard_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          $modby = $this->session->userdata('adminname');
          
          //Get Post Request
          $id = "";
          if($this->input->post('id', TRUE))
          {
            $id = $this->input->post('id', TRUE);
          }
          
          $vtitle = "";
          if($this->input->post('title', TRUE))
          {
            $vtitle = $this->input->post('title', TRUE);
          }
          
          $vgroup = "";
          if($this->input->post('group', TRUE))
          {
            $vgroup = $this->input->post('group', TRUE);
          }
          
          $vunit = "";
          if($this->input->post('unit', TRUE))
          {
            $vunit = $this->input->post('unit', TRUE);
          }
          
          $vprice1 = "";
          if($this->input->post('price1', TRUE))
          {
            $vprice1 = $this->input->post('price1', TRUE);
          }
          
          $vprice2 = "";
          if($this->input->post('price2', TRUE))
          {
            $vprice2 = $this->input->post('price2', TRUE);
          }
          
          $vprice3 = "";
          if($this->input->post('price3', TRUE))
          {
            $vprice3 = $this->input->post('price3', TRUE);
          }
          
          $vprice4 = "";
          if($this->input->post('price4', TRUE))
          {
            $vprice4 = $this->input->post('price4', TRUE);
          }
          
          $vprice5 = "";
          if($this->input->post('price5', TRUE))
          {
            $vprice5 = $this->input->post('price5', TRUE);
          }
          //End Get Post Request
          
          //Upload Image
          $vimg = "pricelist".$id.".jpg";
          $file_element_name = 'editfile';
          $config['upload_path'] = './images/pricelist/';
          $config['allowed_types'] = 'jpg';
          $config['max_size'] = 1024;
          $config['file_name'] = $vimg;
          $config['overwrite'] = TRUE;

          $this->upload->initialize($config);
          $uplst = 0; //0 Wrong Param; 1 Valid Image; 2 No Image Uploaded
          if (!$this->upload->do_upload($file_element_name))
          {
            $data['message'] = $this->upload->display_errors('', '');
            if($data['message'] === "You did not select a file to upload.")
            {
              $uplst = 2;
            }
            else
            {
              $uplst = 0;
            }
          }
          else
          {
            $uplst = 1;
            $this->upload->data();
          }
          @unlink($_FILES[$file_element_name]);
          //End Upload Image

          if($uplst > 0)
          {
            $data['result'] = "s";
            if($uplst === 1)
            {
              $this->model_dashboard_pricelist->edit_object($id, $vtitle, $vgroup, $vunit, $vprice1, $vprice2, $vprice3, $vprice4, $modby, $vimg);
            }
            else
            {
              $this->model_dashboard_pricelist->edit_object($id, $vtitle, $vgroup, $vunit, $vprice1, $vprice2, $vprice3, $vprice4, $modby, "");
            }
          }
          else
          {
            $data['result'] = "f";
          }
          
          echo json_encode($data);
        }
      }

      function showObject()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_dashboard_admin->check_admin($admin)->num_rows();
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
          $vtitle = "";
          if($this->input->post('title', TRUE))
          {
            $vtitle = $this->input->post('title', TRUE);
          }
          $vgroup = "";
          if($this->input->post('group', TRUE))
          {
            $vgroup = $this->input->post('group', TRUE);
          }
          $vunit = "";
          if($this->input->post('unit', TRUE))
          {
            $vunit = $this->input->post('unit', TRUE);
          }
          $show = 0;
          if($this->input->post('show', TRUE))
          {
            $show = $this->input->post('show', TRUE);
          }
          $order = 0;
          if($this->input->post('order', TRUE))
          {
            $order = $this->input->post('order', TRUE);
          }
          //End Filter

          $totalrow = $this->model_dashboard_pricelist->get_object(0, $vtitle, $vgroup, $vunit, $order, $show)->num_rows();

          //Set totalpaging
          $totalpage = ceil($totalrow/$size);
          $data['totalpage'] = $totalpage;
          //End Set totalpaging

          if($totalrow>0)
          {
            $query = $this->model_dashboard_pricelist->get_object(0, $vtitle, $vgroup, $vunit, $order, $show, $limit, $size)->result();
            $temp = 0;
            foreach ($query as $row)
            {
              $data['result'] = "s";

              $data['id'][$temp] = $row->id;
              $data['title'][$temp] = $row->vtitle;
              $data['group'][$temp] = $row->vgroup;
              $data['unit'][$temp] = $row->vunit;
              $data['vprice1'][$temp] = $row->vprice1;
              $data['vprice2'][$temp] = $row->vprice2;
              $data['vprice3'][$temp] = $row->vprice3;
              $data['vprice4'][$temp] = $row->vprice4;
              $data['img'][$temp] = $row->vimg;
              
              $data['cretime'][$temp] = date("d M Y H:i:s", strtotime($row->cretime));
              $data['creby'][$temp] = $row->creby;
              $data['modtime'][$temp] = date("d M Y H:i:s", strtotime($row->modtime));
              $data['modby'][$temp] = $row->modby;
              $data['show'][$temp] = $row->show;
              $temp++;
            }
            $data['total'] = $temp;
            $data['size'] = $size;
          }
          else
          {
            $data['result'] = "f";
            $data['message'] = "No Pricelist";
          }
          echo json_encode($data);
        }
      }

      function getObject()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_dashboard_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          $id = $this->input->post('id', TRUE);
          $query = $this->model_dashboard_pricelist->get_object($id)->result();
          foreach ($query as $row)
          {
            $data['result'] = "s";
            
            $data['id'] = $row->id;
            $data['title'] = $row->vtitle;
            $data['group'] = $row->vgroup;
            $data['unit'] = $row->vunit;
            $data['vprice1'] = $row->vprice1;
            $data['vprice2'] = $row->vprice2;
            $data['vprice3'] = $row->vprice3;
            $data['vprice4'] = $row->vprice4;
            $data['img'] = $row->vimg;
            
            $data['cretime'] = $row->cretime;
            $data['creby'] = $row->creby;
            $data['modtime'] = $row->modtime;
            $data['modby'] = $row->modby;
          }
          echo json_encode($data);
        }
      }

      function setShow()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_dashboard_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          $id = $this->input->post('id', TRUE);

          $query = $this->model_dashboard_pricelist->get_show($id)->result();
          foreach ($query as $row)
          {
            $show = $row->show;
          }
          if($show === "0")
          {
            $show = "1";
          }
          else
          {
            $show = "0";
          }

          $data['result'] = "s";
          $data['show'] = $show;
          $this->model_dashboard_pricelist->set_show($id, $show);

          echo json_encode($data);
        }
      }

      function removeObject()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_dashboard_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          $id = $this->input->post('id', TRUE);

          $data['result'] = "s";
          $this->model_dashboard_pricelist->remove_object($id);

          echo json_encode($data);
        }
      }

      function index()
      {
        //Header Data
        $data['header'] = "Price List";
        //End Header Data

        //Sidebar Data
        $sidebar['header'] = "pricelist";
        $sidebar['adminlevel'] = $this->session->userdata('adminlevel');
        //End Sidebar Data

        //Content Data
        ////Set paging size
        $content['size'] = 10;
        ////End Set paging size
        //End Content Data

        //Modal Data
        $data['modal'][0] = $this->load->view('dashboard/pricelist/modal_add', '', TRUE);
        $data['modal'][1] = $this->load->view('dashboard/pricelist/modal_edit', '', TRUE);
        $data['modal'][2] = $this->load->view('dashboard/pricelist/modal_remove', '', TRUE);
        //End Modal Data

        $data['topbar'] = $this->load->view('dashboard/template_topbar', '', TRUE);
        $data['sidebar'] = $this->load->view('dashboard/template_sidebar', $sidebar, TRUE);
        $data['content'] = $this->load->view('dashboard/pricelist/index', $content, TRUE);

        $this->load->view('dashboard/template_index', $data);
      }
    }

