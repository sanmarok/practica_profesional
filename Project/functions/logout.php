<?php
session_start();
if (isset($_SESSION['id'])) {
    session_destroy();
    header('Location: ../ourpages/authentication.php');
} else {
    header('Location: ../ourpages/authentication.php');
    exit();
}
