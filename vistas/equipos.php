<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/equipos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../JS/eliminar.js" defer></script>
    <script src="../JS/actualizar.js" defer></script>
    <script src="../JS/registrar.js" defer></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Equipos</title>
</head>
<body>
    <?php include "../vistas/nav-bar.php" ?>
    <div id="main-content">
        <div class="Nuevoequipo">   
            <h2>Nuevo equipo: </h2>
            <button id="myButton">Agregar equipo +</button>
            <br>
            <hr>
        </div>  
        <center><h2>Equipos</h2></center>
        <table id="miTabla">
            <thead> 
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Jugadores</th>
                    <th>Capitan</th>
                    <th>Contacto</th>
                    <th>Escudo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody> 
                <?php
                include '../Backend/conexion.php'; 
                $sql = $conn->query("SELECT * FROM Equipos");
                while($datos = $sql->fetch_object()) { ?>
                    <tr>
                        <td><?= $datos->id_equipo ?></td>
                        <td><?= $datos->nombre_equipo ?></td>
                        <td><?= $datos->cantidad_jugadores ?></td>
                        <td><?= $datos->capitan ?></td>
                        <td><?= $datos->contacto ?></td>
                        <td><?= $datos->escudo ?></td>
                        <td>
                        <button class="material-symbols-outlined delete-button" data-id="<?= $datos->id_equipo ?>">delete</button>
                        <button id="actualizar" class="material-symbols-outlined update-button" data-id="<?= $datos->id_equipo ?>" data-category="libre" data-nombre="<?= $datos->nombre_equipo ?>" data-jugadores="<?= $datos->cantidad_jugadores ?>" data-capitan="<?= $datos->capitan ?>" data-contacto="<?= $datos->contacto ?>" data-escudo="<?= $datos->escudo ?>">sync_alt</button>
                        <button id="ver" class="material-symbols-outlined" onclick="location.href='ver_equipo.php?id=<?= $datos->id_equipo ?>'">preview</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        
</body>
</html>
