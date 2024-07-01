<?php

add_action( 'add_meta_boxes', 'survey_email_metabox' );

function survey_email_metabox() {
  global $post;

  // Check if the post is a child of the 'survey' page
  $is_survey_page = $post->post_parent && wp_get_post_parent_id( $post->ID ) === get_id_by_slug( 'survey' );

  if ( $is_survey_page ) {
    add_meta_box(
      'travel_survey_email_metabox', // Unique ID
      'Recipient Email Address', // Title
      'survey_email_metabox_callback', // Callback function
      'page', // Applies to pages
      'side', // Position
      'high' // Priority
    );
  }
}

// Callback function to display metabox content
function survey_email_metabox_callback( $post ) {
  $recipient_email = get_post_meta( $post->ID, 'travel_survey_recipient_email', true ); // Get saved email
  ?>
  <p>
    <label for="travel_survey_recipient_email">Enter recipient email address:</label>
    <input type="email" name="travel_survey_recipient_email" id="travel_survey_recipient_email" value="<?php echo esc_attr( $recipient_email ); ?>">
  </p>
  <?php
}

// Save metabox data on post save
add_action( 'save_post', 'survey_email_save_metabox_data' );

function survey_email_save_metabox_data( $post_id ) {

  // Verify nonce and capability (if applicable)
  if ( ! wp_verify_nonce( $_POST['travel_survey_nonce'], 'travel_survey_action' ) ) return;
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; // Don't save on autosave

  // Sanitize and save email address
  $recipient_email = sanitize_email( $_POST['travel_survey_recipient_email'] );
  update_post_meta( $post_id, 'travel_survey_recipient_email', $recipient_email );
}

// Helper function to get post ID by slug
function get_id_by_slug( $slug ) {
  $page = get_page_by_path( $slug );
  if ( $page ) {
    return $page->ID;
  } else {
    return null;
  }
}


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
  $recipient_emails = array();
  for ($i = 1; $i <= 3; $i++ ) {
    $email = $_POST[' recipient_email_' . $i ] );
    if ( !empty( $email ) ) {
      $recipient_emails[] = $email;
    }
  }
  if ( empty( $recipient_emails ) ) {
    $recipient_emails[] = get_option( 'admin_email' );
  }

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
  foreach ( $recipient_emails as $email ) {
    $headers[] = 'Bcc: ' . $email;
  }

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
