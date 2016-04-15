<input type="hidden" id="pagesize" value="<?php echo empty($pagesize) ? 10 : $pagesize; ?>" />

<div id="div-hidden" style="display: none"></div>
<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-12">
    <form class="form-inline form_filter" role="form">
      <div class="form-group">
        <input type='text' class="form-control" id='txt_date_from' value="<?php echo date('Y-m-01'); ?>" placeholder="Date From" /> - 
      </div>
      <div class="form-group">
        <input type='text' class="form-control" id='txt_date_to' value="<?php echo date('Y-m-d'); ?>" placeholder="Date To" />
      </div>
      <div class="cleardiv"></div>
    </form>
  </div>
</div>

<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-12">
    <form class="form-inline form_filter" role="form">
      <div class="form-group">
        <label class="sr-only" for="txt_customer_email">Customer Email</label>
        <input type="text" class="form-control" id="txt_customer_email" placeholder="Customer Email">
      </div>
      <button id="btn_apply" type="button" class="btn btn-default">Apply</button>
      <div class="form-group">
        <div class="ajaxloading-tr"></div>
      </div>
      <div class="cleardiv"></div>
    </form>
  </div>
</div>


<div class="row">
  <div class="col-lg-12">
    <div id="curve_chart" style="width: 100%; height: 500px"></div>
    <span id="span_error" style="color: red"></span>
  </div>
</div>
