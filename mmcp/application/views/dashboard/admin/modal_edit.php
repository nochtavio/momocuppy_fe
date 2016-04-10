<div id="modal_edit" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Admin</h4>
      </div>
      <form class="form-horizontal" role="form" id="edit_file">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_editadminusername" class="col-sm-4 control-label">Username</label>
            <div class="col-sm-6">
              <input type="text" readonly="readonly" class="form-control" id="txt_editadminusername" placeholder="Input admin username here ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editadminpassword" class="col-sm-4 control-label">Password</label>
            <div class="col-sm-6">
              <input type="password" class="form-control" id="txt_editadminpassword" placeholder="Input admin password here ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editconfpassword" class="col-sm-4 control-label">Confirm Password</label>
            <div class="col-sm-6">
              <input type="password" class="form-control" id="txt_editconfpassword" placeholder="Repeat your password here ...">
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