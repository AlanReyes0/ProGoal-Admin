
<html>
<link rel="stylesheet" href="../estilos/nav-bar.css">
<head>
</head>
<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al formulario de inicio de sesión si no está autenticado
    exit;
}

// Incluir el archivo de conexión a la base de datos
include '../Backend/conexion.php'; 

// Obtener los detalles del usuario
$user_id = $_SESSION['user_id'];
$sql = "SELECT nombre FROM Usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nombre);
$stmt->fetch();
$stmt->close();
?>
<body>

<div class="top-bar">
    <h2 class="username"> <?php echo htmlspecialchars($nombre); ?></h2>
</div>

<ul>
    <img src="../imagenes/logo.jpg" alt="">
    <li><a href="home.php">Home</a></li>
    <li><a href="clasificacion.php">Estadisticas</a></li>
    <li><a href="equipos.php">Equipos</a></li>
    <li><a href="partidos.php">Partidos</a></li>
    <li><a href="about.php">Mi info</a></li>
    <li class="logout">
        <form action="../Backend/logout.php" method="POST">
            <button type="submit" class="button" name="logout">Cerrar sesión</button>
        </form>
    </li>
</ul>

</body>
</html>
