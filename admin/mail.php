<?php

function sendVerificationEmail($user,$email,$password,$token) {

    $subject = "Account Verification";
    $message = '
    
    Thanks for signing up!
    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
    
    ------------------------
    Username: '.$user.'
    Password: '.$password.'
    ------------------------
    
    Please click this link to activate your account:
    http://localhost:8080/camagru/admin/verify_reg.php?token='.$token.'
    
    ';
    $headers = "From: Camagru Admin <keke.orava83@gmail.com>\n";

    mail($email, $subject, $message, $headers);
}

?>
