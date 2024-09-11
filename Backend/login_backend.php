<?php
session_start(); // Iniciar la sesión
include '../Backend/conexion.php'; // Asegúrate de que la ruta al archivo de conexión es correcta

// Verificar si se enviaron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Verificar si los campos están vacíos
    if (empty($username) || empty($password)) {
        $_SESSION['errorLogin'] = "Por favor, llene todos los campos.";
        header("Location: ../vistas/login.php"); // Redirigir al formulario de inicio de sesión
        exit;
    }

    // Consultar la base de datos para verificar las credenciales
    $sql = "SELECT * FROM Usuarios WHERE Nombre_usuario = ? AND contrasena = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Datos del usuario encontrados, iniciar sesión
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id']; // Asumiendo que tu tabla tiene una columna 'id'
        $_SESSION['username'] = $user['username'];
        $_SESSION['nombre'] = $user['nombre']; // Asumiendo que tienes una columna 'nombre'

        // Redirigir a la página principal o al área protegida
        header("Location: ../vistas/home.php");
        exit;
    } else {
        // Credenciales incorrectas
        $_SESSION['errorLogin'] = "Este usuario no existe.";
        header("Location: ../vistas/login.php");
        exit;
    }

    $stmt->close();
}
?>
