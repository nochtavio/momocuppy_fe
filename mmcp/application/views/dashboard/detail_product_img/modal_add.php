<div id="modal_add" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add Product Image</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_add">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label" style="padding-top: 0;">Image</label>
            <div class="col-sm-9 col-xs-8">
              <label class="label-no col-xs-12">
                <input type="file" name="userfile" id="userfile" size="20" style="margin-bottom: 4px;" />
                <em>Only .jpg is allowed (1227x757 pixels)</em> <br/>
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