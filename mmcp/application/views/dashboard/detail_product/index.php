<input type="hidden" id="pagesize" value="<?php echo empty($pagesize) ? 10 : $pagesize; ?>" />
<input type="hidden" id="id_product" value="<?php echo empty($id_product) ? 0 : $id_product; ?>" />

<div id="div-hidden" style="display: none"></div>

<?php 
  if(!empty($add_product_message)){
    ?>
    <div class="alert alert-success">
      <strong>Well done!</strong> <?php echo $add_product_message; ?>
    </div>
    <?php
  }
?>


<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-6">
    <h4>Product Name: <strong><?php echo empty($product_name) ? "" : $product_name; ?></strong></h4>
  </div>
  <div class="col-lg-6">
    <a href="<?php echo base_url() ?>dashboard/product/" class="btn btn-warning pull-right">Back</a>
  </div>
</div>

<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-12">
    <form class="form-inline form_filter" role="form">
      <div class="form-group">
        <select class="form-control" id="sel_id_color">
          <option value="-1">All Colors</option>
          <?php
          if (!empty($color_total)) {
            if (count($color_total) > 0) {
              for ($x = 0; $x < $color_total; $x++) {
                ?>
                <option value="<?php echo $color_id[$x] ?>"><?php echo $color_name[$x] ?></option>
                <?php
              }
            }
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <select class="form-control" id="sel_order">
          <option value="-1">Sort By Newest Data</option>
          <option value="1">Sort By Oldest Data</option>
          <option value="2">Sort By Lowest Stock</option>
          <option value="3">Sort By Highest Stock</option>
		  <option value="4">Sort By Color Name A-Z</option>
		  <option value="5">Sort By Color Name Z-A</option>
        </select>
      </div>
      <div class="form-group">
        <select class="form-control" id="sel_visible">
          <option value="-1">-</option>
          <option selected="selected" value="1">Visible Only</option>
          <option value="0">Non-Visible Only</option>
        </select>
      </div>
      <button id="btn_search_" type="button" class="btn btn-default">Search</button>
      <div class="form-group">
        <div class="ajaxloading-tr"></div>
      </div>
      <button id="btn_add" type="button" class="btn btn-primary pull-right">Add Product Detail</button>
      <div class="cleardiv"></div>
    </form>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Color</th>
            <th>Stock</th>
            <th>Detail</th>
            <th>Visible</th>
            <th>Action</th>
        </thead>
        <tbody id="tablecontent">

        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <ul id="paging" class="mypagination pagination pull-right">

    </ul>
  </div>
</div>
