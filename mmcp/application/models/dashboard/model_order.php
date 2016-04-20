<?php

class model_order extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $type = 0, $email = "", $street_address = "", $zip_code = "", $country = "", $city = "", $order_no = "", $resi_no = "", $status = 0, $cretime_from = "", $cretime_to = "", $order = 0, $limit = 0, $size = 0) {
    if($type == 1){
      $this->db->select('mo.*, mm.email, mv.voucher_name, mpr.product_name');
    }else{
      $this->db->select('mo.*, mm.email, mv.voucher_name');
    }
    $this->db->from('ms_order mo');
    $this->db->join('ms_member mm', 'mm.id = mo.id_member');
    $this->db->join('ms_voucher mv', 'mv.voucher_code = mo.voucher_code', 'left');
    if($type == 1){
      $this->db->join('dt_order dor', 'dor.id_order = mo.id');
      $this->db->join('ms_product_redeem mpr', 'mpr.id = dor.id_dt_product');
    }

    //Set Filter
    if ($id > 0) {
      $this->db->where('mo.id', $id);
    }
    if ($email !== "") {
      $this->db->like('mm.email', $email);
    }
    if ($street_address != "") {
      $this->db->like('mo.street_address', $street_address);
    }
    if ($zip_code != "") {
      $this->db->like('mo.zip_code', $zip_code);
    }
    if ($country != "") {
      $this->db->like('mo.country', $country);
    }
    if ($city != "") {
      $this->db->like('mo.city', $city);
    }
    if ($order_no !== "") {
      $this->db->like('mo.order_no', $order_no);
    }
    if ($resi_no !== "") {
      $this->db->like('mo.resi_no', $resi_no);
    }
    if ($status > 0) {
      $this->db->like('mo.status', $status);
    }
    if ($cretime_from !== "" && $cretime_to !== ""){
      $this->db->where('mo.cretime >=', $cretime_from);
      $this->db->where('mo.cretime <=', $cretime_to);
    }
    $this->db->where('mo.type', $type);
    $this->db->where('mo.archive', 0);
    //End Set Filter
    
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mo.cretime", "asc");
      } else if ($order == 2) {
        $this->db->order_by("mm.email", "desc");
      } else if ($order == 3) {
        $this->db->order_by("mm.email", "asc");
      }
    } else {
      $this->db->order_by("mo.cretime", "desc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();
    
    return $query;
  }

  function add_object($id_member, $firstname, $lastname, $street_address, $phone, $zip_code, $country, $city, $payment_name, $payment_account, $payment_account_name, $courier, $shipping_cost, $voucher_code = NULL, $discount = NULL, $referral = NULL) {
    $this->db->trans_begin();
    $order_no = $this->generate_order_no();
    $return['result'] = true;
    
    //Check First Time Buyer
    $first_time_buyer = FALSE;
    $filter = array(
      'id_member' => $id_member
    );

    $this->db->select('id_member');
    $check_first_time_buy = $this->db->get_where('ms_order', $filter);
    if ($check_first_time_buy->num_rows() <= 0) {
      $first_time_buyer = TRUE;
    }
    
    //Check Cart
    $member_cart = $this->model_order->get_cart($id_member);
    if($member_cart->num_rows() > 0){
      //Check Stock
      foreach ($member_cart->result() as $row) {
        $check_stock = $this->check_stock($id_member, $row->id_dt_product, $row->qty, TRUE);
        if(!$check_stock){
          $return['result'] = false;
          $return['result_message'] = "One of your item in your cart is out of stock. Therefore, system remove it from your cart.";
          
          $this->db->where('id_member', $id_member);
          $this->db->where('id_dt_product', $row->id_dt_product);
          $this->db->delete('ms_cart');
        }
      }
      
      if($return['result']){
        //Insert Order
        $data = array(
          'id_member' => $id_member,
          'firstname' => $firstname,
          'lastname' => $lastname,
          'street_address' => $street_address,
          'phone' => $phone,
          'zip_code' => $zip_code,
          'country' => $country,
          'city' => $city,
          'payment_name' => $payment_name,
          'payment_account' => $payment_account,
          'payment_account_name' => $payment_account_name,
          'referral' => $referral,
          'courier' => $courier,
          'shipping_cost' => $shipping_cost,
          'order_no' => $order_no,
          'voucher_code' => $voucher_code,
          'discount' => $discount,
          'cretime' => date('Y-m-d H:i:s'),
          'creby' => 'SYSTEM'
        );

        $this->db->insert('ms_order', $data);

        //Insert Detail Order
        $id_order = $this->db->insert_id();
        $sub_total = 0;
        $discount_total = ($discount == NULL) ? 0 : $discount ;
        $grand_total = 0;
        foreach ($member_cart->result() as $row) {
          $data = array(
            'id_order' => $id_order,
            'id_dt_product' => $row->id_dt_product,
            'price' => $row->product_price,
            'qty' => $row->qty,
            'weight' => $row->product_weight
          );
          $this->db->insert('dt_order', $data);
          
          $stock = $this->get_stock($row->id_dt_product)->row()->stock - $row->qty;
          $data = array(
            'stock' => $stock
          );
          $this->db->where('id', $row->id_dt_product);
          $this->db->update('dt_product', $data);

          //Calculate Grand Total
          $sub_total += $row->product_price * $row->qty;
        }
        $grand_total = ceil($sub_total - ($sub_total * $discount_total /100) + $shipping_cost);
        $grand_total_before_disc = $sub_total;
        $this->db->where('id_member', $id_member);
        $this->db->delete('ms_cart');

        //Calculate Point
        $point = floor($grand_total_before_disc / 50000);

        //Calculate Referral
        if (!empty($referral)) {
          //Check Referral Exist
          $filter = array(
            'referral' => $referral
          );

          $this->db->select('id');
          $check_referral = $this->db->get_where('ms_member', $filter);
          if ($check_referral->num_rows() > 0) {
            if ($first_time_buyer) {
              $point = $point+5;
            }
          }
        }

        $return_order = array(
          'order_no' => $order_no,
          'order_detail' => $member_cart->result(),
          'grand_total' => $grand_total,
          'point' => ($point > 0) ? $point : 0,
          'payment_name' => $payment_name,
          'payment_account' => $payment_account,
          'payment_account_name' => $payment_account_name
        );
        
        if ($this->db->trans_status() === FALSE){
          $this->db->trans_rollback();
          $return['result'] = false;
          $return['result_message'] = "Cart is empty";
        }else{
          $this->db->trans_commit();
          $return['return_order'] = $return_order;
        }
      }
    }else{
      $return['result'] = false;
      $return['result_message'] = "Cart is empty";
    }
    
    return $return;
  }

  function edit_object($id, $status, $resi_no) {
    //Check Status
    $filter = array(
      'id' => $id
    );
    $this->db->select('id_member, status, referral');
    $check_status = $this->db->get_where('ms_order', $filter);
    $id_member = $check_status->row()->id_member;
    $referral = $check_status->row()->referral;
    $point_added = ($check_status->row()->status < 3) ? FALSE : TRUE ;
    $stock_substracted = ($check_status->row()->status < 6) ? TRUE : FALSE ;
    //End Check Status
    
    //Check First Time Buyer
    $first_time_buyer = FALSE;
    $this->db->select('mo.id_member');
    $this->db->from('ms_order mo');
    $this->db->where('mo.id_member', $id_member);
    $this->db->where('mo.status >', 2);

    $check_first_time_buy = $this->db->get();
    if ($check_first_time_buy->num_rows() <= 0) {
      $first_time_buyer = TRUE;
    }
    
    if($point_added && $status < 3){
      //Revert Point
      $detail_order = $this->model_order->get_detail_order($id);
      if($detail_order->num_rows() > 0){
        //Calculate Grand Total
        $grand_total = 0;
        foreach ($detail_order->result() as $row) {
          $grand_total += $row->price * $row->qty;
        }
        
        //Calculate Point
        $point = floor($grand_total / 50000);
        if ($point > 0) {
          $this->calculate_point($id_member, $point, TRUE);
        }
      }
      
      if (!empty($referral)) {
        //Check Referral Exist
        $filter = array(
          'referral' => $referral
        );
        
        $this->db->select('id');
        $check_referral = $this->db->get_where('ms_member', $filter);
        if ($check_referral->num_rows() > 0) {
          $parent_id_member = $check_referral->row()->id;
          
          if ($first_time_buyer) {
            $this->calculate_point($id_member, 5, TRUE);
            $this->calculate_point($parent_id_member, 5, TRUE);
          }
        }
      }
      //End Revert Point
    }else if(!$point_added && $status > 2){
      //Add Point
      $detail_order = $this->model_order->get_detail_order($id);
      if($detail_order->num_rows() > 0){
        //Calculate Grand Total
        $grand_total = 0;
        foreach ($detail_order->result() as $row) {
          $grand_total += $row->price * $row->qty;
        }
        
        //Calculate Point
        $point = floor($grand_total / 50000);
        if ($point > 0) {
          $this->calculate_point($id_member, $point);
        }
      }
      
      if (!empty($referral)) {
        //Check Referral Exist
        $filter = array(
          'referral' => $referral
        );
        
        $this->db->select('id');
        $check_referral = $this->db->get_where('ms_member', $filter);
        if ($check_referral->num_rows() > 0) {
          $parent_id_member = $check_referral->row()->id;
          
          if ($first_time_buyer) {
            $this->calculate_point($id_member, 5);
            $this->calculate_point($parent_id_member, 5);
          }
        }
      }
      //End Add Point
    }
    
    if($stock_substracted && $status == 6){
      //Return Stock
      $filter = array(
        'id_order' => $id
      );
      $this->db->select('id_dt_product, qty');
      $check_order = $this->db->get_where('dt_order', $filter);
      foreach ($check_order->result() as $row) {
        $stock = $this->get_stock($row->id_dt_product)->row()->stock + $row->qty;
        $data = array(
          'stock' => $stock
        );
        $this->db->where('id', $row->id_dt_product);
        $this->db->update('dt_product', $data);
      }
    }else if(!$stock_substracted && $status < 6){
      //Substract Stock
      $filter = array(
        'id_order' => $id
      );
      $this->db->select('id_dt_product, qty');
      $check_order = $this->db->get_where('dt_order', $filter);
      foreach ($check_order->result() as $row) {
        $stock = $this->get_stock($row->id_dt_product)->row()->stock - $row->qty;
        $data = array(
          'stock' => $stock
        );
        $this->db->where('id', $row->id_dt_product);
        $this->db->update('dt_product', $data);
      }
    }
    
    $data = array(
      'status' => $status,
      'resi_no' => $resi_no,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('ms_order', $data);
  }

  function get_archive($id) {
    $this->db->select('mo.archive');
    $this->db->from('ms_order mo');
    $this->db->where('mo.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_archive($id, $archive) {
    $data = array(
      'archive' => $archive
    );

    $this->db->where('id', $id);
    $this->db->update('ms_order', $data);
  }

  //Addon Function
  function validate_order_post($firstname, $lastname, $street_address, $phone, $zip_code, $country, $city, $payment_name, $payment_account, $payment_account_name, $voucher_code = NULL, $discount = NULL, $referral = NULL){
    $valid = TRUE;
    //Validate Address
    $this->db->select('da.*, mc.city_name');
    $this->db->from('dt_address da');
    $this->db->join('ms_city mc', 'mc.city_id = da.city');
    $this->db->where('da.firstname', $firstname);
    $this->db->where('da.lastname', $lastname);
    $this->db->where('da.street_address', $street_address);
    $this->db->where('da.phone', $phone);
    $this->db->where('da.zip_code', $zip_code);
    $this->db->where('da.country', $country);
    $this->db->where('mc.city_name', $city);
    $query_address = $this->db->get();
    if($query_address->num_rows() <= 0){
      $valid = FALSE;
    }else{
      //Validate Payment
      $this->db->select('mp.*');
      $this->db->from('ms_payment mp');
      $this->db->where('mp.payment_name', $payment_name);
      $this->db->where('mp.rek_no', $payment_account);
      $this->db->where('mp.rek_name', $payment_account_name);
      $query_payment = $this->db->get();
      if($query_payment->num_rows() <= 0){
        $valid = FALSE;
      }else{
        //Validate Voucher
        if($voucher_code !== NULL){
          $this->db->select('mv.*');
          $this->db->from('ms_voucher mv');
          $this->db->where('mv.voucher_code', $voucher_code);
          $this->db->where('mv.discount', $discount);
          $query_discount = $this->db->get();
          if($query_discount->num_rows() <= 0){
            $valid = FALSE;
          }
        }
        //Validate Referral
        if($referral !== NULL){
          $this->db->select('mm.*');
          $this->db->from('ms_member mm');
          $this->db->where('mm.referral', $referral);
          $query_referral = $this->db->get();
          if($query_referral->num_rows() <= 0){
            $valid = FALSE;
          }
        }
      }
    }
    
    return $valid;
  }
  
  function add_redeem($id_member, $id_redeem, $firstname, $lastname, $street_address, $phone, $zip_code, $country, $city) {
    $this->db->trans_begin();
    $order_no = $this->generate_order_no();
    $return['result'] = true;
    
    //Insert Order
    $data_header = array(
      'type' => 1,
      'id_member' => $id_member,
      'firstname' => $firstname,
      'lastname' => $lastname,
      'street_address' => $street_address,
      'phone' => $phone,
      'zip_code' => $zip_code,
      'country' => $country,
      'city' => $city,
      'courier' => 'REG',
      'shipping_cost' => 0,
      'order_no' => $order_no,
      'status' => 2,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => 'SYSTEM'
    );

    $this->db->insert('ms_order', $data_header);

    //Insert Detail Order
    $id_order = $this->db->insert_id();
    $data_detail = array(
      'id_order' => $id_order,
      'id_dt_product' => $id_redeem,
      'price' => 0,
      'qty' => 1,
      'weight' => 1
    );
    $this->db->insert('dt_order', $data_detail);
    
    //Get Product Point and Stock
    $this->db->select('mpr.product_point, mpr.stock');
    $this->db->from('ms_product_redeem mpr');
    $this->db->where('mpr.id', $id_redeem);
    $get_pointstock = $this->db->get();
    
    $point = $get_pointstock->row()->product_point;
    $stock = $get_pointstock->row()->stock;
    //End Get Product Point and Stock
    
    //Calculate Point
    $filter_point = array(
      'id_member' => $id_member
    );
    $this->db->select('point');
    $check_point = $this->db->get_where('ms_point', $filter_point);
    
    $updated_point = $check_point->row()->point - $point;
    $data_point = array(
      'point' => $updated_point,
      'cretime' => date('Y-m-d')
    );

    $this->db->where('id_member', $id_member);
    $this->db->update('ms_point', $data_point);
    //End Calculate Point
    
    //Update Stock
    $updated_stock = $stock - 1;
    $data_stock = array(
      'stock' => $updated_stock
    );

    $this->db->where('mpr.id', $id_redeem);
    $this->db->update('ms_product_redeem mpr', $data_stock);
    //End Update Stock
    
    $return_order = array(
      'order_no' => $order_no
    );

    if ($this->db->trans_status() === FALSE){
      $this->db->trans_rollback();
      $return['result'] = false;
      $return['result_message'] = "Cart is empty";
    }else{
      $this->db->trans_commit();
      $return['return_order'] = $return_order;
    }
    
    return $return;
  }
  
  function validate_redeem_post($firstname, $lastname, $street_address, $phone, $zip_code, $country, $city){
    $valid = TRUE;
    //Validate Address
    $this->db->select('da.*, mc.city_name');
    $this->db->from('dt_address da');
    $this->db->join('ms_city mc', 'mc.city_id = da.city');
    $this->db->where('da.firstname', $firstname);
    $this->db->where('da.lastname', $lastname);
    $this->db->where('da.street_address', $street_address);
    $this->db->where('da.phone', $phone);
    $this->db->where('da.zip_code', $zip_code);
    $this->db->where('da.country', $country);
    $this->db->where('mc.city_name', $city);
    $query_address = $this->db->get();
    if($query_address->num_rows() <= 0){
      $valid = FALSE;
    }
    
    return $valid;
  }
  
  function edit_redeem($id, $status, $resi_no) {
    //Get Point
    $this->db->select('mo.status, mo.id_member, mpr.product_point');
    $this->db->from('ms_order mo');
    $this->db->join('dt_order dor', 'dor.id_order = mo.id');
    $this->db->join('ms_product_redeem mpr', 'mpr.id = dor.id_dt_product');
    $this->db->where('mo.id', $id);
    $get_point = $this->db->get();
    
    $id_member = $get_point->row()->id_member;
    $point = $get_point->row()->product_point;
    $point_substracted = ($get_point->row()->status != 6) ? TRUE : FALSE ;
    //End Get Point
    
    if($status == 6){
      //Revert Point
      $this->db->where('id_order', $id);
      $this->db->delete('ms_point');
      //End Revert Point
    }else if(!$point_substracted && $status != 6){
      //Substract Point
      $this->calculate_point($id_member, $id, $point*-1);
      //End Substract Point
    }
    
    $data = array(
      'status' => $status,
      'resi_no' => $resi_no,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('ms_order', $data);
  }
  
  function get_detail_order($order_id = 0, $limit = 0, $size = 0) {
    //Check Order Type
    $this->db->select('mo.type');
    $this->db->from('ms_order mo');
    $this->db->where('mo.id', $order_id);
    $query_order_type = $this->db->get();
    //End Check Order Type
    
    if($query_order_type->row()->type == 0){
      //Get Detail Order
      $this->db->select('mo.order_no, mp.product_name, mc.color_name, dor.price, dor.qty, mo.discount, mo.shipping_cost');
      $this->db->from('dt_order dor');
      $this->db->join('ms_order mo', 'dor.id_order = mo.id');
      $this->db->join('dt_product dp', 'dor.id_dt_product = dp.id');
      $this->db->join('ms_product mp', 'dp.id_product = mp.id');
      $this->db->join('ms_color mc', 'dp.id_color = mc.id');

      //Set Filter
      if ($order_id > 0) {
        $this->db->where('mo.id', $order_id);
      }
      //End Set Filter

      if ($size > 0) {
        $this->db->limit($size, $limit);
      }
      $query = $this->db->get();
    }else{
      //Get Detail Redeem
      $this->db->select('mo.order_no, mpr.*');
      $this->db->from('dt_order dor');
      $this->db->join('ms_order mo', 'dor.id_order = mo.id');
      $this->db->join('ms_product_redeem mpr', 'dor.id_dt_product = mpr.id');

      //Set Filter
      if ($order_id > 0) {
        $this->db->where('mo.id', $order_id);
      }
      //End Set Filter

      if ($size > 0) {
        $this->db->limit($size, $limit);
      }
      $query = $this->db->get();
    }
    
    return $query;
  }

  function check_order_no($order_no) {
    $filter = array(
      'order_no' => $order_no
    );

    $this->db->select('order_no');
    $query = $this->db->get_where('ms_order', $filter);
    return $query;
  }

  function generate_order_no() {
    $year = date('y');
    $month = date('m');
    
    $this->db->where('cretime >=', date("Y-m-d 00:00:00"));
    $this->db->where('cretime <=', date("Y-m-d 23:59:59"));
    $this->db->from('ms_order');
    $total_order = $this->db->count_all_results();
    if($total_order < 10){
      $total_order = '000'.$total_order;
    }else if($total_order < 100){
      $total_order = '00'.$total_order;
    }else if($total_order < 1000){
      $total_order = '0'.$total_order;
    }
    
    $order_no = $year.$month.$total_order;

    return $order_no;
  }

  function get_cart($id_member) {
    $this->db->select('mcart.*, mp.product_price, mp.product_weight, mc.color_name, mp.product_name, (SELECT img FROM dt_product_img dpi WHERE dpi.id_product = mp.id LIMIT 1) as img');
    $this->db->from('ms_cart mcart');
    $this->db->join('dt_product dp', 'dp.id = mcart.id_dt_product');
    $this->db->join('ms_product mp', 'mp.id = dp.id_product');
    $this->db->join('ms_color mc', 'mc.id = dp.id_color');
    $this->db->where('mcart.id_member', $id_member);
    $query = $this->db->get();
    return $query;
  }
  
  function get_stock($id_dt_product){
    $this->db->select('dp.stock');
    $this->db->from('dt_product dp');
    $this->db->where('dp.id', $id_dt_product);
    $query = $this->db->get();
    return $query;
  }
  
  function check_stock($id_member, $id_dt_product, $qty, $order = FALSE){
    if(!$order){
      //Get Qty
      $filter_cart = array(
        'id_member' => $id_member,
        'id_dt_product' => $id_dt_product
      );

      $this->db->select('qty');
      $check_cart = $this->db->get_where('ms_cart', $filter_cart);

      if ($check_cart->num_rows() > 0) {
        $qty = $qty + $check_cart->row()->qty;
      }
    }
    
    //Get Stock
    $filter_stock = array(
      'id' => $id_dt_product,
      'visible' => 1
    );
    
    $this->db->select('stock');
    $check_stock = $this->db->get_where('dt_product', $filter_stock);
    
    if($check_stock){
      $stock = $check_stock->row()->stock;
      if($qty > $stock){
        return false;
      }else{
        return true;
      }
    }else{
      return false;
    }
  }

  function set_cart($id_member, $id_dt_product, $qty) {
    $filter = array(
      'id_member' => $id_member,
      'id_dt_product' => $id_dt_product
    );

    $this->db->select('qty');
    $check_product = $this->db->get_where('ms_cart', $filter);

    if ($check_product->num_rows() > 0) {
      //Product is exist on cart
      $data = array(
        'qty' => $check_product->row()->qty + $qty
      );

      $this->db->where('id_member', $id_member);
      $this->db->where('id_dt_product', $id_dt_product);
      $this->db->update('ms_cart', $data);
    } else {
      //New Product on cart
      $data = array(
        'id_member' => $id_member,
        'id_dt_product' => $id_dt_product,
        'qty' => $qty
      );

      $this->db->insert('ms_cart', $data);
    }
  }

  function remove_cart($id_member, $id) {
    $filter = array(
      'id_member' => $id_member,
      'id' => $id
    );

    $this->db->select('id');
    $check_cart = $this->db->get_where('ms_cart', $filter);
    if ($check_cart->num_rows() > 0) {
      $this->db->where('id', $id);
      $this->db->delete('ms_cart');
      return TRUE;
    }else{
      return FALSE;
    }
  }

  function calculate_point($id_member, $point, $revert=FALSE) {
    $filter = array(
      'id_member' => $id_member
    );

    $this->db->select('point');
    $check_point = $this->db->get_where('ms_point', $filter);

    if ($check_point->num_rows() > 0) {
      //Update Point
      $updated_point = ($revert) ? $check_point->row()->point - $point : $check_point->row()->point + $point;
      $data = array(
        'point' => $updated_point,
        'cretime' => date('Y-m-d')
      );

      $this->db->where('id_member', $id_member);
      $this->db->update('ms_point', $data);
    } else {
      //Add Point
      $data = array(
        'id_member' => $id_member,
        'point' => $point,
        'cretime' => date('Y-m-d')
      );

      $this->db->insert('ms_point', $data);
    }
  }
  
  function get_unconfirmed_order(){
    $filter = array(
      'paid_date' => NULL
    );

    $this->db->select('id, status, cretime');
    $query = $this->db->get_where('ms_order', $filter);
    return $query;
  }
  
  function cancel_order($id_order){
    $filter = array(
      'id' => $id_order
    );
    $this->db->select('id_member, status, referral');
    $check_status = $this->db->get_where('ms_order', $filter);
    $id_member = $check_status->row()->id_member;
    $referral = $check_status->row()->referral;
    
    //Check First Time Buyer
    $first_time_buyer = FALSE;
    $this->db->select('mo.id_member');
    $this->db->from('ms_order mo');
    $this->db->where('mo.id_member', $id_member);
    $this->db->where('mo.status >', 2);

    $check_first_time_buy = $this->db->get();
    if ($check_first_time_buy->num_rows() <= 0) {
      $first_time_buyer = TRUE;
    }
    
    //Revert Point
    $detail_order = $this->model_order->get_detail_order($id_order);
    if($detail_order->num_rows() > 0){
      //Calculate Grand Total
      $grand_total = 0;
      foreach ($detail_order->result() as $row) {
        $grand_total += $row->price * $row->qty;
      }

      //Calculate Point
      $point = floor($grand_total / 50000);
      if ($point > 0) {
        $this->calculate_point($id_member, $point, TRUE);
      }
    }

    if (!empty($referral)) {
      //Check Referral Exist
      $filter = array(
        'referral' => $referral
      );

      $this->db->select('id');
      $check_referral = $this->db->get_where('ms_member', $filter);
      if ($check_referral->num_rows() > 0) {
        $parent_id_member = $check_referral->row()->id;

        if ($first_time_buyer) {
          $this->calculate_point($id_member, 5, TRUE);
          $this->calculate_point($parent_id_member, 5, TRUE);
        }
      }
    }
    //End Revert Point
    
    //Return Stock
    $filter = array(
      'id_order' => $id_order
    );
    $this->db->select('id_dt_product, qty');
    $check_order = $this->db->get_where('dt_order', $filter);
    foreach ($check_order->result() as $row) {
      $stock = $this->get_stock($row->id_dt_product)->row()->stock + $row->qty;
      $data = array(
        'stock' => $stock
      );
      $this->db->where('id', $row->id_dt_product);
      $this->db->update('dt_product', $data);
    }
    
    $data = array(
      'status' => 6,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => 'CRON'
    );

    $this->db->where('id', $id_order);
    $this->db->update('ms_order', $data);
  }
  
  function statistic_order($from, $to){
    $query = "
      SELECT DATE_FORMAT(mc.crt_date,'%d %b %y') AS order_date, COUNT(data_order.id) AS total_order
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
  
  function test_cron(){
    $data = array(
      'cretime' => date('Y-m-d H:i:s')
    );

    $this->db->insert('test_cron', $data);
    
    return $this->db->last_query();
  }
  //End Addon Function
}

?>
