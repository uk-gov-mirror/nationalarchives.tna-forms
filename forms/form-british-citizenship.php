<?php
/**
 * Form: Check for a certificate of British citizenship
 *
 */
function return_form_british_citizenship( $content ) {
	// Global variables to determine if the form submission
	// is successful or comes back with errors
	global $tna_success_message,
	       $tna_error_message;
	// HTML form string (I know, it's long!)
	$form = '<div class="arrow-steps clearfix">
	                <ul>
	                    <li class="current"><span>1</span> Certificate holder\'s details</li>
	                    <li><span>2</span> Certificate details</li>
	                    <li><span>3</span> Contact details</li>
	                </ul>
	            </div>
	            <form action=""  id="naturalisation" method="POST">
	            	<input type="hidden" name="tna-form" value="naturalisation">
	            	<input type="hidden" name="token" value="' . form_token() . '">
	            	<input type="hidden" name="timestamp" value="' . time() . '">
	                <fieldset class="form-step-1">
	                    <legend>Certificate holder\'s details</legend>
	                    <div class="form-row">
	                        <p>Enter the details of the certificate holder at the time the certificate was issued.</p>
	                    </div>
	                    <div class="form-row">
	                        <label for="certificate_forename">Full name</label>
	                        <input type="text" id="certificate_name" name="certificate-name" aria-required="true" required ' . set_value( 'certificate-name' ) . '>
	                        ' . field_error_message( 'certificate-name', 'Certificate holder name' ) . '
	                    </div>
	                    <div class="form-row">
	                        <label for="certificate_surname_alt">Alternative name(s) <span class="optional">(optional)</span></label>
	                        <p class="form-hint">For example: married or maiden names</p>
	                        <input type="text" id="certificate_name_alt" name="certificate-name-alt" ' . set_value( 'certificate-name-alt' ) . '>
	                    </div>
	                    <div class="form-row">
	                        <label for="certificate_birth_country">Country of birth <span class="optional">(optional)</span></label>
	                        <input type="text" id="certificate_birth_country" name="certificate-birth-country" ' . set_value( 'certificate-birth-country' ) . '>
	                    </div>
	                    <div class="form-row">
	                    <p>Date of birth <span class="optional">(optional)</span></p>
	                    <p class="form-hint">For example: 8 3 1955</p>
	                        <span class="dob-col day">
	                            <label for="certificate_day">Day</label>
	                            <input type="number" id="certificate_day" name="certificate-day" ' . set_value( 'certificate-day' ) . '>
	                        </span>
	                        <span class="dob-col month">
	                            <label for="certificate_month">Month</label>
	                            <input type="number" id="certificate_month" name="certificate-month" ' . set_value( 'certificate-month' ) . '>
	                        </span>
	                        <span class="dob-col year">
	                            <label for="certificate_year">Year</label>
	                            <input type="number" id="certificate_year" name="certificate-year" ' . set_value( 'certificate-year' ) . '>
	                        </span>
	                    </div>
	                    <div class="form-row dob-approx">
	                        <input id="certificate_dob_approx" type="checkbox" name="certificate-dob-approx" value="Yes" ' . set_value( 'certificate-dob-approx', 'checkbox' ) . '>
	                        <label for="certificate_dob_approx">Tick here if the date of birth is an approximation.</label>
	                    </div>
	                    <div class="form-row">
	                        <label for="certificate_postal_address">Address at time of registration <span class="optional">(optional)</span></label>
	                        <textarea id="certificate_postal_address" name="certificate-postal-address">' . set_value( 'certificate-postal-address', 'textarea' ) . '</textarea>
	                    </div>
	                    <div class="form-row form-nav">
	                        <a href="#" title="continue" class="button">Continue</a>
	                    </div>
	                </fieldset>
	                <fieldset class="form-step-2">
	                    <legend>Certificate details (optional)</legend>
	                    <div class="form-row form-nav">
	                        <a href="#" title="back" class="button-back">&#10094; Back</a>
	                    </div>
	                    <div class="form-row">
	                        <p>If you know any details of the certificate, please provide them below. This will help us narrow down our search.</p>
	                    </div>
	                    <div class="form-row">
	                        <label for="certificate_issued_country">Country of issue <span class="optional">(optional)</span></label>
	                        <input type="text" id="certificate_issued_country" name="certificate-issued-country" ' . set_value( 'certificate-issued-country' ) . '>
	                    </div>
	                    <div class="form-row">
	                        <label for="certificate_number">Certificate number <span class="optional">(optional)</span></label>
	                        <input type="text" id="certificate_number" name="certificate-number" ' . set_value( 'certificate-number' ) . '>
	                    </div>
	                    <div class="form-row registration-year">
	                    <p><label class="form-label" for="certificate_year_issued_from">Year of registration <span class="optional">(optional)</span></label></p>
	                        <label class="form-label" for="certificate_year_issued_from">between</label>
	                        <select id="certificate_year_issued_from" name="certificate-year-issued-from">
	                            <option value="">Please select</option>
	                            <option value="1949" ' . set_value( 'certificate-year-issued-from', 'select', '1949' ) . '>1949</option>
	                            <option value="1950" ' . set_value( 'certificate-year-issued-from', 'select', '1950' ) . '>1950</option>
	                            <option value="1951" ' . set_value( 'certificate-year-issued-from', 'select', '1951' ) . '>1951</option>
	                            <option value="1952" ' . set_value( 'certificate-year-issued-from', 'select', '1952' ) . '>1952</option>
	                            <option value="1953" ' . set_value( 'certificate-year-issued-from', 'select', '1953' ) . '>1953</option>
	                            <option value="1954" ' . set_value( 'certificate-year-issued-from', 'select', '1954' ) . '>1954</option>
	                            <option value="1955" ' . set_value( 'certificate-year-issued-from', 'select', '1955' ) . '>1955</option>
	                            <option value="1956" ' . set_value( 'certificate-year-issued-from', 'select', '1956' ) . '>1956</option>
	                            <option value="1957" ' . set_value( 'certificate-year-issued-from', 'select', '1957' ) . '>1957</option>
	                            <option value="1958" ' . set_value( 'certificate-year-issued-from', 'select', '1958' ) . '>1958</option>
	                            <option value="1959" ' . set_value( 'certificate-year-issued-from', 'select', '1959' ) . '>1959</option>
	                            <option value="1960" ' . set_value( 'certificate-year-issued-from', 'select', '1960' ) . '>1960</option>
	                            <option value="1961" ' . set_value( 'certificate-year-issued-from', 'select', '1961' ) . '>1961</option>
	                            <option value="1962" ' . set_value( 'certificate-year-issued-from', 'select', '1962' ) . '>1962</option>
	                            <option value="1963" ' . set_value( 'certificate-year-issued-from', 'select', '1963' ) . '>1963</option>
	                            <option value="1964" ' . set_value( 'certificate-year-issued-from', 'select', '1964' ) . '>1964</option>
	                            <option value="1965" ' . set_value( 'certificate-year-issued-from', 'select', '1965' ) . '>1965</option>
	                            <option value="1966" ' . set_value( 'certificate-year-issued-from', 'select', '1966' ) . '>1966</option>
	                            <option value="1967" ' . set_value( 'certificate-year-issued-from', 'select', '1967' ) . '>1967</option>
	                            <option value="1968" ' . set_value( 'certificate-year-issued-from', 'select', '1968' ) . '>1968</option>
	                            <option value="1969" ' . set_value( 'certificate-year-issued-from', 'select', '1969' ) . '>1969</option>
	                            <option value="1970" ' . set_value( 'certificate-year-issued-from', 'select', '1970' ) . '>1970</option>
	                            <option value="1971" ' . set_value( 'certificate-year-issued-from', 'select', '1971' ) . '>1971</option>
	                            <option value="1972" ' . set_value( 'certificate-year-issued-from', 'select', '1972' ) . '>1972</option>
	                            <option value="1973" ' . set_value( 'certificate-year-issued-from', 'select', '1973' ) . '>1973</option>
	                            <option value="1974" ' . set_value( 'certificate-year-issued-from', 'select', '1974' ) . '>1974</option>
	                            <option value="1975" ' . set_value( 'certificate-year-issued-from', 'select', '1975' ) . '>1975</option>
	                            <option value="1976" ' . set_value( 'certificate-year-issued-from', 'select', '1976' ) . '>1976</option>
	                            <option value="1977" ' . set_value( 'certificate-year-issued-from', 'select', '1977' ) . '>1977</option>
	                            <option value="1978" ' . set_value( 'certificate-year-issued-from', 'select', '1978' ) . '>1978</option>
	                            <option value="1979" ' . set_value( 'certificate-year-issued-from', 'select', '1979' ) . '>1979</option>
	                            <option value="1980" ' . set_value( 'certificate-year-issued-from', 'select', '1980' ) . '>1980</option>
	                            <option value="1981" ' . set_value( 'certificate-year-issued-from', 'select', '1981' ) . '>1981</option>
	                            <option value="1982" ' . set_value( 'certificate-year-issued-from', 'select', '1982' ) . '>1982</option>
	                            <option value="1983" ' . set_value( 'certificate-year-issued-from', 'select', '1983' ) . '>1983</option>
	                            <option value="1984" ' . set_value( 'certificate-year-issued-from', 'select', '1984' ) . '>1984</option>
	                            <option value="1985" ' . set_value( 'certificate-year-issued-from', 'select', '1985' ) . '>1985</option>
								<option value="1986" ' . set_value( 'certificate-year-issued-from', 'select', '1986' ) . '>1986</option>
	                        </select>
	                        <label class="form-label" for="certificate_year_issued_to">and</label>
	                        <select id="certificate_year_issued_to" name="certificate-year-issued-to">
	                            <option value="">Please select</option>
	                            <option value="1949" ' . set_value( 'certificate-year-issued-to', 'select', '1949' ) . '>1949</option>
	                            <option value="1950" ' . set_value( 'certificate-year-issued-to', 'select', '1950' ) . '>1950</option>
	                            <option value="1951" ' . set_value( 'certificate-year-issued-to', 'select', '1951' ) . '>1951</option>
	                            <option value="1952" ' . set_value( 'certificate-year-issued-to', 'select', '1952' ) . '>1952</option>
	                            <option value="1953" ' . set_value( 'certificate-year-issued-to', 'select', '1953' ) . '>1953</option>
	                            <option value="1954" ' . set_value( 'certificate-year-issued-to', 'select', '1954' ) . '>1954</option>
	                            <option value="1955" ' . set_value( 'certificate-year-issued-to', 'select', '1955' ) . '>1955</option>
	                            <option value="1956" ' . set_value( 'certificate-year-issued-to', 'select', '1956' ) . '>1956</option>
	                            <option value="1957" ' . set_value( 'certificate-year-issued-to', 'select', '1957' ) . '>1957</option>
	                            <option value="1958" ' . set_value( 'certificate-year-issued-to', 'select', '1958' ) . '>1958</option>
	                            <option value="1959" ' . set_value( 'certificate-year-issued-to', 'select', '1959' ) . '>1959</option>
	                            <option value="1960" ' . set_value( 'certificate-year-issued-to', 'select', '1960' ) . '>1960</option>
	                            <option value="1961" ' . set_value( 'certificate-year-issued-to', 'select', '1961' ) . '>1961</option>
	                            <option value="1962" ' . set_value( 'certificate-year-issued-to', 'select', '1962' ) . '>1962</option>
	                            <option value="1963" ' . set_value( 'certificate-year-issued-to', 'select', '1963' ) . '>1963</option>
	                            <option value="1964" ' . set_value( 'certificate-year-issued-to', 'select', '1964' ) . '>1964</option>
	                            <option value="1965" ' . set_value( 'certificate-year-issued-to', 'select', '1965' ) . '>1965</option>
	                            <option value="1966" ' . set_value( 'certificate-year-issued-to', 'select', '1966' ) . '>1966</option>
	                            <option value="1967" ' . set_value( 'certificate-year-issued-to', 'select', '1967' ) . '>1967</option>
	                            <option value="1968" ' . set_value( 'certificate-year-issued-to', 'select', '1968' ) . '>1968</option>
	                            <option value="1969" ' . set_value( 'certificate-year-issued-to', 'select', '1969' ) . '>1969</option>
	                            <option value="1970" ' . set_value( 'certificate-year-issued-to', 'select', '1970' ) . '>1970</option>
	                            <option value="1971" ' . set_value( 'certificate-year-issued-to', 'select', '1971' ) . '>1971</option>
	                            <option value="1972" ' . set_value( 'certificate-year-issued-to', 'select', '1972' ) . '>1972</option>
	                            <option value="1973" ' . set_value( 'certificate-year-issued-to', 'select', '1973' ) . '>1973</option>
	                            <option value="1974" ' . set_value( 'certificate-year-issued-to', 'select', '1974' ) . '>1974</option>
	                            <option value="1975" ' . set_value( 'certificate-year-issued-to', 'select', '1975' ) . '>1975</option>
	                            <option value="1976" ' . set_value( 'certificate-year-issued-to', 'select', '1976' ) . '>1976</option>
	                            <option value="1977" ' . set_value( 'certificate-year-issued-to', 'select', '1977' ) . '>1977</option>
	                            <option value="1978" ' . set_value( 'certificate-year-issued-to', 'select', '1978' ) . '>1978</option>
	                            <option value="1979" ' . set_value( 'certificate-year-issued-to', 'select', '1979' ) . '>1979</option>
	                            <option value="1980" ' . set_value( 'certificate-year-issued-to', 'select', '1980' ) . '>1980</option>
	                            <option value="1981" ' . set_value( 'certificate-year-issued-to', 'select', '1981' ) . '>1981</option>
	                            <option value="1982" ' . set_value( 'certificate-year-issued-to', 'select', '1982' ) . '>1982</option>
	                            <option value="1983" ' . set_value( 'certificate-year-issued-to', 'select', '1983' ) . '>1983</option>
	                            <option value="1984" ' . set_value( 'certificate-year-issued-to', 'select', '1984' ) . '>1984</option>
	                            <option value="1985" ' . set_value( 'certificate-year-issued-to', 'select', '1985' ) . '>1985</option>
								<option value="1986" ' . set_value( 'certificate-year-issued-to', 'select', '1986' ) . '>1986</option>
	                        </select>
	                    </div>
	                    <div class="form-row form-nav ">
	                        <a href="#" title="continue" class="button">Continue</a>
	                    </div>
	                </fieldset>
	                <fieldset class="form-step-3">
	                    <legend>Contact details</legend>
	                    <div class="form-row form-nav">
	                        <a href="#" title="back" class="button-back">&#10094; Back</a>
	                    </div>
	                    <div class="form-row">
	                        <p>Please provide your details so we can let you know whether we\'ve found the certificate.</p>
	                    </div>
	                    <div class="form-row">
	                        <label for="full_name">Full name</label>
	                        <input type="text" id="full_name" name="full-name" aria-required="true" required ' . set_value( 'full-name' ) . '>
	                        ' . field_error_message( 'full-name', 'Full name' ) . '
	                    </div>
	                    <div class="form-row">
	                        <p class="form-warning-error">How would you prefer to be contacted?</p>
		                    ' . field_error_message( 'preferred-contact', 'Preferred contact', 'radio' ) . '
		                    <div class="form-col pref_contact">
		                        <input id="contact_email" type="radio" name="preferred-contact" value="Email" ' . set_value( 'preferred-contact', 'radio', 'Email' ) . '>
		                        <label for="contact_email">Email</label>
		                    </div>
		                    <div class="form-col pref_contact">
		                        <input id="contact_postal" type="radio" name="preferred-contact" value="Post" ' . set_value( 'preferred-contact', 'radio', 'Post' ) . '>
		                        <label for="contact_postal">Post</label>
		                    </div>
	                    </div>
	                    <div class="email-wrapper">
	                        <div class="form-row">
	                            <label for="email">Email address</label>
	                            <input type="email" id="email" name="email" ' . set_value( 'email' ) . '>
	                            ' . field_error_message( 'email', 'Email' ) . '
	                        </div>
	                        <div class="form-row">
	                            <label for="confirm_email">Please re-type your email address</label>
	                            <input type="email" id="confirm_email" name="confirm-email" ' . set_value( 'confirm-email' ) . '>
	                            ' . field_error_message( 'confirm-email', 'Confirm email', 'reconfirm', 'email' ) . '
	                        </div>
	                    </div>
	                    <div class="form-row address-wrapper">
	                        <label for="postal_address">Postal address</label>
	                        <textarea id="postal_address" name="postal-address">' . set_value( 'postal-address', 'textarea' ) . '</textarea>
	                    </div>
	                    <div class="form-row hidden">
	                        <label for="skype_name">Skype name (please ignore this field)</label>
	                        <input type="text" id="skype_name" name="skype-name-' . rand(10, 99) . '">
	                    </div>
	                    <div class="form-row">
	                        <input type="submit" alt="Submit" name="submit-bc" id="submit-tna-form" value="Submit">
	                    </div>
	                </fieldset>
	            </form>';
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
function process_form_british_citizenship() {
	// The processing happens at form submission.
	// If no form is submitted we stop here.
	if ( ! is_admin() && isset( $_POST['submit-bc'] ) ) {
		// Checks for token
		// If the token exists then the form has been submitted so do nothing
		/* $token = filter_input( INPUT_POST, 'token' );
		if ( get_transient( 'token_' . $token ) ) {
			$_POST = array();
			return;
		}
		set_transient( 'token_' . $token, 'form-token', 360 ); */
		// Global variables
		global $tna_success_message,
		       $tna_error_message,
		       $tna_error_messages;
		// Setting global variables
		$tna_success_message = '';
		$tna_error_message   = '';
		// Error messages for individual form fields stored into an array
		// IMPORTANT: $tna_error_messages array keys must match exactly the $form_fields array keys
		$tna_error_messages  = array(
			'Certificate holder name'   => 'Please enter the certificate holder’s name',
			'Full name'                 => 'Please enter your full name',
			'Preferred contact'         => 'Please indicate your preferred method of contact',
			'Email'                     => 'Please enter a valid email address',
			'Confirm email'             => 'Please enter your email address again'
		);
		// Get the form elements and store them into an array
		// IMPORTANT: $form_fields array keys must match exactly the $tna_error_messages array keys
		$form_fields = array(
			'Certificate holder name'     => is_mandatory_text_field_valid( filter_input( INPUT_POST, 'certificate-name' ) ),
			'Alternative name'            => is_text_field_valid( filter_input( INPUT_POST, 'certificate-name-alt' ) ),
			'Country of birth'            => is_text_field_valid( filter_input( INPUT_POST, 'certificate-birth-country' ) ),
			'DOB'                         => is_text_field_valid( filter_input( INPUT_POST, 'certificate-day' ) ) . '-' .
			                                 is_text_field_valid( filter_input( INPUT_POST, 'certificate-month' ) ) . '-' .
			                                 is_text_field_valid( filter_input( INPUT_POST, 'certificate-year' ) ),
			'Approx DOB'                  => ( isset( $_POST['certificate-dob-approx'] ) ) ? is_checkbox_radio_valid( filter_input( INPUT_POST, 'certificate-dob-approx' ) ) : 'No',
			'Certificate holder address'  => is_textarea_field_valid( filter_input( INPUT_POST, 'certificate-postal-address' ) ),
			'Country of issue'            => is_text_field_valid( filter_input( INPUT_POST, 'certificate-issued-country' ) ),
			'Certificate number'          => is_text_field_valid( filter_input( INPUT_POST, 'certificate-number' ) ),
			'Issued from'                 => is_text_field_valid( filter_input( INPUT_POST, 'certificate-year-issued-from' ) ),
			'Issued to'                   => is_text_field_valid( filter_input( INPUT_POST, 'certificate-year-issued-to' ) ),
			'Full name'                   => is_mandatory_text_field_valid( filter_input( INPUT_POST, 'full-name' ) ),
			'Preferred contact'           => ( isset( $_POST['preferred-contact'] ) ) ? is_checkbox_radio_valid( filter_input( INPUT_POST, 'preferred-contact' ) ) : false,
			'Email'                       => is_email_field_valid( filter_input( INPUT_POST, 'email' ) ),
			'Confirm email'               => does_fields_match( $_POST['confirm-email'], $_POST['email'] ),
			'Postal address'              => is_textarea_field_valid( filter_input( INPUT_POST, 'postal-address' ) ),
			'Spam'                        => is_this_spam( $_POST )
		);
		// If any value inside the array is false then there is an error
		if ( in_array( false, $form_fields ) ) {
			// Oops! Error!
			// Store error messages into the global variable
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
			$tna_success_message .= '<p>If you provided your email address you will shortly receive an email confirming your application – please do not reply to this email</p>';
			$tna_success_message .= '<h3>Summary of your enquiry</h3>';
			$tna_success_message .= display_compiled_form_data( $form_fields );
			// Store email content to user into a variable
			$email_to_user = success_message_header( 'Your reference number:', $ref_number );
			$email_to_user .= confirmation_content( $post->ID );
			$email_to_user .= '<h3>Summary of your enquiry</h3>';
			$email_to_user .= display_compiled_form_data( $form_fields );
			// Send email to user
			send_form_via_email( $form_fields['Email'], 'Check for a certificate of British citizenship - Ref:', $ref_number,
				$email_to_user, $form_fields['Spam'] );
			// Store email content to TNA into a variable
			$email_to_tna = success_message_header( 'Reference number:', $ref_number );
			$email_to_tna .= display_compiled_form_data( $form_fields );
			// Send email to TNA
			send_form_via_email( get_tna_email( 'contactcentre' ), 'Certificate of British citizenship request - Ref:', $ref_number,
				$email_to_tna, $form_fields['Spam'] );
			log_spam( $form_fields['Spam'], date_timestamp_get( date_create() ), $form_fields['Email'] );
		}
	}
}
add_action('wp', 'process_form_british_citizenship');