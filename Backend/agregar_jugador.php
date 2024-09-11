<?php
include '../Backend/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $posicion = $_POST['posicion'];
    $id_equipo = $_POST['id_equipo'];

    if (empty($nombre) || empty($posicion) || empty($id_equipo)) {
        echo 'Error: Todos los campos son requeridos.';
        exit;
    }

    // Insertar el nuevo jugador en la tabla de jugadores con la fecha y hora actuales
    $stmt = $conn->prepare("INSERT INTO jugadores (nombre, posicion, id_equipo, fecha_hora) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("ssi", $nombre, $posicion, $id_equipo);
    
    if ($stmt->execute()) {
        // Actualizar el número de jugadores en la tabla de equipos
        $stmt2 = $conn->prepare("UPDATE Equipos SET cantidad_jugadores = cantidad_jugadores + 1 WHERE id_equipo = ?");
        $stmt2->bind_param("i", $id_equipo);
        $stmt2->execute();
        $stmt2->close();

        echo 'Jugador agregado exitosamente.';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
