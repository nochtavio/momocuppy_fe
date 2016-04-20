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
          $now = time(); // or your date as well
          $your_date = strtotime($row->cretime);
          $date_diff = floor(($now - $your_date)/(60*60*24));
          if($row->status == 1 && $date_diff >= 30){
            $this->model_order->cancel_order($row->id);
          }
        }
      }
    }
    
    function archive_order(){
      $this->load->model('dashboard/model_order', '', TRUE);
      
      $get_order = $this->model_order->get_object();
      if($get_order->num_rows() > 0){
        foreach ($get_order->result() as $row) {
          $now = time(); // or your date as well
          $your_date = strtotime($row->cretime);
          $date_diff = floor(($now - $your_date)/(60*60*24));
          if(($row->status == 5 || $row->status == 6) && $date_diff >= 30){
            $get_archive = $this->model_order->get_archive($row->id)->result();
            $archive = ($get_archive->row()->archive == "0") ? "0" : "1" ;
            $this->model_order->set_archive($row->id, $archive);
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