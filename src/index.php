<?php
session_start(); // Iniciar la sesión

$servername = "db";
$username = "usuario";
$password = "usuario_password";
$database = "mi_base_de_datos";

// !CREAR LA CONN CON PAQUETE MYSQLI
$conn = new mysqli($servername, $username, $password, $database);

// !CHEQUEAR CONN
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario ha sido enviado (si el cliente pulsó el botón)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insertar'])) {
    // Solo insertamos si el botón ha sido presionado
    $sql_insert = "INSERT INTO Usuarios (nombre, email) VALUES 
                  ('Juan', 'juan@example.com'), 
                  ('María', 'maria@example.com'), 
                  ('Pedro', 'pedro@example.com')";

    if ($conn->query($sql_insert) === TRUE) {
        // Redirigir después de la inserción para evitar duplicaciones en el refresco
        header("Location: " . $_SERVER['PHP_SELF']); // Redirigir antes de cualquier salida
        exit(); // Asegurar que la ejecución se detenga después de la redirección
    } else {
        echo "Error al insertar los datos: " . $conn->error;
    }
}

// !CONSULTA SQL TABLA USUARIOS
$sql = "SELECT id, nombre, email FROM Usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios con PHP</title>
    <link rel="stylesheet" href="./styles/main.css">
</head>

<body>
    <h1>Lista de Usuarios</h1>

    <!-- Formulario con un botón para insertar los datos -->
    <form method="post" action="">
        <button type="submit" name="insertar">Insertar Usuarios</button>
    </form>

    <!-- MOSTRAR DATOS -->
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["nombre"] . "</td>
                    <td>" . $row["email"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No se encontraron resultados.</p>";
    }

    // !CERRAR CONN
    $conn->close();
    ?>
</body>

</html>