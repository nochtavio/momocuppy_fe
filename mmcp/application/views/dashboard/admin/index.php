<input type="hidden" id="pagesize" value="<?php echo empty($pagesize) ? 10 : $pagesize; ?>" />

<div id="div-hidden" style="display: none"></div>
<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-12">
    <form class="form-inline form_filter" role="form">
      <div class="form-group">
        <label class="sr-only" for="txt_username">Username</label>
        <input type="text" class="form-control" id="txt_username" placeholder="Username">
      </div>
      <div class="form-group">
        <select class="form-control" id="sel_order">
          <option value="-1">Sort By Username A-Z</option>
          <option value="1">Sort By Username Z-A</option>
        </select>
      </div>
      <div class="form-group">
        <select class="form-control" id="sel_active">
          <option value="-1">-</option>
          <option selected="selected" value="1">Active Only</option>
          <option value="0">Non-Active Only</option>
        </select>
      </div>
      <button id="btn_search_" type="button" class="btn btn-default">Search</button>
      <div class="form-group">
        <div class="ajaxloading-tr"></div>
      </div>
      <button id="btn_add" type="button" class="btn btn-primary pull-right">Add Admin</button>
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
            <th>Username</th>
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
