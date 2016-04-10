<?php
  
class cron extends CI_Controller {
    function __construct() {
      date_default_timezone_set('Asia/Jakarta');
      parent::__construct();
      $this->load->model('dashboard/model_admin', '', TRUE);
      $this->load->library('custom_encrypt');
    }
    
    function check_order(){
      $this->load->model('dashboard/model_order', '', TRUE);
      
      $get_unconfirmed_order = $this->model_order->get_unconfirmed_order();
      if($get_unconfirmed_order->num_rows() > 0){
        foreach ($get_unconfirmed_order->result() as $row) {
          if($row->status == 1){
            $this->model_order->cancel_order($row->id);
          }
        }
      }
    }
    
    function test_cron(){
      $this->load->model('dashboard/model_order', '', TRUE);
      $test = $this->model_order->test_cron();
      
      echo $test;
    }
}