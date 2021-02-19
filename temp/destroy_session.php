<?php
try {
	session_start();
	session_unset();
	session_destroy();
	echo "SESSION succesfully destroyed";
} catch(Exception $e) {
	echo "ERROR" , $e->getMessage();
}
