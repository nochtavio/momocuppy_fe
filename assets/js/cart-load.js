$(document).ready(function() {
	$('.cart-popup').magnificPopup({
		type: 'ajax',
		ajax: {
			settings: null, // Ajax settings object that will extend default one - http://api.jquery.com/jQuery.ajax/#jQuery-ajax-settings
			// For example:
			// settings: {cache:false, async:false}
		
			cursor: 'mfp-ajax-cur', // CSS class that will be added to body during the loading (adds "progress" cursor)
			tError: '<a href="%url%">The content</a> could not be loaded.' //  Error message, can contain %curr% and %total% tags if gallery is enabled
		},
		callbacks: {
			parseAjax: function(mfpResponse) {
				// mfpResponse.data is a "data" object from ajax "success" callback
				// for simple HTML file, it will be just String
				// You may modify it to change contents of the popup
				// For example, to show just #some-element:
				// mfpResponse.data = $(mfpResponse.data).find('#some-element');
		
				// mfpResponse.data must be a String or a DOM (jQuery) element
		
				//console.log('Ajax content loaded:', mfpResponse);
			},
			ajaxContentAdded: function() {
				// Ajax content is loaded and appended to DOM
				//console.log(this.content);
				/*$('ul#itemload').simplebar({
					css: {
						// defaults
						container: 'simplebar',
						content: 'simplebar-content',
						scrollContent: 'simplebar-scroll-content',
						scrollbar: 'simplebar-scrollbar2',
						scrollbarTrack: 'simplebar-track2'
					}						
				}); 	*/		
				$('ul.orderhistory').jScrollPane(); 
				$('ul#itemload').jScrollPane(); 	
			}
		}
	});	
});