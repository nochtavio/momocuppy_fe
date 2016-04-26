<?php

/*
  LAST UPDATE
  27-12-2015 eff update email after regis
 */

class api extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->library('custom_encrypt');
  }

  function sendMail() {
    if(!isset($_SESSION)){session_start();}

    $name = ($this->input->post('name', TRUE)) ? $this->input->post('name', TRUE) : "";
    $subject = ($this->input->post('subject', TRUE)) ? $this->input->post('subject', TRUE) : "";
    $message = ($this->input->post('message', TRUE)) ? $this->input->post('message', TRUE) : "";
    $email = ($this->input->post('email', TRUE)) ? $this->input->post('email', TRUE) : "";
    $no1 = (isset($_SESSION["no1"])) ? $_SESSION["no1"] : 0;
    $no2 = (isset($_SESSION["no2"])) ? $_SESSION["no2"] : 0;
    $verify = ($this->input->post('verify', TRUE)) ? $this->input->post('verify', TRUE) : "";
    
    if($name == "" || $subject == "" || $message == "" || $email == "" || $verify == ""){
      $data['result'] = "f";
      $data['message'] = "All field must be filled.";
    }else{
      if ($verify != $no1 + $no2) {
        $data['result'] = "f";
        $data['message'] = "Verify Number is false.";
      } else {
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
        $this->email->to('help@momocuppy.com'); // change it to yours
        $this->email->subject("[" . $email . "] " . $subject);
        $this->email->message($message);
        if ($this->email->send()) {
          $data['result'] = "s";
          $data['message'] = "Message has been sent successfully!";
        } else {
          $data['result'] = "f";
          $data['message'] = show_error($this->email->print_debugger());
        }
      }
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function generate_about_us() {
    $this->load->model('dashboard/model_about_us', '', TRUE);

    $totalrow = $this->model_about_us->get_object()->num_rows();
    if ($totalrow > 0) {
      $query = $this->model_about_us->get_object()->result();
      $data['result'] = "s";
      $data['content'] = $query;
    } else {
      $data['result'] = "f";
      $data['message'] = "No Content";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_header("HTTP/1.1 200 OK")
      ->set_header("Connection: keep-alive")
      ->set_header("Connection: close")
      ->set_output(json_encode($data));
  }

  function generate_contact_us() {
    $this->load->model('dashboard/model_contact_us', '', TRUE);

    $totalrow = $this->model_contact_us->get_object()->num_rows();
    if ($totalrow > 0) {
      $query = $this->model_contact_us->get_object()->result();
      $data['result'] = "s";
      $data['content'] = $query;
    } else {
      $data['result'] = "f";
      $data['message'] = "No Content";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function generate_category() {
    $this->load->model('dashboard/model_category', '', TRUE);

    //Paging
    $page = ($this->input->post('page', TRUE)) ? $this->input->post('page', TRUE) : 1;
    $size = ($this->input->post('size', TRUE)) ? $this->input->post('size', TRUE) : 10;
    $limit = ($page - 1) * $size;
    //End Paging
    //Filter
    $type = ($this->input->post('type', TRUE)) ? $this->input->post('type', TRUE) : 0;
    $category_name = ($this->input->post('category_name', TRUE)) ? $this->input->post('category_name', TRUE) : "";
    $visible = ($this->input->post('visible', TRUE)) ? $this->input->post('visible', TRUE) : 1;
    $order = ($this->input->post('order', TRUE)) ? $this->input->post('order', TRUE) : 0;
    //End Filter

    $totalrow = $this->model_category->get_object(0, $category_name, $type, $visible, $order)->num_rows();

    //Set totalpaging
    $totalpage = ceil($totalrow / $size);
    $data['totalpage'] = $totalpage;
    //End Set totalpaging

    if ($totalrow > 0) {
      $query = $this->model_category->get_object(0, $category_name, $type, $visible, $order, $limit, $size)->result();
      $data['result'] = "s";
      $data['content'] = $query;
    } else {
      $data['result'] = "f";
      $data['message'] = "No Category";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function generate_member_address() {
    $this->load->model('dashboard/model_detail_address', '', TRUE);

    //Filter
    $id = ($this->input->post('id', TRUE)) ? $this->input->post('id', TRUE) : 0;
    $id_member = $this->get_id_member();
    $order = ($this->input->post('order', TRUE)) ? $this->input->post('order', TRUE) : 1;
    //End Filter
    
    if($id_member){
      $totalrow = $this->model_detail_address->get_object($id, $id_member, "", $order)->num_rows();

      if ($totalrow > 0) {
        $query = $this->model_detail_address->get_object($id, $id_member, "", $order)->result();
        $data['result'] = "s";
        $data['content'] = $query;
      } else {
        $data['result'] = "f";
        $data['message'] = "No Address";
      }
    }else{
      $data['result'] = "f";
      $data['message'] = "No Address";
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function add_address() {
    $this->load->model('dashboard/model_detail_address', '', TRUE);

    $result = "r1";
    $result_message = "";

    //Parameter
    $id_member = $this->get_id_member();
    $firstname = ($this->input->post('firstname', TRUE)) ? $this->input->post('firstname', TRUE) : "";
    $lastname = ($this->input->post('lastname', TRUE)) ? $this->input->post('lastname', TRUE) : "";
    $street_address = ($this->input->post('street_address', TRUE)) ? $this->input->post('street_address', TRUE) : "";
    $zip_code = ($this->input->post('zip_code', TRUE)) ? $this->input->post('zip_code', TRUE) : "";
    $phone = ($this->input->post('phone', TRUE)) ? $this->input->post('phone', TRUE) : "";
    $country = ($this->input->post('country', TRUE)) ? $this->input->post('country', TRUE) : "";
    $city = ($this->input->post('city', TRUE)) ? $this->input->post('city', TRUE) : "";
    //End Parameter
    
    //Check Error
    $data['message'] = "";
    if (!$id_member) {
      $result = "r2";
      $result_message = "You must login first! ";
    }
    if ($firstname === "") {
      $result = "r2";
      $result_message = "Firstname must be filled! ";
    }
    if ($lastname === "") {
      $result = "r2";
      $result_message = "Lastname must be filled! ";
    }
    if ($street_address === "") {
      $result = "r2";
      $result_message = "Street Address must be filled! ";
    }
    if ($zip_code === "") {
      $result = "r2";
      $result_message = "Zip Code must be filled! ";
    }elseif(!is_numeric($zip_code)){
      $result = "r2";
      $result_message = "Zip Code must be a number! ";
    }
    if ($phone === "") {
      $result = "r2";
      $result_message = "Phone must be filled! ";
    }
    if ($country === "") {
      $result = "r2";
      $result_message = "Country must be filled! ";
    }
    if ($city === "") {
      $result = "r2";
      $result_message = "City must be filled! ";
    }
    //End Check Error

    if ($result == "r1") {
      $this->model_detail_address->add_object($id_member, $firstname, $lastname, $street_address, $zip_code, $phone, $country, $city);
      $result_message = "Add Address Success";
    }

    $data['result'] = $result;
    $data['result_message'] = $result_message;

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function edit_address() {
    $this->load->model('dashboard/model_detail_address', '', TRUE);

    $result = "r1";
    $result_message = "";

    //Parameter
    $id_member = $this->get_id_member();
    $id = ($this->input->post('id', TRUE)) ? $this->input->post('id', TRUE) : "";
    $firstname = ($this->input->post('firstname', TRUE)) ? $this->input->post('firstname', TRUE) : "";
    $lastname = ($this->input->post('lastname', TRUE)) ? $this->input->post('lastname', TRUE) : "";
    $street_address = ($this->input->post('street_address', TRUE)) ? $this->input->post('street_address', TRUE) : "";
    $zip_code = ($this->input->post('zip_code', TRUE)) ? $this->input->post('zip_code', TRUE) : "";
    $phone = ($this->input->post('phone', TRUE)) ? $this->input->post('phone', TRUE) : "";
    $country = ($this->input->post('country', TRUE)) ? $this->input->post('country', TRUE) : "";
    $city = ($this->input->post('city', TRUE)) ? $this->input->post('city', TRUE) : "";
    //End Parameter
    
    //Check Error
    $data['message'] = "";
    if (!$id_member) {
      $result = "r2";
      $result_message = "You must login first! ";
    }
    if ($firstname === "") {
      $result = "r2";
      $result_message = "Firstname must be filled! ";
    }
    if ($lastname === "") {
      $result = "r2";
      $result_message = "Lastname must be filled! ";
    }
    if ($street_address === "") {
      $result = "r2";
      $result_message = "Street Address must be filled! ";
    }
    if ($zip_code === "") {
      $result = "r2";
      $result_message = "Zip Code must be filled! ";
    }elseif(!is_numeric($zip_code)){
      $result = "r2";
      $result_message = "Zip Code must be a number! ";
    }
    if ($phone === "") {
      $result = "r2";
      $result_message = "Phone must be filled! ";
    }elseif(!is_numeric($phone)){
      $result = "r2";
      $result_message = "Phone must be a number! ";
    }
    if ($country === "") {
      $result = "r2";
      $result_message = "Country must be filled! ";
    }
    if ($city === "") {
      $result = "r2";
      $result_message = "City must be filled! ";
    }
    //End Check Error

    if ($result == "r1") {
      $this->model_detail_address->edit_object($id, $firstname, $lastname, $street_address, $zip_code, $phone, $country, $city);
      $result_message = "Edit Address Success";
    }

    $data['result'] = $result;
    $data['result_message'] = $result_message;

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function generate_list_payment() {
    $this->load->model('dashboard/model_payment', '', TRUE);
    $id = ($this->input->post('id', TRUE)) ? $this->input->post('id', TRUE) : 0;
    
    if($id > 0){
      $totalrow = $this->model_payment->get_object($id, "", "", "", 1)->num_rows();

      if ($totalrow > 0) {
        $query = $this->model_payment->get_object($id, "", "", "", 1)->result();
        $data['result'] = "s";
        $data['content'] = $query;
      } else {
        $data['result'] = "f";
        $data['message'] = "No Payment";
      }
    }else{
      $data['result'] = "f";
      $data['message'] = "No Payment";
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function generate_hash($email) {
    $this->load->helper('security');

    $secret_key = "momocuppy123";
    return do_hash($secret_key . $email);
  }

  function generate_referral() {
    $this->load->model('dashboard/model_member', '', TRUE);

    $referral = random_string('alnum', 7);
    while ($this->model_member->check_referral(0, $referral)->num_rows() > 0) {
      $referral = random_string('alnum', 7);
    }
    return $referral;
  }

  function generate_city() {
    $this->load->model('dashboard/model_city', '', TRUE);

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://api.rajaongkir.com/starter/city",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 10000,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "key: 67e47b562d26068bdf0db0886c797f7c"
      ),
    ));

    $response = json_decode(curl_exec($curl), true);
    $err = curl_error($curl);
    curl_close($curl);

    //ADD to DB
    if ($response['rajaongkir']['status']['code'] == 200) {
      $data['result'] = 'r1';
      $data['message'] = $response['rajaongkir']['status']['description'];
      $this->db->truncate('ms_city');
      foreach ($response['rajaongkir']['results'] as $value) {
        $this->model_city->add_object($value['city_id'], $value['city_name'], $value['type']);
      }
    } else {
      $data['result'] = 'r2';
      $data['message'] = $response['rajaongkir']['status']['description'];
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function member_register() {
    $this->load->model('dashboard/model_member', '', TRUE);
    $this->load->model('dashboard/model_subscriber', '', TRUE);

    $result = "s";

    //Parameter
    $password = ($this->input->post('password', TRUE)) ? $this->input->post('password', TRUE) : "";
    $confpassword = ($this->input->post('cpassword', TRUE)) ? $this->input->post('cpassword', TRUE) : "";
    $firstname = ($this->input->post('firstname', TRUE)) ? $this->input->post('firstname', TRUE) : "";
    $lastname = ($this->input->post('lastname', TRUE)) ? $this->input->post('lastname', TRUE) : "";
    $phone = ($this->input->post('phone', TRUE)) ? $this->input->post('phone', TRUE) : "";
    $email = ($this->input->post('email', TRUE)) ? $this->input->post('email', TRUE) : "";
    $dob = ($this->input->post('dob', TRUE)) ? $this->input->post('dob', TRUE) : "";
    $streetname = ($this->input->post('streetname', TRUE)) ? $this->input->post('streetname', TRUE) : "";
    $postalcode = ($this->input->post('postalcode', TRUE)) ? $this->input->post('postalcode', TRUE) : "";
    $country = ($this->input->post('country', TRUE)) ? $this->input->post('country', TRUE) : "";
    $city = ($this->input->post('city', TRUE)) ? $this->input->post('city', TRUE) : "";
    //End Parameter
    //Check Parameter
    if ($firstname == "") {
      $result = "f";
      $err['firstname'] = "must be filled";
    }

    if ($lastname == "") {
      $result = "f";
      $err['lastname'] = "must be filled";
    }

    if ($phone == "") {
      $result = "f";
      $err['phone'] = "must be filled";
    } elseif (!is_numeric($phone)) {
      $result = "f";
      $err['phone'] = "phone must be in numeric";
    }

    if ($email == "") {
      $result = "f";
      $err['email'] = "must be filled";
    } elseif ($this->model_member->check_email($email)->num_rows() > 0) {
      $result = "f";
      $err['email'] = "email already registered";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $result = "f";
      $err['email'] = "wrong format";
    }

    if ($password == "") {
      $result = "f";
      $err['password'] = "must be filled";
    }

    if ($confpassword == "") {
      $result = "f";
      $err['cpassword'] = "must be filled";
    }

    if ($password !== $confpassword) {
      $result = "f";
      $err['cpassword'] = "password not match";
    }

    if ($dob == "") {
      $result = "f";
      $err['dob'] = "must be filled";
    }

    if ($streetname == "") {
      $result = "f";
      $err['streetname'] = "must be filled";
    }

    if ($postalcode == "") {
      $result = "f";
      $err['postalcode'] = "must be filled";
    }else if(!is_numeric($postalcode)){
      $result = "f";
      $err['postalcode'] = "must be a number";
    }

    if ($country == "") {
      $result = "f";
      $err['country'] = "must be filled";
    }

    if ($city == "") {
      $result = "f";
      $err['city'] = "must be filled";
    }
    //End Check Parameter

    if ($result == "s") {
      $hash = $this->generate_hash($email);
      $referral = $this->generate_referral();
      $this->model_member->add_object($password, $firstname, $lastname, $phone, $email, $dob, $hash, $referral, $streetname, $postalcode, $country, $city);
      
      //Insert Subscriber
      if($this->model_subscriber->get_object(0, $email)->num_rows() <= 0){
        $this->model_subscriber->add_object($email);
      }
      //End Insert Subscriber
      
      $this->session->unset_userdata('member_reg');
      $this->session->unset_userdata('member_err');
      $this->session->unset_userdata('member_firstname');
      $this->session->unset_userdata('member_lastname');
      $this->session->unset_userdata('member_phone');
      $this->session->unset_userdata('member_email');
      $this->session->unset_userdata('member_dob');
      $this->session->unset_userdata('member_streetname');
      $this->session->unset_userdata('member_postalcode');
      $this->session->unset_userdata('member_country');

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
      $this->email->subject("Welcome ".$firstname." to Momo Cuppy, please verify your account to continue shopping");
      
      //Data Message
      $data_message['name'] = $firstname." ".$lastname;
      $data_message['email'] = $email;
      $data_message['phone'] = $phone;
      $data_message['hash'] = $hash;
      $data_message['referral'] = $referral;
      $message = $this->load->view('email/register', $data_message, TRUE);
      $this->email->message($message);
      if ($this->email->send()) {
        $data['result'] = "s";
        $data['message'] = "Message has been sent successfully!";
        redirect('../member/register/activation/?email='.$email.'#maincontent');
        die();
      } else {
        $data['result'] = "f";
        $data['message'] = show_error($this->email->print_debugger());
        redirect('../member/register/#maincontent');
        die();
      }
    } else {
      //Set Session Order
      $session_data = array(
        'member_reg' => $result,
        'member_err' => $err,
        'member_firstname' => $firstname,
        'member_lastname' => $lastname,
        'member_phone' => $phone,
        'member_email' => $email,
        'member_dob' => $dob,
        'member_streetname' => $streetname,
        'member_postalcode' => $postalcode,
        'member_country' => $country
      );
      $this->session->set_userdata($session_data);
      redirect('../member/register/#maincontent');
      die();
    }
  }
  
  function resend_verification(){
    $this->load->model('dashboard/model_member', '', TRUE);
    
    //Parameter
    $email = ($this->input->post('email', TRUE)) ? $this->input->post('email', TRUE) : "";
    
    if ($this->model_member->check_email($email)->num_rows() < 0) {
      $data['result'] = "f";
      $data['message'] = "Email is invalid";
    }else{
      $query = $this->model_member->get_object(0,"","",$email)->result();
      foreach ($query as $row) {
        $firstname = $row->firstname;
        $lastname = $row->lastname;
        $phone = $row->phone;
        $hash = $row->hash;
        $referral = $row->referral;
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
      $this->email->subject("Welcome ".$firstname." to Momo Cuppy, please verify your account to continue shopping");

      //Data Message
      $data_message['name'] = $firstname." ".$lastname;
      $data_message['email'] = $email;
      $data_message['phone'] = $phone;
      $data_message['hash'] = $hash;
      $data_message['referral'] = $referral;
      $message = $this->load->view('email/register', $data_message, TRUE);
      $this->email->message($message);
      if ($this->email->send()) {
        $data['result'] = "s";
        $data['message'] = "Message has been sent successfully!";
      } else {
        $data['result'] = "f";
        $data['message'] = show_error($this->email->print_debugger());
      }
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function get_err_register() {
    if ($this->session->userdata('member_reg')) {
      $data['result'] = $this->session->userdata('member_reg');
      $data['member_err'] = $this->session->userdata('member_err');
      $data['member_firstname'] = $this->session->userdata('member_firstname');
      $data['member_lastname'] = $this->session->userdata('member_lastname');
      $data['member_phone'] = $this->session->userdata('member_phone');
      $data['member_email'] = $this->session->userdata('member_email');
      $data['member_dob'] = $this->session->userdata('member_dob');
      $data['member_streetname'] = $this->session->userdata('member_streetname');
      $data['member_postalcode'] = $this->session->userdata('member_postalcode');
      $data['member_country'] = $this->session->userdata('member_country');

      $this->session->unset_userdata('member_reg');
      $this->session->unset_userdata('member_err');
      $this->session->unset_userdata('member_firstname');
      $this->session->unset_userdata('member_lastname');
      $this->session->unset_userdata('member_phone');
      $this->session->unset_userdata('member_email');
      $this->session->unset_userdata('member_dob');
      $this->session->unset_userdata('member_streetname');
      $this->session->unset_userdata('member_postalcode');
      $this->session->unset_userdata('member_country');
    } else {
      $data['result'] = "f";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function member_login() {
    if(!isset($_SESSION)){session_start();} ;
    $this->load->model('dashboard/model_member', '', TRUE);

    $result = "r1";
    $result_message = "Login Success";

    //Parameter
    $email = ($this->input->post('email', TRUE)) ? $this->input->post('email', TRUE) : "";
    $password = ($this->input->post('password', TRUE)) ? $this->input->post('password', TRUE) : "";
    //End Parameter
    
    //Check Parameter
    if ($password == "") {
      $result = "r2";
      $result_message = "Password is empty!";
    }

    if ($email == "") {
      $result = "r2";
      $result_message = "Email is empty!";
    }else{
      if ($this->model_member->check_email($email, 1)->num_rows() <= 0) {
        $result = "r2";
        $result_message = "Incorrect email or password!";
      }
      if($this->model_member->check_email($email, 0)->num_rows() > 0){
        $result = "r3";
      }
    }

    if ($result == "r1" && !$this->model_member->do_login($email, $password)) {
      $result = "r2";
      $result_message = "Incorrect email or password!";
    }
    //End Check Parameter

    if ($result == "r1") {
      $session_data = array(
        'email' => $email,
        'status_login' => $this->custom_encrypt->encrypt_string($email)
      );
      $this->session->set_userdata($session_data);
      
      $_SESSION["email"] = $email;
      $_SESSION["status_login"] = $this->custom_encrypt->encrypt_string($email);
    }

    $data['result'] = $result;
    $data['result_message'] = $result_message;

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function validate_member_login() {
    if(!isset($_SESSION)){session_start();} ;
    $this->load->model('dashboard/model_member', '', TRUE);

    $result = "r1";
    $result_message = "Login is valid";
    
    //Check Parameter
    if (!isset($_SESSION['email'])) {
      $result = "r2";
      $result_message = "Email is expired!";
    }

    if (!isset($_SESSION['status_login'])) {
      $result = "r2";
      $result_message = "Status Login is expired!";
    }
    
    if($result == "r1"){
      if (!$this->model_member->validate_login($_SESSION['email'], $_SESSION['status_login'])) {
        $result = "r2";
        $result_message = "Status Login is invalid!";
      }
    }
    //End Check Parameter

    $data['result'] = $result;
    $data['result_message'] = $result_message;
    $data['result_email'] = $this->session->userdata('email');

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function get_id_member(){
    if(!isset($_SESSION)){session_start();} 
    $this->load->model('dashboard/model_member', '', TRUE);
    $valid = TRUE;
    
    //Check Parameter
    if (!isset($_SESSION['email'])) {
      $valid = FALSE;
    }

    if (!isset($_SESSION['status_login'])) {
      $valid = FALSE;
    }
    
    if($valid){
      if (!$this->model_member->validate_login($_SESSION['email'], $_SESSION['status_login'])) {
        $valid = FALSE;
      }
    }
    //End Check Parameter
    
    if($valid){
      return $this->model_member->get_id($_SESSION['email']);
    }else{
      return $valid;
    }
  }
  
  function member_logout() {
    if(!isset($_SESSION)){session_start();} ;
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('status_login');
    session_unset();
    redirect('../about-us/');
    die();
  }
  
  function member_forget_password(){
    $this->load->model('dashboard/model_member', '', TRUE);
    
    $data['result'] = 'r1';
    $data['result_message'] = 'Your new password has succesfully been sent to your email.';
    
    //Parameter
    $email = ($this->input->post('email', TRUE)) ? $this->input->post('email', TRUE) : "";
    //End Parameter
    
    //Check Parameter
    if($email == ""){
      $data['result'] = 'r2';
      $data['result_message'] = 'No email was inputted.';
    }else if ($this->model_member->check_email($email)->num_rows() <= 0) {
      $data['result'] = 'r2';
      $data['result_message'] = 'Email is not registered.';
    }
    //End Check Parameter
    
    if($data['result'] == 'r1'){
      $generated_password = $this->model_member->reset_password($email);
      
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
      $this->email->subject("[Momo Cuppy] Your password for ".$email." has been resetted");
      
      //Data Message
      $data_message['email'] = $email;
      $data_message['password'] = $generated_password;
      $message = $this->load->view('email/resetpwd', $data_message, TRUE);
      $this->email->message($message);
      if (!$this->email->send()) {
        $data['result'] = "r2";
        $data['result_message'] = show_error($this->email->print_debugger());
      }
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function add_wishlist() {
    $this->load->model('dashboard/model_wishlist', '', TRUE);

    $result = "r1";
    $result_message = "Add to Wishlist Success";

    //Parameter
    $id_member = $this->get_id_member();
    $id_product = ($this->input->post('id_product', TRUE)) ? $this->input->post('id_product', TRUE) : "";
    //End Parameter
    
    //Check Parameter
    if(!$id_member){
      $result = "r2";
      $result_message = "You must login first!";
    }else{
      if ($id_product == "") {
        $result = "r2";
        $result_message = "ID Product is empty!";
      }

      if ($this->model_wishlist->check_wishlist($id_member, $id_product)->num_rows() > 0) {
        $result = "r2";
        $result_message = "Product is already on your wishlist!";
      }
    }
    
    
    //End Check Parameter

    if ($result == "r1") {
      $this->model_wishlist->add_object($id_member, $id_product);
    }

    $data['result'] = $result;
    $data['result_message'] = $result_message;

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function remove_wishlist() {
    $this->load->model('dashboard/model_wishlist', '', TRUE);

    $result = "r1";
    $result_message = "Add to Wishlist Success";

    //Parameter
    $id_member = $this->get_id_member();
    $id_product = ($this->input->post('id_product', TRUE)) ? $this->input->post('id_product', TRUE) : 0;
    //End Parameter

    if (!$id_member) {
      $result = "r2";
      $result_message = "You must login first!";
    }else{
      $check_wishlist = $this->model_wishlist->check_wishlist($id_member, $id_product);
      if ($check_wishlist->num_rows() < 0) {
        $result = "r2";
        $result_message = "Wishlist data not found!";
      }

      if ($result == "r1") {
        $this->model_wishlist->remove_object($check_wishlist->row()->id);
      }
    }

    $data['result'] = $result;
    $data['result_message'] = $result_message;

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function set_cart() {
    $this->load->model('dashboard/model_order', '', TRUE);

    $result = "r1";
    $result_message = "Add to Cart Success";

    //Parameter
    $id_member = $this->get_id_member();
    $id_dt_product = ($this->input->post('id_dt_product', TRUE)) ? $this->input->post('id_dt_product', TRUE) : "";
    $qty = ($this->input->post('qty', TRUE)) ? $this->input->post('qty', TRUE) : "";
    //End Parameter
    
    //Check Parameter
    if(!$id_member){
      $result = "r2";
      $result_message = "You must login first!";
    }else{
      if ($id_dt_product == "") {
        $result = "r2";
        $result_message = "ID Detail Product is empty!";
      }

      if ($qty == "") {
        $result = "r2";
        $result_message = "Quantity is empty!";
      } else if (!is_numeric($qty)) {
        $result_message = "Quantity must be a number!";
      }

      if(!$this->model_order->check_stock($id_member, $id_dt_product, $qty)){
        $result = "r2";
        $result_message = "Not enough stock!";
      }
    }
    //End Check Parameter

    if ($result == "r1") {
      $this->model_order->set_cart($id_member, $id_dt_product, $qty);
    }

    $data['result'] = $result;
    $data['result_message'] = $result_message;

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function get_cart() {
    $this->load->model('dashboard/model_order', '', TRUE);

    //Filter
    $id_member = $this->get_id_member();
    //End Filter
    
    if(!$id_member){
      $data['result'] = "f";
      $data['message'] = "You must login first!";
    }else{
      $totalrow = $this->model_order->get_cart($id_member)->num_rows();
      if ($totalrow > 0) {
        $query = $this->model_order->get_cart($id_member)->result();
        $data['result'] = "s";
        $data['content'] = $query;
      } else {
        $data['result'] = "f";
        $data['message'] = "Cart is empty";
      }
    }

    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function remove_cart() {
    $this->load->model('dashboard/model_order', '', TRUE);

    //Filter
    $id_member = $this->get_id_member();
    $id = ($this->input->post('id', TRUE)) ? $this->input->post('id', TRUE) : 0;
    //End Filter
    
    if(!$id_member){
      $data['result'] = "f";
      $data['message'] = "You must login first!";
    }else{
      $remove_cart = $this->model_order->remove_cart($id_member, $id);
      if ($remove_cart) {
        $data['result'] = "s";
      } else {
        $data['result'] = "f";
      }
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function get_voucher() {
    $this->load->model('dashboard/model_voucher', '', TRUE);

    //Filter
    $voucher_code = ($this->input->post('voucher_code', TRUE)) ? $this->input->post('voucher_code', TRUE) : '';
    //End Filter
    
    if($voucher_code == ''){
      $data['result'] = "f";
      $data['message'] = "Voucher is empty!";
    }else{
      $query = $this->model_voucher->get_object(0, "", $voucher_code);
      $totalrow = $query->num_rows();
      if ($totalrow > 0) {
        if ($query->row()->expired_date != null) {
          $date_now = strtotime(date('Y-m-d'));
          $date_expired = strtotime(date_format(date_create($query->row()->expired_date), 'Y-m-d'));
          if ($date_expired > $date_now) {
            $result = $query->result();
            $data['result'] = "s";
            $session_data = array(
              'voucher_code' => $voucher_code,
              'discount' => $query->row()->discount
            );
            $this->session->set_userdata($session_data);
            $data['message'] = "Voucher is applied!";
            $data['content'] = $result;
          } else {
            $data['result'] = "f";
            $data['message'] = "Voucher is expired!";
          }
        } else {
          $result = $query->result();
          $session_data = array(
            'voucher_code' => $voucher_code,
            'discount' => $query->row()->discount
          );
          $this->session->set_userdata($session_data);
          $data['result'] = "s";
          $data['message'] = "Voucher is applied!";
          $data['content'] = $result;
        }
      } else {
        $data['result'] = "f";
        $data['message'] = "Voucher is not exist!";
      }
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function get_session_voucher() {
    if ($this->session->userdata('voucher_code')) {
      $data['result'] = "s";
      $data['voucher_code'] = $this->session->userdata('voucher_code');
      $data['discount'] = $this->session->userdata('discount');
    } else {
      $data['result'] = "f";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function get_referral() {
    $this->load->model('dashboard/model_member', '', TRUE);

    //Filter
    $id_member = $this->get_id_member();
    $referral = ($this->input->post('referral', TRUE)) ? $this->input->post('referral', TRUE) : '';
    //End Filter
    
    if(!$id_member){
      $data['result'] = "f";
      $data['message'] = "You must login first!";
    }else if($referral == ''){
      $data['result'] = "f";
      $data['message'] = "Referral Code is empty!";
    }else{
      $query_first_time_buyer = $this->model_member->check_first_time_buyer($id_member)->num_rows();
      if ($query_first_time_buyer <= 0) {
        $query_referral = $this->model_member->check_referral($id_member, $referral)->num_rows();
        if ($query_referral > 0) {
          $session_data = array(
            'referral' => $referral
          );
          $this->session->set_userdata($session_data);
          $data['result'] = "s";
          $data['message'] = "Referral Code is applied!";
        } else {
          $data['result'] = "f";
          $data['message'] = "Referral Code is not exist!";
        }
      } else {
        $data['result'] = "f";
        $data['message'] = "Referral only applied to first time buyer!";
      }
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function get_session_referral() {
    if ($this->session->userdata('referral')) {
      $data['result'] = "s";
      $data['referral'] = $this->session->userdata('referral');
    } else {
      $data['result'] = "f";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function get_shipping() {
    if(!isset($_SESSION)){session_start();} ;
    
    //Filter
    $courier = ($this->input->post('courier', TRUE)) ? $this->input->post('courier', TRUE) : "";
    //End Filter
    
    if($courier !== ""){
      $data['result'] = "s";
      $_SESSION['courier'] = $courier;
    } else {
      $data['result'] = "f";
      $data['message'] = "Error in connection!";
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function get_cost() {
    if(!isset($_SESSION)){session_start();} ;
    
    //Get Parameter
    $city_id = ($this->input->post('city_id', TRUE)) ? $this->input->post('city_id', TRUE) : "";
    $weight = ($this->input->post('weight', TRUE)) ? $this->input->post('weight', TRUE) : "";
    //End Get Parameter
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "origin=151&destination=".$city_id."&weight=".$weight."&courier=jne",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "key: 67e47b562d26068bdf0db0886c797f7c"
      ),
    ));

    $response = json_decode(curl_exec($curl), true);
    $err = curl_error($curl);
    curl_close($curl);
    
    //Check Courier
    if (isset($_SESSION['courier'])) {
      if ($response['rajaongkir']['status']['code'] == 200) {
        $data['result'] = 'r2';
        $data['message'] = 'Sorry, your area is not covered with JNE. Please contact help@momocuppy.com to order.';
        $courier = $_SESSION['courier'];
        foreach ($response['rajaongkir']['results'] as $value) {
          $temp = 0;
          foreach ($value['costs'] as $ongkir) {
            $service = "";
            if($ongkir['service'] == 'CTC'){
              $service = 'REG';
            }else if($ongkir['service'] == 'CTCYES'){
              $service = 'YES';
            }
            if($ongkir['service'] == $courier || $service == $courier){
              $data['result'] = 'r1';
              $data['message'] = $response['rajaongkir']['status']['description'];
              $data['cost'] = $ongkir['cost'][0]['value'];
              $_SESSION['shipping_cost'] = $ongkir['cost'][0]['value'];
              break;
            }else{
              $data['result'] = 'r2';
              $data['message'] = 'Sorry, your area is not covered with JNE. Please contact help@momocuppy.com to order.';
            }
            $temp++;
          }
        }
      }else if($response['rajaongkir']['status']['code'] == 400){
        $data['result'] = 'r2';
        $data['message'] = 'Sorry, weight limit is exceeded (max 30 kg).';
      }else {
        $data['result'] = 'r2';
        $data['message'] = 'Sorry, an error occurred. Please try again in 10 minutes.';
      }
    } else {
      $data['result'] = 'r3';
      $data['message'] = 'Shipping Method is empty';
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function new_order() {
    if(!isset($_SESSION)){session_start();}
    
    $this->load->model('dashboard/model_order', '', TRUE);

    $result = "r1";
    $result_message = "Order Success";

    //Parameter
    $id_member = $this->get_id_member();
    $firstname = ($this->input->post('order_firstname', TRUE)) ? $this->input->post('order_firstname', TRUE) : "";
    $lastname = ($this->input->post('order_lastname', TRUE)) ? $this->input->post('order_lastname', TRUE) : "";
    $street_address = ($this->input->post('order_street_address', TRUE)) ? $this->input->post('order_street_address', TRUE) : "";
    $phone = ($this->input->post('order_phone', TRUE)) ? $this->input->post('order_phone', TRUE) : "";
    $zip_code = ($this->input->post('order_zip_code', TRUE)) ? $this->input->post('order_zip_code', TRUE) : "";
    $country = ($this->input->post('order_country', TRUE)) ? $this->input->post('order_country', TRUE) : "";
    $city = ($this->input->post('order_city', TRUE)) ? $this->input->post('order_city', TRUE) : "";
    $payment_name = ($this->input->post('order_payment_name', TRUE)) ? $this->input->post('order_payment_name', TRUE) : "";
    $payment_account = ($this->input->post('order_payment_account', TRUE)) ? $this->input->post('order_payment_account', TRUE) : "";
    $payment_account_name = ($this->input->post('order_payment_account_name', TRUE)) ? $this->input->post('order_payment_account_name', TRUE) : "";
    $courier = (isset($_SESSION['courier'])) ? $_SESSION['courier'] : "";
    $shipping_cost = (isset($_SESSION['shipping_cost'])) ? $_SESSION['shipping_cost'] : 0;
    $voucher_code = ($this->input->post('order_voucher_code', TRUE)) ? $this->input->post('order_voucher_code', TRUE) : NULL;
    $discount = ($this->input->post('order_discount', TRUE)) ? $this->input->post('order_discount', TRUE) : NULL;
    $referral = ($this->input->post('order_referral', TRUE)) ? $this->input->post('order_referral', TRUE) : NULL;
    //End Parameter
    
    //Check Parameter
    if (!$id_member) {
      $result = "r2";
      $result_message = "You must login first!";
      redirect('../order/order2.php#summary', 'refresh');
      die();
    }

    if ($street_address == "" || $zip_code == "" || $country == "" || $city == "") {
      $result = "r2";
      $result_message = "Please choose your shipping address!";
    }

    if ($payment_name == "" || $payment_account == "") {
      $result = "r2";
      $result_message = "Please choose payment method!";
    }
    
    if ($courier == "") {
      $result = "r2";
      $result_message = "Please choose your shipping method!";
    }
    
    if ($shipping_cost < 0) {
      $result = "r2";
      $result_message = "Please choose your shipping method!";
    }

    //Check Cart
    if ($this->model_order->get_cart($id_member)->num_rows() <= 0) {
      $result = "r2";
      $result_message = "Cart is empty!";
    }
    //End Check Parameter

    if ($result == "r1") {
      $validate_order_post = $this->model_order->validate_order_post($firstname, $lastname, $street_address, $phone, $zip_code, $country, $city, $payment_name, $payment_account, $payment_account_name, $voucher_code, $discount, $referral);
      if($validate_order_post){
        $order = $this->model_order->add_object($id_member, $firstname, $lastname, $street_address, $phone, $zip_code, $country, $city, $payment_name, $payment_account, $payment_account_name, $courier, $shipping_cost, $voucher_code, $discount, $referral);

        if(!$order['result']){
          //Set Session Order
          $session_data = array(
            'order_alert' => $order['result_message']
          );
          $this->session->set_userdata($session_data);

          redirect('../order/index.php', 'refresh');
          die();
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
        $this->email->to($_SESSION["email"]); // change it to yours
        $this->email->subject("Momo Cuppy Order Confirmation (Order No ".$order['return_order']['order_no'].")");

        //Data Message
        $data_message['order_no'] = $order['return_order']['order_no'];
        $data_message['firstname'] = $firstname;
        $data_message['lastname'] = $lastname;
        $data_message['product'] = $order['return_order']['order_detail'];
        $data_message['shipping'] = $shipping_cost;
        $data_message['discount'] = $discount;
        $data_message['courier'] = $courier;
        $data_message['street_address'] = $street_address;
        $data_message['zip_code'] = $zip_code;
        $data_message['country'] = $country;
        $data_message['phone'] = $phone;
        $data_message['city'] = $city;
        $data_message['payment_name'] = $payment_name;
        $data_message['payment_account_name'] = $payment_account_name;
        $data_message['payment_account'] = $payment_account;

        $message = $this->load->view('email/order', $data_message, TRUE);
        $this->email->message($message);
        if ($this->email->send()) {
          //Set Session Order
          $_SESSION['order_no'] = $order['return_order']['order_no'];
          $_SESSION['grand_total'] = $order['return_order']['grand_total'];
          $_SESSION['point'] = $order['return_order']['point'];
          $_SESSION['payment_name'] = $order['return_order']['payment_name'];
          $_SESSION['payment_account'] = $order['return_order']['payment_account'];
          $_SESSION['payment_account_name'] = $order['return_order']['payment_account_name'];
          redirect('../order/order3.php#summary', 'refresh');
          die();
        } else {
          //Set Session Order
          $session_data = array(
            'order_error' => show_error($this->email->print_debugger())
          );
          $this->session->set_userdata($session_data);

          redirect('../order/order2.php#summary', 'refresh');
          die();
        }
      }else{
        //Set Session Order
        $session_data = array(
          'order_error' => "There was a mismatch data with system. Aborting."
        );
        $this->session->set_userdata($session_data);

        redirect('../order/order2.php#summary', 'refresh');
        die();
      }
    } else {
      //Set Session Order
      $session_data = array(
        'order_error' => $result_message
      );
      $this->session->set_userdata($session_data);

      redirect('../order/order2.php#summary', 'refresh');
      die();
    }
  }
  
  function new_redeem() {
    if(!isset($_SESSION)){session_start();}
    
    $this->load->model('dashboard/model_order', '', TRUE);

    $result = "r1";
    $result_message = "Redeem Success";

    //Parameter
    $id_member = $this->get_id_member();
    $id_redeem = (isset($_SESSION['id_redeem'])) ? $_SESSION['id_redeem'] : "";
    $firstname = ($this->input->post('order_firstname', TRUE)) ? $this->input->post('order_firstname', TRUE) : "";
    $lastname = ($this->input->post('order_lastname', TRUE)) ? $this->input->post('order_lastname', TRUE) : "";
    $street_address = ($this->input->post('order_street_address', TRUE)) ? $this->input->post('order_street_address', TRUE) : "";
    $phone = ($this->input->post('order_phone', TRUE)) ? $this->input->post('order_phone', TRUE) : "";
    $zip_code = ($this->input->post('order_zip_code', TRUE)) ? $this->input->post('order_zip_code', TRUE) : "";
    $country = ($this->input->post('order_country', TRUE)) ? $this->input->post('order_country', TRUE) : "";
    $city = ($this->input->post('order_city', TRUE)) ? $this->input->post('order_city', TRUE) : "";
    //End Parameter
    
    //Check Parameter
    if (!$id_member) {
      $result = "r2";
      $result_message = "You must login first!";
      redirect('../order/order2.php#summary', 'refresh');
      die();
    }
    
    if ($id_redeem == "") {
      $result = "r2";
      $result_message = "Redeem product is not found!";
    }

    if ($street_address == "" || $zip_code == "" || $country == "" || $city == "") {
      $result = "r2";
      $result_message = "Please choose your Shipping Address!";
    }
    //End Check Parameter

    if ($result == "r1") {
      $validate_redeem_post = $this->model_order->validate_redeem_post($firstname, $lastname, $street_address, $phone, $zip_code, $country, $city);
      if($validate_redeem_post){
        $order = $this->model_order->add_redeem($id_member, $id_redeem, $firstname, $lastname, $street_address, $phone, $zip_code, $country, $city);

        if(!$order['result']){
          //Set Session Order
          $session_data = array(
            'order_error' => $order['result_message']
          );
          $this->session->set_userdata($session_data);

          redirect('../redeem/checkout/?redeem_p='.$id_redeem, 'refresh');
        die();
        }
        
        //Set Session Order
        $_SESSION['order_no'] = $order['return_order']['order_no'];
        $_SESSION['redeem_keep'] = TRUE;
        redirect('../redeem/success/#maincontent', 'refresh');
        die();
      }else{
        //Set Session Order
        $session_data = array(
          'order_error' => "There was a mismatch data with system. Aborting."
        );
        $this->session->set_userdata($session_data);

        redirect('../redeem/checkout/?redeem_p='.$id_redeem, 'refresh');
        die();
      }
    } else {
      //Set Session Order
      $session_data = array(
        'order_error' => $result_message
      );
      $this->session->set_userdata($session_data);

      redirect('../redeem/checkout/?redeem_p='.$id_redeem, 'refresh');
      die();
    }
  }
  
  function get_order_payment() {
    $this->load->model('dashboard/model_order', '', TRUE);
    
//    $id_member = $this->get_id_member();
//    if(!$id_member){
//      $data['result'] = "f";
//      $data['message'] = "You must login first";
//    }else{
//      $orderid = ($this->input->post('orderid', TRUE)) ? $this->input->post('orderid', TRUE) : 0;
//      $totalrow = $this->model_order->get_object(0, "", "", "", "", "", $orderid)->num_rows();
//      if ($totalrow > 0) {
//        $query = $this->model_order->get_object(0, "", "", "", "", "", $orderid)->result();
//        $data['result'] = "s";
//        $data['content'] = $query;
//      } else {
//        $data['result'] = "f";
//        $data['message'] = "ORDER ID is not exist";
//      }
//    }
    
    $orderid = ($this->input->post('orderid', TRUE)) ? $this->input->post('orderid', TRUE) : 0;
    if($orderid > 0){
      $totalrow = $this->model_order->get_object(0, 0, "", "", "", "", "", $orderid)->num_rows();
      if ($totalrow > 0) {
        $query = $this->model_order->get_object(0, 0, "", "", "", "", "", $orderid)->result();
        $data['result'] = "s";
        $data['content'] = $query;
      } else {
        $data['result'] = "f";
        $data['message'] = "ORDER ID is not exist";
      }
    }else{
      $data['result'] = "f";
      $data['message'] = "ORDER ID is not exist";
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function get_session_order_alert() {
    if ($this->session->userdata('order_alert')) {
      $data['result'] = "r1";
      $data['order_alert'] = $this->session->userdata('order_alert');
      $this->session->unset_userdata('order_alert');
    } else {
      $data['result'] = "r2";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function get_session_order() {
    if ($this->session->userdata('order_no')) {
      $data['result'] = "r1";
      $data['order_no'] = $this->session->userdata('order_no');
      $data['grand_total'] = $this->session->userdata('grand_total');
      $data['point'] = $this->session->userdata('point');
      $data['payment_name'] = $this->session->userdata('payment_name');
      $data['payment_account'] = $this->session->userdata('payment_account');
      $data['payment_account_name'] = $this->session->userdata('payment_account_name');
      $this->remove_session_order();
    } else if ($this->session->userdata('order_error')) {
      $data['result'] = "r2";
      $data['order_error'] = $this->session->userdata('order_error');
    } else {
      $data['result'] = "r3";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function remove_session_order() {
    $this->session->unset_userdata('referral');
    $this->session->unset_userdata('voucher_code');
    $this->session->unset_userdata('shipping');
    $this->session->unset_userdata('discount');
    $this->session->unset_userdata('order_no');
    $this->session->unset_userdata('grand_total');
    $this->session->unset_userdata('point');
    $this->session->unset_userdata('payment_name');
    $this->session->unset_userdata('payment_account');
    $this->session->unset_userdata('order_error');
    $data['result'] = "s";
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function get_session_redeem() {
    if ($this->session->userdata('order_no')) {
      $data['result'] = "r1";
      $data['order_no'] = $this->session->userdata('order_no');
      $this->remove_session_redeem();
    } else if ($this->session->userdata('order_error')) {
      $data['result'] = "r2";
      $data['order_error'] = $this->session->userdata('order_error');
    } else {
      $data['result'] = "r3";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function remove_session_redeem() {
    $this->session->unset_userdata('order_no');
    $this->session->unset_userdata('order_error');
    $data['result'] = "s";
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function set_price(){
    $price = ($this->input->post('price', TRUE)) ? $this->input->post('price', TRUE) : "";
    $weight = ($this->input->post('weight', TRUE)) ? $this->input->post('weight', TRUE) : "";
    $interest = ($this->input->post('interest', TRUE)) ? $this->input->post('interest', TRUE) : "";
    
    $calculated_price = ($price/($weight/500))*($interest+100)/100;
    
    $data['calculated_price'] = ceil($calculated_price);
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function get_object_search() {
    $this->load->model('dashboard/model_product', '', TRUE);

    //Filter
    $keyword = ($this->input->post('keyword', TRUE)) ? $this->input->post('keyword', TRUE) : "";
    //End Filter
    
    if($keyword != ""){
      $get_object_search = $this->model_product->get_object_search($keyword);
      if($get_object_search->num_rows() > 0){
        $data['result'] = "s";
        $data['content'] = $get_object_search->result();
      }else{
        $data['result'] = "f";
      }
    }else{
      $data['result'] = "f";
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
}
