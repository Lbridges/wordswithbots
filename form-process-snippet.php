<?php

// Function to generate CRM content table
function generateCRMcontent($postInfo) {
  $table = "<table>";
  $table .= "<tr><td>First Name:</td><td>" . $postInfo->firstName . "</td></tr>";
  $table .= "<tr><td>Last Name:</td><td>" . $postInfo->lastName . "</td></tr>";
  $table .= "<tr><td>Email:</td><td>" . $postInfo->email . "</td></tr>";
  $table .= "<tr><td>Phone Number:</td><td>" . $postInfo->phone . "</td></tr>";
  $table .= "<tr><td>Zip Code:</td><td>" . $postInfo->zipcode . "</td></tr>";
  $table .= "</table>";
  return $table;
}

// Function to write content to a file
function writeToFile($fileLocation, $content) {
  $handle = fopen($fileLocation, 'w'); // Open file for writing
  fwrite($handle, $content); // Write content to file
  fclose($handle); // Close the file
}

// Function to save form data as JSON
function saveToFile($object) {
  // Generate unique ID
  $uniqueID = random_int(PHP_INT_MIN, PHP_INT_MAX);

  // Define file path and name
  $fileLocation = '/user/forms/';
  $fileName = 'formData' . $uniqueID . '.json';
  $fullPath = $fileLocation . $fileName;

  // Check and create directory if needed
  if (!is_dir($fileLocation)) {
    mkdir($fileLocation, 0777, true); // Create directory with permissions
  }

  // Check if file exists, append data if it does, otherwise write as new object
  if (file_exists($fullPath)) {
    $fileContent = file_get_contents($fullPath);
    $jsonObject = json_decode($fileContent);
    $jsonObject[] = $object;
    $writeContent = json_encode($jsonObject);
  } else {
    $writeContent = json_encode($object);
  }

  writeToFile($fullPath, $writeContent); // Save data to file
}

// Class for Request Information (optional)
class RequestInfo {
  public $firstName;
  public $lastName;
  public $email;
  public $phone;
  public $zipcode;
  public $CRMcontent;

  function __construct($postData) {
    $this->firstName = $postData['firstName'];
    $this->lastName = $postData['lastName'];
    $this->email = $postData['email'];
    $this->phone = $postData['phone'];
    $this->zipcode = $postData['zipcode'];
  }
}

// Function to process form submission
if (isset($_POST)) {

  // Create RequestInfo object (optional)
  $jsonInfo = new RequestInfo($_POST);

  // Generate CRM content table
  $table = generateCRMcontent($jsonInfo);
  $jsonInfo->CRMcontent = $table;

  // Create a new FormJson object (optional)
  $toSave = new FormJson(array(
    "label" => $jsonInfo->valueForLabel, // Replace with function to get label from field name
    "firstName" => $jsonInfo->firstName,
    "lastName" => $jsonInfo->lastName,
    "email" => $jsonInfo->email,
    "phone" => $jsonInfo->phone,
    "zipcode" => $jsonInfo->zipcode,
    "CRMcontent" => $jsonInfo->CRMcontent
  ));

  // Log information for debugging (optional)
  write_log(json_encode($jsonInfo));
  write_log(json_encode($toSave));

  // Save form data to JSON file
  saveToFile($toSave);

  // Redirect to confirmation page
  header('Location: ' . $_POST["confirmationURL"]);
  die();
}

// Class for FormJson data (optional)
class FormJson {
  public $label;
  public $firstName;
  public $lastName;
  public $email;
  public $phone;
  public $zipcode;
  public $CRMcontent;

  function __construct($formData) {
    $this->label = $formData['label'];
    $this->firstName = $formData['firstName'];
    $lastName = $formData['lastName'];
    $this->email = $formData['email'];
    $this->phone = $formData['phone'];
    $this->zipcode = $formData['zipcode'];
    $this->CRMcontent = $formData['CRMcontent'];
  }
}
// Explanation:

// The if (isset($_POST)) block checks if the form has been submitted.
// A FormJson class is introduced (optional) to hold the form data in a structured format.
// The script creates a new FormJson object with all the submitted data.
// You can replace "label" => $jsonInfo->valueForLabel with a function to dynamically determine the label based on the field name.
// write_log functions are used for debugging purposes (optional, implement your logging mechanism).
// The script calls saveToFile to save the $toSave object as a JSON file.
// Finally, it redirects the user to the confirmation URL specified in the hidden field and terminates the script execution with die().
// Note:

// This code uses basic file handling and assumes write permissions on the /user/forms/ directory. You might need to adjust permissions or use a different storage method based on your specific needs.
// The write_log function and RequestInfo class are optional and can be removed if not needed.
