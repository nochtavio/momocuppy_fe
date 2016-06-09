<div id="modal_edit" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Product Type</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_edit">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_editproductname" class="col-sm-4 control-label">Product Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editproductname" placeholder="Input product name ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editproductprice" class="col-sm-4 control-label">Product Price</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editproductprice" placeholder="Input product price ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editproductdesc" class="col-sm-4 control-label">Product Description</label>
            <div class="col-sm-6">
              <textarea id="txt_editproductdesc" style="width:100%;"></textarea>
              <em>Please avoid copy paste from other source. Or at least copy paste to notepad first, then copy it to here.</em>
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editpublishdate" class="col-sm-4 control-label">Publish Date</label>
            <div class="col-sm-6">
              <div class='input-group date' id='txt_editpublishdate'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
              <p class="help-block" style="font-size: 12px;">Leave it empty if you want to publish this product immediately.</p>
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editproductweight" class="col-sm-4 control-label">Product Weight (kg)</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editproductweight" placeholder="Input product weight ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editposition" class="col-sm-4 control-label">Position</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editposition" placeholder="Input product position ...">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Category</label>
            <div class="col-sm-6">
              <select id="sel_editcategory" class="form-control" multiple="multiple">
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
