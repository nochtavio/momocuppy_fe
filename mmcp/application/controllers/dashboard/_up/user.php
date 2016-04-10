<?php
    class user extends CI_Controller
    {
      function __construct() 
      {
        date_default_timezone_set('Asia/Jakarta');
        parent::__construct();
        $this->load->model('dashboard/model_dashboard_admin', '', TRUE);
        $this->load->model('dashboard/model_dashboard_user', '', TRUE);
      }
      
      function checkField()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_dashboard_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          //Get Post Request
          $companyname = "";
          if($this->input->post('companyname', TRUE))
          {
            $companyname = $this->input->post('companyname', TRUE);
          }
          
          $tipe = "";
          if($this->input->post('tipe', TRUE))
          {
            $tipe = $this->input->post('tipe', TRUE);
          }
          
          $brand = "";
          if($this->input->post('brand', TRUE))
          {
            $brand = $this->input->post('brand', TRUE);
          }
          
          $address = "";
          if($this->input->post('address', TRUE))
          {
            $address = $this->input->post('address', TRUE);
          }
          
          $phone = "";
          if($this->input->post('phone', TRUE))
          {
            $phone = $this->input->post('phone', TRUE);
          }
          
          $fax = "";
          if($this->input->post('fax', TRUE))
          {
            $fax = $this->input->post('fax', TRUE);
          }
          
          $web = "";
          if($this->input->post('web', TRUE))
          {
            $web = $this->input->post('web', TRUE);
          }
          
          $pic = "";
          if($this->input->post('pic', TRUE))
          {
            $pic = $this->input->post('pic', TRUE);
          }
          
          $bidang = "";
          if($this->input->post('bidang', TRUE))
          {
            $bidang = $this->input->post('bidang', TRUE);
          }
          
          $year = "";
          if($this->input->post('year', TRUE))
          {
            $year = $this->input->post('year', TRUE);
          }
          
          $weeklymeat = "";
          if($this->input->post('weeklymeat', TRUE))
          {
            $weeklymeat = $this->input->post('weeklymeat', TRUE);
          }
          
          $weeklymeat2 = "";
          if($this->input->post('weeklymeat2', TRUE))
          {
            $weeklymeat2 = $this->input->post('weeklymeat2', TRUE);
          }
          
          $item = "";
          if($this->input->post('item', TRUE))
          {
            $item = $this->input->post('item', TRUE);
          }
          
          $buyername = "";
          if($this->input->post('buyername', TRUE))
          {
            $buyername = $this->input->post('buyername', TRUE);
          }
          
          $email = "";
          if($this->input->post('email', TRUE))
          {
            $email = $this->input->post('email', TRUE);
          }
          
          $buyerphone = "";
          if($this->input->post('buyerphone', TRUE))
          {
            $buyerphone = $this->input->post('buyerphone', TRUE);
          }

          $password = "";
          if($this->input->post('password', TRUE))
          {
            $password = $this->input->post('password', TRUE);
          }
          
          $confpassword = "";
          if($this->input->post('confpassword', TRUE))
          {
            $confpassword = $this->input->post('confpassword', TRUE);
          }
          
          $isEdit = 0;
          if($this->input->post('isEdit', TRUE))
          {
            $isEdit = $this->input->post('isEdit', TRUE);
          }
          
          $isEditPassword = 0;
          if($this->input->post('isEditPassword', TRUE))
          {
            $isEditPassword = $this->input->post('isEditPassword', TRUE);
          }
          //End Get Post Request

          //Check Error
          $data['message'] = "";
          if($companyname === "")
          {
            $data['message'] .= "Company Name must be filled! <br/>";
          }
          if($address === "")
          {
            $data['message'] .= "Address must be filled! <br/>";
          }
          if($phone === "")
          {
            $data['message'] .= "Phone must be filled! <br/>";
          }
          if($pic === "")
          {
            $data['message'] .= "Penanggung Jawab must be filled! <br/>";
          }
          if($bidang === "")
          {
            $data['message'] .= "Bidang must be filled! <br/>";
          }
          if($year === "")
          {
            $data['message'] .= "Tahun Perusahaan must be filled! <br/>";
          }
          if($weeklymeat === "")
          {
            $data['message'] .= "Kebutuhan Daging must be filled! <br/>";
          }
          if($weeklymeat2 === "")
          {
            $data['message'] .= "Kebutuhan Daging Olahan must be filled! <br/>";
          }
          if($item === "")
          {
            $data['message'] .= "Item must be filled! <br/>";
          }
          if($buyername === "")
          {
            $data['message'] .= "Buyer Name must be filled! <br/>";
          }
          if($email === "")
          {
            $data['message'] .= "Email must be filled! <br/>";
          }
          
          
          if($isEdit === 0)
          {
            $checkemail = $this->model_dashboard_user->check_email($email)->num_rows();
            if($checkemail > 0)
            {
              $data['message'] .= "Email is already used! <br/>";
            }
          }
          if($isEditPassword === "1")
          {
            if($password === "")
            {
              $data['message'] .= "Password must be filled! <br/>";
            }
            if($confpassword === "")
            {
              $data['message'] .= "Confirmation Password must be filled! <br/>";
            }
            if($password !== $confpassword)
            {
              $data['message'] .= "Password and Confirmation Password are not match! <br/>";
            }
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
      
      function sendMail($subject, $message, $to)
      {
        $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'mail.kibif.com',
          'smtp_port' => 587,
          'smtp_user' => 'cs@kibif.com', // change it to yours
          'smtp_pass' => 'kibif123', // change it to yours
          'mailtype' => 'html',
          'charset' => 'iso-8859-1',
          'wordwrap' => TRUE
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('cs@kibif.com'); // change it to yours
        $this->email->to($to);// change it to yours
        $this->email->subject($subject);
        $this->email->message($message);
        if($this->email->send())
        {

        }
        else
        {
         show_error($this->email->print_debugger());
        }
      }
      
      function editObject()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_dashboard_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          //Get Post Request
          $id = "";
          if($this->input->post('id', TRUE))
          {
            $id = $this->input->post('id', TRUE);
          }
          
          $companyname = "";
          if($this->input->post('companyname', TRUE))
          {
            $companyname = $this->input->post('companyname', TRUE);
          }
          
          $tipe = "";
          if($this->input->post('tipe', TRUE))
          {
            $tipe = $this->input->post('tipe', TRUE);
          }
          
          $brand = "";
          if($this->input->post('brand', TRUE))
          {
            $brand = $this->input->post('brand', TRUE);
          }
          
          $address = "";
          if($this->input->post('address', TRUE))
          {
            $address = $this->input->post('address', TRUE);
          }
          
          $phone = "";
          if($this->input->post('phone', TRUE))
          {
            $phone = $this->input->post('phone', TRUE);
          }
          
          $fax = "";
          if($this->input->post('fax', TRUE))
          {
            $fax = $this->input->post('fax', TRUE);
          }
          
          $web = "";
          if($this->input->post('web', TRUE))
          {
            $web = $this->input->post('web', TRUE);
          }
          
          $pic = "";
          if($this->input->post('pic', TRUE))
          {
            $pic = $this->input->post('pic', TRUE);
          }
          
          $bidang = "";
          if($this->input->post('bidang', TRUE))
          {
            $bidang = $this->input->post('bidang', TRUE);
          }
          
          $year = "";
          if($this->input->post('year', TRUE))
          {
            $year = $this->input->post('year', TRUE);
          }
          
          $weeklymeat = "";
          if($this->input->post('weeklymeat', TRUE))
          {
            $weeklymeat = $this->input->post('weeklymeat', TRUE);
          }
          
          $weeklymeat2 = "";
          if($this->input->post('weeklymeat2', TRUE))
          {
            $weeklymeat2 = $this->input->post('weeklymeat2', TRUE);
          }
          
          $item = "";
          if($this->input->post('item', TRUE))
          {
            $item = $this->input->post('item', TRUE);
          }
          
          $buyername = "";
          if($this->input->post('buyername', TRUE))
          {
            $buyername = $this->input->post('buyername', TRUE);
          }
          
          $email = "";
          if($this->input->post('email', TRUE))
          {
            $email = $this->input->post('email', TRUE);
          }
          
          $buyerphone = "";
          if($this->input->post('buyerphone', TRUE))
          {
            $buyerphone = $this->input->post('buyerphone', TRUE);
          }
          
          $password = "";
          if($this->input->post('password', TRUE))
          {
            $password = $this->input->post('password', TRUE);
          }
          
          $isEditPassword = 0;
          if($this->input->post('isEditPassword', TRUE))
          {
            $isEditPassword = $this->input->post('isEditPassword', TRUE);
          }
          //End Get Post Request
          
          $data['result'] = "s";
          if($isEditPassword === 0)
          {
            $this->model_dashboard_user->edit_object2($id, $tipe, $companyname, $brand, $address, $phone, $fax, $web, $pic, $bidang, $year, $weeklymeat, $weeklymeat2, $item, $buyername, $buyerphone);
          }
          else
          {
            $this->model_dashboard_user->edit_object($id, $tipe, $companyname, $brand, $address, $phone, $fax, $web, $pic, $bidang, $year, $weeklymeat, $weeklymeat2, $item, $buyername, $buyerphone, $password);
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
          $companyname = "";
          if($this->input->post('companyname', TRUE))
          {
            $companyname = $this->input->post('companyname', TRUE);
          }
          $tipe = 0;
          if($this->input->post('tipe', TRUE))
          {
            $tipe = $this->input->post('tipe', TRUE);
          }
          $tactive = 0;
          if($this->input->post('active', TRUE))
          {
            $tactive = $this->input->post('active', TRUE);
          }
          $order = 0;
          if($this->input->post('order', TRUE))
          {
            $order = $this->input->post('order', TRUE);
          }
          //End Filter
          
          $totalrow = $this->model_dashboard_user->get_object(0, $companyname, $tipe, $tactive, $order)->num_rows();

          //Set totalpaging
          $totalpage = ceil($totalrow/$size);
          $data['totalpage'] = $totalpage;
          //End Set totalpaging

          if($totalrow>0)
          {
            $query = $this->model_dashboard_user->get_object(0, $companyname, $tipe, $tactive, $order, $limit, $size)->result();
            $temp = 0;
            foreach ($query as $row)
            {
              $data['result'] = "s";

              $data['id'][$temp] = $row->id;
              $data['tipe'][$temp] = $row->ttipe;
              $data['tactive'][$temp] = $row->tactive;
              $data['companyname'][$temp] = $row->vcompanyname;
              $data['brand'][$temp] = $row->vbrand;
              $data['address'][$temp] = $row->vaddress;
              $data['phone'][$temp] = $row->vphone;
              $data['fax'][$temp] = $row->vfax;
              $data['web'][$temp] = $row->vweb;
              $data['pic'][$temp] = $row->vpic;
              $data['bidang'][$temp] = $row->vbidang;
              $data['year'][$temp] = $row->vyear;
              $data['weeklymeat'][$temp] = $row->tweeklymeat;
              $data['weeklymeat2'][$temp] = $row->tweeklymeat2;
              $data['item'][$temp] = $row->vitem;
              $data['buyername'][$temp] = $row->vbuyername;
              $data['email'][$temp] = $row->vemail;
              $data['password'][$temp] = $row->vpassword;
              $data['buyerphone'][$temp] = $row->vbuyername;
              $temp++;
            }
            $data['total'] = $temp;
            $data['size'] = $size;
          }
          else
          {
            $data['result'] = "f";
            $data['message'] = "No User";
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
          $query = $this->model_dashboard_user->get_object($id)->result();
          foreach ($query as $row)
          {
            $data['result'] = "s";
            
            $data['id'] = $row->id;
            $data['tipe'] = $row->ttipe;
            $data['tactive'] = $row->tactive;
            $data['companyname'] = $row->vcompanyname;
            $data['brand'] = $row->vbrand;
            $data['address'] = $row->vaddress;
            $data['phone'] = $row->vphone;
            $data['fax'] = $row->vfax;
            $data['web'] = $row->vweb;
            $data['pic'] = $row->vpic;
            $data['bidang'] = $row->vbidang;
            $data['year'] = $row->vyear;
            $data['weeklymeat'] = $row->tweeklymeat;
            $data['weeklymeat2'] = $row->tweeklymeat2;
            $data['item'] = $row->vitem;
            $data['buyername'] = $row->vbuyername;
            $data['email'] = $row->vemail;
            $data['password'] = $row->vpassword;
            $data['buyerphone'] = $row->vbuyerphone;
          }
          echo json_encode($data);
        }
      }

      function setActive()
      {
        $admin = $this->session->userdata('admin');
        $checkadmin = $this->model_dashboard_admin->check_admin($admin)->num_rows();
        if($checkadmin > 0)
        {
          $id = $this->input->post('id', TRUE);

          $query = $this->model_dashboard_user->get_active($id)->result();
          foreach ($query as $row)
          {
            $active = $row->tactive;
            $email = $row->vemail;
            $password = $row->vpassword;
          }
          if($active === "0")
          {
            $active = "1";
            $message = ""
                    . "Terima kasih sudah mendaftar di Kibif. <br/>"
                    . "Berikut email dan password anda yang sudah siap digunakan. <br/>"
                    . "<strong>Email: </strong>".$email."<br/>"
                    . "<strong>Password: </strong>".$password."<br/>"
                    ."";
            $this->sendMail('Kibif Account Confirmation',$message, $email);
          }
          else
          {
            $active = "0";
          }

          $data['result'] = "s";
          $data['active'] = $active;
          $this->model_dashboard_user->set_active($id, $active);

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
          $this->model_dashboard_user->remove_object($id);

          echo json_encode($data);
        }
      }

      function index()
      {
        //Header Data
        $data['header'] = "Customer";
        //End Header Data

        //Sidebar Data
        $sidebar['header'] = "user";
        $sidebar['adminlevel'] = $this->session->userdata('adminlevel');
        //End Sidebar Data

        //Content Data
        ////Set paging size
        $content['size'] = 10;
        ////End Set paging size
        //End Content Data

        //Modal Data
        $data['modal'][0] = $this->load->view('dashboard/user/modal_edit', '', TRUE);
        $data['modal'][1] = $this->load->view('dashboard/user/modal_remove', '', TRUE);
        //End Modal Data

        $data['topbar'] = $this->load->view('dashboard/template_topbar', '', TRUE);
        $data['sidebar'] = $this->load->view('dashboard/template_sidebar', $sidebar, TRUE);
        $data['content'] = $this->load->view('dashboard/user/index', $content, TRUE);

        $this->load->view('dashboard/template_index', $data);
      }
    }