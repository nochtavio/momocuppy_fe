<div id="modal_add" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add Voucher</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_add">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_addvouchername" class="col-sm-4 control-label">Voucher Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addvouchername" placeholder="Input voucher name ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addvouchercode" class="col-sm-4 control-label">Voucher Code</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addvouchercode" name="txt_addvouchercode" placeholder="Input voucher code ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_adddiscount" class="col-sm-4 control-label">Discount (%)</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_adddiscount" name="txt_adddiscount" placeholder="Input discount ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addexpireddate" class="col-sm-4 control-label">Expired Date</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addexpireddate" placeholder="Input expired date ...">
              <p class="help-block" style="font-size: 12px;">Leave it empty if you want this voucher exist forever.</p>
            </div>
          </div>
          <div class="alert alert-warning modal_warning" role="alert"></div>
        </div>
        <div class="modal-footer">
          <button id="btn_add_" type="submit" class="btn btn-warning">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>