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
            <label for="txt_addproductdesc" class="col-sm-4 control-label">Product Description</label>
            <div class="col-sm-6" id="txt_editproductdesc">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editpublishdate" class="col-sm-4 control-label">Publish Date</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editpublishdate" placeholder="Input publish date ...">
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
            <label class="col-sm-4 control-label">Category</label>
            <div class="col-sm-4" style="padding: 7px 0 0 14px;">
              <label>Home Decor</label>
              <?php
              if (!empty($category_homedecor_total)) {
                if (count($category_homedecor_total) > 0) {
                  for ($x = 0; $x < $category_homedecor_total; $x++) {
                    ?>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="edit_category_homedecor" value="<?php echo $category_homedecor_id[$x] ?>"><?php echo $category_homedecor_name[$x] ?>
                      </label>
                    </div>
                    <?php
                  }
                }
              }
              ?>
            </div>
            <div class="col-sm-4" style="padding: 7px 0 0 14px;">
              <label>Accessories</label>
              <?php
              if (!empty($category_accessories_total)) {
                if (count($category_accessories_total) > 0) {
                  for ($x = 0; $x < $category_accessories_total; $x++) {
                    ?>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="edit_category_accessories" value="<?php echo $category_accessories_id[$x] ?>"><?php echo $category_accessories_name[$x] ?>
                      </label>
                    </div>
                    <?php
                  }
                }
              }
              ?>
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