<?php
    // My modifications to mailer script from:
    // http://blog.teamtreehouse.com/create-ajax-contact-form
    // Added input sanitizing to prevent injection

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $fname = strip_tags(trim($_POST["firstname"]));
            $fname = preg_replace("/[^a-zA-Z]/", "", $fname);
				$fname = str_replace(array("\r","\n"),array(" "," "),$fname);
        $lname = strip_tags(trim($_POST["lastname"]));
            $lname = preg_replace("/[^a-zA-Z]/", "", $lname);
                $lname = str_replace(array("\r","\n"),array(" "," "),$lname);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        //$message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($fname) OR empty($lname) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        //$recipient = "wheublein@gmail.com";
        $recipient = "none@test.org";

        // Set the email subject.
        $subject = "New kiosk TMMC Newsletter signup from $fname $lname";

        // Build the email content.

        $email_content = "There is a new TMMC Newsletter signup from the kiosk.";
        $email_content .= "\n\n";        
        $email_content .= "Name: $fname $lname\n";
        $email_content .= "Email: $email\n\n";
        //$email_content .= "Message:\n$message\n";
        $email_content .= "\n\n";
        $email_content .= "http://www.marinemammalcenter.org/Get-Involved/take-action/email-signup-ipad.html";
        // Build the email headers.
        $email_headers = "From: $fname $lname <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
