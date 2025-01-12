<?php
// Incluir el archivo de conexión
include 'conexion.php';
session_start();

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y sanitizar los datos de entrada
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    // Validar que los campos requeridos no estén vacíos
    if (empty($email) || empty($password)) {
        echo "Todos los campos son requeridos.";
        exit();
    }

    // Validar formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "El correo electrónico no es válido.";
        exit();
    }

    // Preparar la consulta SQL para obtener el usuario
    $sql = "SELECT * FROM usuario WHERE email = :email";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe
    if ($user) {
        // Comparar la contraseña en texto plano directamente
        if ($password === $user ['password']) {
            // Iniciar sesión y redirigir
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            header("Location: index_sesion.html"); // Página a la que se redirige tras el inicio de sesión
            exit();
        } else {
            echo "Correo electrónico o contraseña incorrectos.";
        }
    } else {
        echo "Correo electrónico o contraseña incorrectos.";
    }
}
?>