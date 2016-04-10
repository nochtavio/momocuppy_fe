<div id="modal_edit" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Product Redeem Image</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_edit">
        <div class="modal-body">
          <div class="form-proofofpayment form-group">
            <label class="col-sm-3 control-label" style="padding-top: 0;">Image</label>
            <div class="col-sm-9 col-xs-8">
              <div class="row">
                <div class="col-lg-12">
                  <img id="img_edit" class="col-xs-4" alt="No Image" />
                </div>
                <div class="col-lg-12">
                  <label class="label-no col-xs-12">
                    <input type="file" name="editfile" id="editfile" size="20" style="margin:10px 0 1px 0" />
                    <em>Only .jpg is allowed (1227x757 pixels)</em> <br/>
                  </label>
                </div>
              </div>
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