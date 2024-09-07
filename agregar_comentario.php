<?php
// Conectar a la base de datos
$conn = new mysqli("localhost", "recetario_user", "123Recetario321", "recetario");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$receta_id = $_POST['receta_id'];
$usuario = $_POST['usuario'];
$comentario = $_POST['comentario'];

// Insertar el comentario en la base de datos
$sql = "INSERT INTO comentarios (receta_id, usuario, comentario) VALUES ($receta_id, '$usuario', '$comentario')";
if ($conn->query($sql) === TRUE) {
    echo "Comentario agregado con éxito";
} else {
    echo "Error al agregar el comentario: " . $conn->error;
}

// Cerrar la conexión
$conn->close();

// Redirigir de vuelta a la página de detalles de la receta
header("Location: detalles_receta.php?id=" . $receta_id);
exit();
?>
