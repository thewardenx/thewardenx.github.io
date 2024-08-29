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

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Eliminar pedido
    $sql = "DELETE FROM Tienda WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Pedido eliminado correctamente.";
    } else {
        echo "Error al eliminar el pedido: " . $conn->error;
    }

    // Redireccionar a la página de consultar pedidos
    header('Location: http://localhost/proyectodie%c3%b1oweb/html/IndeTienda2.html');
    exit;
} else {
    echo "Error: No se ha proporcionado el id.";
}

$conn->close();
?>

