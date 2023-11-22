# Phone Validation Plugin

**
Plugin Name:** Phone Validation Plugin  
Plugin URI: https://example.com/phone-validation-plugin  
Description: A simple plugin to validate phone numbers using International Telephone Input.  
Version: 1.0.0  
Author: Bard  
Author URI: https://example.com  
License: GPLv2 or later  
**
## Description:  
This plugin provides real-time validation of phone numbers using International Telephone Input. It ensures that users enter valid phone numbers before submitting forms.

## Features:
Real-time phone number validation using International Telephone Input  
Conditional resource loading to improve page load performance  
Submit button control based on phone number validity and other required fields  
User-friendly error messages and visual feedback  

## Installation:
Upload the plugin folder to your WordPress plugins directory.  
Activate the plugin from the Plugins menu in your WordPress dashboard.  
Add the target form element to your theme or page.  
Customize the phone input field with the appropriate class or ID.  

## Usage:
The plugin automatically initializes International Telephone Input for the specified phone input field.  
Phone number validation occurs on blur and form submission.  
Submit button is disabled until all required fields, including the phone number, are valid.  

## Example Usage:
      <form id="phone-validation-form">  
        <label for="name">Name:</label>  
        <input type="text" id="name">  
        <br>  
        <label for="email">Email:</label>  
        <input type="email" id="email">  
        <br>  
        <label for="phone">Phone Number:</label>  
        <input type="tel" id="phone">  
        <span id="phoneError"></span>  
        <br>  
        <button type="submit">Submit</button>  
      </form>  

### Additional Notes:

The plugin works with any theme or page that includes the target form element.  
The plugin can be customized to support additional validation rules and error messages.  
The plugin can be integrated with other form plugins for enhanced form functionality.  

### Support:
For any questions or issues related to the plugin, please create a new topic on the WordPress support forums.

#### Contributing:
We welcome contributions to improve the plugin. Please create a pull request on the GitHub repository.

##### Credits:
International Telephone Input library for phone number formatting and validation  
WordPress community for providing a great platform for plugin development
