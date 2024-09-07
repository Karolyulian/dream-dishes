<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Receta</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <?php
        // Conectar a la base de datos
        $conn = new mysqli("localhost", "recetario_user", "123Recetario321", "recetario");

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Obtener el ID de la receta
        $receta_id = $_GET['id'];

        // Obtener los detalles de la receta
        $sql = "SELECT * FROM recetas WHERE id = $receta_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<h1>' . $row["titulo"] . '</h1>';
            echo '<img src="' . $row["imagen"] . '" alt="Imagen de la receta" class="img-fluid">';
            echo '<p>' . $row["descripcion"] . '</p>';
            echo '<p><strong>Ventajas Nutricionales:</strong> ' . $row["ventajas"] . '</p>';
            echo '<p><strong>Desventajas:</strong> ' . $row["desventajas"] . '</p>';
        } else {
            echo "<p>Receta no encontrada.</p>";
        }

        // Mostrar comentarios
        echo '<h2>Comentarios</h2>';
        $sql = "SELECT * FROM comentarios WHERE receta_id = $receta_id ORDER BY fecha DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="comment">';
                echo '<p><strong>' . $row["usuario"] . ':</strong> ' . $row["comentario"] . '</p>';
                echo '<p class="text-muted"><small>' . $row["fecha"] . '</small></p>';
                echo '</div>';
            }
        } else {
            echo "<p>No hay comentarios todavía. ¡Sé el primero en comentar!</p>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>

        <h2>Agregar un Comentario</h2>
        <form action="agregar_comentario.php" method="post">
            <input type="hidden" name="receta_id" value="<?php echo $receta_id; ?>">
            <div class="form-group">
                <label for="usuario">Nombre:</label>
                <input type="text" id="usuario" name="usuario" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="comentario">Comentario:</label>
                <textarea id="comentario" name="comentario" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Enviar Comentario</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+Eu1tmIkp6e28qx0P5nKAYjUml+2g" crossorigin="anonymous"></script>
</body>
</html>
