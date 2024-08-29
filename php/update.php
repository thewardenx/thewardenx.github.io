<?php
// Configuración de conexión
$servername = "localhost";
$username = "root"; // Usuario de MySQL
$password = ""; // Contraseña de MySQL, dejar vacío si no hay contraseña
$dbname = "tienda_online";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$pedido = []; // Inicializar la variable para el pedido
$error = ""; // Variable para almacenar mensajes de error
$success = false; // Variable para indicar si la actualización fue exitosa

// Verificar si se ha enviado el formulario para obtener el pedido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Obtener el pedido actual
    $sql = "SELECT * FROM Tienda WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pedido = $result->fetch_assoc();

    if (!$pedido) {
        die("No se encontró el pedido.");
    }

    // Verificar si se ha enviado el formulario de actualización
    if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['direccion']) && isset($_POST['total']) && isset($_POST['fecha'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $direccion = $_POST['direccion'];
        $total = $_POST['total'];
        $fecha = $_POST['fecha'];

        // Actualizar pedido
        $sql = "UPDATE Tienda SET nombre = ?, email = ?, direccion = ?, total = ?, fecha = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nombre, $email, $direccion, $total, $fecha, $id);

        if ($stmt->execute()) {
            $success = true; // Indicar que la actualización fue exitosa
            $pedido = []; // Limpiar el pedido para que los campos se limpien
        } else {
            $error = "Error al actualizar el pedido: " . $conn->error;
        }
    } else {
        if (isset($_POST['nombre'])) {
            $error = "Faltan datos para actualizar el pedido.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Pedido</title>
    <link rel="stylesheet" href="../css/actualizar.css"> <!-- Ajusta la ruta según la ubicación del archivo CSS -->
    <style>
        .message {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Actualizar Pedido</h1>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($pedido['id'] ?? ''); ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($pedido['nombre'] ?? ''); ?>" required>
        <label for="email">Correo:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($pedido['email'] ?? ''); ?>" required>
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($pedido['direccion'] ?? ''); ?>" required>
        <label for="total">Total:</label>
        <input type="text" id="total" name="total" value="<?php echo htmlspecialchars($pedido['total'] ?? ''); ?>" readonly> 
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($pedido['fecha'] ?? ''); ?>" required>
        <input type="submit" value="Actualizar Pedido">
    </form>

    <?php if ($success): ?>
        <div class="message success">Pedido actualizado correctamente.</div>
    <?php elseif ($error): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <center><a href="../html/indeTienda2.html">Volver a Consultar Pedidos</a></center>
</body>
</html>

