<div id="modal_edit" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Voucher</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_edit">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_editvouchername" class="col-sm-4 control-label">Voucher Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editvouchername" placeholder="Input voucher name ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editvouchercode" class="col-sm-4 control-label">Voucher Code</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editvouchercode" placeholder="Input voucher code ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editdiscount" class="col-sm-4 control-label">Discount (%)</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editdiscount" name="txt_editdiscount" placeholder="Input discount ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editexpireddate" class="col-sm-4 control-label">Expired Date</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editexpireddate" placeholder="Input expired date ...">
              <p class="help-block" style="font-size: 12px;">Leave it empty if you want this voucher exist forever.</p>
            </div>
          </div>
          <div class="alert alert-warning modal_warning" role="alert"></div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="txteditid" value="" />
          <button id="btn_edit_" type="submit" class="btn btn-warning">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>