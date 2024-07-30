<?php
session_start();
session_unset();
session_destroy();
unset($_SESSION['authenticated']);
unset($_SESSION['auth_user']);
$_SESSION['status'] = "You Logout Succesfully";
header("Location: ../views/login.php");