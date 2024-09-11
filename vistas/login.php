<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/login.css">
    <title>Iniciar Sesión</title>
</head>
<body>
    <form action="../Backend/login_backend.php" method="POST">
        <img src="../imagenes/logo.jpg" alt="">
        <h2>Iniciar Sesión</h2>
        <?php 
        session_start();
        if (isset($_SESSION['errorLogin'])) {
            echo "<h3>" . htmlspecialchars($_SESSION['errorLogin']) . "</h3>";
            unset($_SESSION['errorLogin']); // Borrar el mensaje de error después de mostrarlo
        }
        ?>
        
        <p>Nombre de Usuario: <br> <input type="text" name="username"> </p>
        <p>Contraseña: <br> <input type="password" name="password"> </p>
        <p class="center"> <input type="submit" value="Iniciar Sesión"> </p>
    </form>
</body>
</html>
