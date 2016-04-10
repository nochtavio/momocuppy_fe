$(document).ready(function(){
  //Initial Setup
  id_member = 1;
  get_cart(id_member, $('#shopbaglist'));
  //End Initial Setup
  
  //User Action
  $('#addtocart_prod').click(function(event){
    event.preventDefault();
    
    //Set Parameter
    var id_dt_product = $('#txt_id_dt_product').val();
    var qty = $('#txt_qty').val();
    //End Set Parameter
    add_to_cart(id_member, id_dt_product, qty, $('#shopbaglist'));
  });
  //End User Action
});