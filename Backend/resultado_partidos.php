<?php
include '../Backend/conexion.php';

$id_partido = $_POST['id_partido'];
$resultado_equipo1 = $_POST['resultado_equipo1'];
$resultado_equipo2 = $_POST['resultado_equipo2'];

$sql = "UPDATE Partidos SET resultado_equipo1 = ?, resultado_equipo2 = ? WHERE id_partido = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $resultado_equipo1, $resultado_equipo2, $id_partido);

if ($stmt->execute()) {
    echo "Resultados actualizados con éxito.";
} else {
    echo "Error al actualizar los resultados: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
