<div id="modal_add" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add Product on <?php echo empty($main_category_name) ? "" : $main_category_name; ?></h4>
      </div>
      <form class="form-horizontal" role="form" id="form_add">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_addselproduct" class="col-sm-4 control-label">Product</label>
            <div class="col-sm-6">
              <select class="form-control" id="txt_addselproduct">
                <option value="0">Select Product</option>
                <?php
                if (!empty($product_total)) {
                  if (count($product_total) > 0) {
                    for ($x = 0; $x < $product_total; $x++) {
                      ?>
                      <option value="<?php echo $product_id[$x] ?>"><?php echo $product_name[$x] ?></option>
                      <?php
                    }
                  }
                }
                ?>
              </select>            
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