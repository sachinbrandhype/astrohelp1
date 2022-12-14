$(window).on('load', function(){

	"use strict";
 
	
	/* ========================================================== */
	/*   Hide Responsive Navigation On-Click                      */
	/* ========================================================== */
	
	  $(".navbar-nav li a").on('click', function(event) {
	    $(".navbar-collapse").collapse('hide');
	  });

 

	/* ========================================================== */
	/*   Countdown                                                */
	/* ========================================================== */

	$("#countdown").countdown({
		date: "29 December 2021 12:00:00",
		format: "on"
	},

	function() {
		// callback function
	}); 


	/* ========================================================== */
	/*   Newsletter                                               */
	/* ========================================================== */
	
	$('.newsletter-form').each( function(){
		var form = $(this);
		//form.validate();
		form.submit(function(e) {
			if (!e.isDefaultPrevented()) {
				jQuery.post(this.action,{
					'email':$('input[name="nf_email"]').val(),
				},function(data){
					form.fadeOut('fast', function() {
						$(this).siblings('p.newsletter_success_box').show();
					});
				});
				e.preventDefault();
			}
		});
	});
	
	
});