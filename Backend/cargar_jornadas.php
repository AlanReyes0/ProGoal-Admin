<?php
include '../Backend/conexion.php';

// Consulta SQL para obtener los datos de las jornadas, partidos y equipos
$sql = "SELECT j.id_jornada, p.id_partido, e1.nombre_equipo AS equipo1, e2.nombre_equipo AS equipo2, p.resultado_equipo1, p.resultado_equipo2
        FROM Jornadas j
        JOIN Partidos p ON j.id_jornada = p.id_jornada
        JOIN Equipos e1 ON p.id_equipo1 = e1.id_equipo
        JOIN Equipos e2 ON p.id_equipo2 = e2.id_equipo
        ORDER BY j.id_jornada, p.id_partido";
$result = $conn->query($sql);

//En este array almacenamos los resultados de la consulta anterior y con while
//recorremos sus resultados
$jornadas = [];
while ($row = $result->fetch_assoc()) {
    $id_jornada = $row['id_jornada'];
    if (!isset($jornadas[$id_jornada])) {
        $jornadas[$id_jornada] = [
            'id_jornada' => $id_jornada,
            'partidos' => [],
            'descanso' => [] // Añadir campo para el equipo que descansa
        ];
    }
    $jornadas[$id_jornada]['partidos'][] = [
        'id_partido' => $row['id_partido'],
        'equipo1' => $row['equipo1'],
        'equipo2' => $row['equipo2'],
        'resultado_equipo1' => $row['resultado_equipo1'],
        'resultado_equipo2' => $row['resultado_equipo2']
    ];
}

// Calcular los equipos que descansan
$equipos = [];
$sql_equipos = "SELECT id_equipo, nombre_equipo FROM Equipos";
$result_equipos = $conn->query($sql_equipos);
//similar a la funcion de arriba recorre los resultados de la consulta
while ($row = $result_equipos->fetch_assoc()) {
    $equipos[$row['id_equipo']] = $row['nombre_equipo'];
}

// Recorre cada jornada para calcular el equipo que descansa
foreach ($jornadas as $id_jornada => &$jornada) {
    $equipos_jornada = array_column($jornada['partidos'], 'equipo1');
    $equipos_jornada = array_merge($equipos_jornada, array_column($jornada['partidos'], 'equipo2'));
    $equipos_jornada = array_unique($equipos_jornada);

    $descanso = array_diff($equipos, $equipos_jornada);
    $jornada['descanso'] = $descanso ? reset($descanso) : 'N/A';
}

header('Content-Type: application/json');
echo json_encode(['jornadas' => array_values($jornadas)]);
?>
