<div id="modal_edit" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Update Order</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_edit">
        <div class="modal-body">
          <div class="form-group">
            <label for="sel_editstatus" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-6">
              <select class="form-control" id="sel_editstatus">
                <option value="1">Waiting for Payment</option>
                <option value="2">Member Confirmed</option>
                <option value="3">Approved</option>
                <option value="4">On Delivery</option>
                <option value="5">Delivered</option>
                <option value="6">Canceled</option>
              </select>            
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editresino" class="col-sm-4 control-label">Resi No</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editresino" placeholder="Input no resi ...">
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