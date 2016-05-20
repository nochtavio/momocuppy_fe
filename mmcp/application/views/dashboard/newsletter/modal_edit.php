<div id="modal_edit" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Newsletter</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_edit">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_edittitle" class="col-sm-4 control-label">Title</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_edittitle" placeholder="Input title ...">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" style="padding-top: 0;">Banner #1</label>
            <div class="col-sm-6 col-xs-8">
              <div class="row">
                <div class="col-lg-12">
                  <img id="img_edit" class="col-xs-4" alt="No Image" style="padding: 0" />
                </div>
                <div class="col-lg-12">
                  <label class="label-no col-xs-12" style="margin: 0 0 0 -15px;">
                    <input type="file" name="editfile" id="editfile" size="20" style="margin:10px 0 1px 0" />
                    <em>Only .jpg is allowed | Maximum Size is 1 MB | Recommended Resolution is 444x474 pixels</em> <br/>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editlink1" class="col-sm-4 control-label">Link #1</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editlink1" placeholder="Input link #1 ...">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" style="padding-top: 0;">Banner #2</label>
            <div class="col-sm-6 col-xs-8">
              <div class="row">
                <div class="col-lg-12">
                  <img id="img_edit2" class="col-xs-4" alt="No Image" style="padding: 0" />
                </div>
                <div class="col-lg-12">
                  <label class="label-no col-xs-12" style="margin: 0 0 0 -15px;">
                    <input type="file" name="editfile2" id="editfile2" size="20" style="margin:10px 0 1px 0" />
                    <em>Only .jpg is allowed | Maximum Size is 1 MB | Recommended Resolution is 444x474 pixels</em> <br/>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editlink2" class="col-sm-4 control-label">Link #2</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editlink2" placeholder="Input link #2 ...">
            </div>
          </div>
          <div class="alert alert-warning modal_warning" role="alert"></div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="txteditid" value="" />
          <input type="hidden" id="txteditbanner1" value="" />
          <input type="hidden" id="txteditbanner2" value="" />
          <button id="btn_edit_" type="submit" class="btn btn-warning">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>