<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Pedidos</title>
    <!-- Ruta correcta al archivo CSS -->
    <link rel="stylesheet" href="../css/consulta_pedidos.css">
    <script>
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que deseas cancelar esta compra?");
        }
    </script>
</head>
<body>
    <h1>Tus Pedidos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Dirección</th>
                <th>Total $</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
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

            // Inicializar variable de consulta
            $consulta_nombre = "";

            // Verificar si se ha enviado el formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['consulta-nombre'])) {
                    $consulta_nombre = $conn->real_escape_string($_POST['consulta-nombre']);
                }
            }

            // Crear la consulta SQL para obtener pedidos por nombre si se ha proporcionado un nombre
            $sql = "SELECT * FROM Tienda";
            if (!empty($consulta_nombre)) {
                $sql .= " WHERE nombre LIKE '%$consulta_nombre%'";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["direccion"] . "</td>";
                    echo "<td>" . $row["total"] . "</td>";
                    echo "<td>" . $row["fecha"] . "</td>";
                    echo "<td>
                            <form action='update.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <input type='submit' value='Actualizar'>
                            </form>
                            <form action='delete.php' method='POST' style='display:inline;' onsubmit='return confirmarEliminacion();'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <input type='submit' value='Eliminar'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay pedidos registrados.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
    <a href="../html/indeTienda2.html">Volver a Inicio</a>
</body>
</html>


