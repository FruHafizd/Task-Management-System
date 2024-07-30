<?php
session_start();

if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Please Login To Acces";
    header("Location: ../views/login.php");
    exit(0);
} else {
    # code...
}
