<div id="modal_add" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add Payment</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_add">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_addpaymentname" class="col-sm-4 control-label">Payment Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addpaymentname" placeholder="Input payment name ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addrekno" class="col-sm-4 control-label">Rek No</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addrekno" name="txt_addrekno" placeholder="Input rek no ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addrekname" class="col-sm-4 control-label">Rek Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addrekname" name="txt_addrekname" placeholder="Input rek name ...">
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