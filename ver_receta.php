<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM recetas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $receta = $result->fetch_assoc();
} else {
    echo "Receta no encontrada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($receta['nombre']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($receta['nombre']); ?></h1>
    <img src="uploads/<?php echo htmlspecialchars($receta['imagen']); ?>" alt="Imagen de la receta">
    <p><?php echo htmlspecialchars($receta['descripcion']); ?></p>
    <h2>Ingredientes</h2>
    <p><?php echo nl2br(htmlspecialchars($receta['ingredientes'])); ?></p>
    <h2>Instrucciones</h2>
    <p><?php echo nl2br(htmlspecialchars($receta['instrucciones'])); ?></p>
    <h2>Ventajas Nutricionales</h2>
    <p><?php echo nl2br(htmlspecialchars($receta['ventajas'])); ?></p>
    <h2>Desventajas Nutricionales</h2>
    <p><?php echo nl2br(htmlspecialchars($receta['desventajas'])); ?></p>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
