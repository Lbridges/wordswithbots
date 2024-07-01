<?php
add_action( 'admin_post_nopriv_travel_survey_handler', 'travel_survey_handler_function' );

function travel_survey_handler_function() {

  // Check if form is submitted
  if ( ! isset( $_POST['travel_survey_nonce'] ) || ! wp_verify_nonce( $_POST['travel_survey_nonce'], 'travel_survey_action' ) ) {
    die( 'Security check failed.' );
  }

  // Get form data
  $travel_preference = ( $_POST['travel_preference'] );
  $travel_frequency = ( $_POST['travel_frequency'] );
  $destinations_checked = ( $_POST['destinations_checked'] );
  $fname = sanitize_text_field( $_POST['fname'] );
  $lname = sanitize_text_field( $_POST['lname'] );
  $age = ( $_POST['age'] );
  $married = ( $_POST['married'] );
  $income = ( $_POST['income'] );
  $country = ( $_POST['country'] );
  $income = ( $_POST['phone'] );
  $email = sanitize_email( $_POST['email'] );

  // Prepare email content
  $email_body .= "**Travel Preference:** $travel_preference\n";
  $email_body .= "**Travel Frequency:** $travel_frequency\n";
  $email_body .= "**Destinations Checked:** $destinations_checked\n";  
  $email_body = "**First Name:** $fname\n";
  $email_body = "**Last Name:** $lname\n";
  $email_body .= "**Age:** $age\n";
  $email_body .= "**Married:** $married\n";
  $email_body .= "**Income:** $income\n";
  $email_body .= "**Country:** $country\n";
  $email_body .= "**Phone:** $phone\n";
  $email_body .= "**Email:** $email\n";

  // Set email headers
  $headers = array(
    'From' => 'Your Name <your_email@example.com>',
    'Subject' => 'Travel Survey',
    'Content-Type' => 'text/plain',
  );

  // Send email
  $result = wp_mail( 'recipient_email@example.com', $headers['Subject'], $email_body, $headers );

  // Display success or error message based on wp_mail result
  if ( $result ) {
    echo 'Thank you for taking the survey.';
  } else {
    echo 'There was an error with our survey. Please try again later.';
  }

  die(); // Exit after processing
}
