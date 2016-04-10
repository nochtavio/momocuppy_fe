<div id="modal_edit" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Payment</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_edit">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_editpaymentname" class="col-sm-4 control-label">Payment Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editpaymentname" placeholder="Input payment name ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editrekno" class="col-sm-4 control-label">Rek No</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editrekno" name="txt_editrekno" placeholder="Input rek no ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editrekname" class="col-sm-4 control-label">Rek Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editrekname" name="txt_editrekname" placeholder="Input rek name ...">
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