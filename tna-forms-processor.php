<?php

class Form_Processor {

	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function sanitize_value( $key ) {
		$value          = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
		$value          = trim( $value );
		$newline        = '--NEWLINE--';
		$value          = str_replace( "\n", $newline, $value );
		$sanitize_value = str_replace( $newline, '<br />', $value );

		return $sanitize_value;
	}

	/**
	 * @param $data
	 *
	 * @return string
	 */
	public function display_data( $data ) {
		if ( is_array( $data ) ) {
			$display_data = '<div class="form-data"><ul>';
			foreach ( $data as $field_name => $field_value ) {
				if ( strpos( $field_name,
						'skype-name' ) !== false || $field_name == 'confirm-email-required' || $field_name == 'confirm-email'
				) {

					// do nothing

				} else {

					$field_name = str_replace( '-required', '', $field_name );
					$field_name = ucfirst( str_replace( '-', ' ', $field_name ) );

					$display_data .= '<li>' . $field_name . ': ' . $field_value . '</li>';
				}
			}
			$display_data .= '</ul></div>';

			return $display_data;
		}
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	public function get_data( $data ) {
		$form_data = array();
		foreach ( $data as $key => $value ) {
			if ( $key == 'tna-form' || $key == 'token' || $key == 'timestamp' || strpos( $key, 'submit' ) !== false ) {
				// do nothing
			} elseif ( strpos( $key, 'skype-name' ) !== false && trim( $value ) !== '' ) {
				$form_data['spam'] = true;
			} else {
				if ( strpos( $key, 'required' ) !== false ) {
					if ( ( strpos( $key, 'email' ) !== false ) ) {
						if ( trim( $value ) === '' || is_email( $value ) == false ) {
							$form_data[ $key ] = false;
						} elseif ( $key == 'confirm-email-required' ) {
							if ( trim( $_POST['email-required'] ) !== trim( $_POST['confirm-email-required'] ) ) {
								$form_data[ $key ] = false;
							} else {
								$form_data[ $key ] = true;
							}
						} else {
							$sanitize_value    = $this->sanitize_value( $key );
							$form_data[ $key ] = $sanitize_value;
						}
					} else {
						if ( trim( $value ) === '' ) {
							$form_data[ $key ] = false;
						} else {
							$sanitize_value    = $this->sanitize_value( $key );
							$form_data[ $key ] = $sanitize_value;
						}
					}
				} elseif ( trim( $value ) !== '' ) {
					$sanitize_value    = $this->sanitize_value( $key );
					$form_data[ $key ] = $sanitize_value;
				} else {
					$form_data[ $key ] = '-';
				}
			}
		}

		return $form_data;
	}

	/**
	 * @param $form_name
	 * @param $form_data
	 * @param string $tna_recipient
	 */
	public function process_data( $form_name, $form_data, $tna_recipient = '' ) {

		// Global variables
		global $tna_success_message,
		       $tna_error_message;

		// Reset global variables
		$tna_success_message = '';
		$tna_error_message   = '';

		if ( isset( $form_data['email-required'] ) ) {
			$user_email = $form_data['email-required'];
		} elseif ( isset( $form_data['email'] ) ) {
			$user_email = $form_data['email'];
		} else {
			$user_email = '';
		}

		// If any value inside the array is false then there is an error
		if ( isset( $form_data['spam'] ) ) {

			// Oops! Spam!
			$this->log_spam( 'yes', date_timestamp_get( date_create() ), $user_email );

		} elseif ( in_array( false, $form_data ) ) {

			// Oops! Error!
			$tna_error_message = $this->error_message();

		} else {

			// Yay! Success!

			global $post;
			$ref_number   = $this->ref_number( 'TNA', date_timestamp_get( date_create() ) );
			$form_content = $this->display_data( $form_data );

			// Confirmation message
			$tna_success_message = $this->message( $form_name, $form_content, $ref_number, $post->ID, 'success' );

			// Confirmation email to user
			$user_email_content = $this->message( $form_name, $form_content, $ref_number, $post->ID, 'user' );
			$this->send_email( $user_email, $form_name . ' - Ref:', $ref_number, $user_email_content );

			// Email to TNA
			$tna_email         = $this->get_tna_email( $tna_recipient );
			$tna_email_content = $this->message( $form_name, $form_content, $ref_number, $post->ID );
			$this->send_email( $tna_email, $form_name . ' - Ref:', $ref_number, $tna_email_content );

			// Subscribe to newsletter
			if ( isset( $form_data['newsletter'] ) ) {
				subscribe_to_newsletter( $form_data['newsletter'], $form_data['full-name'], $user_email, $form_name, '' );
			}
		}
	}

	/**
	 * @param $prefix
	 * @param $time_stamp
	 *
	 * @return string
	 */
	public function ref_number( $prefix, $time_stamp ) {
		$letter = chr( rand( 65, 90 ) );
		$suffix = $letter . rand( 10, 99 );

		return $prefix . $time_stamp . $suffix;
	}

	/**
	 * @return string
	 */
	public function error_message() {
		$error_message = '<div class="emphasis-block error-message" role="alert">';
		$error_message .= '<h3>Sorry, there was a problem</h3>';
		$error_message .= '<p>Please check the highlighted fields to proceed.</p></div>';

		return $error_message;
	}

	/**
	 * @param $form_name
	 * @param $form_content
	 * @param $ref_number
	 * @param $id
	 * @param string $type
	 *
	 * @return string
	 */
	public function message( $form_name, $form_content, $ref_number, $id, $type = '' ) {
		if ( $type ) {
			$subject = 'Your reference number:';
		} else {
			$subject = 'Reference number:';
		}
		$content = success_message_header( $subject, $ref_number );
		if ( $type == 'user' ) {
			$content .= confirmation_email_content( $id );
		} elseif ( $type == 'success' ) {
			$content .= confirmation_content( $id );
		}
		if ( $type ) {
			$content .= '<h3>Summary of your enquiry</h3>';
		} else {
			$content .= '<h3>' . $form_name . '</h3>';
			$content .= '<h3>Summary of enquiry</h3>';
		}
		$content .= $form_content;

		return $content;
	}

	/**
	 * @param $email
	 * @param $subject
	 * @param $ref_number
	 * @param $content
	 */
	public function send_email( $email, $subject, $ref_number, $content ) {
		if ( is_email( $email ) ) {

			// Email Subject
			$email_subject = $subject . ' ' . $ref_number;

			// Email message
			$email_message = $content;

			// Email header
			$email_headers = 'From: The National Archives (DO NOT REPLY) <no-reply@nationalarchives.gov.uk>';

			wp_mail( $email, $email_subject, $email_message, $email_headers );
		}
	}

	/**
	 * @param string $user
	 *
	 * @return mixed
	 */
	public function get_tna_email( $user = '' ) {
		global $post;
		$meta_user = get_post_meta( $post->ID, 'cf_get_tna_email', true );
		if ( $user ) {
			$contact_user = get_user_by( 'login', $user );
			if ( $contact_user ) {
				$email = $contact_user->user_email;

				return $email;
			} else {
				$email = get_option( 'admin_email' );

				return $email;
			}
		} elseif ( $meta_user ) {
			$contact_user = get_user_by( 'login', $meta_user );
			if ( $contact_user ) {
				$email = $contact_user->user_email;

				return $email;
			} else {
				$email = get_option( 'admin_email' );

				return $email;
			}
		} else {
			$email = get_option( 'admin_email' );

			return $email;
		}
	}

	/**
	 * @param $spam
	 * @param $time
	 * @param $email
	 */
	public function log_spam( $spam, $time, $email ) {
		if ( $spam == 'yes' ) {
			$file = plugin_dir_path( __FILE__ ) . 'spam_log.txt';
			$log  = $time . ' - ' . $email . PHP_EOL;
			file_put_contents( $file, $log, FILE_APPEND );
		}
	}
}