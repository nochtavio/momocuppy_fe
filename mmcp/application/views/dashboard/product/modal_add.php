<div id="modal_add" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add Product</h4>
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
            <label for="txt_addproductprice" class="col-sm-4 control-label">Product Price</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addproductprice" placeholder="Input product price ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addproductdesc" class="col-sm-4 control-label">Product Description</label>
            <div class="col-sm-6">
              <div id="txt_addproductdesc"></div>
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addproductweight" class="col-sm-4 control-label">Product Weight (kg)</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addproductweight" placeholder="Input product weight ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addpublishdate" class="col-sm-4 control-label">Publish Date</label>
            <div class="col-sm-6">
              <div class='input-group date' id='txt_addpublishdate'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
              <p class="help-block" style="font-size: 12px;">Leave it empty if you want to publish this product immediately.</p>
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addposition" class="col-sm-4 control-label">Position</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addposition" placeholder="Input product position ...">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Category</label>
            <div class="col-sm-6">
              <select id="sel_addcategory" class="form-control" multiple="multiple">
                <?php 
                foreach($category as $cat){
                  ?>
                    <option value="<?php echo $cat->id; ?>"><?php echo '['.$cat->type_name.'] '.$cat->category_name; ?></option>
                  <?php
                }
              ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="chk_visible" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-6">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="chk_visible" value=""> Visible
                </label>
                <label style="margin-left: 7px;">
                  <input type="checkbox" id="chk_sale" value=""> Sale
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