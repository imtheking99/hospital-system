<?php
// start Session 
session_start();

//erase all session variables
session_unset();

//destroy session
session_destroy();

//redirect to login page with a status message

header("Location: ../index.php?status=loggedout");
exit();
?>