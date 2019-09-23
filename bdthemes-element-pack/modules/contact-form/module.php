<?php
namespace ElementPack\Modules\ContactForm;

use ElementPack\Base\Element_Pack_Module_Base;
use ElementPack\Classes\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Element_Pack_Module_Base {

	public function __construct() {
		parent::__construct();

		add_action('wp_ajax_element_pack_contact_form', [$this, 'contact_form']);
		add_action('wp_ajax_nopriv_element_pack_contact_form', [$this, 'contact_form']);
	}

	public function get_name() {
		return 'contact-form';
	}

	public function get_widgets() {

		$widgets = ['Contact_Form'];

		return $widgets;
	}


	public function contact_form() {

		$email         = get_bloginfo( 'admin_email' );
		$error_empty   = esc_html__("Please fill in all the required fields.", "bdthemes-element-pack");
		$error_noemail = esc_html__("Please enter a valid e-mail address.", "bdthemes-element-pack");
		$success       = esc_html__("Thanks for your e-mail! We'll get back to you as soon as we can.", "bdthemes-element-pack");

	    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$error = false;
			// set the "required fields" to check
			$required_fields = array( "name", "email", "message", "subject" );
			
			// this part fetches everything that has been POSTed, sanitizes them and lets us use them as $form_data['subject']
			foreach ( $_POST as $field => $value ) {
			    if ( get_magic_quotes_gpc() ) {
			        $value = stripslashes( $value );
			    }
			    $form_data[$field] = strip_tags( $value );
			}
			
			// if the required fields are empty, switch $error to TRUE and set the result text to the shortcode attribute named 'error_empty'
			foreach ( $required_fields as $required_field ) {
			    $value = trim( $form_data[$required_field] );
			    if ( empty( $value ) ) {
			        $error = true;
			        $result = $error_empty;
			    }
			}


			// and if the e-mail is not valid, switch $error to TRUE and set the result text to the shortcode attribute named 'error_noemail'
			if ( ! is_email( $form_data['email'] ) ) {
			    $error = true;
			    $result = $error_noemail;
			}

			// but if $error is still FALSE, put together the POSTed variables and send the e-mail!
			if ( $error == false ) {
			    // get the website's name and puts it in front of the subject
			    $email_subject = "[" . get_bloginfo( 'name' ) . "] " . $form_data['subject'];
			    // get the message from the form and add the IP address of the user below it
			    $email_message = $this->message_html($form_data['message'], $form_data['name'], $form_data['email']);
			    // set the e-mail headers with the user's name, e-mail address and character encoding
			    $headers  = "From: " . $form_data['name'] . " <" . $form_data['email'] . ">\n";
			    $headers .= "Content-Type: text/html; charset=UTF-8\n";
			    $headers .= "Content-Transfer-Encoding: 8bit\n";
			    // send the e-mail with the shortcode attribute named 'email' and the POSTed data
			    wp_mail( $email, $email_subject, $email_message, $headers );
			    // and set the result text to the shortcode attribute named 'success'
			    $result = $success;
			    // ...and switch the $sent variable to TRUE
			    $sent = true;
			}
	    	
	    	if ($error == false ) {
		    	echo '<span class="bdt-text-success">' . $success . '</span>';
	    	} else {
	    		echo '<span class="bdt-text-warning">' . $result . '</span>';
	    	}
		}

	    die;
	}


	public function message_html($message, $name, $email) {
		$fullmsg  = "<html><body style='background-color: #f5f5f5; padding: 35px;'>";
		$fullmsg .= "<div style='max-width: 768px; margin: 0 auto; background-color: #fff; padding: 50px 35px;'>";
		$fullmsg .= nl2br($message);
		$fullmsg .= "<br><br>";
		$fullmsg .= "<b>" . $name . "<b><br>";
		$fullmsg .= $email . "<br>";
		$fullmsg .= "<em>IP: " . Utils::get_client_ip() . "</em>";
		$fullmsg .= "</div>";
		$fullmsg .= "</body></html>";

		return $fullmsg;
	}

}
