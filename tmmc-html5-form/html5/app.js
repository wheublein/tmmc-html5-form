$(function() {

	// Get the form.
	var form = $('#ajax-contact');

	// Get the messages div.
	var formMessages = $('#formMessages');

	// Set up an event listener for the contact form.
	$(form).submit(function(e) {
		// Stop the browser from submitting the form.
		e.preventDefault();

		// Serialize the form data.
		var formData = $(form).serialize();

		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			data: formData
		})
		.done(function(response) {
			// Make sure that the formMessages div has the 'success' class.
			$(formMessages).removeClass('error');
			$(formMessages).addClass('success');

			//hide or gray-out submit button


			// Set the message text.
			$(formMessages).text(response);

			// Clear the form.
			$('#firstname').val('');
			$('#lastname').val('');
			$('#email').val('');
			$('#message').val('');

			//Transition to thankspage
			//<a href="#thankspage" data-transition="flip" class="ui-btn ui-corner-all ui-shadow ui-btn-a center" id="back-btn-copy" style="max-width:240px">Go to thank page</a>
			$('body').pagecontainer( 'change', '#thankspage' );
			$(formMessages).removeClass('error');
			$(formMessages).removeClass('success');
			$(formMessages).text('');

		})
		.fail(function(data) {
			// Make sure that the formMessages div has the 'error' class.
			$(formMessages).removeClass('success');
			$(formMessages).addClass('error');

			// Set the message text.
			if (data.responseText !== '') {
				$(formMessages).text(data.responseText);
			} else {
				$(formMessages).text('Oops! An error occured and your message could not be sent.');
			}
		});

	});

});
