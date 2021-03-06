<div id="modal_add" class="modal fade">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

        <h4 class="modal-title">Add Newsletter</h4>

      </div>

      <form class="form-horizontal" role="form" id="form_add">

        <div class="modal-body">

          <div class="form-group">

            <label for="txt_addtitle" class="col-sm-4 control-label">Title</label>

            <div class="col-sm-6">

              <input type="text" class="form-control" id="txt_addtitle" placeholder="Input title ...">

            </div>

          </div>

          <div class="form-group">

            <label class="col-sm-4 control-label" style="padding-top: 0;">Banner #1</label>

            <div class="col-sm-6">

              <label class="label-no col-xs-12" style="margin: 0 0 0 -15px;">

                <input type="file" name="userfile" id="userfile" size="20" style="margin-bottom: 4px;" />

                <em>Only .jpg is allowed | Maximum Size is 1 MB | Recommended Resolution is 444x474 pixels</em> <br/>

              </label>

            </div>

          </div>

          <div class="form-group">

            <label for="txt_addlink1" class="col-sm-4 control-label">Link #1</label>

            <div class="col-sm-6">

              <input type="text" class="form-control" id="txt_addlink1" placeholder="Input link #1 ...">

            </div>

          </div>

          <div class="form-group">

            <label class="col-sm-4 control-label" style="padding-top: 0;">Banner #2</label>

            <div class="col-sm-6">

              <label class="label-no col-xs-12" style="margin: 0 0 0 -15px;">

                <input type="file" name="userfile2" id="userfile2" size="20" style="margin-bottom: 4px;" />

                <em>Only .jpg is allowed | Maximum Size is 1 MB | Recommended Resolution is 444x256 pixels</em> <br/>

              </label>

            </div>

          </div>

          <div class="form-group">

            <label for="txt_addlink2" class="col-sm-4 control-label">Link #2</label>

            <div class="col-sm-6">

              <input type="text" class="form-control" id="txt_addlink2" placeholder="Input link #2 ...">

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