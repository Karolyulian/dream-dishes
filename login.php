<?php
session_start();
include 'db_connect.php';

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $email = $conn->real_escape_string($_POST['email']);
    $contraseña = $_POST['contraseña'];

    // Verificar si el usuario existe
    $sql = "SELECT id, nombre, contraseña FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener los datos del usuario
        $row = $result->fetch_assoc();
        $hash = $row['contraseña'];

        // Verificar la contraseña
        if (password_verify($contraseña, $hash)) {
            // Iniciar sesión y redirigir al recetario
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            header("Location: recetario.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró una cuenta con ese correo electrónico.";
    }

    $stmt->close();
}

$conn->close();
?>
