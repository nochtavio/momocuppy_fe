<input type="hidden" id="pagesize" value="<?php echo empty($pagesize) ? 10 : $pagesize; ?>" />

<div id="div-hidden" style="display: none"></div>

<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-12">
    <form class="form-inline form_filter" role="form">
      <div class="form-group">
        <select class="form-control" id="sel_type">
          <option value="0">Order</option>
          <option value="1">Order Redeem</option>
        </select>
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_email">Email</label>
        <input type="text" class="form-control" id="txt_email" placeholder="Email">
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_street_address">Street Address</label>
        <input type="text" class="form-control" id="txt_street_address" placeholder="Street Address">
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_zip_code">Zip Code</label>
        <input type="text" class="form-control" id="txt_zip_code" placeholder="Zip Code">
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_country">Country</label>
        <input type="text" class="form-control" id="txt_country" placeholder="Country">
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_city">City</label>
        <input type="text" class="form-control" id="txt_city" placeholder="City">
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_order_no">Order No</label>
        <input type="text" class="form-control" id="txt_order_no" placeholder="Order No">
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_resi_no">Resi No</label>
        <input type="text" class="form-control" id="txt_resi_no" placeholder="Resi No">
      </div>
    </form>
  </div>
</div>

<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-12">
    <form class="form-inline form_filter" role="form">
      <div class="form-group">
        <select class="form-control" id="sel_status">
          <option value="-1">All Status</option>
          <option value="1">Waiting for Payment</option>
          <option value="2">Member Confirmed</option>
          <option value="3">Approved</option>
          <option value="4">On Delivery</option>
          <option value="5">Delivered</option>
          <option value="6">Canceled</option>
        </select>
      </div>
      <div class="form-group">
        <input type='text' class="form-control" id='txt_cretime_from' placeholder="Ordered From" /> - 
      </div>
      <div class="form-group">
        <input type='text' class="form-control" id='txt_cretime_to' placeholder="Ordered To" />
      </div>
      <div class="form-group">
        <select class="form-control" id="sel_order">
          <option value="-1">Sort By Newest Order</option>
          <option value="1">Sort By Oldest Order</option>
          <option value="2">Sort By Order Email A-Z</option>
          <option value="3">Sort By Order Email Z-A</option>
        </select>
      </div>
      <button id="btn_search_" type="button" class="btn btn-default">Search</button>
      <button id="btn_export" type="button" class="btn btn-success">Export Excel</button>
      <a href="<?php echo base_url() . "dashboard/order/" ?>" type="button" class="btn btn-info">Back</a>
      <div class="form-group">
        <div class="ajaxloading-tr"></div>
      </div>
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
            <th>Email</th>
            <th>Order Detail</th>
            <th>Status</th>
            <th>Detail</th>
            <th>Action</th>
          </tr>
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
