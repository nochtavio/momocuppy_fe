<div id="modal_edit" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Category</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_edit">
        <div class="modal-body">
          <div class="form-group">
            <label for="sel_edittype" class="col-sm-4 control-label">Type</label>
            <div class="col-sm-6">
              <select class="form-control" id="sel_edittype">
                <?php 
                  foreach ($fetch_type as $type) {
                    ?>
                    <option value="<?php echo $type->id ?>"><?php echo $type->type_name ?></option>
                    <?php
                  }
                ?>
              </select>            
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editcategoryname" class="col-sm-4 control-label">Category Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editcategoryname" placeholder="Input category name ...">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editposition" class="col-sm-4 control-label">Position</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editposition" placeholder="Input category position ...">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" style="padding-top: 0;">Image</label>
            <div class="col-sm-6 col-xs-8">
              <div class="row">
                <div class="col-lg-12">
                  <img id="img_edit" class="col-xs-4" alt="No Image" style="padding: 0" />
                </div>
                <div class="col-lg-12">
                  <label class="label-no col-xs-12" style="margin: 0 0 0 -15px;">
                    <input type="file" name="editfile" id="editfile" size="20" style="margin:10px 0 1px 0" />
                    <em>Only .png is allowed | Maximum Size is 1 MB | Recommended Resolution is 269x269 pixels</em> <br/>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" style="padding-top: 0;">Image Hover</label>
            <div class="col-sm-6 col-xs-8">
              <div class="row">
                <div class="col-lg-12">
                  <img id="img_edit2" class="col-xs-4" alt="No Image" style="padding: 0" />
                </div>
                <div class="col-lg-12">
                  <label class="label-no col-xs-12" style="margin: 0 0 0 -15px;">
                    <input type="file" name="editfile2" id="editfile2" size="20" style="margin:10px 0 1px 0" />
                    <em>Only .png is allowed | Maximum Size is 1 MB | Recommended Resolution is 269x269 pixels</em> <br/>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="alert alert-warning modal_warning" role="alert"></div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="txteditid" value="" />
          <input type="hidden" id="txteditimg" value="" />
          <input type="hidden" id="txteditimghover" value="" />
          <button id="btn_edit_" type="submit" class="btn btn-warning">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>