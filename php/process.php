<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_online";

// Crear conexión
$conn = new mysqli($servername,  $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['name'];
$tarjeta = $_POST['tarjeta'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$total = $_POST['total'];
$fecha = date('Y-m-d H:i:s'); // Obtener la fecha actual

// Preparar e insertar el registro en la base de datos
$sql = "INSERT INTO Tienda (nombre, email, tarjeta, direccion, total, fecha)
        VALUES ('$nombre', '$email', '$tarjeta', '$direccion', '$total', '$fecha')";

if ($conn->query($sql) === TRUE) {
    echo "Pedido registrado correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
