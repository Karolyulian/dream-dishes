<?php
session_start();
include 'db_connect.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener el nombre del usuario
$sql_user = "SELECT nombre FROM usuarios WHERE id = '$usuario_id'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();

// Obtener las recetas del usuario
$sql = "SELECT * FROM recetas WHERE usuario_id = '$usuario_id' ORDER BY fecha_creacion DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Recetas</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlace a tu archivo CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet"> <!-- Google Fonts -->
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?>!</h1>
        <p>Este es tu recetario privado.</p>
        <a href="agregar_receta.html" class="btn">Agregar Nueva Receta</a>
    </header>
    <main>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='receta'>";
                echo "<h2>" . htmlspecialchars($row['titulo']) . "</h2>";
                echo "<p><strong>Descripción:</strong> " . htmlspecialchars($row['descripcion']) . "</p>";
                echo "<img src='uploads/" . htmlspecialchars($row['imagen']) . "' alt='" . htmlspecialchars($row['titulo']) . "' style='width:200px;height:auto;'><br>";
                echo "<p><strong>Ventajas Nutricionales:</strong> " . htmlspecialchars($row['ventajas_nutricionales']) . "</p>";
                echo "<p><strong>Desventajas:</strong> " . htmlspecialchars($row['desventajas']) . "</p>";
                echo "<a href='compartir.php?receta_id=" . $row['id'] . "' class='btn'>Compartir</a><br>";
                echo "<hr>";
                echo "</div>";
            }
        } else {
            echo "<p>No has agregado ninguna receta todavía.</p>";
        }
        ?>
    </main>
</body>
</html>

<?php
$conn->close();
?>
