<?php
include 'config/setup.php';

echo "Hello World!";
try {

}
catch(PDOException $e) {
    die("ERROR:  " . $e->getMessage() . "<br /><br />");
}

?>
