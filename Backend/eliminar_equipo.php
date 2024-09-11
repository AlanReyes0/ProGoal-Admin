<?php
// Incluir el archivo de conexión a la base de datos
include '../Backend/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_equipo = $_POST['id_equipo'] ?? '';

    // Imprimir datos para depuración
    error_log("ID del equipo recibido: $id_equipo");

    if ($id_equipo) {
        // Preparar la consulta de eliminación
        $sql = "DELETE FROM Equipos WHERE id_equipo = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            error_log('Error en la preparación de la consulta: ' . $conn->error);
            echo 'error';
            exit;
        }

        $stmt->bind_param('i', $id_equipo);
        $success = $stmt->execute();

        if ($success) {
            echo 'success';
        } else {
            error_log('Error al ejecutar la consulta: ' . $stmt->error);
            echo 'error';
        }

        $stmt->close();
    } else {
        echo 'Datos incompletos.';
    }

    $conn->close();
}
?>
