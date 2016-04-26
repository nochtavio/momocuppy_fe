<?php

class model_product extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_object($id = 0, $product_name = "", $type = 0, $color = 0, $sale = -1, $visible = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mp.*, (SELECT img FROM dt_product_img dpi WHERE dpi.id_product = mp.id LIMIT 1) as img, (SELECT SUM(stock) FROM dt_product dp WHERE dp.id_product = mp.id) AS stock');
    $this->db->from('ms_product mp');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mp.id', $id);
    }
    if ($product_name !== "") {
      $this->db->like('mp.product_name', $product_name);
    }
    if ($type > 0) {
      $this->db->where('mp.id IN (SELECT DISTINCT dc.id_product AS id FROM dt_category dc JOIN ms_category mc ON dc.id_category = mc.id JOIN ms_type mt ON mt.id = mc.type WHERE mt.id = '.$type.')', NULL, FALSE);
    }
    if ($color > 0) {
      $this->db->where('mp.id IN (SELECT id_product AS id FROM dt_product WHERE id_color = '.$color.')', NULL, FALSE);
    }
    if ($sale > -1) {
      $this->db->where('mp.sale', $sale);
    }
    if ($visible > -1) {
      $this->db->where('mp.visible', $visible);
    }

    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mp.product_name", "desc");
      } else if ($order == 2) {
        $this->db->order_by("stock", "asc");
      } else if ($order == 3) {
        $this->db->order_by("stock", "desc");
      } else if ($order == 4) {
        $this->db->order_by("mp.product_price", "asc");
      } else if ($order == 5) {
        $this->db->order_by("mp.product_price", "desc");
      } else if ($order == 6) {
        $this->db->order_by("mp.cretime", "desc");
      } else if ($order == 7) {
        $this->db->order_by("mp.cretime", "asc");
      }
    } else {
      $this->db->order_by("mp.product_name", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();

    return $query;
  }

  function add_object($product_name, $product_price, $product_desc, $product_weight, $publish_date, $position, $category, $visible, $sale) {
    $data = array(
      'product_name' => $product_name,
      'product_price' => $product_price,
      'product_desc' => $product_desc,
      'product_weight' => $product_weight,
      'publish_date' => $publish_date,
      'sale' => $sale,
      'position' => $position,
      'visible' => $visible,
      'cretime' => date('Y-m-d H:i:s'),
      'creby' => $this->session->userdata('admin')
    );

    $this->db->insert('ms_product', $data);
    $id_product = $this->db->insert_id();
    
    //add new category
    if(!empty($category)){
      if(!is_array($category)){
        $category = explode(",", $category);
      }
      foreach ($category as $cat) {
        $data = array(
          'id_category' => $cat,
          'id_product' => $id_product,
          'cretime' => date('Y-m-d H:i:s'),
          'creby' => $this->session->userdata('admin')
        );
        $this->db->insert('dt_category', $data);
      }
    }
    
    return $id_product;
  }

  function edit_object($id, $product_name, $product_price, $product_desc, $product_weight, $publish_date, $position, $category) {
    $data = array(
      'product_name' => $product_name,
      'product_price' => $product_price,
      'product_desc' => $product_desc,
      'product_weight' => $product_weight,
      'publish_date' => $publish_date,
      'position' => $position,
      'modtime' => date('Y-m-d H:i:s'),
      'modby' => $this->session->userdata('admin')
    );

    $this->db->where('id', $id);
    $this->db->update('ms_product', $data);

    $this->db->where('id_product', $id);
    $this->db->delete('dt_category');

    //add new category
    if(!empty($category)){
      if(!is_array($category)){
        $category = explode(",", $category);
      }
      foreach ($category as $cat) {
        $data = array(
          'id_category' => $cat,
          'id_product' => $id,
          'cretime' => date('Y-m-d H:i:s'),
          'creby' => $this->session->userdata('admin')
        );
        $this->db->insert('dt_category', $data);
      }
    }
  }
  
  function get_sale($id) {
    $this->db->select('mp.sale');
    $this->db->from('ms_product mp');
    $this->db->where('mp.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_sale($id, $sale) {
    $data = array(
      'sale' => $sale
    );

    $this->db->where('id', $id);
    $this->db->update('ms_product', $data);
  }

  function get_visible($id) {
    $this->db->select('mp.visible');
    $this->db->from('ms_product mp');
    $this->db->where('mp.id', $id);

    $query = $this->db->get();
    return $query;
  }

  function set_visible($id, $visible) {
    $data = array(
      'visible' => $visible
    );

    $this->db->where('id', $id);
    $this->db->update('ms_product', $data);
  }

  function remove_object($id) {
    $this->db->where('id', $id);
    $this->db->delete('ms_product');

    $this->db->where('id_product', $id);
    $this->db->delete('dt_product');

    $this->db->where('id_product', $id);
    $this->db->delete('dt_product_img');
  }

  //Function Add Ons
  function clear_category($id) {
    $this->db->where('id_product', $id);
    $this->db->delete('dt_category');
  }

  function get_object_api($id = 0, $product_name = "", $type = 0, $id_category = 0, $visible = -1, $order = 0, $limit = 0, $size = 0) {
    $this->db->select('mp.*, (SELECT img FROM dt_product_img dpi WHERE dpi.id_product = mp.id LIMIT 1) as img');
    $this->db->from('ms_product mp');
    $this->db->join('dt_category dc', 'mp.id = dc.id_product');
    $this->db->join('ms_category mc', 'mc.id = dc.id_category');

    //Set Filter
    if ($id > 0) {
      $this->db->where('mp.id', $id);
    }
    if ($product_name !== "") {
      $this->db->like('mp.product_name', $product_name);
    }
    if ($type > 0) {
      $this->db->where('mc.type', $type);
    }
    if ($id_category > 0) {
      $this->db->where('mc.id', $id_category);
    }

    if ($visible > -1) {
      $this->db->where('mp.visible', $visible);
    }

    //End Set Filter
    //Set Order
    if ($order > 0) {
      if ($order == 1) {
        $this->db->order_by("mp.product_name", "desc");
      } else if ($order == 2) {
        $this->db->order_by("mp.cretime", "desc");
      } else if ($order == 3) {
        $this->db->order_by("mp.cretime", "asc");
      }
    } else {
      $this->db->order_by("mp.product_name", "asc");
    }
    //End Set Order

    if ($size > 0) {
      $this->db->limit($size, $limit);
    }
    $query = $this->db->get();
    return $query;
  }
  
  function get_object_search($keyword){
    $this->db->select('mp.id, mp.product_name, mp.product_price, mc.type, (SELECT img FROM dt_product_img dpi WHERE dpi.id_product = mp.id LIMIT 1) AS img');
    $this->db->from('ms_product mp');
    $this->db->join('dt_category dc', 'mp.id = dc.id_product');
    $this->db->join('ms_category mc', 'mc.id = dc.id_category');
    $this->db->where('mp.visible', 1);
    $this->db->like('mp.product_name', $keyword);
    $this->db->distinct();
    $this->db->limit(4);
    $query = $this->db->get();
    return $query;
  }
  
  function statistic_product($from, $to){
    $query = "
      SELECT mp.product_name, SUM(dor.qty) AS total_order
      FROM dt_order dor
      JOIN ms_order mo ON mo.id = dor.id_order
      JOIN dt_product dp ON dp.id = dor.id_dt_product
      JOIN ms_product mp ON mp.id = dp.id_product
      WHERE mo.cretime BETWEEN '".date('Y-m-d', strtotime($from))."' AND '".date('Y-m-d', strtotime($to))."'
      GROUP BY mp.product_name
      ORDER BY mo.cretime ASC
      LIMIT 0,10
    ";
    return $this->db->query($query);
  }

}

?>
