<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "recetario";
$password = "123Recetario321";
$dbname = "recetario";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID de la receta desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consulta SQL para obtener los detalles de la receta
$sql = "SELECT nombre, imagen, descripcion, ingredientes, instrucciones, ventajas, desventajas FROM recetas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nombre, $imagen, $descripcion, $ingredientes, $instrucciones, $ventajas, $desventajas);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Receta de <?php echo htmlspecialchars($nombre); ?> - Dream Dishes</title>
</head>
<body>
    <header>
        <img src="imagenes/Cream and Gray Modern New Fashion ETSY shop cover.png" alt="Logo Dream Dishes" class="logo">
        <h1><?php echo htmlspecialchars($nombre); ?></h1>
        <nav>
            <ul>
                <li><a href="Index.html">Inicio</a></li>
                <li><a href="Recetas.php">Recetas</a></li>
                <li><a href="Acerca_de.html">Acerca de</a></li>
                <li><a href="Contacto.html">Contacto</a></li>
                <li><a href="Terminos_condiciones.html">Términos y Condiciones</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="receta">
            <!-- Imagen flotante -->
            <img src="imagenes/<?php echo htmlspecialchars($imagen); ?>" alt="<?php echo htmlspecialchars($nombre); ?>" class="imagen-flotante">
            
            <h2>Descripción:</h2>
            <p><?php echo nl2br(htmlspecialchars($descripcion)); ?></p>
            
            <h2>Ingredientes:</h2>
            <ul>
                <?php
                $ingredientesArray = explode("\n", $ingredientes);
                foreach ($ingredientesArray as $ingrediente) {
                    if (!empty(trim($ingrediente))) {
                        echo "<li>" . htmlspecialchars($ingrediente) . "</li>";
                    }
                }
                ?>
            </ul>
            
            <h2>Instrucciones:</h2>
            <ol>
                <?php
                $instruccionesArray = explode("\n", $instrucciones);
                foreach ($instruccionesArray as $instruccion) {
                    if (!empty(trim($instruccion))) {
                        echo "<li>" . htmlspecialchars($instruccion) . "</li>";
                    }
                }
                ?>
            </ol>

            <?php if (!empty($ventajas)): ?>
            <h2>Ventajas Nutricionales:</h2>
            <ul>
                <?php
                $ventajasArray = explode("\n", $ventajas);
                foreach ($ventajasArray as $ventaja) {
                    if (!empty(trim($ventaja))) {
                        echo "<li>" . htmlspecialchars($ventaja) . "</li>";
                    }
                }
                ?>
            </ul>
            <?php endif; ?>

            <?php if (!empty($desventajas)): ?>
            <h2>Desventajas Nutricionales:</h2>
            <ul>
                <?php
                $desventajasArray = explode("\n", $desventajas);
                foreach ($desventajasArray as $desventaja) {
                    if (!empty(trim($desventaja))) {
                        echo "<li>" . htmlspecialchars($desventaja) . "</li>";
                    }
                }
                ?>
            </ul>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 Dream Dishes</p>
    </footer>
</body>
</html>
