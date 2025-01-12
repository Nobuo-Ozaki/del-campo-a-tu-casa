<?php

// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y sanitizar los datos de entrada
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $cedula = filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validar que los campos requeridos no estén vacíos
    if (empty($nombre) || empty($cedula) || empty($email) || empty($telefono) || empty($password) || empty($confirm_password)) {
        echo "Todos los campos son requeridos.";
        exit();
    }

    // Validar formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "El correo electrónico no es válido.";
        exit();
    }

    // Verificar si las contraseñas coinciden
    if ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit();
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO usuario (nombre, cedula, email, telefono, password) VALUES (:nombre, :cedula, :email, :telefono, :password)";

    $stmt = $con->prepare($sql);

    // Asignar valores a los parámetros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':password', $password);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Código JavaScript para la alerta y redirección
        echo '<script>
                alert("Registro exitoso.");
                window.location.href = "login.html"; // Reemplaza con la URL de tu página de destino
              </script>';
    } else {
        echo "Error al almacenar los datos en la base de datos.";
    }
}
?>