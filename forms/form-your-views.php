<?php
/**
 * Form: contact us
 *
 */

function return_form_your_views( $content ) {

	// Global variables to determine if the form submission
	// is successful or comes back with errors
	global $tna_success_message,
	       $tna_error_message;

	// If the form is submitted the form data is processed
	if ( isset( $_POST['submit-yv'] ) ) {
		process_form_your_views();
	}

	// HTML form string
	$html = new Form_Builder;
	$form =  $html->form_begins( 'your-views', 'Your views' ) .
	         $html->fieldset_begins( 'Your details' ) .
	         $html->form_text_input( 'Full name', 'full_name', 'full-name' ) .
	         $html->form_email_input( 'Email address', 'email', 'email' ) .
	         $html->form_email_input( 'Please re-type your email address', 'confirm_email', 'confirm-email', '', 'email' ) .
	         $html->fieldset_ends() .
	         $html->fieldset_begins( 'Your message' ) .
	         $html->form_select_input( 'Reason for contact', 'reason', 'reason', array('Compliment', 'Suggestion or comment', 'Criticism or concern', 'Complaint'), 'Please select an option' ) .
	         $html->form_textarea_input( 'Your enquiry', 'enquiry', 'enquiry', 'Please enter your enquiry' ) .
	         $html->fieldset_ends() .
	         $html->fieldset_begins( 'Additional record information' ) .
	         $html->help_text( 'Please enter an order number or catalogue reference if either are relevant to this message.' ) .
	         $html->form_text_input( 'Order number or catalogue reference', 'order_number_cat_ref', 'order-number-cat-ref' ) .
	         $html->form_spam_filter( rand(10, 99) ) .
	         $html->submit_form( 'submit-yv', 'submit-tna-form' ) .
	         $html->fieldset_ends() .
	         $html->form_ends();

	// If the form submission comes with errors give us back
	// the form populated with form data and error messages
	if ( $tna_error_message ) {
		return $tna_error_message . $form;
	}

	// If the form is successful give us the confirmation content
	elseif ( $tna_success_message ) {
		return $tna_success_message . print_page();
	}

	// If no form submission, hence the user has
	// accessed the page for the first time, give us an empty form
	else {
		return $content . $form;
	}
}

function process_form_your_views() {

	// Global variables
	global $tna_success_message,
	       $tna_error_message;

	// Setting global variables
	$tna_success_message = '';
	$tna_error_message   = '';

	// Get the form elements and store them into an array
	$form_fields = array(
		'Name'              				  => is_text_field_valid( filter_input( INPUT_POST, 'full-name' ) ),
		'Email'              				  => is_text_field_valid( filter_input( INPUT_POST, 'email' ) ),
		'Confirm email'    				      => does_fields_match( $_POST['confirm-email'], $_POST['email'] ),
		'Reason'          				      => is_mandatory_select_valid( filter_input( INPUT_POST, 'reason' ) ),
		'Enquiry'           			      => is_mandatory_textarea_field_valid( filter_input( INPUT_POST, 'enquiry' ) ),
		'Order number or catalogue reference' => is_text_field_valid( filter_input( INPUT_POST, 'order-number' ) ),
		'Spam'                 				  => is_this_spam( $_POST )
	);

	// If any value inside the array is false then there is an error
	if ( in_array( false, $form_fields ) ) {

		// Oops! Error!

		// Store error message into the global variable
		$tna_error_message = display_error_message();

		log_spam( $form_fields['Spam'], date_timestamp_get( date_create() ), $form_fields['Email'] );

	} else {

		// Yay! Success!

		global $post;
		// Generate reference number based on user's surname and timestamp
		$ref_number = ref_number( 'TNA', date_timestamp_get( date_create() ) );

		// Store confirmation content into the global variable
		$tna_success_message = success_message_header( 'Your reference number:', $ref_number );
		$tna_success_message .= confirmation_content( $post->ID );
		$tna_success_message .= '<h3>Summary of your enquiry</h3>';
		$tna_success_message .= display_compiled_form_data( $form_fields );

		// Store email content to user into a variable
		$email_to_user = success_message_header( 'Your reference number:', $ref_number );
		$email_to_user .= confirmation_content( $post->ID );
		$email_to_user .= '<h3>Summary of your enquiry</h3>';
		$email_to_user .= display_compiled_form_data( $form_fields );

		// Send email to user
		send_form_via_email( $form_fields['Email'], 'Your enquiry - Ref:', $ref_number, $email_to_user, $form_fields['Spam'] );

		// Store email content to TNA into a variable
		$email_to_tna = success_message_header( 'Reference number:', $ref_number );
		$email_to_tna .= display_compiled_form_data( $form_fields );

		// Send email to TNA
		// Amend email address function with username to send email to desired destination.
		// eg, get_tna_email( 'contactcentre' )
		send_form_via_email( get_tna_email(), 'Enquiry, reason for contact: ' . $form_fields['Reason'] . ' - Ref:', $ref_number, $email_to_tna, $form_fields['Spam'] );

		log_spam( $form_fields['Spam'], date_timestamp_get( date_create() ), $form_fields['Email'] );

	}
}
