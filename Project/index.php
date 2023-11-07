<?php
session_start();
if (isset($_SESSION['id'])) {
    header('Location: ourpages/dashboard.php');
    exit();
} else {
    header('Location: ourpages/authentication.php');
    exit();
}
