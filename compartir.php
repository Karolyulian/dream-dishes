<?php
session_start();
include 'db_connect.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

$receta_id = intval($_GET['receta_id']);
$usuario_id = $_SESSION['usuario_id'];

// Obtener la receta
$sql = "SELECT * FROM recetas WHERE id = '$receta_id' AND usuario_id = '$usuario_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $receta = $result->fetch_assoc();
    // Aquí podrías agregar código para compartir la receta, como enviarla por correo electrónico, etc.
    echo "<h2>Compartir Receta</h2>";
    echo "<p>Receta para compartir:</p>";
    echo "<h3>" . htmlspecialchars($receta['titulo']) . "</h3>";
    echo "<p><strong>Descripción:</strong> " . htmlspecialchars($receta['descripcion']) . "</p>";
    echo "<img src='uploads/" . htmlspecialchars($receta['imagen']) . "' alt='" . htmlspecialchars($receta['titulo']) . "' style='width:200px;height:auto;'><br>";
    echo "<p><strong>Ventajas Nutricionales:</strong> " . htmlspecialchars($receta['ventajas_nutricionales']) . "</p>";
    echo "<p><strong>Desventajas:</strong> " . htmlspecialchars($receta['desventajas']) . "</p>";

    // Ejemplo de formulario para enviar la receta por correo electrónico
    echo "<h4>Compartir por Correo Electrónico</h4>";
    echo "<form action='enviar_correo.php' method='POST'>";
    echo "<input type='hidden' name='receta_id' value='" . $receta_id . "'>";
    echo "<label for='email'>Correo Electrónico:</label>";
    echo "<input type='email' id='email' name='email' required>";
    echo "<button type='submit'>Enviar</button>";
    echo "</form>";
} else {
    echo "No tienes permiso para compartir esta receta.";
}

$conn->close();
?>
