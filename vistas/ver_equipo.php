<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Equipo</title>
    <link rel="stylesheet" href="../estilos/ver_equipo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../JS/agregar_jugador.js" defer></script>
</head>
<body>
    <?php include "../vistas/nav-bar.php" ?>

    <div class="main-content">
        <?php
            include '../Backend/conexion.php';

            if (isset($_GET['id'])) {
                $id_equipo = $_GET['id'];

                $table = 'Equipos';
                
                $sql = $conn->query("SELECT * FROM $table WHERE id_equipo = $id_equipo");
                $equipo = $sql->fetch_object();
                
                if ($equipo) {
                    echo "<div class='equipo-info'>";
                    echo "<h1>Información del Equipo</h1>";
                    echo "<p><strong>Nombre:</strong> {$equipo->nombre_equipo}</p>";
                    echo "<p><strong>Cantidad de jugadores:</strong> {$equipo->cantidad_jugadores}</p>";
                    echo "<p><strong>Capitán:</strong> {$equipo->capitan}</p>";
                    echo "<p><strong>Contacto:</strong> {$equipo->contacto}</p>";
                    echo "<p><strong>Escudo:</strong> <img src='../imagenes/$equipo->escudo alt='Escudo del equipo'></p>";
                    ?>
                    <div class="add-player-button">     
                        <h2>Agregar Jugador: </h2>
                        <button id="myButton">Agregar +</button>         
                    </div> 
                    <hr>
                    <div class="jugadores-info">
                      <center><h2>Jugadores del Equipo</h2></center>
                      <div class="players-list">
                        <table class="tabla-jugadores">
                            <thead>
                                <tr>
                                    <th>Id Jugador</th>
                                    <th>Nombre</th>
                                    <th>Posición</th>
                                    <th>Fecha Registro</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sqlJugadores = $conn->query("SELECT * FROM jugadores WHERE id_equipo = $id_equipo");
                                while ($jugador = $sqlJugadores->fetch_object()) {
                                    echo "<tr>";
                                    echo "<td>{$jugador->id_jugador}</td>";
                                    echo "<td>{$jugador->nombre}</td>";
                                    echo "<td>{$jugador->posicion}</td>";
                                    echo "<td>{$jugador->fecha_hora}</td>";
                                    echo "<td></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                      </div>
                    </div>
                    <?php
                    echo "</div>";
                } else {
                    echo "<p>Equipo no encontrado.</p>";
                }
            } else {
                echo "<p>Datos insuficientes.</p>";
            }
        ?>
    </div>
</body>
</html>
