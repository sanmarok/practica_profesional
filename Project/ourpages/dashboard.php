<?php
session_start();
if (isset($_SESSION['id'])) {
    echo "ID: " . $_SESSION['id'] . "<br>";
    echo "Nombre: " . $_SESSION['first_name'] . "<br>";
    echo "Apellido: " . $_SESSION['last_name'] . "<br>";
    echo "Rol: " . $_SESSION['role'] . "<br>";
} else {
    header('Location: authentication.php');
    exit();
}
?>

