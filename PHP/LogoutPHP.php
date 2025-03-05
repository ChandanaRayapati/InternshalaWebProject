<?php
    session_start();
    
    unset($_SESSION['userid']);//All the session variables are unset and destroyed.
    unset($_SESSION['name']);
    unset($_SESSION['email']);
    unset($_SESSION['isLogged']);
    session_destroy();
    header("Location:LoginPHP.php");//User is directed to Login page.
?>

