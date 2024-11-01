(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	 $(function() {
		 
		$('.verify-vmg').on( "click", function(event) {
 			event.preventDefault();
 			$(this).hide();
 			$('.vmg-response-checking').show();

			$.post(
				ajax_object.ajax_url,
				{
					// wp ajax action
					action : 'verify_vmg_api',
					nextNonce : ajax_object.nonce
					
				},
							
				function( response ) {
					
					$('.vmg-response').append(response);
					$('.vmg-response-checking').hide();
				}
			);
			
 			
/*
			var post_id = $(this).parent().parent().attr('id');
			var user_id = $(this).parent().parent().find('input#user').val();
			var nonce = $(this).parent().parent().find('input#nonce').val();


*/
			
		});
		
	 });

})( jQuery );
