<div id="modal_add" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add Type</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_add">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_addtypename" class="col-sm-4 control-label">Type Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addtypename" placeholder="Input type name ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addposition" class="col-sm-4 control-label">Position</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addposition" placeholder="Input type position ...">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" style="padding-top: 0;">Image</label>
            <div class="col-sm-6">
              <label class="label-no col-xs-12" style="margin: 0 0 0 -15px;">
                <input type="file" name="userfile" id="userfile" size="20" style="margin-bottom: 4px;" />
                <em>Only .png is allowed | Maximum Size is 1 MB | Recommended Resolution is 310x186 pixels</em> <br/>
              </label>
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