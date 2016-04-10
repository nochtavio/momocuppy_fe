<?php

class api extends CI_Controller {

  function __construct() {
    date_default_timezone_set('Asia/Jakarta');
    parent::__construct();
    $this->load->model('dashboard/model_admin', '', TRUE);
    $this->load->library('custom_encrypt');
  }

  function sendMail() {
    session_start();
    
    $name = ($this->input->post('name', TRUE)) ? $this->input->post('name', TRUE) : "";
    $subject = ($this->input->post('subject', TRUE)) ? $this->input->post('subject', TRUE) : "";
    $message = ($this->input->post('message', TRUE)) ? $this->input->post('message', TRUE) : "";
    $to = ($this->input->post('to', TRUE)) ? $this->input->post('to', TRUE) : "";
    $no1 = ($this->input->post('no1', TRUE)) ? $this->input->post('no1', TRUE) : 0;
    $no2 = ($this->input->post('no2', TRUE)) ? $this->input->post('no2', TRUE) : 0;
    $verify = ($this->input->post('no1', TRUE)) ? $this->input->post('verify', TRUE) : "";

    if($verify != $no1+$no2){
      $data['result'] = "f";
      $data['message'] = "Verify Number is false.";
    }else{
      $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'mail.momocuppy.com',
        'smtp_port' => 587,
        'smtp_user' => 'alief@momocuppy.com', // change it to yours
        'smtp_pass' => 'inop22', // change it to yours
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
      );

      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('alief@momocuppy.com'); // change it to yours
      $this->email->to($to); // change it to yours
      $this->email->subject("[".$name."] ".$subject);
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

  function generate_list_product() {
    $this->load->model('dashboard/model_product', '', TRUE);
    $this->load->model('dashboard/model_detail_product', '', TRUE);
    $this->load->model('dashboard/model_detail_product_img', '', TRUE);

    //Paging
    $page = ($this->input->post('page', TRUE)) ? $this->input->post('page', TRUE) : 1;
    $size = ($this->input->post('size', TRUE)) ? $this->input->post('size', TRUE) : 10;
    $limit = ($page - 1) * $size;
    //End Paging
    //Filter
    $id = ($this->input->post('id', TRUE)) ? $this->input->post('id', TRUE) : 0;
    $product_name = ($this->input->post('product_name', TRUE)) ? $this->input->post('product_name', TRUE) : "";
    $type = ($this->input->post('type', TRUE)) ? $this->input->post('type', TRUE) : 1;
    $id_category = ($this->input->post('id_category', TRUE)) ? $this->input->post('id_category', TRUE) : 0;
    $visible = ($this->input->post('visible', TRUE)) ? $this->input->post('visible', TRUE) : 0;
    $order = ($this->input->post('order', TRUE)) ? $this->input->post('order', TRUE) : 0;
    //End Filter

    $totalrow = $this->model_product->get_object_api($id, $product_name, $type, $id_category, $visible, $order)->num_rows();

    //Set totalpaging
    $totalpage = ceil($totalrow / $size);
    $data['totalpage'] = $totalpage;
    //End Set totalpaging

    if ($totalrow > 0) {
      $query = $this->model_product->get_object_api($id, $product_name, $type, $id_category, $visible, $order, $limit, $size)->result();

      $data['result'] = "s";
      $data['content'] = $query;
      if ($id > 0) {
        $query_detail = $this->model_detail_product->get_object(0, $id, 0, 1)->result();
        $query_detail_img = $this->model_detail_product_img->get_object(0, $id, 1)->result();
        $data['detail'] = $query_detail;
        $data['img'] = $query_detail_img;
      }
    } else {
      $data['result'] = "f";
      $data['message'] = "No Product";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function generate_list_product_redeem() {
    $this->load->model('dashboard/model_product_redeem', '', TRUE);
    $this->load->model('dashboard/model_detail_product_redeem_img', '', TRUE);

    //Paging
    $page = ($this->input->post('page', TRUE)) ? $this->input->post('page', TRUE) : 1;
    $size = ($this->input->post('size', TRUE)) ? $this->input->post('size', TRUE) : 10;
    $limit = ($page - 1) * $size;
    //End Paging
    //Filter
    $id = ($this->input->post('id', TRUE)) ? $this->input->post('id', TRUE) : 0;
    $product_name = ($this->input->post('product_name', TRUE)) ? $this->input->post('product_name', TRUE) : "";
    $visible = ($this->input->post('visible', TRUE)) ? $this->input->post('visible', TRUE) : 0;
    $order = ($this->input->post('order', TRUE)) ? $this->input->post('order', TRUE) : 0;
    //End Filter

    $totalrow = $this->model_product_redeem->get_object($id, $product_name, $visible, $order)->num_rows();

    //Set totalpaging
    $totalpage = ceil($totalrow / $size);
    $data['totalpage'] = $totalpage;
    //End Set totalpaging

    if ($totalrow > 0) {
      $query = $this->model_product_redeem->get_object($id, $product_name, $visible, $order, $limit, $size)->result();

      $data['result'] = "s";
      $data['content'] = $query;
      if ($id > 0) {
        $query_detail_img = $this->model_detail_product_redeem_img->get_object(0, $id, 1)->result();
        $data['img'] = $query_detail_img;
      }
    } else {
      $data['result'] = "f";
      $data['message'] = "No Product";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function generate_member_address() {
    $this->load->model('dashboard/model_detail_address', '', TRUE);

    //Filter
    $id = ($this->input->post('id', TRUE)) ? $this->input->post('id', TRUE) : 0;
    $id_member = 1;
    $order = ($this->input->post('order', TRUE)) ? $this->input->post('order', TRUE) : 1;
    //End Filter

    $totalrow = $this->model_detail_address->get_object($id, $id_member, "", $order)->num_rows();

    if ($totalrow > 0) {
      $query = $this->model_detail_address->get_object($id, $id_member, "", $order)->result();
      $data['result'] = "s";
      $data['content'] = $query;
    } else {
      $data['result'] = "f";
      $data['message'] = "No Address";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function add_address(){
    $this->load->model('dashboard/model_detail_address', '', TRUE);
    
    $result = "r1";
    $result_message = "";
    
    //Parameter
    $id_member = 1;
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
  
  function edit_address(){
    $this->load->model('dashboard/model_detail_address', '', TRUE);
    
    $result = "r1";
    $result_message = "";
    
    //Parameter
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

    $totalrow = $this->model_payment->get_object($id, "", "", "", 1)->num_rows();

    if ($totalrow > 0) {
      $query = $this->model_payment->get_object($id, "", "", "", 1)->result();
      $data['result'] = "s";
      $data['content'] = $query;
    } else {
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
    while ($this->model_member->check_referral($referral)->num_rows() > 0) {
      $referral = random_string('alnum', 7);
    }
    return $referral;
  }
  
  function generate_city(){
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
    if($response['rajaongkir']['status']['code'] == 200){
      $data['result'] = 'r1';
      $data['message'] = $response['rajaongkir']['status']['description'];
      $this->db->truncate('ms_city');
      foreach ($response['rajaongkir']['results'] as $value) {
        $this->model_city->add_object($value['city_id'], $value['city_name'], $value['type']);
      }
    }else{
      $data['result'] = 'r2';
      $data['message'] = $response['rajaongkir']['status']['description'];
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function member_register() {
    $this->load->model('dashboard/model_member', '', TRUE);

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
    }
    
    if ($email == "") {
      $result = "f";
      $err['email'] = "must be filled";
    } else if ($this->model_member->check_email($email)->num_rows() > 0) {
      $result = "f";
      $err['email'] = "email already registered";
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
        'smtp_user' => 'alief@momocuppy.com', // change it to yours
        'smtp_pass' => 'inop22', // change it to yours
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
      );

      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('alief@momocuppy.com'); // change it to yours
      $this->email->to($email); // change it to yours
      $this->email->subject("Momocuppy Email Verification");
      $this->email->message("Welcome to Momocuppy. <br/> <br/> Please click link below to active your member. <br/> http://www.momocuppy.com/activate/?email=".$email."&hash=".$hash);
      if ($this->email->send()) {
        $data['result'] = "s";
        $data['message'] = "Message has been sent successfully!";
        redirect('../member/register/#success');
        die();
      } else {
        $data['result'] = "f";
        $data['message'] = show_error($this->email->print_debugger());
        redirect('../member/register/#failed');
        die();
      }
    }else{
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
      redirect('../member/register/#failed');
      die();
    }
  }
  
  function get_err_register(){
    if($this->session->userdata('member_reg')){
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
    }else{
      $data['result'] = "f";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function member_login() {
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
    } else if ($this->model_member->check_email($email)->num_rows() <= 0) {
      $result = "r2";
      $result_message = "Email is not registered!";
    }

    if ($result == "r1" && !$this->model_member->do_login($email, $password)) {
      $result = "r2";
      $result_message = "Wrong password!";
    }
    //End Check Parameter

    if ($result == "r1") {
      $session_data = array(
        'email' => $email,
        'status_login' => $this->custom_encrypt->encrypt_string($email)
      );
      $this->session->set_userdata($session_data);
    }

    $data['result'] = $result;
    $data['result_message'] = $result_message;

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function validate_member_login() {
    $this->load->model('dashboard/model_member', '', TRUE);

    $result = "r1";
    $result_message = "Login is valid";

    //Parameter
    $email = ($this->input->post('email', TRUE)) ? $this->input->post('email', TRUE) : "";
    //End Parameter
    
    //Check Parameter
    if ($email == "") {
      $result = "r2";
      $result_message = "Email is empty!";
    }

    if (!$this->session->userdata('status_login')) {
      $result = "r2";
      $result_message = "Status Login is expired!";
    }

    if (!$this->model_member->validate_login($email, $this->session->userdata('status_login'))) {
      $result = "r2";
      $result_message = "Status Login is invalid!";
    }
    //End Check Parameter

    $data['result'] = $result;
    $data['result_message'] = $result_message;

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function add_wishlist() {
    $this->load->model('dashboard/model_wishlist', '', TRUE);

    $result = "r1";
    $result_message = "Add to Wishlist Success";

    //Parameter
    $id_member = 1;
    $id_product = ($this->input->post('id_product', TRUE)) ? $this->input->post('id_product', TRUE) : "";
    //End Parameter
    
    //Check Parameter
    if ($id_product == "") {
      $result = "r2";
      $result_message = "ID Product is empty!";
    }
    
    if ($this->model_wishlist->check_wishlist($id_member, $id_product)->num_rows() > 0) {
      $result = "r2";
      $result_message = "Product is already on your wishlist!";
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
    $id_member = 1;
    $id_product = ($this->input->post('id_product', TRUE)) ? $this->input->post('id_product', TRUE) : 0;
    //End Parameter
    
    if($id_member == 0){
      $result = "r2";
      $result_message = "ID Product is empty!";
    }
    
    $check_wishlist = $this->model_wishlist->check_wishlist($id_member, $id_product);
    if ($check_wishlist->num_rows() < 0) {
      $result = "r2";
      $result_message = "Wishlist data not found!";
    }
    
    if($result == "r1"){
      $this->model_wishlist->remove_object($check_wishlist->row()->id);
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
    $id_member = 1;
    $id_dt_product = ($this->input->post('id_dt_product', TRUE)) ? $this->input->post('id_dt_product', TRUE) : "";
    $qty = ($this->input->post('qty', TRUE)) ? $this->input->post('qty', TRUE) : "";
    //End Parameter
    
    //Check Parameter
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
    $id_member = 1;
    //End Filter

    $totalrow = $this->model_order->get_cart($id_member)->num_rows();
    if ($totalrow > 0) {
      $query = $this->model_order->get_cart($id_member)->result();
      $data['result'] = "s";
      $data['content'] = $query;
    } else {
      $data['result'] = "f";
      $data['message'] = "Cart is empty";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function remove_cart() {
    $this->load->model('dashboard/model_order', '', TRUE);

    //Filter
    $id_member = 1;
    $id = ($this->input->post('id', TRUE)) ? $this->input->post('id', TRUE) : 0;
    //End Filter
    
    $remove_cart = $this->model_order->remove_cart($id_member, $id);
    if ($remove_cart) {
      $data['result'] = "s";
    } else {
      $data['result'] = "f";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function get_voucher(){
    $this->load->model('dashboard/model_voucher', '', TRUE);

    //Filter
    $voucher_code = ($this->input->post('voucher_code', TRUE)) ? $this->input->post('voucher_code', TRUE) : 0;
    //End Filter
    $query = $this->model_voucher->get_object(0,"",$voucher_code);
    $totalrow = $query->num_rows();
    if ($totalrow > 0) {
      if($query->row()->expired_date != null){
        $date_now = strtotime(date('Y-m-d'));
        $date_expired = strtotime(date_format(date_create($query->row()->expired_date), 'Y-m-d'));
        if($date_expired > $date_now){
          $result = $query->result();
          $data['result'] = "s";
          $data['message'] = "Voucher is applied!";
          $data['content'] = $result;
        }else{
          $data['result'] = "f";
          $data['message'] = "Voucher is expired!";
        }
      }else{
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
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function get_session_voucher(){
    if($this->session->userdata('voucher_code')){
      $data['result'] = "s";
      $data['voucher_code'] = $this->session->userdata('voucher_code');
      $data['discount'] = $this->session->userdata('discount');
    }else{
      $data['result'] = "f";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function get_referral(){
    $this->load->model('dashboard/model_member', '', TRUE);

    //Filter
    $id_member = 1;
    $referral = ($this->input->post('referral', TRUE)) ? $this->input->post('referral', TRUE) : 0;
    //End Filter
    
    $query_first_time_buyer = $this->model_member->check_first_time_buyer($id_member)->num_rows();
    if($query_first_time_buyer <= 0){
      $query_referral = $this->model_member->check_referral($referral)->num_rows();
      if($query_referral > 0){
        $session_data = array(
          'referral' => $referral
        );
        $this->session->set_userdata($session_data);
        $data['result'] = "s";
        $data['message'] = "Referral Code is applied!";
      }else{
        $data['result'] = "f";
        $data['message'] = "Referral Code is not exist!";
      }
    }else{
      $data['result'] = "f";
      $data['message'] = "Referral only applied to first time buyer!";
    }
    
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function get_session_referral(){
    if($this->session->userdata('referral')){
      $data['result'] = "s";
      $data['referral'] = $this->session->userdata('referral');
    }else{
      $data['result'] = "f";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  function new_order() {
    $this->load->model('dashboard/model_order', '', TRUE);

    $result = "r1";
    $result_message = "Order Success";

    //Parameter
    $id_member = 1;
    $firstname = ($this->input->post('order_firstname', TRUE)) ? $this->input->post('order_firstname', TRUE) : "";
    $lastname = ($this->input->post('order_lastname', TRUE)) ? $this->input->post('order_lastname', TRUE) : "";
    $street_address = ($this->input->post('order_street_address', TRUE)) ? $this->input->post('order_street_address', TRUE) : "";
    $phone = ($this->input->post('order_phone', TRUE)) ? $this->input->post('order_phone', TRUE) : "";
    $zip_code = ($this->input->post('order_zip_code', TRUE)) ? $this->input->post('order_zip_code', TRUE) : "";
    $country = ($this->input->post('order_country', TRUE)) ? $this->input->post('order_country', TRUE) : "";
    $city = ($this->input->post('order_city', TRUE)) ? $this->input->post('order_city', TRUE) : "";
    $payment_name = ($this->input->post('order_payment_name', TRUE)) ? $this->input->post('order_payment_name', TRUE) : "";
    $payment_account = ($this->input->post('order_payment_account', TRUE)) ? $this->input->post('order_payment_account', TRUE) : "";
    $shipping_cost = ($this->input->post('order_shipping_cost', TRUE)) ? $this->input->post('order_shipping_cost', TRUE) : 0;
    $voucher_code = ($this->input->post('order_voucher_code', TRUE)) ? $this->input->post('order_voucher_code', TRUE) : NULL;
    $discount = ($this->input->post('order_discount', TRUE)) ? $this->input->post('order_discount', TRUE) : NULL;
    $referral = ($this->input->post('order_referral', TRUE)) ? $this->input->post('order_referral', TRUE) : NULL;
    //End Parameter
    
    //Check Parameter
    if ($id_member == "") {
      $result = "r2";
      $result_message = "ID Member is empty!";
    }

    if ($street_address == "" || $zip_code == "" || $country == "" || $city == "") {
      $result = "r2";
      $result_message = "Shipping Address belum dipilih!";
    }

    if ($payment_name == "" || $payment_account == "") {
      $result = "r2";
      $result_message = "Metode Pembayaran harus dipilih!";
    }
    
    if ($shipping_cost < 0) {
      $result = "r2";
      $result_message = "Shipping Cost is empty!";
    }

    //Check Cart
    if ($this->model_order->get_cart($id_member)->num_rows() <= 0) {
      $result = "r2";
      $result_message = "Cart is empty!";
    }
    //End Check Parameter
    
    if ($result == "r1") {
      $order = $this->model_order->add_object($id_member, $firstname, $lastname, $street_address, $phone, $zip_code, $country, $city, $payment_name, $payment_account, $shipping_cost, $voucher_code, $discount, $referral);
      
      //Set Session Order
      $session_data = array(
        'order_no' => $order['order_no'],
        'grand_total' => $order['grand_total'],
        'point' => $order['point'],
        'payment_name' => $order['payment_name'],
        'payment_account' => $order['payment_account']
      );
      $this->session->set_userdata($session_data);
      
      redirect('../order/order3.php#summary', 'refresh');
    }else{
      //Set Session Order
      $session_data = array(
        'order_error' => $result_message
      );
      $this->session->set_userdata($session_data);
      
      redirect('../order/order2.php#summary', 'refresh');
    }
  }

  function get_session_order(){
    if($this->session->userdata('order_no')){
      $data['result'] = "r1";
      $data['order_no'] = $this->session->userdata('order_no');
      $data['grand_total'] = $this->session->userdata('grand_total');
      $data['point'] = $this->session->userdata('point');
      $data['payment_name'] = $this->session->userdata('payment_name');
      $data['payment_account'] = $this->session->userdata('payment_account');
    }else if($this->session->userdata('order_error')){
      $data['result'] = "r2";
      $data['order_error'] = $this->session->userdata('order_error');
    }else{
      $data['result'] = "r3";
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  function remove_session_order(){
    $this->session->unset_userdata('referral');
    $this->session->unset_userdata('voucher_code');
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
}
