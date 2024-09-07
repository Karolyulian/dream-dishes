<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $email = $conn->real_escape_string($_POST['email']);
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
    $receta = $conn->real_escape_string($_POST['receta']);

    // Verificar si el correo electrónico ya está registrado
    $sql = "SELECT id FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "El correo electrónico ya está registrado.";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre, email, contraseña) VALUES ('$nombre', '$email', '$contraseña')";

        if ($conn->query($sql) === TRUE) {
            $user_id = $conn->insert_id; // Obtener el ID del nuevo usuario

            if (!empty($receta)) {
                // Insertar la receta si se ha proporcionado
                $sql_receta = "INSERT INTO recetas (usuario_id, contenido) VALUES ('$user_id', '$receta')";

                if ($conn->query($sql_receta) !== TRUE) {
                    echo "Error al guardar la receta: " . $conn->error;
                }
            }

            echo "Registro exitoso. Ahora puedes iniciar sesión.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
