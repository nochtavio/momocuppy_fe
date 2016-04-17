<?php

class model_statistic extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->library('custom_encrypt');
  }
  
  function statistic_member($from, $to){
    $query = "
      SELECT DATE_FORMAT(mc.crt_date,'%d %b %y') AS registered_date, COUNT(mm.id) AS total_member
      FROM ms_calendar mc
      LEFT JOIN ms_member mm ON DATE_FORMAT(mc.crt_date,'%d %b %y') = DATE_FORMAT(mm.cretime,'%d %b %y')
      WHERE mc.crt_date BETWEEN '".date('Y-m-d', strtotime($from))."' AND '".date('Y-m-d', strtotime($to))."'
      GROUP BY registered_date
      ORDER BY mc.crt_date ASC
    ";
    return $this->db->query($query);
  }
  
  function statistic_product($from, $to, $product_name){
    $query = "
      SELECT mp.product_name, SUM(dor.qty) AS total_order
      FROM dt_order dor
      JOIN ms_order mo ON mo.id = dor.id_order
      JOIN dt_product dp ON dp.id = dor.id_dt_product
      JOIN ms_product mp ON mp.id = dp.id_product
      WHERE (mo.cretime BETWEEN '".date('Y-m-d', strtotime($from))."' AND '".date('Y-m-d', strtotime($to))."')
      AND mp.product_name LIKE '%".$product_name."%'
      GROUP BY mp.product_name
      ORDER BY mo.cretime ASC
      LIMIT 0,10
    ";
    return $this->db->query($query);
  }
  
  function statistic_order($from, $to, $email){
    $query = "
      SELECT DATE_FORMAT(mc.crt_date,'%d %b %y') AS order_date, COUNT(data_order.id) AS total_order
      FROM ms_calendar mc
      LEFT JOIN 
        (
          SELECT mo.* 
          FROM ms_order mo 
          JOIN ms_member mm ON mm.id = mo.id_member
          WHERE mm.email LIKE '%".$email."%' 
          AND mo.status > 2 AND mo.status < 6
        ) AS data_order
        ON DATE_FORMAT(mc.crt_date,'%d %b %y') = DATE_FORMAT(data_order.cretime,'%d %b %y')
      WHERE (mc.crt_date BETWEEN '".date('Y-m-d', strtotime($from))."' AND '".date('Y-m-d', strtotime($to))."')
      GROUP BY order_date
      ORDER BY mc.crt_date ASC
    ";
    return $this->db->query($query);
  }
  
  function statistic_category($from, $to){
    $query = "
      SELECT mc.category_name, SUM(dor.qty) AS total_order
      FROM ms_order mo 
      JOIN dt_order dor ON mo.id = dor.id_order
      JOIN dt_product dp ON dp.id = dor.id_dt_product
      JOIN ms_product mp ON mp.id = dp.id_product
      JOIN dt_category dc ON dc.id_product = dp.id_product
      JOIN ms_category mc ON mc.id = dc.id_category
      WHERE mo.cretime BETWEEN '".date('Y-m-d', strtotime($from))."' AND '".date('Y-m-d', strtotime($to))."'
      AND mo.status > 2 
      AND mo.status < 6
      GROUP BY mc.category_name
    ";
    return $this->db->query($query);
  }
  
  function statistic_shipping_cost($from, $to){
    $query = "
      SELECT DATE_FORMAT(mc.crt_date,'%d %b %y') AS order_date, IFNULL(SUM(data_order.shipping_cost),0) AS total_cost
      FROM ms_calendar mc
      LEFT JOIN 
        (
        SELECT * FROM ms_order mo WHERE mo.status > 2 AND mo.status< 6
        ) AS data_order
        ON DATE_FORMAT(mc.crt_date,'%d %b %y') = DATE_FORMAT(data_order.cretime,'%d %b %y')
      WHERE (mc.crt_date BETWEEN '".date('Y-m-d', strtotime($from))."' AND '".date('Y-m-d', strtotime($to))."')
      GROUP BY order_date
      ORDER BY mc.crt_date ASC
    ";
    return $this->db->query($query);
  }

  //End Addon Function
}

?>
