<?php

    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])){
        return 'FALSE';
    }
    $toEmail = "email@email.com";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $mailHeaders = "From: " . $name . "<". $email .">\r\n";
    if(mail($toEmail, "ContactForm - " . $mailHeaders, $message, $mailHeaders)) {
        return 'TRUE';	
    } else {
        return 'FALSE';
    }

?>