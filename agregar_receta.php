<?php
session_start();
include 'db_connect.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $nombre = $conn->real_escape_string(trim($_POST['titulo']));
    $descripcion = $conn->real_escape_string(trim($_POST['descripcion']));
    $ingredientes = $conn->real_escape_string(trim($_POST['ingredientes']));
    $instrucciones = $conn->real_escape_string(trim($_POST['instrucciones']));
    $ventajas = $conn->real_escape_string(trim($_POST['ventajas']));
    $desventajas = $conn->real_escape_string(trim($_POST['desventajas']));
    
    // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen_nombre = basename($_FILES['imagen']['name']);
        $imagen_ruta = 'uploads/' . $imagen_nombre;
        
        // Mover la imagen al directorio 'uploads'
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen_ruta)) {
            // Insertar la receta en la base de datos
            $usuario_id = $_SESSION['usuario_id'];
            $sql = "INSERT INTO recetas (nombre, descripcion, ingredientes, instrucciones, imagen, ventajas, desventajas, fecha_creacion, usuario_id) 
                    VALUES ('$nombre', '$descripcion', '$ingredientes', '$instrucciones', '$imagen_nombre', '$ventajas', '$desventajas', NOW(), '$usuario_id')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<p>Receta agregada exitosamente.</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Error al subir la imagen.</p>";
        }
    } else {
        echo "<p>No se ha seleccionado ninguna imagen.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Receta</title>
    <style>
        body {
            font-family: Georgia, "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            background-color: #f9e9e9;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background-color: #422316;
            color: #FFFFFB;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 30px;
            margin: 0;
            text-transform: uppercase;
            padding: 20px;
        }

        header img {
            max-width: 100%;
            height: auto;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline-block;
            margin-right: 30px;
        }

        nav ul li a {
            text-decoration: none;
            color: #976800;
            font-size: 20px;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #f5e44d;
        }

        main {
            padding: 30px 20px;
            background-color: #ffffff;
            margin-bottom: 100px;
        }

        main h2 {
            font-size: 36px;
            color: #C97C23;
            margin-bottom: 20px;
        }

        main h3 {
            font-size: 20px;
            color: #301900;
        }

        main p {
            font-size: 18px;
            color: #53440e;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="file"] {
            margin-top: 10px;
        }

        button[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .btn-success {
            background-color: #007BFF;
            color: #ffffff;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 30px;
            transition: background-color 0.3s;
        }

        .btn-success:hover {
            background-color: #0056b3;
        }

        .btn-back {
            background-color: #C97C23;
            color: #ffffff;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #a65a1c;
        }

        footer {
            background-color: #422316;
            color: #ffffff;
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <img src="imagenes/Cream and Gray Modern New Fashion ETSY shop cover.png" alt="Logo Dream Dishes" class="logo">
        <h1>Mi Recetario</h1>
    </header>

    <main>
        <form action="agregar_receta.php" method="POST" enctype="multipart/form-data">
            <h2>Agregar Nueva Receta</h2>
            <div class="form-group">
                <label for="nombre">Título de la receta:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="ingredientes">Ingredientes:</label>
                <textarea id="ingredientes" name="ingredientes" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="instrucciones">Instrucciones:</label>
                <textarea id="instrucciones" name="instrucciones" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="ventajas">Ventajas nutricionales:</label>
                <textarea id="ventajas" name="ventajas" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="desventajas">Desventajas nutricionales:</label>
                <textarea id="desventajas" name="desventajas" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen de la receta:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <button type="submit" class="btn-success">Agregar Receta</button>
        </form>
        <div style="text-align: center; margin-top: 40px;">
            <a href="recetario.php" class="btn-back">Volver al Recetario</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Mi Recetario. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
