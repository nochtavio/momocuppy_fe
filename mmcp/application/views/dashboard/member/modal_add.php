<div id="modal_add" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add Product Type</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_add">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_addcolorname" class="col-sm-4 control-label">Color Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addcolorname" placeholder="Input color name ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addcolorcode" class="col-sm-4 control-label">Color Code</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addcolorcode" name="txt_addcolorcode" placeholder="Input color code ...">
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