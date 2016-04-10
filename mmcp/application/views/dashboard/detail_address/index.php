<input type="hidden" id="pagesize" value="<?php echo empty($pagesize) ? 10 : $pagesize; ?>" />
<input type="hidden" id="id_member" value="<?php echo empty($id_member) ? 0 : $id_member; ?>" />

<div id="div-hidden" style="display: none"></div>

<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-6">
    <h4>Email: <strong><?php echo empty($email) ? "" : $email; ?></strong></h4>
  </div>
  <div class="col-lg-6">
    <a href="<?php echo base_url() ?>dashboard/member/" class="btn btn-warning pull-right">Back</a>
  </div>
</div>

<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-12">
    <form class="form-inline form_filter" role="form">
      <div class="form-group">
        <label class="sr-only" for="txt_street_address">Street Address</label>
        <input type="text" class="form-control" id="txt_street_address" placeholder="Street Address">
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_zip_code">Zip Code</label>
        <input type="text" class="form-control" id="txt_street_address" placeholder="Zip Code">
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_country">Country</label>
        <input type="text" class="form-control" id="txt_street_address" placeholder="Country">
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_city">City</label>
        <input type="text" class="form-control" id="txt_street_address" placeholder="City">
      </div>
      <div class="form-group">
        <select class="form-control" id="sel_order">
          <option value="-1">Sort By Newest Data</option>
          <option value="1">Sort By Oldest Data</option>
          <option value="2">Sort By Lowest Stock</option>
          <option value="3">Sort By Highest Stock</option>
        </select>
      </div>
      <button id="btn_search_" type="button" class="btn btn-default">Search</button>
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
            <th>Address</th>
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
