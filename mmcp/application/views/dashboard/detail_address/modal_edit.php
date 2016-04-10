<div id="modal_edit" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Address</h4>
      </div>
      <form class="form-horizontal" role="form" id="form_edit">
        <div class="modal-body">
          <div class="form-group">
            <label for="txt_editfirstname" class="col-sm-4 control-label">Firstname</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editfirstname" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editlastname" class="col-sm-4 control-label">Lastname</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editlastname" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editstreetaddress" class="col-sm-4 control-label">Street Address</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editstreetaddress" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editzipcode" class="col-sm-4 control-label">Zip Code</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editzipcode" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editphone" class="col-sm-4 control-label">Phone</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editphone" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editcountry" class="col-sm-4 control-label">Country</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editcountry" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_editcity" class="col-sm-4 control-label">City</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="txt_editcity" placeholder="">
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