<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dream Dishes - Recetas</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header>
        <img src="imagenes/Cream and Gray Modern New Fashion ETSY shop cover.png" alt="Logo Dream Dishes" class="logo">
        <h1>Recetario de Dream Dishes</h1>
        <nav>
            <ul>
                <li><a href="Index.html">Inicio</a></li>
                <li><a href="Recetas.php">Recetas</a></li>
                <li><a href="Acerca de.html">Acerca de</a></li>
                <li><a href="Contacto.html">Contacto</a></li>
                <li><a href="Politica_Privacidad.html">Política de Privacidad</a></li>
                <li><a href="Terminos_condiciones.html">Términos y Condiciones</a></li>
                <li><a href="login.html">Iniciar Sesión</a></li>
                <li><a href="register.html">Registrarse</a></li>
            </ul>
        </nav>
    </header>

    <main class="container mt-5">
        <div class="row">
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

            // Consulta SQL para obtener las recetas
            $sql = "SELECT id, nombre, imagen, descripcion FROM recetas";
            $result = $conn->query($sql);

            // Mostrar las recetas si hay resultados
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="imagenes/' . $row["imagen"] . '" class="card-img-top" alt="' . $row["nombre"] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row["nombre"] . '</h5>';
                    echo '<p class="card-text">' . $row["descripcion"] . '</p>';
                    echo '<a href="detalle_receta.php?id=' . $row["id"] . '" class="btn btn-primary">Ver receta</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay recetas disponibles.</p>';
            }

            // Cerrar la conexión
            $conn->close();
            ?>
        </div>
    </main>
</body>
</html>
