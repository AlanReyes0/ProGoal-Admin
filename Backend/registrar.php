<?php
header('Content-Type: text/plain');

// Obtener los datos del formulario
$nombre_equipo = $_POST['nombre_equipo'] ?? '';
$cantidad_jugadores = $_POST['cantidad_jugadores'] ?? '';
$capitan = $_POST['capitan'] ?? '';
$contacto = $_POST['contacto'] ?? '';
$escudo = $_POST['escudo'] ?? '';



// Verificar que todos los campos estén completos
if ($nombre_equipo !== '' && $capitan !== '' && $contacto !== '' && $escudo !== '' && $cantidad_jugadores !== '') {
    // Incluir el archivo de conexión a la base de datos
    include '../Backend/conexion.php'; 

    // Preparar la consulta SQL
    $sql = "INSERT INTO Equipos (nombre_equipo, cantidad_jugadores, capitan, contacto, escudo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo 'Error en la preparación de la consulta: ' . $conn->error;
        exit;
    }

    // Vincular los parámetros
    $stmt->bind_param("sisss", $nombre_equipo, $cantidad_jugadores, $capitan, $contacto, $escudo);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo 'Datos registrados con éxito.';
    } else {
        echo 'Error al registrar los datos: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Datos incompletos.';
}
?>
