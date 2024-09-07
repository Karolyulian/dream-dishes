<?php
$servername = "localhost";
$username = "recetario";
$password = "123Recetario321";
$dbname = "recetario";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
