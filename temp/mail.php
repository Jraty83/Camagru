<?PHP

$sender = 'keke.orava83@gmail.com';
$recipient = 'kerkkoinen@gmail.com';

$subject = "just another test mail using mail()";
$message = "seems to be working";
$headers = 'From:' . $sender;

try {
    mail($recipient, $subject, $message, $headers);
    echo "Verification email sent";
} catch(PDOException $e) {
    die("ERROR: email not sent. " . $e->getMessage() . "<br>");
}
?>
