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
    http://localhost:8080/camagru/admin/verify_reg.php?email='.$email.'&token='.$token.'
    
    ';
    $headers = "From: Camagru Admin <keke.orava83@gmail.com>\n";

    mail($email, $subject, $message, $headers);
    // echo "Verification email sent";
}

function sendActivatedEmail($email) {

    $subject = "Account Activated";
    $message = '
    
    Congratulations!

    Your account has now been activated and you can login by pressing the url below:
    http://localhost:8080/camagru/user/login.php

    ';
    $headers = "From: Camagru Admin <keke.orava83@gmail.com>\n";

    mail($email, $subject, $message, $headers);
}

function sendPasswordResetEmail($email,$token) {
    $subject = "Password reset requested";
    $message = '
    
    Forgot your password? Press the url below to reset your password:
    http://localhost:8080/camagru/user/reset_pass.php?token='.$token.'

    ';
    $headers = "From: Camagru Admin <keke.orava83@gmail.com>\n";

    mail($email, $subject, $message, $headers);
    // echo "Password reset link sent";
}

function sendPasswordChangedEmail($user,$email,$password) {

    $subject = "Password changed";
    $message = '
    
    Your password has been changed, you can now login with the following credentials.
    
    ------------------------
    Username: '.$user.'
    Password: '.$password.'
    ------------------------
    
    Back to login by pressing the url below:
    http://localhost:8080/camagru/user/login.php

    ';
    $headers = "From: Camagru Admin <keke.orava83@gmail.com>\n";

    mail($email, $subject, $message, $headers);
    // echo "Password changed";
}

function sendCommentedEmail($email,$file) {

    $subject = "Your picture received a new comment";
    $message = '
    
    Hi!

    Someone commented your photo '.$file.', you can go check it out by pressing the url below:
    http://localhost:8080/camagru/index.php

    ';
    $headers = "From: Camagru Admin <keke.orava83@gmail.com>\n";

    mail($email, $subject, $message, $headers);
    // echo "EmailNotification sent";
}

?>
