<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

// Incluir la conexión a la base de datos
include 'db_connect.php';

// Obtener el ID del usuario
$usuario_id = $_SESSION['usuario_id'];

// Consultar las recetas del usuario
$sql = "SELECT * FROM recetas WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Recetario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Estilos adicionales */
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
        <form action="logout.php" method="post" style="display: inline;">
            <button type="submit" class="btn-logout">Cerrar sesión</button>
        </form>
    </header>

    <main class="container mt-5">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h2>
        <p>Este es tu recetario privado.</p>

        <!-- Botón para agregar una nueva receta -->
        <a href="agregar_receta.php" class="btn btn-success mb-3">Agregar Nueva Receta</a>

        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="uploads/' . htmlspecialchars($row["imagen"]) . '" class="card-img-top" alt="' . htmlspecialchars($row["nombre"]) . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row["nombre"]) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($row["descripcion"]) . '</p>';
                    echo '<a href="detalle_receta.php?id=' . $row["id"] . '" class="btn btn-primary">Ver receta</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No tienes recetas aún. ¡Agrega algunas!</p>';
            }
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Mi Recetario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-XQT3v6g7bVnPNUx6JyF0gKlMYKMZjsKKFDdT+L4FBkT4uMDhX+POzMRDktz4dS68" crossorigin="anonymous"></script>
</body>
</html>
