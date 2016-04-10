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
            <label for="txt_addselcolor" class="col-sm-4 control-label">Color</label>
            <div class="col-sm-6">
              <select class="form-control" id="txt_addselcolor">
                  <?php
                  if (!empty($color_total)) {
                    if (count($color_total) > 0) {
                      for ($x = 0; $x < $color_total; $x++) {
                        ?>
                      <option value="<?php echo $color_id[$x] ?>"><?php echo $color_name[$x] ?></option>
                      <?php
                    }
                  }
                }
                ?>
              </select>            
            </div>
          </div>
          <div class="form-group">
            <label for="txt_addstock" class="col-sm-4 control-label">Stock</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_addstock" placeholder="Input product stock ...">
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