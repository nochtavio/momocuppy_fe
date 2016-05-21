<div class="row">
  <div class="col-lg-12" style="padding: 0 40px 0 39px;">
    <img id="img_aboutus" class="img-responsive img-thumbnail" src="/mmcp/images/aboutus/headerintro.png" />
    <form>
      <div class="form-group" style="margin: 7px 0 0 0;">
        <input type="file" name="editfile" id="editfile">
        <p class="help-block">Choose your image to replace the old one. Only PNG is allowed | Maximum Size is 1 MB | Recommended Resolution is 550x249 px</p>
      </div>
    </form>
    <div class="alert alert-warning modal_warning_" role="alert" style="display: none;"></div>
    <div class="alert alert-success modal_success_" role="alert" style="display: none;"></div>
    <button id="btn_change" type="submit" class="btn btn-warning">Change</button>
  </div>
</div>

<div class="row" style="margin-bottom: 10px;">
  <div class="col-lg-12">
    <form class="form-horizontal" role="form" id="form_edit">
      <div class="form-group">
        <div class="col-sm-12">
          <textarea id="txt_editcontent" style="width:100%;"></textarea>
        </div>
      </div>
      <div class="alert alert-warning modal_warning" role="alert" style="display: none;"></div>
      <div class="alert alert-success modal_success" role="alert" style="display: none;"></div>
      <button id="btn_edit_" type="submit" class="btn btn-warning">Submit</button>
    </form>
  </div>
</div>