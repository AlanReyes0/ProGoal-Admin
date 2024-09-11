<?php
include '../Backend/conexion.php';

// Calcular partidos jugados, ganados, empatados, perdidos, goles a favor, goles en contra y puntos
$sql = "SELECT e.nombre_equipo,
               COALESCE(COUNT(DISTINCT CASE 
                      WHEN (p.id_equipo1 = e.id_equipo OR p.id_equipo2 = e.id_equipo)
                           AND (p.resultado_equipo1 IS NOT NULL AND p.resultado_equipo2 IS NOT NULL)
                      THEN p.id_partido
                      ELSE NULL 
                  END), 0) AS partidos_jugados,
               COALESCE(SUM(CASE 
                      WHEN p.id_equipo1 = e.id_equipo AND p.resultado_equipo1 > p.resultado_equipo2 THEN 1
                      WHEN p.id_equipo2 = e.id_equipo AND p.resultado_equipo2 > p.resultado_equipo1 THEN 1
                      ELSE 0 
                  END), 0) AS partidos_ganados,
               COALESCE(SUM(CASE 
                      WHEN p.id_equipo1 = e.id_equipo AND p.resultado_equipo1 = p.resultado_equipo2 THEN 1
                      WHEN p.id_equipo2 = e.id_equipo AND p.resultado_equipo2 = p.resultado_equipo1 THEN 1
                      ELSE 0 
                  END), 0) AS partidos_empatados,
               COALESCE(SUM(CASE 
                      WHEN p.id_equipo1 = e.id_equipo AND p.resultado_equipo1 < p.resultado_equipo2 THEN 1
                      WHEN p.id_equipo2 = e.id_equipo AND p.resultado_equipo2 < p.resultado_equipo1 THEN 1
                      ELSE 0 
                  END), 0) AS partidos_perdidos,
               COALESCE(SUM(CASE 
                      WHEN p.id_equipo1 = e.id_equipo THEN p.resultado_equipo1
                      WHEN p.id_equipo2 = e.id_equipo THEN p.resultado_equipo2
                      ELSE 0 
                  END), 0) AS goles_favor,
               COALESCE(SUM(CASE 
                      WHEN p.id_equipo1 = e.id_equipo THEN p.resultado_equipo2
                      WHEN p.id_equipo2 = e.id_equipo THEN p.resultado_equipo1
                      ELSE 0 
                  END), 0) AS goles_contra,
               COALESCE(SUM(CASE 
                      WHEN p.id_equipo1 = e.id_equipo AND p.resultado_equipo1 > p.resultado_equipo2 THEN 3
                      WHEN p.id_equipo2 = e.id_equipo AND p.resultado_equipo2 > p.resultado_equipo1 THEN 3
                      WHEN p.resultado_equipo1 = p.resultado_equipo2 THEN 1
                      ELSE 0 
                  END), 0) AS puntos
        FROM Equipos e
        LEFT JOIN Partidos p ON p.id_equipo1 = e.id_equipo OR p.id_equipo2 = e.id_equipo
        WHERE p.resultado_equipo1 IS NOT NULL AND p.resultado_equipo2 IS NOT NULL
        GROUP BY e.id_equipo, e.nombre_equipo
        ORDER BY puntos DESC, goles_favor - goles_contra DESC";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => $conn->error]);
    exit;
}

$clasificacion = [];
while ($row = $result->fetch_assoc()) {
    $clasificacion[] = $row;
}

echo json_encode(['clasificacion' => $clasificacion]);
?>
