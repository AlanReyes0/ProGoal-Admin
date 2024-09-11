<?php
include '../Backend/conexion.php';

function generarPartidos($equipos) {
    $partidos = [];
    $num_equipos = count($equipos);

    // Si el número de equipos es impar, agregamos un equipo ficticio para completar la jornada
    if ($num_equipos % 2 !== 0) {
        $equipos[] = ['id_equipo' => null, 'nombre_equipo' => 'Descanso'];
        $num_equipos++;
    }

    $mitad = $num_equipos / 2;
    for ($i = 0; $i < $num_equipos - 1; $i++) {
        for ($j = 0; $j < $mitad; $j++) {
            $partido = [
                'id_equipo1' => $equipos[$j]['id_equipo'],
                'id_equipo2' => $equipos[$num_equipos - 1 - $j]['id_equipo']
            ];
            if ($partido['id_equipo1'] !== null && $partido['id_equipo2'] !== null) {
                $partidos[$i][] = $partido;
            }
        }

        // Rotar equipos
        $equipo_temp = array_splice($equipos, 1, 1);
        array_splice($equipos, $num_equipos - 1, 0, $equipo_temp);
    }
    return $partidos;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Limpiar tablas existentes
    $conn->query("DELETE FROM Partidos");
    $conn->query("DELETE FROM Jornadas");

    // Obtener equipos
    $sql = "SELECT id_equipo, nombre_equipo FROM Equipos";
    $result = $conn->query($sql);
    $equipos = $result->fetch_all(MYSQLI_ASSOC);
    $num_equipos = count($equipos);

    if ($num_equipos < 2) {
        echo 'No hay suficientes equipos para generar jornadas.';
        exit;
    }

    $jornadas = generarPartidos($equipos);

    // Insertar jornadas y partidos
    foreach ($jornadas as $jornada_num => $partidos) {
        $conn->query("INSERT INTO Jornadas (fecha) VALUES (NOW())");
        $id_jornada = $conn->insert_id;

        $stmt = $conn->prepare("INSERT INTO Partidos (id_jornada, id_equipo1, id_equipo2) VALUES (?, ?, ?)");
        foreach ($partidos as $partido) {
            $stmt->bind_param("iii", $id_jornada, $partido['id_equipo1'], $partido['id_equipo2']);
            $stmt->execute();
        }
        $stmt->close();
    }

    $conn->close();
    echo 'Jornadas generadas con éxito.';
}
?>
