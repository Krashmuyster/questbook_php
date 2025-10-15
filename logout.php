<?php
require_once 'config.php';

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

unset($_SESSION['user']);
unset($_SESSION['loggedin']);

header("Location: index.php");
exit;
?>