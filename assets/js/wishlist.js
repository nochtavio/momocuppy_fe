$(document).ready(function() {
	$('.wishlist_cancel').magnificPopup({	
		type: 'inline',
		mainClass: 'mfp-fade',
		callbacks: {
			open: function () {
				$(".nobtn").click(function(){
					var magnificPopup = $.magnificPopup.instance; 	
					magnificPopup.close();  
				});
				$(".yesbtn").click(function(){
				 var mp = $.magnificPopup.instance,
         t = $(mp.currItem.el[0]);
				 
				 $(location).attr('href', t.data('deletewl'));
				});
			}
		}		
	});
});