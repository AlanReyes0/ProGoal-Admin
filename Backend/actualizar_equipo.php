<?php
include '../Backend/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $jugadores = $_POST['jugadores'];
    $capitan = $_POST['capitan'];
    $contacto = $_POST['contacto'];
    $escudo = $_POST['escudo'];

    // Update the record in the 'Equipos' table
    $sql = "UPDATE Equipos SET nombre_equipo=?, cantidad_jugadores=?, capitan=?, contacto=?, escudo=? WHERE id_equipo=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sisssi', $nombre, $jugadores, $capitan, $contacto, $escudo, $id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
?>
