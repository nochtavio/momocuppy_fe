<div id="modal_add" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add Product Redeem</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_add">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_addproductname" class="col-sm-4 control-label">Product Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addproductname" maxlength="22" placeholder="Input product name ...">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" style="padding-top: 0;">Product Image</label>
            <div class="col-sm-6">
              <label class="label-no col-xs-12">
                <input type="file" name="userfile" id="userfile" size="20" style="margin-bottom: 4px;" />
                <em>Only .jpg is allowed | Maximum Size is 600KB | Recommended Resolution is 1227x757 pixels </em> <br/>
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addproductpoint" class="col-sm-4 control-label">Product Point</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addproductpoint" placeholder="Input product point ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addproductdesc" class="col-sm-4 control-label">Product Description</label>
            <div class="col-sm-6">
              <div id="txt_addproductdesc"></div>
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addpublishdate" class="col-sm-4 control-label">Publish Date</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addpublishdate" placeholder="Input publish date ...">
              <p class="help-block" style="font-size: 12px;">Leave it empty if you want to publish this product immediately.</p>
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addstock" class="col-sm-4 control-label">Stock</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addstock" placeholder="Input product stock ...">
            </div>
          </div>
          <div class="form-group">
            <label for="chk_visible" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-6">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="chk_visible" value=""> Visible
                </label>
              </div>
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