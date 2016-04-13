<input type="hidden" id="pagesize" value="<?php echo empty($pagesize) ? 10 : $pagesize; ?>" />

<div id="div-hidden" style="display: none"></div>

<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-12">
    <form class="form-inline form_filter" role="form">
      <div class="form-group">
        <label class="sr-only" for="txt_email">Email</label>
        <input type="text" class="form-control" id="txt_email" placeholder="Email">
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_firstname">Firstname</label>
        <input type="text" class="form-control" id="txt_firstname" placeholder="Firstname">
      </div>
      <div class="form-group">
        <label class="sr-only" for="txt_lastname">Lastname</label>
        <input type="text" class="form-control" id="txt_lastname" placeholder="Lastname">
      </div>
      <div class="form-group">
        <select class="form-control" id="sel_city">
          <option value="">All City</option>
          <?php 
            foreach ($fetch_city as $city) {
              ?>
              <option value="<?php echo $city->city_name ?>"><?php echo $city->city_name.' ['.$city->type.']' ?></option>
              <?php
            }
          ?>
        </select>
      </div>
    </form>
  </div>
</div>

<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-12">
    <form class="form-inline form_filter" role="form">
      <div class="form-group">
        <select class="form-control" id="sel_order">
          <option value="-1">Sort By Firstname A-Z</option>
          <option value="1">Sort By Firstname Z-A</option>
          <option value="2">Sort By Email A-Z</option>
          <option value="3">Sort By Email Z-A</option>
          <option value="4">Sort By Lowest Point</option>
          <option value="5">Sort By Highest Point</option>
          <option value="6">Sort By Lowest Total Order</option>
          <option value="7">Sort By Highest Total Order</option>
          <option value="8">Sort By Newest Member</option>
          <option value="9">Sort By Oldest Member</option>
        </select>
      </div>
      <div class="form-group">
        <input type='text' class="form-control" id='txt_cretime_from' placeholder="Registered From" /> - 
      </div>
      <div class="form-group">
        <input type='text' class="form-control" id='txt_cretime_to' placeholder="Registered To" />
      </div>
      <div class="form-group">
        <select class="form-control" id="sel_active">
          <option value="-1">-</option>
          <option value="1">Active Only</option>
          <option value="0">Non-Active Only</option>
        </select>
      </div>
      <button id="btn_search_" type="button" class="btn btn-default">Search</button>
      <button id="btn_export" type="button" class="btn btn-success">Export Excel</button>
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
            <th>Account Information</th>
            <th>Email</th>
            <th>Total Order</th>
            <th>Point</th>
            <th>City</th>
            <th>Detail</th>
            <th>Active</th>
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
