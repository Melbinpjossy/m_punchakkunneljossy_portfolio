<?php

if(isset($_POST['submit'])){
    $to = "stfox003@gmail.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $subject = $_POST['subject'];
    $subject2 = "SuperiorGlass - Thank you for reaching us.";
    $message = $first_name . " " . $last_name ." with the Phone number: ". isset($_POST['phone']) ? $_POST['phone'] : "N/A" . " wrote the following:" . "\n\n" . $_POST['message'];
    $message2 = "Here is a copy of your message " . $first_name . "\n\n" . "Our Representatives are reviewing you query and will get back to you ASAP.";

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    if (mail($to,$subject,$message,$headers)) {
        // sends a copy of the message to the sender
        if (mail($from,$subject2,$message2,$headers2)) {
            echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly. <br> <a href='/'>Get Back To Home</a>";
        } else {
            echo "Something Went Wrong try again Later <br> <a href='/'>Get Back To Home</a>";
        }
    } else {
        echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly. <br> <a href='/'>Get Back To Home</a>";
    }


    // You can also use header('Location: thank_you.php'); to redirect to another page.
}