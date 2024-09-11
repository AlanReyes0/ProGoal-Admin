 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jornadas</title>
    <link rel="stylesheet" href="../estilos/partidos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../JS/jornadas.js" defer></script>
</head>
<body>
<?php include "../vistas/nav-bar.php"; ?>

<div class="main-content">
    <div class="jornadas-info">
        <button id="generarJornadas" class="btn-actualizar">Generar Jornadas</button>
        <div id="jornadas"></div>
    </div>
</div>
</body>
</html>
