
$(document).ready(function() {
	$('#message_popup').magnificPopup({	
		type: 'inline',
		mainClass: 'mfp-fade',
		callbacks: {
			open: function () {
				$(".nobtn").click(function(){
					var magnificPopup = $.magnificPopup.instance; 	
					magnificPopup.close();  
				});
			}
		}		
	});
});
