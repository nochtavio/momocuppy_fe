<div id="modal_detail_order" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Detail Order [<span id="txt_detail_order_no"></span>]</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Sub Total</th>
              </tr>
            </thead>
            <tbody id="tabledetailorder">

            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <table class="pull-right">
          <tr>
            <td>
              <strong><span>Total Price</span></strong>
            </td>
            <td>
              <strong><span style="margin: 0 7px 0 7px;">:</span></strong>
            </td>
            <td>
              <span id="txt_total_price"></span> 
            </td>
          </tr>
          <tr>
            <td>
              <strong><span>Shipping Cost</span></strong>
            </td>
            <td>
              <strong><span style="margin: 0 7px 0 7px;">:</span></strong>
            </td>
            <td>
              <span id="txt_shipping_cost"></span> 
            </td>
          </tr>
          <tr>
            <td>
              <strong><span>Discount</span></strong>
            </td>
            <td>
              <strong><span style="margin: 0 7px 0 7px;">:</span></strong>
            </td>
            <td>
              <span id="txt_discount"></span> 
            </td>
          </tr>
          <tr>
            <td>
              <strong><span>Grand Total</span></strong>
            </td>
            <td>
              <strong><span style="margin: 0 7px 0 7px;">:</span></strong>
            </td>
            <td>
              <span id="txt_grand_total"></span> 
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>