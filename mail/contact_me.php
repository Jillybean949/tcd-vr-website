<?php
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "No arguments Provided!";
   return false;
   }
   
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));
   
// Create the email and send the message
$to = 'jiegan@tcd.ie'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Website Contact Form:  $name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
$headers = "From: noreply@trinityvr.online\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";   
// Don't send email yet. Only send if both DB works and email

// Check for empty fields
$servername = "localhost";
$username = "vruser";
$password = "idmteam4";
$dbname = "vr";

// Create Connection to db
$conn = new mysqli($servername, $username, $password, $dbname);
// Check the connection
if ($conn->connect_error) {
	return false;
}

// Prepare statement and bind values
$stmt = $conn->prepare("INSERT INTO Messages (name, email, phone, message) VALUES (?, ?, ?, ?)");

$stmt->bind_param("ssss", $name, $email_address, $phone, $message);
$stmt->execute();
$stmt->close();
$conn->close();

// DB INSERT worked, now send the email
mail($to,$email_subject,$email_body,$headers);

return true;   
?>