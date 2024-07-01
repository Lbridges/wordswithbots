<?php
add_action( 'admin_post_nopriv_my_form_handler', 'my_form_handler_function' );

function my_form_handler_function() {

  // Check if form is submitted
  if ( ! isset( $_POST['my_form_nonce'] ) || ! wp_verify_nonce( $_POST['my_form_nonce'], 'my_form_action' ) ) {
    die( 'Security check failed.' );
  }

  // Get form data
  $name = sanitize_text_field( $_POST['name'] );
  $email = sanitize_email( $_POST['email'] );
  $message = sanitize_textarea_field( $_POST['message'] );

  // Prepare email content
  $email_body = "**Name:** $name\n";
  $email_body .= "**Email:** $email\n";
  $email_body .= "**Message:** $message\n";

  // Set email headers
  $headers = array(
    'From' => 'Your Name <your_email@example.com>',
    'Subject' => 'Form Submission - My Website',
    'Content-Type' => 'text/plain',
  );

  // Send email
  $result = wp_mail( 'recipient_email@example.com', $headers['Subject'], $email_body, $headers );

  // Display success or error message based on wp_mail result
  if ( $result ) {
    echo 'Thank you for contacting us! Your message has been sent.';
  } else {
    echo 'There was an error sending your message. Please try again later.';
  }

  die(); // Exit after processing
}
