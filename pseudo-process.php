<?php

// Include your JWT generation and validation functions (replace with actual implementation)
require_once('jwt_functions.php');

// Function to validate form submission
function validateSubmission($obj) {
  if (!isset($obj)) {
    throw new FormSubmissionException("Empty post object");
  }
  validateForUrlInSubmission($obj);
  validateNotBlank($obj);
  validateSQLInjection($obj);
  // Add any other custom validation logic here
}

// Function to validate for URLs in input fields
function validateForUrlInSubmission($obj) {
  $pattern = '/^(http|https):\/\/[^\s]+$/';
  foreach ($obj as $key => $value) {
    if (preg_match($pattern, $value)) {
      throw new FormSubmissionException("URLs are not allowed in field: $key");
    }
  }
}

// Function to validate for empty fields
function validateNotBlank($obj) {
  foreach ($obj as $key => $value) {
    if (empty($value)) {
      throw new FormSubmissionException("Field cannot be blank: $key");
    }
  }
}

// Function to validate for SQL injection attempts
function validateSQLInjection($obj) {
  $pattern = '/(select|sleep|;|nslookup|response\.write|exec|xp_dirtree|host=|concat|waitfor|nsfw|dblink_connect|trace\.axd|gethostbyname)/i';
  foreach ($obj as $key => $value) {
    if (preg_match($pattern, $value)) {
      throw new FormSubmissionException("Possible SQL injection attempt in field: $key");
    }
  }
}

// Function to handle form with JWT token
function handle_form_with_token() {
  try {
    validateSubmission($_POST);

    $headers = array('alg' => 'H256', 'typ' => 'JWT');
    $payload = array(
      'title' => $_POST['title'],
      'firstName' => $_POST['firstName'],
      // ... add other form data to payload
    );

    // Replace with your actual JWT generation function
    $jwt = generate_jwt($headers, $payload, 'Secret_ExampleKey');
    write_log($jwt);

    $url = 'https://your-server.com/api/endpoint'; // Replace with your API endpoint

    $options = array(
      'header' => "Content-type: application/json\r\n",
      'method' => 'POST',
      "content" => json_encode($payload),
      // Add JWT authorization header
      'http' => array(
        'Authorization' => "Bearer $jwt"
      ),
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);

    // Handle the API response here (success or error)
  } catch (FormSubmissionException $e) {
    write_log($e->getMessage());
    // Handle form validation errors (e.g., display error messages)
  }
}

// Function to handle form submission (original logic)
function handle_form() {
  if (validateSubmission($_POST)) {
    write_log("New Form Submission");
    // ... rest of your original form processing code (generate CRM table, etc.)
  }
}

// ... rest of your code (including saveToFile function)

// Check if JWT token is present and call appropriate function
if (isset($_POST['jwt'])) {
  handle_form_with_token();
} else {
  handle_form();
}
